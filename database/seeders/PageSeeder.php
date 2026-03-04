<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // Data Halaman Profil Universitas (Data Lama)
        Page::updateOrCreate(
            ['slug' => 'profil-universitas'],
            [
                'title' => 'Profil Universitas Stella Maris Sumba',
                'meta_description' => 'Mengenal lebih dekat visi, misi, dan sejarah Universitas Stella Maris Sumba (UNMARIS).',
                'content' => [
                    'sambutan' => 'Selamat datang di kampus peradaban. Kami berkomitmen untuk tidak hanya mencetak lulusan yang cerdas secara akademik, tetapi juga memiliki karakter dan integritas yang tinggi untuk membangun Sumba dan Indonesia.',
                    'visi' => 'Menjadi universitas unggul dan berdaya saing global yang berlandaskan nilai-nilai karakter dalam menghasilkan lulusan yang inovatif dan profesional pada tahun 2035.',
                    'misi' => '<ul><li>Menyelenggarakan pendidikan dan pengajaran yang bermutu.</li><li>Melaksanakan penelitian terapan.</li><li>Melaksanakan pengabdian kepada masyarakat.</li><li>Membangun tata kelola universitas yang baik.</li></ul>',
                    'sejarah' => '<h2>Membangun Peradaban dari Timur</h2><p>Universitas Stella Maris Sumba (UNMARIS) didirikan sebagai respons terhadap tingginya kebutuhan akan pendidikan tinggi yang berkualitas di wilayah Sumba Barat Daya dan sekitarnya.</p>'
                ],
            ]
        );

        // Data Halaman Kontak (Data Baru)
        Page::updateOrCreate(
            ['slug' => 'kontak'],
            [
                'title' => 'Hubungi Kami',
                'meta_description' => 'Pintu kami selalu terbuka. Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan seputar pendaftaran, akademik, atau kerjasama.',
                'content' => [
                    'alamat' => 'Jl. Pendidikan No. 1, Tambolaka, Kab. Sumba Barat Daya, Nusa Tenggara Timur',
                    'email' => 'info@unmaris.ac.id',
                    'telepon' => '0812-3456-7890 (Jam Kerja)',
                    // Mengambil src dari embed maps yang sudah kita buat sebelumnya
                    'peta_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126442.2783852236!2d119.1417006!3d-9.4215758!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4bac8f48039645%3A0xc3b86e066e44b95d!2sTambolaka%2C%20Kabupaten%20Sumba%20Barat%20Daya%2C%20Nusa%20Tenggara%20Tim.!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid'
                ],
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'sistem-pembelajaran'],
            [
                'title' => 'Sistem Pembelajaran',
                'meta_description' => 'Informasi mengenai pendekatan akademik, sistem SKS, dan E-Learning di Universitas Stella Maris Sumba.',
                'content' => [
                    // Menggunakan key 'umum' sesuai dengan Form default yang sudah kita buat
                    'umum' => '<h2>Pendekatan Pembelajaran Modern</h2>
                    <p>Universitas Stella Maris Sumba (UNMARIS) menerapkan sistem pembelajaran <strong>Blended Learning</strong>, yang menggabungkan metode tatap muka interaktif di kelas dengan pembelajaran daring (online) melalui platform E-Learning kampus yang canggih.</p>
                    
                    <h3>Platform E-Learning UNMARIS</h3>
                    <p>Setiap mahasiswa akan diberikan akses penuh ke portal E-Learning interaktif kami. Melalui portal ini, mahasiswa dapat mengunduh materi kuliah, mengumpulkan tugas, mengikuti kuis terjadwal, serta berdiskusi aktif dengan dosen dan sesama mahasiswa kapan saja dan di mana saja.</p>
                    
                    <h3>Sistem Kredit Semester (SKS)</h3>
                    <p>Beban studi mahasiswa dinyatakan dalam Satuan Kredit Semester (SKS). Sistem ini memberikan keleluasaan bagi mahasiswa untuk merancang rencana studinya sendiri setiap semester, dengan berkonsultasi secara intensif bersama Dosen Pembimbing Akademik (DPA) sesuai dengan capaian Indeks Prestasi (IP).</p>
                    
                    <h3>Penilaian Akademik</h3>
                    <ul>
                        <li>Tugas dan Kuis (20%)</li>
                        <li>Kehadiran dan Keaktifan (10%)</li>
                        <li>Ujian Tengah Semester / UTS (30%)</li>
                        <li>Ujian Akhir Semester / UAS (40%)</li>
                    </ul>'
                ],
            ]
        );


        Page::updateOrCreate(
            ['slug' => 'profil-lppm'],
            [
                'title' => 'Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM)',
                'meta_description' => 'Motor penggerak Tri Dharma Perguruan Tinggi di Universitas Stella Maris Sumba yang berfokus pada inovasi dan pemberdayaan masyarakat lokal.',
                'content' => [
                    'umum' => '<h2>Visi LPPM UNMARIS</h2>
                    <p>Menjadi lembaga riset dan pemberdayaan masyarakat yang unggul, inovatif, dan berdampak langsung pada pembangunan peradaban Sumba dan Indonesia Timur.</p>
                    
                    <h3>Fokus Penelitian Unggulan</h3>
                    <ul>
                        <li>Pengembangan Teknologi Agrikultur Lahan Kering</li>
                        <li>Konservasi Budaya dan Kearifan Lokal Sumba</li>
                        <li>Digitalisasi Pendidikan dan Bisnis Daerah</li>
                        <li>Kesehatan Masyarakat dan Sanitasi Lingkungan</li>
                    </ul>
                    
                    <h3>Program Pengabdian</h3>
                    <p>Kami rutin menerjunkan mahasiswa dan dosen ke desa-desa binaan melalui program Kuliah Kerja Nyata (KKN) Tematik dan pemberdayaan UMKM lokal agar inovasi akademik dapat dirasakan manfaatnya secara nyata oleh masyarakat luas.</p>'
                ],
            ]
        );
    }
}
