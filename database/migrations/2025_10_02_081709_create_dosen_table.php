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
            $table->string('email_dos')->primary();
            $table->string('pswd_dos');
            $table->string('gelar_dpn')->nullable();
            $table->string('nm_dos');
            $table->string('gelar_blkg')->nullable();
            $table->integer('id_jabins')->nullable();
            $table->boolean('a_default')->default(0);
            $table->boolean('a_struktural')->default(0);
            $table->boolean('a_dosen')->default(1);
            $table->boolean('blocked')->default(0);
            $table->string('id_prodi')->nullable();
            $table->string('inisial_ajar', 10)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_active')->nullable();
            $table->boolean('a_avatar')->default(0);
            $table->string('tmpt_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->char('jk', 1)->nullable();
            $table->integer('id_agama')->nullable();
            $table->string('kewarganegaraan', 2)->nullable();
            $table->string('id_desa')->nullable();
            $table->string('jln')->nullable();
            $table->string('id_wil_kecamatan')->nullable();
            $table->string('nm_desa')->nullable();
            $table->string('kode_pos', 5)->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nik')->nullable();
            $table->string('nitk')->nullable();
            $table->string('nidn')->nullable();
            $table->string('nuptk')->nullable();
            $table->integer('id_jns_dos')->nullable();
            $table->integer('id_status_dos')->nullable();
            $table->string('kode_bidang_ilmu')->nullable();
            $table->string('kode_bidang_kepakaran')->nullable();
            $table->integer('id_jabfung')->nullable();
            $table->date('tmt_jabfung')->nullable();
            $table->integer('id_pangkat_gol')->nullable();
            $table->date('tmt_pangkat_gol')->nullable();
            $table->string('sk_angkat')->nullable();
            $table->date('tmt_sk_angkat')->nullable();
            $table->string('no_sertifikat_serdos')->nullable();
            $table->boolean('a_pt_homebase')->default(1);
            $table->text('about_me')->nullable();
            $table->date('tmt_srt_tgs')->nullable();
            $table->string('nm_ibu_kandung')->nullable();
            $table->integer('stat_kawin')->nullable();
            $table->string('nm_suami_istri')->nullable();
            $table->integer('id_pekerjaan_suami_istri')->nullable();
            $table->string('jlh_anak')->nullable();
            $table->string('sma_nm_sekolah')->nullable();
            $table->string('diploma_nm_pt')->nullable();
            $table->string('diploma_nm_prodi')->nullable();
            $table->string('s1_nm_pt')->nullable();
            $table->string('s1_nm_prodi')->nullable();
            $table->string('s2_nm_pt')->nullable();
            $table->string('s2_nm_prodi')->nullable();
            $table->string('s3_nm_pt')->nullable();
            $table->string('s3_nm_prodi')->nullable();
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