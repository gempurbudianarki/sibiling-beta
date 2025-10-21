<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- PASTIKAN HasMany DI-IMPORT
use Illuminate\Database\Eloquent\Relations\HasOne;

class Konseling extends Model
{
    use HasFactory;

    protected $table = 'konseling';
    protected $primaryKey = 'id_konseling';
    public $timestamps = false;

    protected $fillable = [
        'nim_mahasiswa', 'id_dosen_wali', 'tgl_pengajuan', 'permasalahan',
        'status_konseling', 'rekomendation_dari', 'sumber_pengajuan',
        'harapan_konseling', 'alasan_penolakan', 'aspek_permasalahan', 
        'permasalahan_segera', 'upaya_dilakukan', 'harapan_pa',
        'bidang_layanan', 'jenis_konseli', 'tujuan_konseling', 
        'deskripsi_masalah', 'hasil_asesmen',
    ];

    protected $casts = [
        'tgl_pengajuan' => 'date',
        'aspek_permasalahan' => 'json',
        'hasil_asesmen' => 'json',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mahasiswa', 'nim');
    }
    
    // ================== PERUBAHAN KRITIS DI SINI ==================
    // Mengubah nama dan tipe relasi. Satu Konseling bisa punya BANYAK Jadwal Sesi.
    public function jadwalSesi(): HasMany
    {
        return $this->hasMany(JadwalKonseling::class, 'id_konseling', 'id_konseling');
    }
    // =============================================================

    public function dosenWali(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_wali', 'email_dos');
    }
}