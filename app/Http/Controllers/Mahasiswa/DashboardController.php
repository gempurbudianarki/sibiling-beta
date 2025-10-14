<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use App\Models\Konseling; // Import model Konseling

class DashboardController extends Controller
{
    /**
     * Display the Mahasiswa dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // === PENAMBAHAN KODE BARU DIMULAI DI SINI ===
        // Ambil NIM mahasiswa yang sedang login
        $nim = Auth::user()->nim;

        // Cari data konseling terakhir berdasarkan tgl_pengajuan
        $konselingTerakhir = Konseling::where('nim_mahasiswa', $nim)
                                     ->orderBy('tgl_pengajuan', 'desc')
                                     ->first();
        // === PENAMBAHAN KODE BARU SELESAI DI SINI ===

        // Kirim data ke view
        return view('mahasiswa.dashboard', [
            'konseling' => $konselingTerakhir
        ]);
    }
}