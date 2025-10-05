<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Konseling;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard yang sesuai berdasarkan peran user.
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan user valid sebelum melanjutkan
        if (!$user || !($user instanceof User)) {
            return redirect()->route('login');
        }

        // Cek jika user adalah DOSEN PEMBIMBING, langsung arahkan
        if ($user->roles()->where('nama_role', 'dosen_pembimbing')->exists()) {
            return redirect()->route('dosen-pembimbing.dashboard');
        }
        
        // Siapkan data default untuk semua user
        $viewData = [
            'is_admin' => false,
            'jumlahDosen' => 0,
            'jumlahMahasiswa' => 0,
            'jumlahKonseling' => 0,
            'konselingBaru' => 0,
        ];

        // Jika user adalah ADMIN, isi dengan data asli
        if ($user->roles()->where('nama_role', 'admin')->exists()) {
            $viewData['is_admin'] = true;
            $viewData['jumlahDosen'] = Dosen::count();
            $viewData['jumlahMahasiswa'] = Mahasiswa::count();
            $viewData['jumlahKonseling'] = Konseling::count();
            $viewData['konselingBaru'] = Konseling::where('status', 'Diajukan')->count();
        }
        
        // Untuk semua peran lain (Admin, Dosen Konseling, Mahasiswa, dll),
        // tampilkan view 'dashboard' dengan data yang sudah disiapkan.
        return view('dashboard', $viewData);
    }
}