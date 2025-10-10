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
            // Tambahkan kolom baru setelah 'harapan_pa'
            $table->text('alasan_penolakan')->nullable()->after('harapan_pa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konseling', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
        });
    }
};