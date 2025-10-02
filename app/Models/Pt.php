<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pt extends Model
{
    use HasFactory;

    protected $table = 'pt';
    protected $primaryKey = 'id_pt';
    public $timestamps = false;

    // Izinkan semua kolom untuk diisi
    protected $guarded = [];
}