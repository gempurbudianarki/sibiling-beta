<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating or updating the default admin user...');

        // Cari role 'admin' menggunakan cara standar Spatie
        $adminRole = Role::findByName('admin');

        if (!$adminRole) {
            $this->command->error("Role 'admin' not found. Please run RoleSeeder first.");
            return;
        }

        // Buat atau update user admin
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@sibiling.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'), // Ganti dengan password yang aman
            ]
        );

        // Berikan role 'admin' ke user tersebut
        if (!$adminUser->hasRole($adminRole)) {
            $adminUser->assignRole($adminRole);
            $this->command->info("Role 'admin' assigned to the admin user.");
        }

        $this->command->info('Admin user seeded successfully.');
    }
}