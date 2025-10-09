<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding process...');

        // 1. Seed the application roles first.
        $this->call(RoleSeeder::class);

        // 2. Import all legacy data from the SQL file.
        // This will populate tables like 'dosen', 'mahasiswa', 'prodi', etc.
        $this->call(ImportLegacyDataSeeder::class);

        // 3. Create the default admin user.
        $this->call(AdminUserSeeder::class);

        // 4. Sync users from 'dosen' and 'mahasiswa' tables.
        // This creates user accounts for all imported lecturers and students.
        $this->call(UserSyncSeeder::class);

        $this->command->info('Database seeding completed successfully.');
    }
}