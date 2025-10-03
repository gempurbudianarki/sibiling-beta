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
            $table->string('nim')->primary();
            $table->string('pswd_mhs');
            $table->boolean('a_default')->default(1);
            $table->string('nm_mhs');
            $table->string('id_prodi');
            $table->string('angkatan', 4);
            $table->string('smt_masuk')->nullable();
            $table->string('id_kelas')->nullable();
            $table->integer('stat_mhs')->nullable();
            $table->boolean('blocked')->default(0);
            $table->string('id_dosen_wali')->nullable();
            $table->string('id_dosen_pembimbing_1')->nullable();
            $table->string('id_dosen_pembimbing_2')->nullable();
            $table->string('tmpt_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->char('jk', 1)->nullable();
            $table->integer('id_agama')->nullable();
            $table->integer('id_jlr_masuk')->nullable();
            $table->string('id_jlr_masuk_feeder')->nullable();
            $table->date('tgl_masuk_kuliah')->nullable();
            $table->string('kewarganegaraan', 2)->nullable();
            $table->string('no_ktp')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->boolean('a_avatar')->default(0);
            $table->string('jln')->nullable();
            $table->string('id_wil_kecamatan')->nullable();
            $table->string('nm_desa')->nullable();
            $table->string('id_desa')->nullable();
            $table->integer('id_jns_tinggal')->nullable();
            $table->integer('id_alat_transport')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable(); // Aturan unique dihapus untuk menerima data kotor
            $table->integer('jlh_sdr_kandung')->nullable();
            $table->string('nm_sekolah_asal')->nullable();
            $table->string('thn_ijazah_asal', 4)->nullable();
            $table->string('nisn')->nullable();
            $table->text('minat_bakat')->nullable();
            $table->string('nm_ayah')->nullable();
            $table->string('no_ktp_ayah')->nullable();
            $table->string('alamat_ayah')->nullable();
            $table->integer('id_jenjang_pendidikan_ayah')->nullable();
            $table->integer('id_pekerjaan_ayah')->nullable();
            $table->integer('id_penghasilan_ayah')->nullable();
            $table->string('nm_ibu_kandung')->nullable();
            $table->string('no_ktp_ibu')->nullable();
            $table->string('alamat_ibu')->nullable();
            $table->integer('id_jenjang_pendidikan_ibu')->nullable();
            $table->integer('id_pekerjaan_ibu')->nullable();
            $table->integer('id_penghasilan_ibu')->nullable();
            $table->string('sk_yudisium')->nullable();
            $table->date('tgl_sk_yudisium')->nullable();
            $table->decimal('ipk', 3, 2)->nullable();
            $table->string('no_seri_ijazah')->nullable();
            $table->string('nm_pt_asal')->nullable();
            $table->string('nm_prodi_asal')->nullable();
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
