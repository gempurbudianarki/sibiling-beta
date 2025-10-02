<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $table = 'konseling';
    protected $primaryKey = 'id_konseling';
    public $timestamps = false;

    // Izinkan semua kolom untuk diisi
    protected $guarded = [];
}