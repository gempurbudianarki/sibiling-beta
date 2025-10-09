<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding roles...');

        $roles = [
            'admin',
            'dosen_konseling',
            'dosen_pembimbing',
            'mahasiswa',
        ];

        foreach ($roles as $roleName) {
            // Menggunakan 'name' sesuai dengan standar Spatie, bukan 'nama_role'
            Role::updateOrCreate(
                ['name' => $roleName],
                ['guard_name' => 'web']
            );
            $this->command->line("Role '{$roleName}' created or updated.");
        }

        $this->command->info('Roles seeded successfully.');
    }
}