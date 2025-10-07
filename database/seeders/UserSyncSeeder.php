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
                // Gunakan updateOrCreate untuk mencegah duplikat dan memperbarui jika ada perubahan
                User::updateOrCreate(
                    ['email' => $dosen->email_dos], // Kunci untuk mencari
                    [
                        'name' => $dosen->nm_dos,
                        'username' => explode('@', $dosen->email_dos)[0], // Username dari bagian email
                        'password' => $hashedPassword,
                    ]
                );
                $dosenCount++;
            } catch (\Exception $e) {
                // Log error jika ada email duplikat atau data tidak valid
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
                // Cek email, jika kosong atau tidak valid, lewati.
                if (empty($mahasiswa->email) || !filter_var($mahasiswa->email, FILTER_VALIDATE_EMAIL)) {
                    Log::warning("Email tidak valid atau kosong untuk NIM: {$mahasiswa->nim}. Dilewati.");
                    continue;
                }

                User::updateOrCreate(
                    ['email' => $mahasiswa->email],
                    [
                        'name' => $mahasiswa->nm_mhs,
                        'username' => $mahasiswa->nim, // <-- NIM DIGUNAKAN SEBAGAI USERNAME DI SINI
                        'password' => $hashedPassword,
                    ]
                );
                $mahasiswaCount++;
            } catch (\Exception $e) {
                Log::warning("Gagal menyinkronkan mahasiswa: {$mahasiswa->nim}. Error: " . $e->getMessage());
            }
        }
        $this->command->info("-> Selesai. {$mahasiswaCount} akun Mahasiswa berhasil disinkronkan.");

        $this->command->info("Sinkronisasi User Selesai!");
    }
}