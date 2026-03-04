<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['name' => 'Kementerian Pendidikan & Kebudayaan RI', 'type' => 'pemerintah', 'logo' => 'dummy'],
            ['name' => 'Pemerintah Daerah Sumba Barat Daya', 'type' => 'pemerintah', 'logo' => 'dummy'],
            ['name' => 'RSUD Waikabubak', 'type' => 'kesehatan', 'logo' => 'dummy'],
            ['name' => 'Universitas Nusa Cendana', 'type' => 'pendidikan', 'logo' => 'dummy'],
            ['name' => 'Telkom Indonesia', 'type' => 'perusahaan', 'logo' => 'dummy'],
            ['name' => 'Bank NTT', 'type' => 'perusahaan', 'logo' => 'dummy'],
        ];

        foreach ($partners as $index => $p) {
            Partner::create([
                'name' => $p['name'],
                'type' => $p['type'],
                'logo' => 'https://ui-avatars.com/api/?name=' . urlencode($p['name']) . '&background=random&color=fff&size=200',
                'order' => $index,
            ]);
        }
    }
}