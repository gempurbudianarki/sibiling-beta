<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan 'nama_role' sesuai dengan file migrasi
        Role::firstOrCreate(['nama_role' => 'admin']);
        Role::firstOrCreate(['nama_role' => 'dosen_pembimbing']);
        Role::firstOrCreate(['nama_role' => 'dosen_konseling']);
        Role::firstOrCreate(['nama_role' => 'mahasiswa']);
    }
}