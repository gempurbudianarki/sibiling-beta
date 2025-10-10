<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Konseling extends Model
{
    use HasFactory;

    protected $table = 'konseling';
    protected $guarded = [];
    public $timestamps = false;

    // ================== TAMBAHKAN DUA PROPERTI INI ==================
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_konseling';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id_konseling';
    }
    // ==============================================================

    /**
     * Get the mahasiswa that owns the konseling record.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mahasiswa', 'nim');
    }
}