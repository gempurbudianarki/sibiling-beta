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
        Schema::create('jadwal_konseling', function (Blueprint $table) {
            $table->increments('id_jadwal');
            $table->integer('id_konseling');
            
            // --- INI PERBAIKANNYA ---
            $table->string('id_dosen_konseling', 50)->nullable(); // Menambahkan kolom untuk email dosen konselor
            
            $table->date('tgl_sesi');
            $table->string('waktu_mulai', 5);
            $table->string('waktu_selesai', 5)->nullable();
            $table->string('lokasi');
            $table->string('jenis_sesi');
            $table->text('catatan')->nullable();
            $table->string('status_sesi')->default('dijadwalkan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_konseling');
    }
};