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
            // PERBAIKAN: Menggunakan 'rekomendation_dari' sebagai kolom acuan yang benar.
            $table->string('bidang_layanan')->nullable()->after('rekomendation_dari');
            $table->enum('jenis_konseli', ['baru', 'lama'])->default('baru')->after('bidang_layanan');
            $table->enum('sumber_rujukan', ['sendiri', 'dosen_pa'])->default('sendiri')->after('jenis_konseli');
            $table->text('tujuan_konseling')->nullable()->after('sumber_rujukan');
            $table->text('deskripsi_masalah')->nullable()->after('tujuan_konseling');
            $table->json('hasil_asesmen')->nullable()->after('deskripsi_masalah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konseling', function (Blueprint $table) {
            $table->dropColumn([
                'bidang_layanan',
                'jenis_konseli',
                'sumber_rujukan',
                'tujuan_konseling',
                'deskripsi_masalah',
                'hasil_asesmen',
            ]);
        });
    }
};