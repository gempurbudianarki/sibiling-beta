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
            $table->id('id_jadwal');
            $table->integer('id_konseling');
            $table->date('tanggal_konseling');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai')->nullable();
            $table->string('jenis_konseling', 10)->default('offline');
            $table->string('tempat_konseling')->nullable();
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
