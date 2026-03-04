<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat daftar Role
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        Role::firstOrCreate(['name' => 'akademik']);

        // 2. Berikan Role ke User Admin yang sudah ada
        // Ganti email sesuai dengan akun admin Anda
        $user = User::where('email', 'admin@unmaris.ac.id')->first();
        if ($user) {
            $user->assignRole($superAdmin);
        }
    }
}
