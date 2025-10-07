<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seeder-seeder ini akan dijalankan secara berurutan
        $this->call([
            RoleSeeder::class,      // 1. Buat peran (roles) terlebih dahulu
            AdminUserSeeder::class, // 2. Buat user admin
            
            // ==================================================================
            // ==== TAMBAHKAN PEMANGGILAN SEEDER BARU DI SINI ====
            // ==================================================================
            UserSyncSeeder::class,  // 3. Sinkronkan Dosen & Mahasiswa ke tabel Users
        ]);
    }
}