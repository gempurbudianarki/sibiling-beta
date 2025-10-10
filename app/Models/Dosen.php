<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'email_dos';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email_dos', 'email');
    }

    /**
     * Mendapatkan semua mahasiswa yang diwalikan oleh dosen ini.
     */
    public function mahasiswaWali(): HasMany
    {
        // Menghubungkan kolom 'email_dos' di tabel ini
        // ke kolom 'id_dosen_wali' di tabel 'mahasiswa'
        return $this->hasMany(Mahasiswa::class, 'id_dosen_wali', 'email_dos');
    }
}