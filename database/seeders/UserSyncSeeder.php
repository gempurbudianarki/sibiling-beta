<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSyncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ==================================================================
        // ==== PENTING: TENTUKAN PASSWORD DEFAULT DI SINI ====
        // ==================================================================
        $defaultPassword = 'password123';
        $hashedPassword = Hash::make($defaultPassword);

        $this->command->info("Memulai sinkronisasi Dosen dan Mahasiswa ke tabel Users...");
        $this->command->info("Password default untuk semua akun baru adalah: '$defaultPassword'");

        // 1. Sinkronisasi dari tabel Dosen
        $this->command->line("-> Menyinkronkan data Dosen...");
        $dosenToSync = Dosen::whereNotNull('email_dos')->get();
        $dosenCount = 0;

        foreach ($dosenToSync as $dosen) {
            try {
                $user = User::updateOrCreate(
                    ['email' => $dosen->email_dos],
                    [
                        'name' => $dosen->nm_dos,
                        'username' => explode('@', $dosen->email_dos)[0],
                        'password' => $hashedPassword,
                    ]
                );
                $dosenCount++;
            } catch (\Exception $e) {
                Log::warning("Gagal menyinkronkan dosen: {$dosen->email_dos}. Error: " . $e->getMessage());
            }
        }
        $this->command->info("-> Selesai. {$dosenCount} akun Dosen berhasil disinkronkan.");


        // 2. Sinkronisasi dari tabel Mahasiswa
        $this->command->line("-> Menyinkronkan data Mahasiswa...");
        $mahasiswaToSync = Mahasiswa::whereNotNull('email')->get();
        $mahasiswaCount = 0;

        foreach ($mahasiswaToSync as $mahasiswa) {
            try {
                if (empty($mahasiswa->email) || !filter_var($mahasiswa->email, FILTER_VALIDATE_EMAIL)) {
                    Log::warning("Email tidak valid atau kosong untuk NIM: {$mahasiswa->nim}. Dilewati.");
                    continue;
                }

                $user = User::updateOrCreate( // <-- Simpan hasil ke variabel $user
                    ['email' => $mahasiswa->email],
                    [
                        'name' => $mahasiswa->nm_mhs,
                        'username' => $mahasiswa->nim,
                        'password' => $hashedPassword,
                    ]
                );

                // Memberikan role 'mahasiswa' ke user yang baru dibuat/diupdate
                $user->assignRole('mahasiswa');

                $mahasiswaCount++;
            } catch (\Exception $e) {
                Log::warning("Gagal menyinkronkan mahasiswa: {$mahasiswa->nim}. Error: " . $e->getMessage());
            }
        }
        $this->command->info("-> Selesai. {$mahasiswaCount} akun Mahasiswa berhasil disinkronkan.");

        // === PERBAIKAN DI BARIS DI BAWAH INI ===
        $this->command->info("Sinkronisasi User Selesai!");
    }
}