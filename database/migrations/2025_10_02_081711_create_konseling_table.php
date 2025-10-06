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
            // Skema final yang sudah benar dan lengkap
            $table->increments('id_konseling');
            $table->string('nim_mahasiswa', 15);
            $table->string('id_dosen_wali', 50)->nullable();
            $table->date('tgl_pengajuan');
            $table->text('permasalahan')->nullable();
            $table->string('status_konseling');
            $table->string('rekomendation_dari')->nullable();
            $table->json('aspek_permasalahan')->nullable();
            $table->text('permasalahan_segera')->nullable();
            $table->text('upaya_dilakukan')->nullable();
            $table->text('harapan_pa')->nullable();
            $table->string('sumber_pengajuan')->default('dosen_pa');
            $table->text('harapan_konseling')->nullable();
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