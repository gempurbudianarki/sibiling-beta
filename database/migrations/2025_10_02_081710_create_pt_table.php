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
        Schema::create('pt', function (Blueprint $table) {
            $table->id('id_pt');
            $table->string('nm_lemb')->nullable();
            $table->string('motto_lemb')->nullable();
            $table->string('slogan_lemb')->nullable();
            $table->string('nm_daerah')->nullable();
            $table->string('nm_singkat')->nullable();
            $table->string('jns_lemb', 4)->nullable();
            $table->date('tgl_berdiri')->nullable();
            $table->string('sk_pendirian_pt')->nullable();
            $table->date('tgl_sk_pendirian_pt')->nullable();
            $table->string('pemberi_sk_pendirian_pt')->nullable();
            $table->string('jln_lemb')->nullable();
            $table->string('id_wil_kecamatan')->nullable();
            $table->string('nm_desa')->nullable();
            $table->integer('kode_pos')->nullable();
            $table->string('no_tel')->nullable();
            $table->string('no_fax')->nullable();
            $table->string('email_lemb')->nullable();
            $table->string('website_lemb')->nullable();
            $table->string('smt_periode_aktif', 5)->nullable();
            // Kolom lainnya dari file SQL bisa ditambahkan di sini jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt');
    }
};
