<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role tersedia
        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'editor']);
        Role::firstOrCreate(['name' => 'akademik']);

        // Ambil user admin
        $user = User::where('email', 'admin@unmaris.ac.id')->first();

        if ($user) {
            // ⭐ Gunakan string role name (lebih stabil)
            $user->syncRoles(['super_admin']);
        }
    }
}
