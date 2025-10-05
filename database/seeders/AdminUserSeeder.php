<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari Role 'admin' menggunakan kolom 'nama_role'
        $adminRole = Role::where('nama_role', 'admin')->first();

        // 2. Buat User Admin jika belum ada.
        $adminUser = User::firstOrCreate(
            ['username' => 'admin'], // Cari berdasarkan username
            [
                'name' => 'Admin SIBILING',
                'email' => 'admin@sibiling.test',
                'password' => Hash::make('password'),
            ]
        );

        // 3. Hubungkan User dengan Role
        if ($adminRole && $adminUser) {
            $adminUser->roles()->syncWithoutDetaching([$adminRole->id_role]);
        }
    }
}