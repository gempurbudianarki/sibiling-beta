<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JadwalKonseling extends Model
{
    use HasFactory;

    protected $table = 'jadwal_konseling';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    /**
     * ===================================================================
     * PERBAIKAN FINAL: Melengkapi $fillable sesuai skema dan controller
     * ===================================================================
     */
    protected $fillable = [
        'id_konseling',
        'id_dosen_konseling',
        'tgl_sesi',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'jenis_sesi',
        'status_sesi',
    ];

    /**
     * Relasi inverse ke Konseling.
     */
    public function konseling(): BelongsTo
    {
        return $this->belongsTo(Konseling::class, 'id_konseling', 'id_konseling');
    }

    /**
     * Relasi ke HasilKonseling.
     */
    public function hasilKonseling(): HasOne
    {
        return $this->hasOne(HasilKonseling::class, 'id_jadwal', 'id_jadwal');
    }
}
