<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konseling;

class RiwayatController extends Controller
{
    /**
     * Menampilkan daftar semua riwayat konseling mahasiswa.
     */
    public function index()
    {
        // Ambil NIM mahasiswa yang sedang login
        $nim = Auth::user()->nim;

        // Ambil semua data konseling milik mahasiswa, urutkan dari yang terbaru
        $riwayatKonseling = Konseling::where('nim_mahasiswa', $nim)
                                     ->orderBy('tgl_pengajuan', 'desc')
                                     ->paginate(10); // Kita gunakan pagination agar tidak berat jika data banyak

        return view('mahasiswa.riwayat.index', [
            'riwayat' => $riwayatKonseling
        ]);
    }
}