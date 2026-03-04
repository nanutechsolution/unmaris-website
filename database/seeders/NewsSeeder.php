<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Jalankan database seeds untuk data berita.
     */
    public function run(): void
    {
        // Mengambil semua kategori yang tersedia
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('Kategori masih kosong. Pastikan CategorySeeder sudah dijalankan!');
            return;
        }

        // Data berita sampel untuk UNMARIS
        $newsData = [
            [
                'title' => 'Pelantikan Rektor Baru Universitas Stella Maris Sumba Periode 2025-2029',
                'category' => 'Berita Utama',
                'excerpt' => 'Momen bersejarah bagi UNMARIS dengan dilantiknya pimpinan baru yang visioner untuk membangun peradaban.',
                'content' => '<p>Universitas Stella Maris Sumba secara resmi melantik Rektor baru untuk masa bakti 2025-2029. Dalam pidato sambutannya, Rektor menekankan pentingnya inovasi teknologi dan penguatan karakter bagi seluruh civitas akademika agar mampu bersaing di kancah internasional.</p><p>Acara ini dihadiri oleh jajaran yayasan, tokoh masyarakat, dan perwakilan pemerintah daerah Sumba Barat Daya.</p>',
            ],
            [
                'title' => 'UNMARIS Raih Akreditasi "Baik Sekali" dari BAN-PT',
                'category' => 'Akademik',
                'excerpt' => 'Pencapaian luar biasa ini membuktikan kualitas mutu pendidikan yang terus meningkat di UNMARIS.',
                'content' => '<p>Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT) secara resmi memberikan predikat "Baik Sekali" kepada institusi Universitas Stella Maris Sumba. Hasil ini merupakan buah kerja keras seluruh staf, dosen, dan mahasiswa dalam menjaga standar kualitas tridarma perguruan tinggi di wilayah Sumba.</p>',
            ],
            [
                'title' => 'Penerimaan Mahasiswa Baru Gelombang 1 Resmi Dibuka',
                'category' => 'Kemahasiswaan',
                'excerpt' => 'Segera bergabung dengan kampus peradaban. Tersedia beasiswa prestasi bagi putra-putri daerah.',
                'content' => '<p>PMB UNMARIS tahun akademik 2025/2026 kini telah membuka pendaftaran gelombang pertama. Calon mahasiswa dapat memilih dari 12 program studi unggulan yang tersedia. Pendaftaran dapat dilakukan sepenuhnya secara daring untuk memudahkan akses dari seluruh wilayah.</p>',
            ],
            [
                'title' => 'Mahasiswa Teknik Informatika Juara Hackathon Nasional',
                'category' => 'Prestasi & Penghargaan',
                'excerpt' => 'Inovasi aplikasi pemantauan pertanian lahan kering berhasil menyisihkan universitas ternama lainnya.',
                'content' => '<p>Prestasi membanggakan datang dari program studi Teknik Informatika. Tim "Sumba Tech" berhasil meraih juara pertama dalam kompetisi Hackathon tingkat nasional dengan inovasi solusi digital untuk kemajuan pertanian di pulau Sumba.</p>',
            ],
            [
                'title' => 'Seminar Internasional: Transformasi Pendidikan di Era AI',
                'category' => 'Event & Seminar',
                'excerpt' => 'Menghadirkan pembicara dari 5 negara untuk membahas tantangan dan peluang kecerdasan buatan.',
                'content' => '<p>UNMARIS sukses menyelenggarakan seminar internasional bertajuk "Masa Depan Pendidikan di Era AI". Seminar ini bertujuan untuk membekali para pendidik dan mahasiswa dengan wawasan terkini mengenai implementasi teknologi dalam proses belajar mengajar.</p>',
            ],
        ];

        foreach ($newsData as $data) {
            // Cari kategori yang sesuai atau gunakan random jika tidak ditemukan
            $category = Category::where('name', $data['category'])->first() ?? $categories->random();

            News::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'category_id' => $category->id,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'featured_image' => null, // Anda dapat mengunggah gambar melalui Admin Panel nantinya
                    'is_published' => true,
                    'published_at' => Carbon::now()->subHours(rand(1, 72)),
                    'views' => rand(150, 2500),
                    'shares' => rand(5, 120),
                ]
            );
        }

        $this->command->info('Data Berita UNMARIS berhasil disemai!');
    }
}