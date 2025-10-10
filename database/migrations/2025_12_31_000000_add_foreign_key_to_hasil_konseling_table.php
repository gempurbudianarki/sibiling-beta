<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_konseling', function (Blueprint $table) {
            $table->foreign('id_jadwal')
                  ->references('id_jadwal')
                  ->on('jadwal_konseling')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('hasil_konseling', function (Blueprint $table) {
            $table->dropForeign(['id_jadwal']);
        });
    }
};
