<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'email_dos';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email_dos');
    }

    /**
     * Mendefinisikan relasi one-to-many ke tabel Mahasiswa.
     * Satu Dosen bisa memiliki banyak Mahasiswa bimbingan.
     */
    public function mahasiswaBimbingan()
    {
        // ======================================================
        // ==== PERBAIKANNYA ADA DI SINI ('id_pembimbing' -> 'id_dosen_wali') ====
        // ======================================================
        return $this->hasMany(Mahasiswa::class, 'id_dosen_wali', 'email_dos');
    }
}