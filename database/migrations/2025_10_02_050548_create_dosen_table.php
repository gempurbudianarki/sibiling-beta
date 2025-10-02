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
        Schema::create('dosen', function (Blueprint $table) {
            $table->string('email_dos', 150)->primary();
            $table->string('pswd_dos', 255);

            // perbesar ukuran kolom yang sering error
            $table->string('gelar_dpn', 150)->nullable();
            $table->string('nm_dos', 150);
            $table->string('gelar_blkg', 150)->nullable();

            $table->unsignedBigInteger('id_jabins')->nullable();
            $table->tinyInteger('a_default')->default(0);
            $table->tinyInteger('a_struktural')->default(0);
            $table->tinyInteger('a_dosen')->default(1);
            $table->tinyInteger('blocked')->default(0);

            $table->unsignedBigInteger('id_prodi')->nullable();
            $table->string('inisial_ajar', 50)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_active')->nullable();
            $table->string('a_avatar', 255)->nullable();

            $table->string('tmpt_lahir', 150)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jk', ['L', 'P'])->nullable();

            $table->unsignedBigInteger('id_agama')->nullable();
            $table->string('kewarganegaraan', 50)->default('ID');

            $table->unsignedBigInteger('id_desa')->nullable();
            $table->string('jln', 255)->nullable();
            $table->unsignedBigInteger('id_wil_kecamatan')->nullable();
            $table->string('nm_desa', 150)->nullable();
            $table->string('kode_pos', 20)->nullable();
            $table->string('no_hp', 50)->nullable();

            // dokumen identitas, naikin panjang biar aman
            $table->string('no_ktp', 50)->nullable();
            $table->string('npwp', 50)->nullable();
            $table->string('nik', 100)->nullable();
            $table->string('nitk', 50)->nullable();
            $table->string('nidn', 50)->nullable();
            $table->string('nuptk', 50)->nullable();

            $table->unsignedBigInteger('id_jns_dos')->nullable();
            $table->unsignedBigInteger('id_status_dos')->nullable();

            $table->string('kode_bidang_ilmu', 50)->nullable();
            $table->string('kode_bidang_kepakaran', 50)->nullable();

            $table->unsignedBigInteger('id_jabfung')->nullable();
            $table->date('tmt_jabfung')->nullable();
            $table->unsignedBigInteger('id_pangkat_gol')->nullable();
            $table->date('tmt_pangkat_gol')->nullable();

            $table->string('sk_angkat', 100)->nullable();
            $table->date('tmt_sk_angkat')->nullable();
            $table->string('no_sertifikat_serdos', 100)->nullable();

            $table->tinyInteger('a_pt_homebase')->default(1);
            $table->text('about_me')->nullable();

            $table->date('tmt_srt_tgs')->nullable();
            $table->string('nm_ibu_kandung', 150)->nullable();
            $table->string('stat_kawin', 50)->nullable();
            $table->string('nm_suami_istri', 150)->nullable();

            $table->unsignedBigInteger('id_pekerjaan_suami_istri')->nullable();
            $table->integer('jlh_anak')->default(0);

            $table->string('sma_nm_sekolah', 150)->nullable();
            $table->string('diploma_nm_pt', 150)->nullable();
            $table->string('diploma_nm_prodi', 150)->nullable();
            $table->string('s1_nm_pt', 150)->nullable();
            $table->string('s1_nm_prodi', 150)->nullable();
            $table->string('s2_nm_pt', 150)->nullable();
            $table->string('s2_nm_prodi', 150)->nullable();
            $table->string('s3_nm_pt', 150)->nullable();
            $table->string('s3_nm_prodi', 150)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
