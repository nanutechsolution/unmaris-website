<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Scholarship;
use Illuminate\Support\Str;

class ScholarshipSeeder extends Seeder
{
    public function run(): void
    {
        Scholarship::create([
            'title' => 'KIP Kuliah Merdeka',
            'slug' => Str::slug('KIP Kuliah Merdeka'),
            'provider' => 'Kemdikbudristek RI',
            'description' => 'Bantuan biaya pendidikan dari pemerintah bagi lulusan SMA/sederajat yang memiliki potensi akademik baik tetapi memiliki keterbatasan ekonomi.',
            'benefits' => '<ul><li>Pembebasan biaya pendaftaran seleksi masuk.</li><li>Pembebasan biaya kuliah/Uang Kuliah Tunggal (UKT) hingga lulus.</li><li>Bantuan biaya hidup bulanan yang disesuaikan dengan indeks harga daerah.</li></ul>',
            'requirements' => '<ul><li>Siswa SMA/SMK/sederajat yang lulus pada tahun berjalan atau maksimal 2 tahun sebelumnya.</li><li>Memiliki Kartu Indonesia Pintar (KIP) atau terdata di DTKS Kemensos.</li><li>Lulus seleksi penerimaan mahasiswa baru di UNMARIS.</li></ul>',
            'start_date' => now()->subDays(5),
            'end_date' => now()->addMonths(2),
            'registration_url' => '[https://kip-kuliah.kemdikbud.go.id](https://kip-kuliah.kemdikbud.go.id)',
            'is_active' => true,
        ]);

        Scholarship::create([
            'title' => 'Beasiswa Prestasi Yayasan Stella Maris',
            'slug' => Str::slug('Beasiswa Prestasi Yayasan Stella Maris'),
            'provider' => 'Yayasan Stella Maris Sumba',
            'description' => 'Apresiasi dari pihak yayasan bagi calon mahasiswa baru maupun mahasiswa aktif yang memiliki prestasi luar biasa di bidang akademik maupun non-akademik.',
            'benefits' => '<ul><li>Potongan Biaya SPP/UKT sebesar 50% hingga 100% selama 2 semester.</li><li>Prioritas dalam program pertukaran pelajar dan magang.</li></ul>',
            'requirements' => '<ul><li>Memiliki nilai rata-rata raport minimal 85 (bagi maba).</li><li>IPK minimal 3.50 (bagi mahasiswa aktif).</li><li>Melampirkan sertifikat juara lomba minimal tingkat kabupaten/provinsi.</li></ul>',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(1), // Sudah lewat (Tutup)
            'registration_url' => null,
            'is_active' => true,
        ]);
    }
}