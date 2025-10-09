<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Ambil data statistik dari database
        $totalDosen = Dosen::count();
        $totalMahasiswa = Mahasiswa::count();
        $totalUsers = User::count();

        // Ambil 5 user terbaru yang memiliki role, beserta relasi rolenya
        $recentUsers = User::whereHas('roles') // Hanya ambil user yang punya role
                            ->with('roles')       // Eager load relasi roles
                            ->latest()            // Urutkan dari yang terbaru
                            ->take(5)             // Ambil 5 saja
                            ->get();

        // Kirim data ke view
        return view('admin.dashboard', [
            'totalDosen' => $totalDosen,
            'totalMahasiswa' => $totalMahasiswa,
            'totalUsers' => $totalUsers,
            'recentUsers' => $recentUsers,
        ]);
    }
}