<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        // Daftar kategori berita yang umum dan penting untuk website universitas
        $categories = [
            'Berita Utama',
            'Akademik',
            'Kemahasiswaan',
            'Penelitian & Inovasi',
            'Pengabdian Masyarakat',
            'Prestasi & Penghargaan',
            'Kerjasama & Kemitraan',
            'Seputar Kampus',
            'Lowongan & Karir',
            'Event & Seminar',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)], // Unik berdasarkan slug
                ['name' => $name]
            );
        }
    }
}