<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class UserSyncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Memulai sinkronisasi User dari data Dosen...');
        $defaultPassword = Hash::make('password123');

        // Ambil semua dosen dari database
        $all_dosen = Dosen::all();
        $dosenCount = 0;

        foreach ($all_dosen as $dosen) {
            // Lewati jika email dosen kosong, karena itu kunci utama
            if (empty($dosen->email_dos)) {
                $this->command->warn('Melewati dosen "' . $dosen->nm_dos . '" karena tidak ada email.');
                continue;
            }

            // Buat atau perbarui user berdasarkan email
            User::updateOrCreate(
                ['email' => $dosen->email_dos], // Cari berdasarkan email
                [
                    'name' => $dosen->nm_dos,
                    'username' => explode('@', $dosen->email_dos)[0] . ($dosen->nidn ?? ''), // Buat username unik
                    'password' => $defaultPassword,
                ]
            );
            $dosenCount++;
        }

        $this->command->info($dosenCount . ' Dosen telah disinkronkan ke tabel users.');
    }
}