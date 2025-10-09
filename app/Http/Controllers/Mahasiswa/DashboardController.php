<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Mahasiswa dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Logic untuk data dashboard mahasiswa
        // Contoh: status pengajuan konseling terakhir, jadwal konseling mendatang, dll.
        return view('mahasiswa.dashboard');
    }
}