<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konseling;
use App\Models\JadwalKonseling;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->hasRole('mahasiswa')) {
            $data['konselingTerakhir'] = Konseling::where('nim_mahasiswa', $user->mahasiswa->nim)
                                                  ->with('jadwalSesi')
                                                  ->latest('tgl_pengajuan')
                                                  ->first();
            return view('mahasiswa.dashboard', $data);
        }

        if ($user->hasRole('dosen_konseling')) {
            $data['jumlahPengajuanBaru'] = Konseling::where('status_konseling', 'Menunggu Verifikasi')->count();
            
            // ================== PERBAIKAN LOGIKA QUERY DI SINI ==================
            // Hitung jadwal hari ini yang BELUM memiliki hasil konseling (yang masih aktif)
            $data['jadwalHariIni'] = JadwalKonseling::where('id_dosen_konseling', $user->email)
                                                    ->whereDate('waktu_mulai', Carbon::today())
                                                    ->whereDoesntHave('hasilKonseling') // <-- Logika Kunci
                                                    ->count();
            // ====================================================================

            return view('dosen-konseling.dashboard', $data);
        }

        if ($user->hasRole('dosen_pembimbing')) {
             $dosenEmail = $user->dosen->email_dos;
             $data['mahasiswaDalamKonseling'] = Konseling::where('id_dosen_wali', $dosenEmail)
                                                        ->whereNotIn('status_konseling', ['Selesai', 'Ditolak'])
                                                        ->distinct('nim_mahasiswa')
                                                        ->count();
            $data['totalMahasiswaWali'] = $user->dosen->mahasiswaWali()->count();
            return view('dosen-pembimbing.dashboard', $data);
        }

        if ($user->hasRole('admin')) {
            $data['totalDosen'] = Dosen::count();
            $data['totalMahasiswa'] = Mahasiswa::count();
            $data['totalUsers'] = User::count();
            return view('admin.dashboard', $data);
        }

        return redirect()->route('profile.edit');
    }
}