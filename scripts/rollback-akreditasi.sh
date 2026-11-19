#!/usr/bin/env bash
#
# scripts/rollback-akreditasi.sh
#
# Rollback fitur data akreditasi dan arsip institusi pada server produksi.
#
# Urutan wajib:
#   preflight (APP_DIR berisi artisan + .env, branch, tree bersih,
#              file migration ada, migration tercatat Ran)
#   -> php artisan down --retry=60
#   -> migrate:rollback --path=<file migration>   (file migration MASIH ADA)
#      dijalankan dari migration terbaru ke terlama
#   -> verifikasi kolom setiap migration sudah hilang
#   -> revert kode (git pull + git revert, atau git pull bila sudah direvert)
#   -> verifikasi tidak ada migration Pending setelah revert
#   -> composer install --no-dev --optimize-autoloader
#   -> optimize:clear, filament:optimize-clear
#   -> queue:restart, reload PHP-FPM
#   -> php artisan up
#
# MENGAPA ROLLBACK MIGRATION HARUS SEBELUM REVERT KODE:
# git revert menghapus file migration dari working tree. Setelah file itu
# hilang, "migrate:rollback --path=database/migrations/..." tidak dapat
# dijalankan lagi karena Laravel tidak menemukan file migration yang dimaksud.
# Karena itu urutan di atas tidak boleh dibalik.
#
# Perilaku trap (disengaja):
# 1. Gagal SEBELUM maintenance mode aktif -> tidak ada aksi.
# 2. Gagal setelah down, tetapi kolom database BELUM dirollback
#    -> "php artisan up" dijalankan karena skema dan kode masih lengkap.
# 3. Gagal setelah kolom database dirollback dan kode BELUM dikembalikan
#    -> maintenance DIPERTAHANKAN, karena kode baru tidak kompatibel dengan
#       skema tanpa kolom akreditasi/institusi. Operator harus menyelesaikan
#       revert kode lebih dulu, baru "php artisan up".
# 4. Gagal setelah kolom dirollback DAN kode sudah dikembalikan
#    (mis. push/composer/cache/queue/PHP-FPM gagal)
#    -> "php artisan up" dijalankan karena skema dan kode sudah konsisten.
#
# Mode revert:
#   REVERT_MODE=server (default)
#     Server melakukan git revert pada commit di REVERT_SHA, lalu git push.
#     Gunakan hanya bila server punya akses push.
#   REVERT_MODE=pull
#     Revert sudah dilakukan dan di-push dari mesin lain. Server hanya
#     menjalankan git pull --ff-only.
#
# Penggunaan (di server produksi), dijalankan dari root project:
#   cd /path/ke/unmaris-website
#   git fetch origin main
#   git show origin/main:scripts/rollback-akreditasi.sh > /tmp/rollback-akreditasi.sh
#   APP_DIR="$(pwd)" REVERT_MODE=pull bash /tmp/rollback-akreditasi.sh
#
# Salinan /tmp disarankan karena git revert menghapus skrip ini dari working
# tree. Bila origin/main sudah tidak memuat skrip (revert sudah di-push),
# salin dari working tree SEBELUM menjalankan skrip:
#   cp scripts/rollback-akreditasi.sh /tmp/rollback-akreditasi.sh
#
# Skrip dijalankan dengan "bash", jadi tidak perlu chmod +x (perubahan mode
# file akan mengotori "git status --short" dan ditolak preflight).
#
# Opsi environment:
#   APP_DIR      default: $PWD (direktori kerja saat skrip dijalankan).
#                Wajib berisi "artisan" dan ".env".
#   BRANCH       default: main
#   REVERT_MODE  default: server  (server|pull)
#   REVERT_SHA   wajib untuk REVERT_MODE=server

set -euo pipefail

BRANCH="${BRANCH:-main}"
REVERT_MODE="${REVERT_MODE:-server}"
REVERT_SHA="${REVERT_SHA:-}"

MIGRATION_AKREDITASI="2026_11_19_000000_add_accreditation_fields_to_documents_table"
MIGRATION_INSTITUSI="2026_11_19_000001_add_institusi_fields_to_documents_table"

# Migration terbaru lebih dulu agar rollback mengikuti urutan kebalikan deploy.
MIGRATION_FILES=(
    "database/migrations/${MIGRATION_INSTITUSI}.php"
    "database/migrations/${MIGRATION_AKREDITASI}.php"
)

MAINTENANCE_MODE=0
DB_ROLLED_BACK=0
CODE_REVERTED=0

log() {
    printf '\n==> %s\n' "$*"
}

warn() {
    printf '\n[PERINGATAN] %s\n' "$*" >&2
}

