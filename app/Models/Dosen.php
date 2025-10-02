<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'id_dos';
    public $timestamps = false;

    // guarded = [] artinya semua kolom boleh diisi.
    // Ini cara cepat karena kolomnya sangat banyak.
    protected $guarded = [];
}