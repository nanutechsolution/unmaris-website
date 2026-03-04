<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AcademicSeeder extends Seeder
{
    /**
     * Jalankan database seeds untuk data Fakultas & Prodi riil.
     */
    public function run(): void
    {
        // Data Riil yang disesuaikan dengan struktur Model UNMARIS
        $data = [
            [
                'name' => 'Fakultas Teknik',
                'description' => 'Fakultas Teknik berfokus pada pengembangan inovasi teknologi dan rekayasa untuk menjawab kebutuhan industri dan masyarakat modern.',
                'vision' => 'Menjadi fakultas unggul di bidang rekayasa teknologi informasi dan lingkungan di kawasan timur Indonesia pada tahun 2035.',
                'mission' => '<ul><li>Menyelenggarakan pendidikan teknik yang berkualitas tinggi.</li><li>Mengembangkan riset terapan di bidang informatika dan lingkungan.</li></ul>',
                'email' => 'teknik@unmaris.ac.id',
                'phone' => '0811-0000-0001',
                'prodis' => [
                    [
                        'name' => 'Manajemen Informatika',
                        'degree' => 'D3',
                        'accreditation' => 'Baik',
                        'description' => 'Mencetak tenaga ahli madya yang terampil dalam mengelola sistem informasi dan administrasi jaringan komputer institusi.',
                        'career_prospects' => '<ul><li>Junior Programmer</li><li>Database Administrator</li><li>IT Support / Teknisi Jaringan</li></ul>',
                    ],
                    [
                        'name' => 'Teknik Informatika',
                        'degree' => 'S1',
                        'accreditation' => 'Baik Sekali',
                        'description' => 'Fokus mendalam pada rekayasa perangkat lunak (software engineering), kecerdasan buatan, dan pengembangan sistem cerdas.',
                        'career_prospects' => '<ul><li>Software Engineer</li><li>System Analyst</li><li>IT Consultant</li></ul>',
                    ],
                    [
                        'name' => 'Teknik Lingkungan',
                        'degree' => 'S1',
                        'accreditation' => 'Baik Sekali',
                        'description' => 'Mempelajari solusi rekayasa untuk masalah pelestarian lingkungan seperti pengelolaan air bersih, manajemen limbah, dan tata ruang ekologis.',
                        'career_prospects' => '<ul><li>HSE Officer (Health, Safety, Environment)</li><li>Konsultan Lingkungan</li><li>Analis AMDAL</li></ul>',
                    ],
                ]
            ],
            [
                'name' => 'Fakultas Kesehatan',
                'description' => 'Mencetak tenaga kesehatan dan manajerial medis yang profesional, kompeten, dan siap mengabdi pada peningkatan taraf kesehatan masyarakat.',
                'vision' => 'Pusat keunggulan pendidikan administrasi kesehatan dan keselamatan kerja yang inovatif dan berdaya saing.',
                'mission' => '<ul><li>Menghasilkan tenaga manajerial kesehatan yang profesional dan beretika.</li><li>Menyelenggarakan pengabdian masyarakat secara masif di bidang penyuluhan kesehatan.</li></ul>',
                'email' => 'kesehatan@unmaris.ac.id',
                'phone' => '0811-0000-0002',
                'prodis' => [
                    [
                        'name' => 'Keselamatan dan Kesehatan Kerja (K3)',
                        'degree' => 'S1',
                        'accreditation' => 'Baik Sekali',
                        'description' => 'Mempelajari secara komprehensif tentang mitigasi risiko, pencegahan kecelakaan, dan manajemen kesehatan di lingkungan operasional/kerja industri.',
                        'career_prospects' => '<ul><li>HSE Manager</li><li>Auditor K3</li><li>Konsultan Keselamatan dan Kesehatan Kerja</li></ul>',
                    ],
                    [
                        'name' => 'Administrasi Rumah Sakit',
                        'degree' => 'S1',
                        'accreditation' => 'Baik',
                        'description' => 'Mencetak lulusan ahli dalam tata kelola operasional, sumber daya manusia, asuransi, dan manajemen keuangan pada fasilitas pelayanan medis.',
                        'career_prospects' => '<ul><li>Manajer Operasional Rumah Sakit</li><li>Staf Ahli Rekam Medis</li><li>Administrator Klinik/Puskesmas</li></ul>',
                    ],
                ]
            ],
            [
                'name' => 'Fakultas Keguruan',
                'description' => 'Berdedikasi tinggi dalam mencetak tenaga pendidik profesional, berkarakter kebangsaan, dan inovatif untuk memajukan pendidikan generasi penerus.',
                'vision' => 'Menjadi pusat percontohan pendidikan tenaga kependidikan berbasis nilai-nilai karakter luhur dan pemanfaatan teknologi terkini.',
                'mission' => '<ul><li>Menyelenggarakan pendidikan keguruan bermutu yang adaptif terhadap era digital.</li><li>Melakukan pendampingan dan riset di berbagai ekosistem sekolah daerah.</li></ul>',
                'email' => 'keguruan@unmaris.ac.id',
                'phone' => '0811-0000-0003',
                'prodis' => [
                    [
                        'name' => 'Pendidikan Teknologi Informasi',
                        'degree' => 'S1',
                        'accreditation' => 'Baik Sekali',
                        'description' => 'Mempersiapkan tenaga pendidik yang tidak hanya menguasai ilmu pedagogik, tetapi juga ahli dalam bidang teknologi informasi dan komunikasi terapan.',
                        'career_prospects' => '<ul><li>Guru TIK / Informatika</li><li>Pengembang Kurikulum E-Learning</li><li>Instruktur Komputer & Edutech</li></ul>',
                    ],
                ]
            ],
            [
                'name' => 'Fakultas Ekonomi Dan Bisnis',
                'description' => 'Membangun jiwa wirausaha tangguh dan kemampuan manajerial di tengah pusaran ekonomi digital yang berevolusi dengan sangat dinamis.',
                'vision' => 'Menjadi fakultas bisnis terkemuka yang diakui dalam mencetak technopreneur dan profesional adaptif.',
                'mission' => '<ul><li>Mengintegrasikan fundamental ilmu ekonomi dengan model bisnis berbasis teknologi digital.</li><li>Membangun kemitraan strategis dengan entitas industri dan startup.</li></ul>',
                'email' => 'feb@unmaris.ac.id',
                'phone' => '0811-0000-0004',
                'prodis' => [
                    [
                        'name' => 'Bisnis Digital',
                        'degree' => 'S1',
                        'accreditation' => 'Baik',
                        'description' => 'Program studi masa depan yang membedah strategi e-commerce, digital marketing terapan, perancangan startup, dan analisis data bisnis.',
                        'career_prospects' => '<ul><li>Digital Marketing Specialist</li><li>Startup Founder / Entrepreneur</li><li>Business Data Analyst</li></ul>',
                    ],
                ]
            ],
        ];

        // Eksekusi Input Data ke Database
        foreach ($data as $f) {
            // Simpan Data Fakultas
            $faculty = Faculty::updateOrCreate(
                ['slug' => Str::slug($f['name'])], // Menjadikan slug sebagai penanda keunikan
                [
                    'name' => $f['name'],
                    'description' => $f['description'],
                    'vision' => $f['vision'],
                    'mission' => $f['mission'],
                    'email' => $f['email'],
                    'phone' => $f['phone'],
                ]
            );

            // Simpan Data Program Studi yang berelasi dengan Fakultas di atas
            foreach ($f['prodis'] as $p) {
                StudyProgram::updateOrCreate(
                    ['slug' => Str::slug($p['name'])], // Menjadikan slug prodi sebagai penanda keunikan
                    [
                        'faculty_id' => $faculty->id,
                        'name' => $p['name'],
                        'degree' => $p['degree'],
                        'accreditation' => $p['accreditation'],
                        'description' => $p['description'],
                        'career_prospects' => $p['career_prospects'],
                        // Memakai visi/misi khusus prodi, atau turunan dari fakultas jika kosong
                        'vision' => $p['vision'] ?? $f['vision'], 
                        'mission' => $p['mission'] ?? $f['mission'], 
                    ]
                );
            }
        }

        $this->command->info('Data Fakultas dan Program Studi RIIL berhasil digenerate.');
    }
}