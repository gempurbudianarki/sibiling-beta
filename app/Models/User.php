<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany; // <-- Tambahkan ini

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @property-read Dosen|null $dosen
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
     * ==================================================================
     * ==== INI ADALAH PERBAIKANNYA ====
     * ==================================================================
     * Relasi polymorphic many-to-many ke model Role.
     * 'model' adalah nama dari relasi polymorphic di tabel pivot.
     */
    public function roles(): MorphToMany
    {
        // Mengubah dari belongsToMany menjadi morphToMany
        return $this->morphToMany(Role::class, 'model', 'model_has_roles', 'model_id', 'id_role');
    }

    /**
     * Relasi one-to-one ke model Dosen.
     */
    public function dosen(): HasOne
    {
        return $this->hasOne(Dosen::class, 'email_dos', 'email');
    }
}