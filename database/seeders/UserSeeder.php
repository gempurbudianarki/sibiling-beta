<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash; // Penting untuk enkripsi password

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Baris ini bagus ditambahkan agar seeder bisa dijalankan berulang kali tanpa error
        User::where('username', 'admin')->delete();

        // 1. Buat user admin baru
        $adminUser = User::create([
            'name' => 'Admin SIBILING',
            'username' => 'admin',
            'email' => 'admin@sibiling.test', // <-- PERBAIKAN: Tambahkan email dummy
            'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman nanti
        ]);

        // 2. Cari role 'admin' yang sudah ada di database
        $adminRole = Role::where('name', 'admin')->first();

        // 3. Hubungkan user admin dengan role 'admin'
        if ($adminUser && $adminRole) {
            $adminUser->roles()->attach($adminRole);
        }
    }
}