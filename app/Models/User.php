<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the dosen record associated with the user.
     */
    public function dosen(): HasOne
    {
        // ================== PERBAIKAN DI SINI ==================
        // Menghubungkan 'email' dari tabel users ke 'email_dos' di tabel dosen
        return $this->hasOne(Dosen::class, 'email_dos', 'email');
    }

    /**
     * Get the mahasiswa record associated with the user.
     */
    public function mahasiswa(): HasOne
    {
        // Menghubungkan 'email' dari tabel users ke 'email' di tabel mahasiswa
        return $this->hasOne(Mahasiswa::class, 'email', 'email');
    }
}