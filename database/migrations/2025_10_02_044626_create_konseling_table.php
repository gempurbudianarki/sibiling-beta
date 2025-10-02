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
        Schema::create('konseling', function (Blueprint $table) {
            $table->id('id_konseling');

            // Foreign Key ke tabel mahasiswa. Nanti akan kita hubungkan.
            $table->string('id_mahasiswa');

            // Foreign Key ke tabel dosen (untuk konselor).
            $table->integer('id_dosen_konseling')->nullable();
            
            // Foreign Key ke tabel dosen (untuk dosen yang mengajukan).
            $table->integer('id_dosen_pembimbing_pengaju')->nullable();

            $table->text('permasalahan');
            $table->date('tanggal_pengajuan');
            $table->string('status', 50)->default('menunggu verifikasi');
            $table->text('revisi_catatan')->nullable();

            // Tabel ini tidak punya timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konseling');
    }
};