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
        Schema::create('hasil_konseling', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->integer('id_jadwal');
            $table->text('catatan_konselor');
            $table->text('rekomendasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_konseling');
    }
};