die() {
    printf '\n[STOP] %s\n' "$*" >&2
    exit 1
}

APP_DIR="${APP_DIR:-$PWD}"
[[ -d "$APP_DIR" ]] || die "APP_DIR tidak ditemukan: $APP_DIR"
cd "$APP_DIR" || die "Gagal masuk ke APP_DIR: $APP_DIR"

on_exit() {
    local exit_code=$?

    if [[ "$MAINTENANCE_MODE" -eq 1 ]]; then
        if [[ "$DB_ROLLED_BACK" -eq 1 && "$CODE_REVERTED" -eq 0 ]]; then
            warn "Kolom database sudah dihapus, tetapi kode baru masih terpasang."
            warn "Aplikasi TETAP dalam maintenance mode sampai kode dikembalikan."
            warn "Selesaikan revert/pull kode, lalu jalankan: php artisan up"
        else
            warn "Rollback berhenti pada kondisi kode dan skema yang konsisten."
            warn "Mengembalikan aplikasi ke mode normal."
            php artisan up || true
        fi
    fi

    exit "$exit_code"
}

trap on_exit EXIT

reload_php_fpm() {
    if ! command -v systemctl >/dev/null 2>&1; then
        warn "systemctl tidak tersedia. Reload PHP-FPM secara manual."
        return 0
    fi

    local service
    service="$(systemctl list-units --type=service --plain --no-legend 'php*-fpm.service' 2>/dev/null | awk 'NR == 1 { print $1 }')"

    if [[ -z "$service" ]]; then
        warn "Service PHP-FPM tidak terdeteksi. Reload PHP-FPM secara manual."
        return 0
    fi

    if ! sudo -n systemctl reload "$service"; then
        warn "Reload otomatis '$service' gagal (sudo non-interaktif tidak diizinkan)."
        warn "Reload PHP-FPM secara manual, contoh: sudo systemctl reload $service"
        return 0
    fi

    log "PHP-FPM direload: $service"
}

columns_for_migration() {
    case "$1" in
        "$MIGRATION_INSTITUSI")
            printf '%s\n' institusi nama_institusi_lama is_arsip
            ;;
        "$MIGRATION_AKREDITASI")
            printf '%s\n' lembaga_akreditasi study_program_id nomor_sk peringkat berlaku_mulai berlaku_sampai
            ;;
        *)
            return 1
            ;;
    esac
}

preflight() {
    [[ -f artisan ]] || die "APP_DIR tidak berisi artisan: $APP_DIR. Jalankan dengan APP_DIR=\"\$(pwd)\" dari root project."
    [[ -f .env ]] || die "File .env tidak ditemukan di $APP_DIR"

    command -v php >/dev/null 2>&1 || die "php tidak tersedia"
    command -v composer >/dev/null 2>&1 || die "composer tidak tersedia"
    command -v git >/dev/null 2>&1 || die "git tidak tersedia"

    local current_branch
    current_branch="$(git rev-parse --abbrev-ref HEAD)"
    [[ "$current_branch" == "$BRANCH" ]] || die "Branch aktif '$current_branch', bukan '$BRANCH'."

    local status_output
    status_output="$(git status --short)"

    if [[ -n "$status_output" ]]; then
        printf '%s\n' "$status_output" >&2
        die "Working tree server tidak bersih. Commit atau stash perubahan sebelum rollback."
    fi

    local file name migration_status pending_output
    local -a existing_files=()

    for file in "${MIGRATION_FILES[@]}"; do
        if [[ -f "$file" ]]; then
            existing_files+=("$file")
        else
            warn "File migration tidak ditemukan (mungkin sudah direvert): $file"
        fi
    done

    [[ "${#existing_files[@]}" -gt 0 ]] \
        || die "Tidak ada file migration fitur akreditasi di working tree. Tidak ada yang dapat dirollback."

    migration_status="$(php artisan migrate:status --no-ansi)"
    pending_output="$(php artisan migrate:status --pending --no-ansi)"

    for file in "${existing_files[@]}"; do
        name="$(basename "$file" .php)"

        if grep -Fq "$name" <<<"$pending_output"; then
            die "Migration '$name' masih Pending (belum pernah dijalankan). Tidak ada yang perlu dirollback."
        fi

        grep -Fq "$name" <<<"$migration_status" \
            || die "Migration '$name' tidak tercatat sebagai Ran. Periksa migrate:status terlebih dahulu."
    done

    log "Preflight OK: APP_DIR $APP_DIR, branch '$current_branch', tree bersih, ${#existing_files[@]} file migration fitur siap dirollback."
}

