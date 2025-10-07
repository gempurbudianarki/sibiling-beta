<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKonseling extends Model
{
    use HasFactory;

    protected $table = 'hasil_konseling';
    protected $primaryKey = 'id_hasil';
    public $timestamps = false; // Sesuai migrasi Anda

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'id_jadwal',
        'ringkasan_sesi',
        'observasi_konselor',
        'tindak_lanjut',
        'status_akhir_sesi', // 'lanjut' atau 'selesai'
        'tgl_pencatatan',
    ];

    /**
     * Relasi ke model JadwalKonseling (satu hasil milik satu jadwal).
     */
    public function jadwal()
    {
        return $this->belongsTo(JadwalKonseling::class, 'id_jadwal', 'id_jadwal');
    }
}