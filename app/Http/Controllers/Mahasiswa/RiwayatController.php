<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konseling;

class RiwayatController extends Controller
{
    /**
     * Menampilkan riwayat pengajuan konseling mahasiswa.
     */
    public function index()
    {
        // Mengambil NIM mahasiswa yang sedang login
        $nim = Auth::user()->nim;

        // Mengambil semua data konseling milik mahasiswa tersebut dari database,
        // diurutkan berdasarkan tanggal pengajuan terbaru
        $riwayatKonseling = Konseling::where('nim_mahasiswa', $nim)
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();

        // Mengirim data riwayat ke view
        return view('mahasiswa.riwayat.index', compact('riwayatKonseling'));
    }

    /**
     * Menampilkan detail spesifik dari sebuah sesi konseling.
     */
    public function show(Konseling $konseling)
    {
        // Otorisasi: Pastikan konseling ini milik mahasiswa yang sedang login.
        // Jika tidak, batalkan request.
        if ($konseling->nim_mahasiswa !== Auth::user()->nim) {
            abort(403, 'AKSES DITOLAK');
        }

        // Load relasi jadwal beserta dosen konselingnya untuk ditampilkan di view
        $konseling->load('jadwal.dosenKonseling');

        // Mengirim data konseling yang spesifik ke view 'show'
        return view('mahasiswa.riwayat.show', compact('konseling'));
    }
}