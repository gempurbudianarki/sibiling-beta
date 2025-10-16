<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Konseling;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard untuk mahasiswa.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data mahasiswa yang terhubung dengan user,
        //    dan langsung panggil relasi 'dosenWali' yang sudah didefinisikan di model.
        //    Ini adalah cara paling tepat dan efisien (Eager Loading).
        $mahasiswa = $user->mahasiswa()->with('dosenWali')->first();
        $dosenWali = $mahasiswa ? $mahasiswa->dosenWali : null;

        // 2. Mengambil data konseling yang sedang aktif
        $konselingAktif = Konseling::with(['jadwal', 'jadwal.dosenKonseling'])
            ->where('nim_mahasiswa', $user->nim)
            ->whereNotIn('status_konseling', ['Selesai', 'Ditolak'])
            ->first();

        // 3. Menghitung total konseling
        $totalKonseling = Konseling::where('nim_mahasiswa', $user->nim)->count();

        // 4. Kirim semua data yang dibutuhkan ke view
        return view('mahasiswa.dashboard', [
            'konselingAktif' => $konselingAktif,
            'totalKonseling' => $totalKonseling,
            'dosenWali' => $dosenWali, // Kirim objek Dosen Wali yang sudah valid
        ]);
    }
}