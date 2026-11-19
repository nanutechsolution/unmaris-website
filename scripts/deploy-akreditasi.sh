#!/usr/bin/env bash
#
# scripts/deploy-akreditasi.sh
#
# Deploy fitur data akreditasi dokumen pada server produksi.
# Seluruh langkah Bagian C runbook dijalankan oleh skrip ini, sehingga tidak
# ada perintah paste interaktif dan tidak ada jeda antara kode baru aktif dan
# migration berjalan.
#
# Urutan:
#   preflight (APP_DIR berisi artisan + .env, branch, working tree bersih)
#   -> backup database (DB_* dibaca via awk dari .env, cek ukuran > 0 byte)
#   -> php artisan down --retry=60
#   -> git pull --ff-only
#   -> composer install --no-dev --optimize-autoloader
#   -> guard migrate:status (enum Ran, semua Pending hanya migration fitur)
#   -> migrate --pretend (disimpan ke log) + tolak DROP/TRUNCATE/MODIFY
#   -> migrate --force
#   -> verifikasi status migration, kolom, dan foreign key
#   -> optimize:clear, filament:optimize, view:cache
#   -> queue:restart, reload PHP-FPM
#   -> php artisan up
#
# Perilaku trap (disengaja):
# 1. Gagal SEBELUM maintenance mode aktif  -> tidak ada aksi, aplikasi normal.
# 2. Gagal SETELAH down tetapi kode baru BELUM terpasang
#    (mis. git pull gagal)                 -> "php artisan up" dijalankan,
#                                             karena skema dan kode masih lama.
# 3. Gagal pada guard migration            -> maintenance DIPERTAHANKAN agar
#                                             operator memeriksa prasyarat
#                                             (enum harus Ran, tidak ada
#                                             migration Pending di luar fitur)
#                                             sebelum mengulang.
# 4. Gagal SETELAH git pull berhasil       -> maintenance DIPERTAHANKAN, karena
#    (composer, pretend, migrate, verifikasi, cache, queue, PHP-FPM)
#                                             kode baru tidak boleh melayani
#                                             request di atas skema lama.
#    Skrip mencetak commit sebelum pull agar operator bisa memulihkan kode
#    lama bila perlu, lalu menjalankan "php artisan up" secara sadar.
#
# Penggunaan (di server produksi), dijalankan dari root project:
#   cd /path/ke/unmaris-website
#   git fetch origin main
#   git show origin/main:scripts/deploy-akreditasi.sh > /tmp/deploy-akreditasi.sh
#   APP_DIR="$(pwd)" bash /tmp/deploy-akreditasi.sh
#
# Skrip dijalankan dengan "bash", jadi tidak perlu chmod +x (perubahan mode
# file akan mengotori "git status --short" dan ditolak preflight).
#
# Opsi environment:
#   APP_DIR   default: $PWD (direktori kerja saat skrip dijalankan).
#             Wajib berisi "artisan" dan ".env".
#   BRANCH    default: main

set -euo pipefail

BRANCH="${BRANCH:-main}"
MIGRATION_ENUM="2026_03_05_174636_update_category_enum_on_documents_table"
MIGRATION_AKREDITASI="2026_11_19_000000_add_accreditation_fields_to_documents_table"
MIGRATION_INSTITUSI="2026_11_19_000001_add_institusi_fields_to_documents_table"
MIGRATION_FITUR=(
    "$MIGRATION_AKREDITASI"
    "$MIGRATION_INSTITUSI"
)

BACKUP_FILE=""
PRETEND_LOG=""
PRE_PULL_SHA=""
MAINTENANCE_MODE=0
CODE_UPDATED=0
HOLD_MAINTENANCE_ON_FAILURE=0

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
        if [[ "$HOLD_MAINTENANCE_ON_FAILURE" -eq 1 ]]; then
            warn "Guard migration gagal. Aplikasi TETAP dalam maintenance mode."
            warn "Periksa output di atas, perbaiki prasyarat migration, lalu ulangi skrip."
            warn "Setelah yakin aman, keluar dari maintenance dengan: php artisan up"
        elif [[ "$CODE_UPDATED" -eq 1 ]]; then
            warn "Kode baru sudah terpasang. Aplikasi TETAP dalam maintenance mode"
            warn "agar kode baru tidak berjalan di atas skema database lama."
            if [[ -n "$PRE_PULL_SHA" ]]; then
                warn "Commit sebelum git pull: $PRE_PULL_SHA"
                warn "Pulihkan kode lama: git reset --hard $PRE_PULL_SHA"
            fi
            warn "Jika migration sudah selesai, keluar dengan: php artisan up"
        else
            warn "Deploy berhenti sebelum kode berubah. Mengembalikan mode normal."
            php artisan up || true
        fi
    fi

    exit "$exit_code"
}

