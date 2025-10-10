<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKonseling extends Model
{
    use HasFactory;

    protected $table = 'hasil_konseling';
    protected $primaryKey = 'id_hasil';

    // public $timestamps = false; // Baris ini kita hapus agar cocok dengan migrasi
    
    /**
     * Kolom yang dapat diisi secara massal.
     * Namanya disamakan dengan yang ada di Controller dan View.
     */
    protected $fillable = [
        'id_jadwal',
        'catatan_sesi', // Menggunakan 'catatan_sesi' agar konsisten
        'rekomendasi',  // Menggunakan 'rekomendasi' agar konsisten
        'status_akhir', // Menggunakan 'status_akhir' agar konsisten
    ];

    /**
     * Relasi ke model JadwalKonseling.
     */
    public function jadwal()
    {
        return $this->belongsTo(JadwalKonseling::class, 'id_jadwal', 'id_jadwal');
    }
}