<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konseling', function (Blueprint $table) {
            // Mengubah kolom id_dosen_wali dari integer menjadi string
            // agar bisa menampung email dosen.
            $table->string('id_dosen_wali')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konseling', function (Blueprint $table) {
            // Kode untuk mengembalikan perubahan jika diperlukan.
            // Laravel akan mencoba mengubahnya kembali ke integer.
            $table->unsignedBigInteger('id_dosen_wali')->change();
        });
    }
};