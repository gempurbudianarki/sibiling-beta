<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('jadwal_konseling', function (Blueprint $table) {
            $table->id('id_jadwal'); // ini otomatis BIGINT UNSIGNED
            $table->unsignedBigInteger('id_konseling');
            $table->string('tgl_sesi');
            $table->string('waktu_mulai')->nullable();
            $table->string('waktu_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->enum('jenis_sesi', ['online', 'offline'])->default('online');
            $table->text('catatan')->nullable();
            $table->enum('status_sesi', ['dijadwalkan', 'selesai'])->default('dijadwalkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_konseling');
    }
};
