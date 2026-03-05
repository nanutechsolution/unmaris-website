<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        ALTER TABLE documents 
        MODIFY category ENUM(
            'kalender_akademik',
            'jadwal_kuliah',
            'jadwal_ujian',
            'buku_pedoman',
            'kurikulum',
            'peraturan_akademik',
            'formulir_akademik',
            'panduan_skripsi',
            'panduan_kkn',
            'panduan_pkl',
            'beasiswa',
            'kemahasiswaan',
            'kerjasama',
            'akreditasi',
            'laporan',
            'pengumuman_resmi',
            'brosur_pmb',
            'dokumen_umum'
        ) DEFAULT 'dokumen_umum'
    ");
    }

    public function down(): void
    {
        DB::statement("
        ALTER TABLE documents 
        MODIFY category ENUM(
            'kalender_akademik',
            'jadwal_kuliah',
            'buku_pedoman',
            'dokumen_umum'
        ) DEFAULT 'dokumen_umum'
    ");
    }
};
