<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Menampilkan daftar riwayat pengajuan konseling milik mahasiswa.
     */
    public function index()
    {
        // 1. Ambil NIM mahasiswa yang sedang login
        $nim_mahasiswa = Auth::user()->mahasiswa->nim;

        // 2. Ambil semua data konseling yang cocok dengan NIM tersebut
        //    Urutkan berdasarkan tanggal pengajuan paling baru
        $riwayatKonseling = Konseling::where('nim_mahasiswa', $nim_mahasiswa)
                                     ->latest('tgl_pengajuan')
                                     ->get();

        // 3. Kirim data ke view
        return view('mahasiswa.riwayat.index', compact('riwayatKonseling'));
    }

    /**
     * Menampilkan detail dari satu riwayat konseling.
     */
    public function show(Konseling $konseling)
    {
        // Pengecekan keamanan: pastikan mahasiswa hanya bisa melihat riwayatnya sendiri
        if ($konseling->nim_mahasiswa !== Auth::user()->mahasiswa->nim) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
        }

        // Memuat relasi yang mungkin diperlukan di halaman detail
        $konseling->load('jadwal');

        return view('mahasiswa.riwayat.show', compact('konseling'));
    }
}