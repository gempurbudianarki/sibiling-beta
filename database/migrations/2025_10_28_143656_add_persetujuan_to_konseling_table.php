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
        Schema::table('konseling', function (Blueprint $table) {
            // Menambahkan kolom untuk mencatat timestamp persetujuan
            // Kita buat nullable() karena data-data lama mungkin tidak punya persetujuan ini
            // 'after' hanya untuk merapikan, bisa disesuaikan
            $table->timestamp('persetujuan_diberikan_pada')->nullable()->after('harapan_konseling');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konseling', function (Blueprint $table) {
            $table->dropColumn('persetujuan_diberikan_pada');
        });
    }
};