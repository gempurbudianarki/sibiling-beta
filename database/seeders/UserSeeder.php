<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSyncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting User & Role Synchronization...');

        // Ambil role yang relevan
        $dosenRole = Role::where('nama_role', 'dosen_pembimbing')->first();
        $mahasiswaRole = Role::where('nama_role', 'mahasiswa')->first();
        $defaultPassword = Hash::make('password123'); // Password default untuk semua user baru

        // 1. Sinkronisasi Dosen ke Tabel User
        if ($dosenRole) {
            $all_dosen = Dosen::all();
            $dosenCount = 0;
            foreach ($all_dosen as $dosen) {
                // Lewati jika email dosen kosong, karena itu kunci utama kita
                if (empty($dosen->email_dos)) {
                    continue;
                }

                // Buat atau update user berdasarkan email
                $user = User::updateOrCreate(
                    ['email' => $dosen->email_dos], // Kunci pencarian: email
                    [
                        'name' => $dosen->nm_dos,
                        // Buat username unik dari bagian depan email
                        'username' => explode('@', $dosen->email_dos)[0] . ($dosen->nidn ?? ''),
                        'password' => $defaultPassword,
                    ]
                );

                // Kita tidak berikan role default di sini. Pemberian role dilakukan manual oleh admin.
                // Jika kamu ingin semua dosen otomatis jadi dosen pembimbing, hapus komentar di baris bawah ini
                // $user->roles()->syncWithoutDetaching([$dosenRole->id_role]);
                $dosenCount++;
            }
            $this->command->info($dosenCount . ' Dosen synced to users table.');
        } else {
            $this->command->warn('Role "dosen_pembimbing" not found. Skipping Dosen sync.');
        }

        // 2. Sinkronisasi Mahasiswa ke Tabel User (jika diperlukan di masa depan)
        // Untuk saat ini kita fokus pada Dosen
        if ($mahasiswaRole) {
            // Logika untuk mahasiswa bisa ditambahkan di sini dengan cara yang sama
             $this->command->info('Mahasiswa sync skipped for now.');
        }

        $this->command->info('User & Role Synchronization finished.');
    }
}