<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;
use Illuminate\Support\Str;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Laboratorium Komputer Terpadu',
                'description' => 'Dilengkapi dengan PC spesifikasi tinggi dan koneksi internet cepat untuk menunjang praktikum mahasiswa IT dan Bisnis Digital.',
                'image' => "logo-lab.png", // Placeholder gambar
                'order' => 1,
            ],
            [
                'name' => 'Perpustakaan Pusat',
                'description' => 'Menyediakan ribuan koleksi buku cetak, jurnal internasional, dan area baca yang nyaman serta tenang untuk referensi mahasiswa.',
                'image' => "logo-perpus.png", // Placeholder gambar
                'order' => 2,
            ],
            [
                'name' => 'Aula Serbaguna (Auditorium)',
                'description' => 'Ruang pertemuan berkapasitas besar untuk menunjang kegiatan acara wisuda, seminar nasional, dan kegiatan kemahasiswaan skala besar.',
                'image' => "logo-aula.png", // Placeholder gambar
                'order' => 3,
            ],
            [
                'name' => 'Kantin Mahasiswa',
                'description' => 'Menyajikan berbagai pilihan makanan dan minuman dengan harga terjangkau untuk memenuhi kebutuhan gizi mahasiswa selama beraktivitas di kampus.',
                'image' => "logo-kantin.png", // Placeholder gambar
                'order' => 4,
            ],
            [
                'name' => 'Lapangan Olahraga',
                'description' => 'Area terbuka untuk berbagai cabang olahraga seperti basket dan voli guna mendukung kebugaran dan minat bakat mahasiswa UNMARIS.',
                'image' => "logo-lapangan.png", // Placeholder gambar
                'order' => 5,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::updateOrCreate(
                ['slug' => Str::slug($facility['name'])], // Unik berdasarkan nama
                [
                    'name' => $facility['name'],
                    'description' => $facility['description'],
                    'image' => $facility['image'],
                    'order' => $facility['order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
