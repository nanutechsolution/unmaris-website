<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'label' => 'Admission Open 2025/2026',
                'title' => 'Membangun Masa Depan<br><span class="text-unmaris-yellow">Dari Sumba Untuk Dunia</span>',
                'description' => 'Wujudkan cita-cita di Universitas Stella Maris Sumba. Kampus peradaban yang membentuk karakter unggul, inovatif, dan berdaya saing global.',
                'image' => null, // Anda bisa mengisi path gambar jika sudah ada di storage
                'button_text' => 'Daftar Sekarang',
                'button_url' => 'https://pmb.unmaris.ac.id',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'label' => 'Scholarship Program',
                'title' => 'Pendidikan Berkualitas<br><span class="text-unmaris-yellow">Tanpa Batas Biaya</span>',
                'description' => 'Tersedia berbagai program beasiswa prestasi dan bantuan biaya pendidikan bagi putra-putri terbaik daerah Sumba dan sekitarnya.',
                'image' => null,
                'button_text' => 'Info Beasiswa',
                'button_url' => '/beasiswa',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'label' => 'Modern Facilities',
                'title' => 'Lingkungan Belajar<br><span class="text-unmaris-yellow">Inovatif & Modern</span>',
                'description' => 'Fasilitas penunjang akademik yang lengkap, laboratorium terstandarisasi, dan dukungan sistem E-Learning terpadu untuk kenyamanan belajar.',
                'image' => null,
                'button_text' => 'Lihat Fasilitas',
                'button_url' => '/akademik/sistem-pembelajaran',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slide) {
            Slider::updateOrCreate(
                ['title' => $slide['title']], // Unik berdasarkan judul
                $slide
            );
        }
    }
}