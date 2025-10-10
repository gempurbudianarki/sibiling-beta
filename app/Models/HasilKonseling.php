<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilKonseling extends Model
{
    use HasFactory;

    protected $table = 'hasil_konseling';
    protected $primaryKey = 'id_hasil';
    public $incrementing = true;

    protected $fillable = [
        'id_jadwal',
        'catatan_sesi',
        'rekomendasi',
        'status_akhir',
    ];

    public function jadwalKonseling(): BelongsTo
    {
        return $this->belongsTo(JadwalKonseling::class, 'id_jadwal', 'id_jadwal');
    }
}