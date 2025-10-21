<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_konseling', function (Blueprint $table) {
            // Menambahkan kolom baru untuk menyimpan metode konseling (Online/Offline)
            $table->string('metode_konseling')->nullable()->after('waktu_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_konseling', function (Blueprint $table) {
            $table->dropColumn('metode_konseling');
        });
    }
};