<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk membuat user admin awal.
     */
    public function run(): void
    {
        // ===== ROLE =====
        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'editor']);
        Role::firstOrCreate(['name' => 'akademik']);

        // ===== USER ADMIN =====
        $admin = User::updateOrCreate(
            ['email' => 'admin@unmaris.ac.id'],
            [
                'name' => 'Super Admin UNMARIS',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Sync role (stable method)
        $admin->syncRoles(['super_admin']);

        $this->command->info('Seeder UNMARIS selesai');
    }
}
