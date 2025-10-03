<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['nama_role' => 'admin']);
        Role::firstOrCreate(['nama_role' => 'dosen']);
        Role::firstOrCreate(['nama_role' => 'mahasiswa']);

        $adminUser = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin SIBILING',
                'email' => 'admin@sibiling.test',
                'password' => Hash::make('password'),
            ]
        );

        $adminUser->roles()->syncWithoutDetaching([$adminRole->id_role]);
    }
}