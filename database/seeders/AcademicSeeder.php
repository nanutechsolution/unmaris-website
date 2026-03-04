<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Fakultas Keguruan dan Ilmu Pendidikan',
                'description' => 'Fakultas yang berdedikasi tinggi dalam mencetak tenaga pendidik profesional, berkarakter, dan inovatif untuk memajukan pendidikan di wilayah Sumba dan nasional.',
                'vision' => 'Menjadi pusat unggulan pendidikan tenaga kependidikan yang menghasilkan lulusan unggul, religius, dan berdaya saing pada tahun 2030.',
                'mission' => '<ul><li>Menyelenggarakan pendidikan keguruan bermutu.</li><li>Melaksanakan penelitian inovatif di bidang kependidikan.</li><li>Melakukan pengabdian masyarakat berbasis kearifan lokal.</li></ul>',
                'email' => 'fkip@unmaris.ac.id',
                'phone' => '0812-3456-001',
                'prodis' => [
                    [
                        'name' => 'Pendidikan Matematika',
                        'degree' => 'S1',
                        'accreditation' => 'Baik Sekali',
                        'description' => 'Mencetak sarjana pendidikan matematika yang menguasai teknologi pembelajaran modern.',
                        'career_prospects' => '<ul><li>Guru Matematika Sekolah Menengah</li><li>Pengembang Kurikulum</li><li>Peneliti Pendidikan</li><li>Instruktur Bimbel</li></ul>',
                    ],
                    [
                        'name' => 'Pendidikan Guru Sekolah Dasar',
                        'degree' => 'S1',
                        'accreditation' => 'Unggul',
                        'description' => 'Mempersiapkan pendidik sekolah dasar yang kreatif, komunikatif, dan mampu mengelola kelas dengan pendekatan karakter.',
                        'career_prospects' => '<ul><li>Guru Kelas SD</li><li>Konsultan Pendidikan Anak</li><li>Penulis Buku Pendidikan</li><li>Kepala Sekolah SD</li></ul>',
                    ]
                ]
            ],
            [
                'name' => 'Fakultas Sains dan Teknologi',
                'description' => 'Mengembangkan ilmu pengetahuan alam dan teknologi terapan untuk menjawab tantangan zaman di era industri 4.0.',
                'vision' => 'Menjadi fakultas sains dan teknologi yang inovatif dalam pengembangan sumber daya alam lokal untuk kemaslahatan masyarakat.',
                'mission' => '<ul><li>Menyelenggarakan pembelajaran berbasis riset.</li><li>Mengembangkan teknologi tepat guna bagi masyarakat Sumba.</li><li>Membangun jejaring kerja sama industri nasional.</li></ul>',
                'email' => 'fst@unmaris.ac.id',
                'phone' => '0812-3456-002',
                'prodis' => [
                    [
                        'name' => 'Teknik Informatika',
                        'degree' => 'S1',
                        'accreditation' => 'B',
                        'description' => 'Fokus pada pengembangan perangkat lunak, keamanan siber, dan kecerdasan buatan.',
                        'career_prospects' => '<ul><li>Software Engineer</li><li>Data Scientist</li><li>Web & Mobile Developer</li><li>IT Consultant</li></ul>',
                    ],
                    [
                        'name' => 'Agroteknologi',
                        'degree' => 'S1',
                        'accreditation' => 'Baik',
                        'description' => 'Mempelajari optimalisasi lahan kering dan pertanian berkelanjutan di wilayah kepulauan.',
                        'career_prospects' => '<ul><li>Agronomis</li><li>Pengusaha Pertanian (Agropreneur)</li><li>Peneliti Tanaman</li><li>Penyuluh Pertanian</li></ul>',
                    ]
                ]
            ],
            [
                'name' => 'Fakultas Ekonomi dan Bisnis',
                'description' => 'Pusat pengembangan ilmu manajemen dan akuntansi yang berorientasi pada kewirausahaan dan ekonomi digital.',
                'vision' => 'Mencetak pemimpin bisnis dan akuntan profesional yang berintegritas.',
                'mission' => '<ul><li>Melaksanakan pendidikan bisnis berbasis etika.</li><li>Mendorong terciptanya startup lokal.</li><li>Meningkatkan literasi keuangan masyarakat.</li></ul>',
                'email' => 'feb@unmaris.ac.id',
                'phone' => '0812-3456-003',
                'prodis' => [
                    [
                        'name' => 'Manajemen',
                        'degree' => 'S1',
                        'accreditation' => 'Baik Sekali',
                        'description' => 'Mengembangkan keahlian dalam manajemen sumber daya manusia, pemasaran, dan operasional bisnis.',
                        'career_prospects' => '<ul><li>Manager Perusahaan</li><li>Human Resource Specialist</li><li>Marketing Analyst</li><li>Wirausahawan</li></ul>',
                    ],
                    [
                        'name' => 'Akuntansi',
                        'degree' => 'S1',
                        'accreditation' => 'B',
                        'description' => 'Membentuk tenaga akuntan yang handal dalam audit, perpajakan, dan pelaporan keuangan.',
                        'career_prospects' => '<ul><li>Akuntan Publik</li><li>Internal Auditor</li><li>Konsultan Pajak</li><li>Financial Analyst</li></ul>',
                    ]
                ]
            ],
            [
                'name' => 'Fakultas Ilmu Sosial dan Politik',
                'description' => 'Mengkaji dinamika sosial dan politik untuk mewujudkan tata kelola publik yang transparan dan adil.',
                'vision' => 'Menjadi pusat kajian sosial politik yang kritis dan solutif bagi pembangunan daerah.',
                'mission' => '<ul><li>Menyelenggarakan studi kebijakan publik yang relevan.</li><li>Mengembangkan riset sosiologi pedesaan.</li><li>Mendorong partisipasi politik warga yang sehat.</li></ul>',
                'email' => 'fisip@unmaris.ac.id',
                'phone' => '0812-3456-004',
                'prodis' => [
                    [
                        'name' => 'Ilmu Komunikasi',
                        'degree' => 'S1',
                        'accreditation' => 'Baik',
                        'description' => 'Mempelajari jurnalistik, hubungan masyarakat, dan komunikasi pemasaran di era digital.',
                        'career_prospects' => '<ul><li>Public Relations Officer</li><li>Jurnalis / Reporter</li><li>Content Creator</li><li>Media Planner</li></ul>',
                    ],
                    [
                        'name' => 'Sosiologi',
                        'degree' => 'S1',
                        'accreditation' => 'B',
                        'description' => 'Menganalisis fenomena sosial masyarakat dan pemberdayaan komunitas lokal.',
                        'career_prospects' => '<ul><li>Social Worker</li><li>Peneliti Sosial</li><li>LSM / Aktivis Kemanusiaan</li><li>Staff CSR Perusahaan</li></ul>',
                    ]
                ]
            ],
            [
                'name' => 'Fakultas Hukum',
                'description' => 'Fakultas yang mendidik calon penegak hukum yang berintegritas, menjunjung tinggi keadilan, dan hak asasi manusia.',
                'vision' => 'Menghasilkan sarjana hukum yang profesional dan taat asas kebenaran.',
                'mission' => '<ul><li>Pendidikan hukum yang berorientasi pada penegakan keadilan.</li><li>Layanan bantuan hukum bagi masyarakat kurang mampu.</li><li>Penelitian tentang hukum adat dan hukum positif.</li></ul>',
                'email' => 'fh@unmaris.ac.id',
                'phone' => '0812-3456-005',
                'prodis' => [
                    [
                        'name' => 'Ilmu Hukum',
                        'degree' => 'S1',
                        'accreditation' => 'Baik Sekali',
                        'description' => 'Kajian mendalam mengenai hukum pidana, perdata, tata negara, dan hukum administrasi.',
                        'career_prospects' => '<ul><li>Hakim / Jaksa</li><li>Advokat / Pengacara</li><li>Legal Corporate</li><li>Notaris</li></ul>',
                    ],
                    [
                        'name' => 'Hukum Bisnis',
                        'degree' => 'S1',
                        'accreditation' => 'Baik',
                        'description' => 'Spesialisasi hukum dalam transaksi dagang, investasi, dan persaingan usaha.',
                        'career_prospects' => '<ul><li>Legal Consultant</li><li>Arbitrator</li><li>Compliance Officer</li><li>Konsultan Kekayaan Intelektual</li></ul>',
                    ]
                ]
            ],
        ];

        foreach ($data as $f) {
            $faculty = Faculty::updateOrCreate(
                ['slug' => Str::slug($f['name'])],
                [
                    'name' => $f['name'],
                    'description' => $f['description'],
                    'vision' => $f['vision'],
                    'mission' => $f['mission'],
                    'email' => $f['email'],
                    'phone' => $f['phone'],
                ]
            );

            foreach ($f['prodis'] as $p) {
                StudyProgram::updateOrCreate(
                    ['slug' => Str::slug($p['name'])],
                    [
                        'faculty_id' => $faculty->id,
                        'name' => $p['name'],
                        'degree' => $p['degree'],
                        'accreditation' => $p['accreditation'],
                        'description' => $p['description'],
                        'career_prospects' => $p['career_prospects'],
                        'vision' => $f['vision'], // Default mengikuti fakultas atau bisa disesuaikan
                        'mission' => $f['mission'],
                    ]
                );
            }
        }
    }
}