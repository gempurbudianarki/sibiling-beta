<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportLegacyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder imports data from a raw SQL file.
     * It's a transitional step to ensure legacy data is seeded correctly
     * within the Laravel ecosystem.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Starting legacy data import from SQL file...');

        // Define the path to the SQL file
        $path = database_path('sql/data_final.sql');

        // Check if the file exists
        if (!File::exists($path)) {
            $this->command->error('SQL file not found at: ' . $path);
            return;
        }

        try {
            // Read the file content
            $sql = File::get($path);

            // Execute the raw SQL queries
            // Using DB::unprepared is suitable for running multi-statement SQL files.
            DB::unprepared($sql);

            $this->command->info('Legacy data imported successfully.');

        } catch (\Exception $e) {
            $this->command->error('Failed to import legacy data: ' . $e->getMessage());
        }
    }
}