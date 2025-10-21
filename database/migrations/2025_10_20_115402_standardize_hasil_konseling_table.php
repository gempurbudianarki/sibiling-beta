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
        Schema::table('hasil_konseling', function (Blueprint $table) {
            // Hapus kolom lama yang tidak terpakai jika ada
            if (Schema::hasColumn('hasil_konseling', 'catatan_sesi')) {
                $table->dropColumn('catatan_sesi');
            }

            // Tambahkan kolom-kolom baru yang dibutuhkan oleh aplikasi HANYA JIKA BELUM ADA
            if (!Schema::hasColumn('hasil_konseling', 'diagnosis')) {
                $table->text('diagnosis')->nullable()->after('id_jadwal');
            }
            if (!Schema::hasColumn('hasil_konseling', 'prognosis')) {
                $table->text('prognosis')->nullable()->after('diagnosis');
            }
            if (!Schema::hasColumn('hasil_konseling', 'rekomendasi')) {
                $table->text('rekomendasi')->nullable()->after('prognosis');
            }
            if (!Schema::hasColumn('hasil_konseling', 'evaluasi')) {
                $table->text('evaluasi')->nullable()->after('rekomendasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_konseling', function (Blueprint $table) {
            // Logika untuk mengembalikan jika diperlukan
            if (!Schema::hasColumn('hasil_konseling', 'catatan_sesi')) {
                $table->text('catatan_sesi')->nullable();
            }
            $table->dropColumn(['diagnosis', 'prognosis', 'rekomendasi', 'evaluasi']);
        });
    }
};