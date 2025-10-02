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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim', 50)->primary();
            $table->string('pswd_mhs', 255);

            $table->tinyInteger('a_default')->default(0);
            $table->string('nm_mhs', 150);
            $table->string('id_prodi', 20);
            $table->string('angkatan', 10);
            $table->string('smt_mulai', 10)->nullable();
            $table->char('kelas', 2)->nullable();   // R, A, B, dll
            $table->char('status', 2)->nullable();  // N, L, DO, dll
            $table->tinyInteger('blocked')->default(0);

            $table->string('email', 150)->nullable();
            $table->string('a_avatar', 255)->nullable();

            $table->string('tmpt_lahir', 150)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jk', ['L', 'P'])->nullable();

            $table->unsignedBigInteger('id_agama')->nullable();
            $table->unsignedBigInteger('id_desa')->nullable();
            $table->unsignedBigInteger('id_wil_kecamatan')->nullable();
            $table->unsignedBigInteger('id_jns_tinggal')->nullable();
            $table->unsignedBigInteger('id_alat_transport')->nullable();

            // identitas
            $table->string('nik', 100)->nullable();
            $table->string('no_ktp', 100)->nullable();
            $table->string('no_seri_ijazah', 100)->nullable();
            $table->string('no_hp', 50)->nullable();

            // orang tua / wali
            $table->string('nm_ayah', 150)->nullable();
            $table->string('nm_ibu_kandung', 150)->nullable();
            $table->unsignedBigInteger('id_jenjang_pendidikan_ayah')->nullable();
            $table->unsignedBigInteger('id_pekerjaan_ayah')->nullable();
            $table->unsignedBigInteger('id_penghasilan_ayah')->nullable();
            $table->unsignedBigInteger('id_jenjang_pendidikan_ibu')->nullable();
            $table->unsignedBigInteger('id_pekerjaan_ibu')->nullable();
            $table->unsignedBigInteger('id_penghasilan_ibu')->nullable();

            $table->unsignedBigInteger('id_dosen_wali')->nullable();

            // akademik
            $table->decimal('ipk', 4, 2)->nullable();
            $table->string('sk_yudisium', 100)->nullable();
            $table->date('tgl_sk_yudisium')->nullable();
            $table->tinyInteger('stat_mhs')->default(1);

            // tambahan
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_active')->nullable();

            $table->string('alamat', 255)->nullable();
            $table->string('kode_pos', 20)->nullable();
            $table->string('hobi', 150)->nullable();

            $table->string('sma_nm_sekolah', 150)->nullable();
            $table->string('tahun_lulus', 10)->nullable();

            $table->unsignedBigInteger('id_kelas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
