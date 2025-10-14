<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $table = 'konseling';
    protected $primaryKey = 'id_konseling';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // === PENAMBAHAN KODE BARU DIMULAI DI SINI ===
    protected $fillable = [
        'nim_mahasiswa',
        'id_dosen_wali',
        'tgl_pengajuan',
        'permasalahan',
        'status_konseling',
        'rekomendation_dari',
        'aspek_permasalahan',
        'permasalahan_segera',
        'upaya_dilakukan',
        'harapan_pa',
        'sumber_pengajuan',
        'harapan_konseling',
        'alasan_penolakan', // Kolom dari migrasi sebelumnya
        // Kolom baru sesuai SOP
        'bidang_layanan',
        'jenis_konseli',
        'sumber_rujukan',
        'tujuan_konseling',
        'deskripsi_masalah',
        'hasil_asesmen',
    ];
    // === PENAMBAHAN KODE BARU SELESAI DI SINI ===

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tgl_pengajuan' => 'date',
        'aspek_permasalahan' => 'json',
        'hasil_asesmen' => 'json', // Pastikan kolom asesmen juga di-cast sebagai json
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mahasiswa', 'nim');
    }

    public function jadwal()
    {
        return $this->hasOne(JadwalKonseling::class, 'id_konseling', 'id_konseling');
    }
}