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
            
            // Kolom 1: tipe_konseli (Untuk "Baru" / "Lama")
            if (!Schema::hasColumn('konseling', 'tipe_konseli')) {
                $table->string('tipe_konseli')->nullable()->after('harapan_konseling');
            }

            // Kolom 2: jenis_permasalahan (Checkbox Sosial/Belajar/dll)
            // Ini yang menyebabkan error
            if (!Schema::hasColumn('konseling', 'jenis_permasalahan')) {
                // Tentukan 'after' berdasarkan kolom 'tipe_konseli'
                $afterColumn1 = Schema::hasColumn('konseling', 'tipe_konseli') ? 'tipe_konseli' : 'harapan_konseling';
                $table->json('jenis_permasalahan')->nullable()->after($afterColumn1);
            }

            // Kolom 3: asesmen_k10 (Untuk 10 pertanyaan K10)
            // Ini kemungkinan besar belum ada
            if (!Schema::hasColumn('konseling', 'asesmen_k10')) {
                // Tentukan 'after' berdasarkan kolom 'jenis_permasalahan'
                $afterColumn2 = Schema::hasColumn('konseling', 'jenis_permasalahan') ? 'jenis_permasalahan' : (Schema::hasColumn('konseling', 'tipe_konseli') ? 'tipe_konseli' : 'harapan_konseling');
                $table->json('asesmen_k10')->nullable()->after($afterColumn2);
            }

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
            // Kita hanya hapus jika ada
            if (Schema::hasColumn('konseling', 'tipe_konseli')) {
                $table->dropColumn('tipe_konseli');
            }
            if (Schema::hasColumn('konseling', 'jenis_permasalahan')) {
                $table->dropColumn('jenis_permasalahan');
            }
            if (Schema::hasColumn('konseling', 'asesmen_k10')) {
                $table->dropColumn('asesmen_k10');
            }
        });
    }
};