columns_of_documents() {
    php artisan tinker --no-ansi \
        --execute="echo implode(',', Schema::getColumnListing('documents'));" \
        | tr -d '\r\n'
}

verify_columns_removed() {
    local columns column

    columns="$(columns_of_documents)"

    for column in "$@"; do
        if [[ ",$columns," == *",$column,"* ]]; then
            die "Kolom documents.$column masih ada setelah rollback."
        fi
    done

    [[ ",$columns," == *",is_active,"* ]] || die "Kolom documents.is_active hilang. Hentikan dan periksa database."

    log "Verifikasi: kolom $* sudah tidak ada, kolom lama tetap utuh."
}

verify_no_pending_migrations() {
    local pending_output

    pending_output="$(php artisan migrate:status --pending --no-ansi)"

    if grep -Eq '^[[:space:]]*[0-9]{4}_[0-9]{2}_[0-9]{2}_[0-9]{6}_[A-Za-z0-9_]+' <<<"$pending_output"; then
        printf '%s\n' "$pending_output" >&2
        die "Masih ada migration Pending setelah revert kode. Skema dan kode tidak konsisten; aplikasi TETAP maintenance mode."
    fi

    log "Verifikasi: tidak ada migration Pending setelah revert kode."
}

revert_code() {
    case "$REVERT_MODE" in
        server)
            [[ -n "$REVERT_SHA" ]] || die "REVERT_SHA wajib diisi untuk REVERT_MODE=server."

            git cat-file -e "${REVERT_SHA}^{commit}" \
                || die "Commit revert '$REVERT_SHA' tidak ditemukan."

            local parent_count
            parent_count="$(git rev-list --parents -n 1 "$REVERT_SHA" | awk '{ print NF - 1 }')"

            if [[ "$parent_count" -gt 1 ]]; then
                if ! git revert -m 1 --no-edit "$REVERT_SHA"; then
                    git revert --abort || true
                    die "git revert gagal. Aplikasi TETAP maintenance mode sampai operator menyelesaikan revert. Perbaiki konflik secara manual, selesaikan revert, lalu jalankan: php artisan up"
                fi
            else
                if ! git revert --no-edit "$REVERT_SHA"; then
                    git revert --abort || true
                    die "git revert gagal. Aplikasi TETAP maintenance mode sampai operator menyelesaikan revert. Perbaiki konflik secara manual, selesaikan revert, lalu jalankan: php artisan up"
                fi
            fi
            ;;
        pull)
            git pull --ff-only origin "$BRANCH" \
                || die "git pull --ff-only gagal. Aplikasi TETAP maintenance mode karena skema sudah tanpa kolom akreditasi/institusi."
            ;;
        *)
            die "REVERT_MODE tidak valid: '$REVERT_MODE'. Gunakan 'server' atau 'pull'."
            ;;
    esac

    verify_no_pending_migrations

    CODE_REVERTED=1
    log "Kode berhasil dikembalikan."

    if [[ "$REVERT_MODE" == "server" ]]; then
        git push origin "$BRANCH" \
            || die "Revert lokal berhasil tetapi git push gagal. Kode server sudah lama; selesaikan push sebelum menutup sesi."
    fi
}

main() {
    local file name line
    local -a columns=()

    log "Preflight rollback akreditasi"
    preflight

    log "Aktifkan maintenance mode"
    php artisan down --retry=60
    MAINTENANCE_MODE=1

    log "Rollback migration (wajib sebelum revert kode)"
    for file in "${MIGRATION_FILES[@]}"; do
        if [[ ! -f "$file" ]]; then
            warn "Lewati rollback, file tidak ada: $file"
            continue
        fi

        name="$(basename "$file" .php)"

        log "Rollback migration: $name"
        php artisan migrate:rollback --path="$file" --force --no-ansi

        columns=()
        while IFS= read -r line; do
            if [[ -n "$line" ]]; then
                columns+=("$line")
            fi
        done <<<"$(columns_for_migration "$name")"

        log "Verifikasi kolom migration $name sudah hilang"
        verify_columns_removed "${columns[@]}"
    done

    DB_ROLLED_BACK=1

    log "Kembalikan kode"
    revert_code

    log "Install dependency produksi"
    composer install --no-dev --optimize-autoloader --no-interaction

    log "Bersihkan cache aplikasi dan Filament"
    php artisan optimize:clear --no-ansi
    php artisan filament:optimize-clear --no-ansi

    log "Restart worker queue"
    php artisan queue:restart

    log "Reload PHP-FPM"
    reload_php_fpm

    log "Matikan maintenance mode"
    php artisan up
    MAINTENANCE_MODE=0

    log "Rollback selesai"
}

main "$@"
