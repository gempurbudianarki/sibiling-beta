<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKonseling extends Model
{
    use HasFactory;

    protected $table = 'hasil_konseling';
    protected $primaryKey = 'id_hasil';
    public $timestamps = false;

    protected $guarded = [];
}