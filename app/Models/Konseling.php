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
     * ==================================================================
     * ==== PERBAIKANNYA ADA DI SINI ====
     * ==================================================================
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
}