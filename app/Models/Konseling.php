<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Ubah import dari HasOne
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Konseling extends Model
{
    use HasFactory;

    protected $table = 'konseling';
    protected $primaryKey = 'id_konseling';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'nim_mahasiswa',
        'id_dosen_wali',
        'id_dosen_konseling',
        'tgl_pengajuan',
        'status_konseling',
        'sumber_pengajuan',
        'rekomendation_dari',
        'aspek_permasalahan',
        'permasalahan_segera',
        'upaya_dilakukan',
        'harapan_pa',
        'permasalahan',
        'harapan',
        'alasan_penolakan',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mahasiswa', 'nim');
    }

    public function dosenKonseling(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_konseling', 'email_dos');
    }

    /**
     * ===================================================================
     * PERBAIKAN: Mengubah relasi dari HasOne menjadi HasMany
     * ===================================================================
     * Satu Konseling bisa memiliki BANYAK JadwalKonseling.
     */
    public function jadwalKonseling(): HasMany
    {
        return $this->hasMany(JadwalKonseling::class, 'id_konseling', 'id_konseling');
    }

    /**
     * Relasi ini tetap benar karena kita ingin mengambil 'satu hasil terakhir melalui banyak jadwal'.
     * Namun, untuk kasus ini kita tidak menggunakannya secara langsung di detail view.
     */
    public function hasilKonseling(): HasOneThrough
    {
        return $this->hasOneThrough(
            HasilKonseling::class,
            JadwalKonseling::class,
            'id_konseling',
            'id_jadwal',
            'id_konseling',
            'id_jadwal'
        );
    }
}