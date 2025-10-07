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
     * Mendefinisikan kolom yang boleh diisi melalui create() atau update().
     */
    protected $fillable = [
        'nim_mahasiswa',
        'id_dosen_wali',
        'tgl_pengajuan',
        'status_konseling',
        'sumber_pengajuan',
        'permasalahan_segera',
        'harapan_konseling',
    ];

    /**
     * Relasi ke tabel Mahasiswa.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mahasiswa', 'nim');
    }

    /**
     * Relasi ke tabel JadwalKonseling (satu konseling bisa punya banyak jadwal/sesi).
     */
    public function jadwal()
    {
        return $this->hasMany(JadwalKonseling::class, 'id_konseling', 'id_konseling');
    }
}