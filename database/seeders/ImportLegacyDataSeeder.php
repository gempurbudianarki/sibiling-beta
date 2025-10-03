<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportLegacyDataSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('sql/data_final.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}