<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentOrganization;
use Illuminate\Support\Str;

class StudentOrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $orgs = [
            // BEM & DPM
            ['name' => 'Badan Eksekutif Mahasiswa (BEM) UNMARIS', 'category' => 'bem_dpm', 'desc' => 'Lembaga eksekutif tertinggi di tingkat universitas yang menaungi seluruh kegiatan kemahasiswaan dan menjadi jembatan aspirasi antara mahasiswa dan rektorat.'],
            ['name' => 'Dewan Perwakilan Mahasiswa (DPM)', 'category' => 'bem_dpm', 'desc' => 'Lembaga legislatif mahasiswa yang bertugas mengawasi kinerja BEM dan menyusun peraturan keluarga mahasiswa UNMARIS.'],
            
            // HMPS
            ['name' => 'HMPS Teknik Informatika', 'category' => 'hmps', 'desc' => 'Wadah mahasiswa Teknik Informatika untuk mengembangkan skill programming, jaringan, dan kecerdasan buatan melalui workshop dan seminar.'],
            ['name' => 'HMPS Bisnis Digital', 'category' => 'hmps', 'desc' => 'Himpunan mahasiswa yang berfokus pada pengembangan jiwa technopreneurship dan inovasi bisnis di era digital.'],
            
            // UKM
            ['name' => 'UKM Paduan Suara Mahasiswa (PSM)', 'category' => 'ukm', 'desc' => 'Wadah penyaluran bakat tarik suara mahasiswa yang rutin mengisi acara wisuda, dies natalis, dan mengikuti kompetisi paduan suara tingkat nasional.'],
            ['name' => 'UKM Olahraga', 'category' => 'ukm', 'desc' => 'Menghimpun mahasiswa yang memiliki minat dan bakat di berbagai cabang olahraga seperti Basket, Voli, Futsal, dan Bulu Tangkis.'],
            ['name' => 'Mahasiswa Pencinta Alam (MAPALA)', 'category' => 'ukm', 'desc' => 'Organisasi yang bergerak di bidang pelestarian lingkungan, ekspedisi alam bebas, dan tanggap darurat bencana di wilayah Sumba.'],
        ];

        foreach ($orgs as $index => $org) {
            StudentOrganization::create([
                'name' => $org['name'],
                'slug' => Str::slug($org['name']),
                'category' => $org['category'],
                'description' => $org['desc'],
                // Generate dummy logo
                'logo' => 'https://via.placeholder.com/150?text=' . urlencode($org['name']),
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }
}
