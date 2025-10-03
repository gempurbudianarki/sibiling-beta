<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        // PERBAIKAN DI SINI:
        // 1. with('prodi') -> Ambil juga data dari tabel 'prodi' yang terhubung.
        // 2. orderBy('angkatan', 'desc') -> Urutkan berdasarkan angkatan, dari yang terbaru ke terlama.
        $all_mahasiswa = Mahasiswa::with('prodi')->orderBy('angkatan', 'desc')->paginate(15);

        return view('mahasiswa.index', ['all_mahasiswa' => $all_mahasiswa]);
    }
}

