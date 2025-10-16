<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalKonseling extends Model
{
    use HasFactory;

    protected $table = 'jadwal_konseling';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'id_konseling',
        'id_dosen_konseling',
        'tgl_sesi', // Nama yang benar
        'waktu_mulai',
        'waktu_selesai',
        'lokasi', // Nama yang benar
        'status_sesi', // Nama yang benar
    ];

    public function konseling(): BelongsTo
    {
        return $this->belongsTo(Konseling::class, 'id_konseling', 'id_konseling');
    }

    public function hasilKonseling(): HasOne
    {
        return $this->hasOne(HasilKonseling::class, 'id_jadwal', 'id_jadwal');
    }
    
    public function dosenKonseling(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_konseling', 'email_dos');
    }
}