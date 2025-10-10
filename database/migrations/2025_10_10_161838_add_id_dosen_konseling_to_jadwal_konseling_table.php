<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom id_dosen_konseling ke tabel jadwal_konseling
     */
    public function up(): void
    {
        Schema::table('jadwal_konseling', function (Blueprint $table) {
            // Kolom untuk menyimpan email atau ID dosen konseling
            $table->string('id_dosen_konseling')->nullable()->after('id_konseling');
        });
    }

    /**
     * Hapus kolom jika rollback
     */
    public function down(): void
    {
        Schema::table('jadwal_konseling', function (Blueprint $table) {
            $table->dropColumn('id_dosen_konseling');
        });
    }
};
