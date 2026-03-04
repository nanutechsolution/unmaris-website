<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\News;
use App\Models\Faculty;
use App\Models\StudyProgram;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

    // user
        \App\Models\User::factory()->create([
            'name' => 'Admin Unmaris',
            'email' => 'admin@unmaris.ac.id',
            'password' => bcrypt('password'), // Ganti dengan password yang lebih aman
        ]);
        // Kategori Berita
        $catAkademik = Category::create(['name' => 'Akademik', 'slug' => 'akademik']);
        $catKampus = Category::create(['name' => 'Kegiatan Kampus', 'slug' => 'kegiatan-kampus']);

        // Fakultas & Prodi
        $fkip = Faculty::create([
            'name' => 'Fakultas Keguruan dan Ilmu Pendidikan',
            'slug' => 'fkip',
            'description' => 'Mencetak pendidik profesional yang berkarakter.'
        ]);
        
        StudyProgram::create([
            'faculty_id' => $fkip->id, // $fkip->id sekarang adalah UUID otomatis
            'name' => 'Pendidikan Bahasa Inggris',
            'slug' => 'pendidikan-bahasa-inggris',
            'degree' => 'S1',
            'accreditation' => 'Baik Sekali'
        ]);

        // Berita Dummy
        for ($i = 1; $i <= 10; $i++) {
            News::create([
                'category_id' => $catKampus->id, // $catKampus->id sekarang adalah UUID otomatis
                'title' => "Berita Universitas Stella Maris Ke-$i",
                'slug' => Str::slug("Berita Universitas Stella Maris Ke-$i"),
                'excerpt' => "Ini adalah ringkasan berita ke-$i yang sangat menarik untuk dibaca.",
                'content' => "<p>Ini adalah konten lengkap dari berita ke-$i. Menggunakan format HTML.</p>",
                'is_published' => true,
                'published_at' => now()->subDays($i),
            ]);
        }
    }
}
