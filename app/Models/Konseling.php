<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne; // Pastikan HasOne di-import

class Konseling extends Model
{
    use HasFactory;

    protected $table = 'konseling';
    protected $primaryKey = 'id_konseling';
    public $timestamps = false;

    protected $fillable = [
        'nim_mahasiswa', 'id_dosen_wali', 'tgl_pengajuan', 'permasalahan',
        'status_konseling', 'rekomendation_dari', 'aspek_permasalahan',
        'permasalahan_segera', 'upaya_dilakukan', 'harapan_pa', 'sumber_pengajuan',
        'harapan_konseling', 'alasan_penolakan', 'bidang_layanan', 'jenis_konseli',
        'sumber_rujukan', 'tujuan_konseling', 'deskripsi_masalah', 'hasil_asesmen',
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

    // === PERBAIKAN RELASI DI SINI ===
    // Nama relasi yang benar adalah 'jadwal' (singular) karena satu konseling punya satu jadwal (hasOne)
    public function jadwal(): HasOne
    {
        return $this->hasOne(JadwalKonseling::class, 'id_konseling', 'id_konseling');
    }
}