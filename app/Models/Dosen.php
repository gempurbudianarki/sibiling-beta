<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'nidn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    /**
     * Get the user that owns the dosen profile.
     */
    public function user(): BelongsTo
    {
        // Foreign key di tabel 'dosen' adalah 'email_dosen'
        // Owner key (primary key) di tabel 'users' adalah 'email'
        return $this->belongsTo(User::class, 'email_dosen', 'email');
    }
}