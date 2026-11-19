<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasUuids;

    /**
     * Dokumen diterbitkan oleh universitas (kondisi saat ini).
     */
    public const INSTITUSI_UNIVERSITAS = 'universitas';

    /**
     * Dokumen diterbitkan saat institusi masih berstatus sekolah tinggi.
     */
    public const INSTITUSI_SEKOLAH_TINGGI = 'sekolah_tinggi';

    /**
     * Label institusi untuk form dan tabel admin.
     *
     * @var array<string, string>
     */
    public const INSTITUSI_OPTIONS = [
        self::INSTITUSI_UNIVERSITAS => 'Universitas Stella Maris Sumba',
        self::INSTITUSI_SEKOLAH_TINGGI => 'STMIK Stella Maris Sumba (arsip)',
    ];

    protected $fillable = [
        'title',
        'slug',
        'category',
        'institusi',
        'nama_institusi_lama',
        'description',
        'file_path',
        'is_active',
        'is_arsip',
        'lembaga_akreditasi',
        'study_program_id',
        'nomor_sk',
        'peringkat',
        'berlaku_mulai',
        'berlaku_sampai',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'berlaku_mulai' => 'date',
            'berlaku_sampai' => 'date',
            'is_arsip' => 'boolean',
        ];
    }

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class);
    }

    /**
     * Status masa berlaku dokumen akreditasi.
     *
     * Status dihitung dari tanggal berlaku_sampai dan tidak disimpan
     * ke database. Mengembalikan null untuk kategori selain akreditasi
     * atau apabila tanggal berlaku_sampai belum diisi.
     */
    public function getStatusMasaBerlakuAttribute(): ?string
    {
        if ($this->category !== 'akreditasi' || blank($this->berlaku_sampai)) {
            return null;
        }

        $berlakuSampai = $this->berlaku_sampai->copy()->startOfDay();
        $hariIni = today();

        if ($berlakuSampai->lt($hariIni)) {
            return 'Kedaluwarsa';
        }

        if ($berlakuSampai->lte($hariIni->copy()->addDays(180))) {
            return 'Akan Berakhir';
        }

        return 'Berlaku';
    }

    /**
     * Menentukan apakah dokumen diperlakukan sebagai arsip sekolah tinggi.
     *
     * Dokumen bertanda arsip selalu dianggap arsip, termasuk yang masa
     * berlakunya belum lewat. Dokumen akreditasi lama yang sudah kedaluwarsa
     * tetap dianggap arsip agar tidak hilang dari publik.
     */
    public function adalahArsip(): bool
    {
        if ($this->is_arsip) {
            return true;
        }

        return $this->category === 'akreditasi'
            && filled($this->berlaku_sampai)
            && $this->berlaku_sampai->lt(today());
    }

    /**
     * Scope dokumen yang boleh tampil di website publik.
     *
     * Dokumen hanya tampil jika aktif, bukan arsip, dan masa berlakunya belum
     * berakhir. Dokumen tanpa tanggal berlaku_sampai (termasuk seluruh dokumen
     * lama dan kategori selain akreditasi) tetap tampil seperti sebelumnya.
     */
    public function scopeTampilPublik(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query->whereNull('is_arsip')
                    ->orWhere('is_arsip', false);
            })
            ->where(function (Builder $query): void {
                $query->whereNull('berlaku_sampai')
                    ->orWhereDate('berlaku_sampai', '>=', today());
            });
    }

    /**
     * Scope dokumen arsip yang tetap boleh diunduh publik.
     *
     * Arsip mencakup dokumen yang ditandai is_arsip dan dokumen akreditasi
     * yang sudah kedaluwarsa. Keduanya hanya tampil jika masih aktif, sehingga
     * admin tetap dapat menyembunyikan dokumen tertentu dari publik.
     */
    public function scopeTampilArsipPublik(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query->where('is_arsip', true)
                    ->orWhere(function (Builder $query): void {
                        $query->where('category', 'akreditasi')
                            ->whereNotNull('berlaku_sampai')
                            ->whereDate('berlaku_sampai', '<', today());
                    });
            });
    }
}