trap on_exit EXIT

env_value() {
    local key="$1"
    local value

    value="$(awk -v key="$key" '
        BEGIN { prefix = key "=" }
        index($0, prefix) == 1 { print substr($0, length(prefix) + 1); exit }
    ' .env)"

    value="${value%$'\r'}"
    value="${value%\"}"; value="${value#\"}"
    value="${value%\'}"; value="${value#\'}"

    printf '%s' "$value"
}

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
        die "Working tree server tidak bersih. Commit atau stash perubahan sebelum deploy."
    fi

    log "Preflight OK: APP_DIR $APP_DIR, branch '$current_branch', working tree bersih."
}

backup_database() {
    command -v mysqldump >/dev/null 2>&1 || die "mysqldump tidak tersedia"

    local db_host db_port db_database db_username db_password

    db_host="$(env_value DB_HOST)"
    db_port="$(env_value DB_PORT)"
    db_database="$(env_value DB_DATABASE)"
    db_username="$(env_value DB_USERNAME)"
    db_password="$(env_value DB_PASSWORD)"

    [[ -n "$db_database" ]] || die "DB_DATABASE kosong di .env"
    [[ -n "$db_username" ]] || die "DB_USERNAME kosong di .env"

    mkdir -p storage/app/backups

    BACKUP_FILE="storage/app/backups/backup-sebelum-akreditasi-$(date +%Y%m%d-%H%M%S).sql"

    MYSQL_PWD="$db_password" mysqldump \
        --host="${db_host:-127.0.0.1}" \
        --port="${db_port:-3306}" \
        --user="$db_username" \
        --single-transaction \
        --routines \
        --triggers \
        "$db_database" > "$BACKUP_FILE"

    unset MYSQL_PWD

    [[ -s "$BACKUP_FILE" ]] || die "Backup gagal atau berukuran 0 byte: $BACKUP_FILE"

    log "Backup database: $BACKUP_FILE ($(wc -c < "$BACKUP_FILE") byte)"
    printf 'Simpan salinan backup ini ke luar server (scp) sebelum menutup sesi.\n'
}

check_migration_prerequisites() {
    local status_output pending_output line migration pending_display
    local -a pending_list=()
    local -A allowed=()

    status_output="$(php artisan migrate:status --no-ansi)"
    pending_output="$(php artisan migrate:status --pending --no-ansi)"

    printf '%s\n' "$status_output"

    grep -Fq "$MIGRATION_ENUM" <<<"$status_output" \
        || die "Migration enum '$MIGRATION_ENUM' tidak ditemukan pada migrate:status."

    if grep -Fq "$MIGRATION_ENUM" <<<"$pending_output"; then
        die "Migration enum '$MIGRATION_ENUM' masih Pending. Deploy dihentikan."
    fi

    for migration in "${MIGRATION_FITUR[@]}"; do
        allowed["$migration"]=1

        grep -Fq "$migration" <<<"$status_output" \
            || die "Migration '$migration' tidak ditemukan pada migrate:status."
    done

    while IFS= read -r line; do
        if [[ "$line" =~ ^[[:space:]]*([0-9]{4}_[0-9]{2}_[0-9]{2}_[0-9]{6}_[A-Za-z0-9_]+) ]]; then
            pending_list+=("${BASH_REMATCH[1]}")
        fi
    done <<<"$pending_output"

    for migration in "${pending_list[@]}"; do
        if [[ -z "${allowed[$migration]:-}" ]]; then
            warn "Migration Pending di luar fitur akreditasi: $migration"
            die "migrate:status --pending memuat migration yang tidak dikenal. Deploy dihentikan."
        fi
    done

    pending_display="tidak ada"
    if [[ "${#pending_list[@]}" -gt 0 ]]; then
        pending_display="${pending_list[*]}"
    fi

    log "Guard migration OK: enum sudah Ran, ${#pending_list[@]} migration fitur Pending ($pending_display)."
}

