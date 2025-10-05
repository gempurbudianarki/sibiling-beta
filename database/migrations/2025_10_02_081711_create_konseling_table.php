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
            $table->string('id_mahasiswa'); // Ini sudah benar
            $table->integer('id_dosen_konseling')->nullable();
            $table->integer('id_dosen_pembimbing_pengaju')->nullable();
            $table->text('permasalahan');
            $table->date('tanggal_pengajuan');
            $table->string('status', 50)->default('menunggu verifikasi');
            $table->text('revisi_catatan')->nullable();
            
            // ==== TAMBAHKAN DUA KOLOM BARU DI BAWAH INI ====
            $table->string('jenis_konseling')->nullable(); // Untuk menyimpan tipe pengajuan (Rekomendasi Dosen PA, dll)
            $table->string('file_pendukung')->nullable(); // Untuk menyimpan path file surat
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