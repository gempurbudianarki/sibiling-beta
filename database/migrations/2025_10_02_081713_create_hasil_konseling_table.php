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
        Schema::create('hasil_konseling', function (Blueprint $table) {
            // Primary key
            $table->id('id_hasil');

            // Foreign key ke jadwal_konseling (tipe harus sama = unsignedBigInteger)
            $table->unsignedBigInteger('id_jadwal');

            // Kolom isi hasil konseling
            $table->text('catatan_sesi');
            $table->text('rekomendasi')->nullable();
            $table->enum('status_akhir', ['tuntas', 'lanjutan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_konseling');
    }
};
