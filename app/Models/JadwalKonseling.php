<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKonseling extends Model
{
    protected $table = 'jadwal_konseling';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'id_konseling',
        'id_dosen_konseling',
        'tgl_sesi',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'jenis_sesi',
        'catatan',
        'status_sesi',
    ];

    public function konseling()
    {
        return $this->belongsTo(Konseling::class, 'id_konseling', 'id_konseling')
            ->with(['mahasiswa']);
    }
}
