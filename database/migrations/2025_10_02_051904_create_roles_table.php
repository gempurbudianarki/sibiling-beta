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
        Schema::create('roles', function (Blueprint $table) {
            // Primary Key kustom sesuai file .sql
            $table->id('id_role');

            // Nama role, contoh 'admin', 'mahasiswa', dll.
            $table->string('nama_role', 50)->unique();

            // Sesuai struktur lama, tabel ini tidak memiliki timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};