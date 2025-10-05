<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportLegacyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file SQL kamu
        $path = 'database/sql/data_final.sql';

        // Cek jika file ada sebelum dieksekusi
        if (file_exists($path)) {
            // Eksekusi query mentah dari file .sql
            DB::unprepared(file_get_contents($path));
            $this->command->info('Legacy data from data_final.sql imported successfully.');
        } else {
            $this->command->error('Could not find data_final.sql file.');
        }
    }
}