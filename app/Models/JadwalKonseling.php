<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne; // <-- TAMBAHKAN IMPORT INI

class JadwalKonseling extends Model
{
    use HasFactory;

    protected $table = 'jadwal_konseling';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'id_konseling',
        'tgl_sesi',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'id_dosen_konseling',
        'metode_konseling',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function konseling(): BelongsTo
    {
        return $this->belongsTo(Konseling::class, 'id_konseling', 'id_konseling');
    }

    public function dosenKonseling(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_dosen_konseling', 'email');
    }

    // ================== RELASI BARU DITAMBAHKAN DI SINI ==================
    /**
     * Get the hasil konseling record associated with the jadwal.
     */
    public function hasilKonseling(): HasOne
    {
        return $this->hasOne(HasilKonseling::class, 'id_jadwal', 'id_jadwal');
    }
    // ====================================================================
}