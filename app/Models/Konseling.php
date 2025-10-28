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

    // ================== ARRAY $fillable YANG SUDAH BERSIH ==================
    protected $fillable = [
        // Kolom Asli
        'nim_mahasiswa', 
        'id_dosen_wali', 
        'tgl_pengajuan', 
        'permasalahan',
        'status_konseling', 
        'rekomendation_dari', 
        'sumber_pengajuan',
        'harapan_konseling', 
        'alasan_penolakan',
        
        // Kolom dari Form SOP Dosen Wali (Tetap dipakai)
        'aspek_permasalahan', 
        'permasalahan_segera', 
        'upaya_dilakukan', 
        'harapan_pa',
        
        // Kolom dari Form Mahasiswa (Rencana Baru)
        'deskripsi_masalah',
        'tujuan_konseling', 
        'persetujuan_diberikan_pada', // Untuk Informed Consent
        'tipe_konseli',               // Untuk "Konseli Baru" / "Lama"
        'jenis_permasalahan',         // Untuk Checkbox "Sosial, Belajar, Karir, Pribadi"
        'asesmen_k10',                // Untuk 10 pertanyaan K10 (JSON)

        // Kolom 'hasil_asesmen' yang lama kita HILANGKAN karena diganti 'asesmen_k10'
        // Kolom 'bidang_layanan' & 'jenis_konseli' kita HILANGKAN karena salah
    ];
    // ================== BATAS PERUBAHAN ==================

    protected $casts = [
        'tgl_pengajuan' => 'date',
        'aspek_permasalahan' => 'json',
        
        // --- TAMBAHAN CASTS BARU ---
        'jenis_permasalahan' => 'json', // Cast kolom baru sebagai JSON
        'asesmen_k10' => 'json',        // Cast kolom baru sebagai JSON
        // 'hasil_asesmen' => 'json', // Cast lama yang kita HILANGKAN
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mahasiswa', 'nim');
    }
    
    // Relasi ini sudah benar, jangan diubah
    public function jadwalSesi(): HasMany
    {
        return $this->hasMany(JadwalKonseling::class, 'id_konseling', 'id_konseling');
    }

    public function dosenWali(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_wali', 'email_dos');
    }
}