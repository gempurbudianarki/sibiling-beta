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
            // Cek dan tambahkan setiap kolom hanya jika belum ada
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
            // Hapus kolom jika ada untuk proses rollback
            $table->dropColumn(['diagnosis', 'prognosis', 'rekomendasi', 'evaluasi']);
        });
    }
};