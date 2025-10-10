<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the Dosen Konseling dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // ================== PERBAIKAN FINAL DENGAN NAMA KOLOM DARI MIGRasi TERBARU ==================
        $pengajuanBaru = Konseling::where('status_konseling', 'menunggu_verifikasi')
                                    ->with('mahasiswa.prodi')
                                    ->latest('tgl_pengajuan') 
                                    ->paginate(10); 

        // Kirim data ke view
        return view('dosen-konseling.dashboard', compact('pengajuanBaru'));
    }
}