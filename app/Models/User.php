<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role; // <-- Pastikan ini ada

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
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
     * The roles that belong to the user.
     */
    // FUNGSI INI KITA PERBAIKI DENGAN PETA YANG JELAS
    public function roles()
    {
        return $this->morphToMany(
            Role::class,
            'model',
            'model_has_roles',
            'model_id', // Foreign key di tabel model_has_roles untuk User
            'id_role'     // Foreign key di tabel model_has_roles untuk Role
        );
    }
}