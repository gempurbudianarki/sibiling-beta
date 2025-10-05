<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];

    /**
     * ==== TAMBAHKAN FUNGSI BARU DI BAWAH INI ====
     * Membuat relasi ke tabel Prodi.
     * Satu Mahasiswa hanya punya satu Prodi.
     */
    public function prodi()
    {
        // 'Prodi::class' -> terhubung ke Model Prodi
        // 'id_prodi' -> Foreign key di tabel mahasiswa
        // 'id_prodi' -> Primary key di tabel prodi
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }
}