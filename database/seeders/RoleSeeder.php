<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // <-- JANGAN LUPA tambahkan baris ini di atas

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Perintah ini akan memasukkan data ke dalam tabel 'roles'
        // menggunakan Model 'Role' yang baru saja kita buat.
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'dosen_pembimbing']);
        Role::create(['name' => 'dosen_konseling']);
        Role::create(['name' => 'mahasiswa']);
    }
}