columns_of_documents() {
    php artisan tinker --no-ansi \
        --execute="echo implode(',', Schema::getColumnListing('documents'));" \
        | tr -d '\r\n'
}

verify_schema() {
    local columns foreign_keys column
    local -a expected_columns=(
        lembaga_akreditasi
        study_program_id
        nomor_sk
        peringkat
        berlaku_mulai
        berlaku_sampai
        institusi
        nama_institusi_lama
        is_arsip
    )

    columns="$(columns_of_documents)"

    for column in "${expected_columns[@]}"; do
        [[ ",$columns," == *",$column,"* ]] || die "Kolom documents.$column tidak ditemukan."
    done

    foreign_keys="$(php artisan tinker --no-ansi --execute="echo json_encode(Schema::getForeignKeys('documents'));")"

    grep -Fq '"name":"documents_study_program_id_foreign"' <<<"$foreign_keys" \
        || die "Foreign key documents_study_program_id_foreign tidak ditemukan."
    grep -Fq '"columns":["study_program_id"]' <<<"$foreign_keys" \
        || die "Foreign key tidak memakai kolom study_program_id."
    grep -Fq '"foreign_table":"study_programs"' <<<"$foreign_keys" \
        || die "Foreign key study_program_id tidak menunjuk ke study_programs."
    grep -Fq '"on_delete":"set null"' <<<"$foreign_keys" \
        || die "Foreign key study_program_id tidak memakai on delete set null."

    log "Verifikasi kolom dan foreign key berhasil."
}

main() {
    local pending_after status_after migration

    log "Preflight deploy akreditasi"
    preflight

    log "Backup database"
    backup_database

    log "Aktifkan maintenance mode"
    php artisan down --retry=60
    MAINTENANCE_MODE=1

    log "Tarik kode terbaru"
    PRE_PULL_SHA="$(git rev-parse HEAD)"
    git pull --ff-only origin "$BRANCH"
    CODE_UPDATED=1

    log "Install dependency produksi"
    composer install --no-dev --optimize-autoloader --no-interaction

    log "Guard status migration"
    HOLD_MAINTENANCE_ON_FAILURE=1
    check_migration_prerequisites
    HOLD_MAINTENANCE_ON_FAILURE=0

    log "Pratinjau SQL migration"
    PRETEND_LOG="storage/logs/migrate-akreditasi-pretend-$(date +%Y%m%d-%H%M%S).log"
    php artisan migrate --pretend --no-ansi > "$PRETEND_LOG"
    cat "$PRETEND_LOG"

    if grep -Eiq '\b(drop|truncate|modify)\b' "$PRETEND_LOG"; then
        die "Pratinjau SQL memuat DROP/TRUNCATE/MODIFY. Deploy dihentikan sebelum migration dijalankan."
    fi

    log "Pratinjau SQL aman dan disimpan di $PRETEND_LOG"

    log "Jalankan migration"
    php artisan migrate --force --no-ansi

    log "Verifikasi status migration"
    pending_after="$(php artisan migrate:status --pending --no-ansi)"
    for migration in "${MIGRATION_FITUR[@]}"; do
        if grep -Fq "$migration" <<<"$pending_after"; then
            die "Migration '$migration' masih Pending setelah eksekusi."
        fi
    done

    status_after="$(php artisan migrate:status --no-ansi)"
    for migration in "${MIGRATION_FITUR[@]}"; do
        grep -Fq "$migration" <<<"$status_after" \
            || die "Migration '$migration' tidak tercatat pada migrate:status."
    done

    log "Verifikasi skema database"
    verify_schema

    log "Bersihkan cache aplikasi dan Filament"
    php artisan optimize:clear --no-ansi
    php artisan filament:optimize --no-ansi
    php artisan view:cache --no-ansi

    log "Restart worker queue"
    php artisan queue:restart

    log "Reload PHP-FPM"
    reload_php_fpm

    log "Matikan maintenance mode"
    php artisan up
    MAINTENANCE_MODE=0

    log "Deploy selesai"
    printf 'Backup database : %s\n' "$BACKUP_FILE"
    printf 'Pratinjau SQL   : %s\n' "$PRETEND_LOG"
}

main "$@"
