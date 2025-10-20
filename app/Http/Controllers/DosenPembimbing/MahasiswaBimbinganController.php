<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaBimbinganController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa bimbingan beserta status konseling terakhir mereka.
     */
    public function index()
    {
        // 1. Ambil data dosen yang sedang login
        $dosen = Auth::user()->dosen;

        // ================== PENYEMPURNAAN QUERY DIMULAI DI SINI ==================
        // 2. Ambil semua mahasiswa yang menjadi walinya.
        //    Gunakan 'with('konseling')' untuk mengambil relasi data konseling secara efisien (Eager Loading).
        //    Ini akan mengambil semua riwayat konseling untuk semua mahasiswa wali dalam satu query tambahan.
        $mahasiswaWali = $dosen->mahasiswaWali()->with('konseling', 'prodi')->get();
        // =================== PENYEMPURNAAN QUERY SELESAI DI SINI ===================

        // 3. Kirim data yang sudah lengkap ke view
        return view('dosen-pembimbing.mahasiswa', compact('mahasiswaWali'));
    }
}