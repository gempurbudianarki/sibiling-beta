<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Konseling;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     */
    public function index()
    {
        // 1. Ambil data statistik dari database
        $jumlahDosen = Dosen::count();
        $jumlahMahasiswa = Mahasiswa::count();
        $jumlahKonseling = Konseling::count();
        $konselingBaru = Konseling::where('status', 'menunggu verifikasi')->count();

        // 2. Kirim data tersebut ke view 'dashboard'
        return view('dashboard', [
            'jumlahDosen' => $jumlahDosen,
            'jumlahMahasiswa' => $jumlahMahasiswa,
            'jumlahKonseling' => $jumlahKonseling,
            'konselingBaru' => $konselingBaru,
        ]);
    }
}
