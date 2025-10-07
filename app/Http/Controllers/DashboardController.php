<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Konseling;
use App\Models\JadwalKonseling;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $viewData = [];

        // 1. Cek jika user adalah Admin
        if ($user->roles->pluck('name')->contains('admin')) {
            // Asumsi view admin.dashboard sudah ada atau akan dibuat
            // Untuk sementara, kita bisa tampilkan di dashboard terpadu juga
            // return view('admin.dashboard'); 
        }

        // 2. Siapkan data untuk Dosen Pembimbing jika memiliki peran tersebut
        if ($user->roles->pluck('name')->contains('dosen_pembimbing')) {
            $viewData['pa_info'] = [
                'jumlahMahasiswa' => Mahasiswa::where('id_dosen_wali', $user->email)->count(),
                'konselingDiajukan' => 0, // Ini masih bisa di-improve nanti
                'konselingAktif' => 0,
                'konselingSelesai' => 0,
            ];
        }

        // 3. Siapkan data untuk Dosen Konseling jika memiliki peran tersebut
        if ($user->roles->pluck('name')->contains('dosen_konseling')) {
            $viewData['konselor_info'] = [
                'pengajuanBaru' => Konseling::where('status_konseling', 'Diajukan')->count(),
                'jadwalMendatang' => JadwalKonseling::where('status_sesi', 'Dijadwalkan')
                                         ->where('id_dosen_konseling', $user->email)
                                         ->where('tgl_sesi', '>=', now()->toDateString())
                                         ->count(),
            ];
        }

        // 4. Jika bukan salah satu di atas (misal mahasiswa atau role lain),
        //    kembalikan view dashboard standar.
        //    Ini juga menjadi view terpadu untuk dosen.
        return view('dashboard', $viewData);
    }
}