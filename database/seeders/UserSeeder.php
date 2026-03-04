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
        // Memastikan Role 'super_admin' tersedia di database untuk mencegah error RoleDoesNotExist
        Role::firstOrCreate(['name' => 'super_admin']);

        // Membuat atau memperbarui akun Super Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@unmaris.ac.id'], // Unik berdasarkan email
            [
                'name' => 'Super Admin UNMARIS',
                'password' => Hash::make('password'), // Silakan ganti password ini jika sudah di production
                'email_verified_at' => now(),
            ]
        );

        // Memberikan Role 'super_admin' jika user belum memilikinya
        if (!$admin->hasRole('super_admin')) {
            $admin->assignRole('super_admin');
        }

        $this->command->info('User Admin berhasil dibuat dengan email: admin@unmaris.ac.id');
    }
}
