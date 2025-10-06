<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Konseling;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard yang sesuai dengan peran pengguna.
     */
    public function index()
    {
        $user = Auth::user();

        // Jika user adalah Dosen Pembimbing, langsung arahkan ke dashboard mereka
        if ($user->roles()->where('nama_role', 'dosen_pembimbing')->exists()) {
            return redirect()->route('dosen-pembimbing.dashboard');
        }

        // Siapkan data default untuk view
        $viewData = [];

        // Jika user adalah Admin, kumpulkan data statistik admin
        if ($user->roles()->where('nama_role', 'admin')->exists()) {
            $viewData['is_admin'] = true;
            $viewData['jumlahDosen'] = Dosen::count();
            $viewData['jumlahMahasiswa'] = Mahasiswa::count();
            $viewData['jumlahKonseling'] = Konseling::count();
            $viewData['konselingBaru'] = Konseling::where('status_konseling', 'Diajukan')->count();
        }
        
        // Tampilkan view dashboard umum dengan data yang sudah disiapkan
        return view('dashboard', $viewData);
    }
}