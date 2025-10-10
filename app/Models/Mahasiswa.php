<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Mendapatkan dosen wali dari mahasiswa ini.
     */
    public function dosenWali(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_wali', 'email_dos');
    }

    /**
     * Mendapatkan semua riwayat konseling mahasiswa ini.
     */
    public function konseling(): HasMany
    {
        return $this->hasMany(Konseling::class, 'nim_mahasiswa', 'nim');
    }
}