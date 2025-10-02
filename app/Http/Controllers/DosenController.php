<?php

namespace App\Http\Controllers;

use App\Models\Dosen; // <-- Import model Dosen
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        // Ambil semua data dosen, tapi kita batasi 50 dulu biar tidak berat
        $dosen = Dosen::take(50)->get();

        // Kirim data ke view
        return view('dosen.index', ['dosen' => $dosen]);
    }
}