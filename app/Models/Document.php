<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'file_path',
        'is_active',
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
     * Scope dokumen yang boleh tampil di website publik.
     *
     * Dokumen hanya tampil jika aktif dan masa berlakunya belum berakhir.
     * Dokumen tanpa tanggal berlaku_sampai (termasuk seluruh dokumen lama
     * dan kategori selain akreditasi) tetap tampil seperti sebelumnya.
     */
    public function scopeTampilPublik(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query->whereNull('berlaku_sampai')
                    ->orWhereDate('berlaku_sampai', '>=', today());
            });
    }
}
