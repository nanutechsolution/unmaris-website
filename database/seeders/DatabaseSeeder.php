<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Role dan Permission

        $this->call([
            UserSeeder::class,
            RolePermissionSeeder::class,
            PageSeeder::class,
            CategorySeeder::class,
            AcademicSeeder::class,
        ]);
    }
}
