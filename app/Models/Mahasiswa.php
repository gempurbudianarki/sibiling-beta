<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    /**
     * Get the prodi for the mahasiswa.
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    /**
     * Get the user that owns the mahasiswa profile.
     */
    public function user(): BelongsTo
    {
        // Menghubungkan kolom 'email' di tabel ini ke kolom 'email' di tabel 'users'
        return $this->belongsTo(User::class, 'email', 'email');
    }
}