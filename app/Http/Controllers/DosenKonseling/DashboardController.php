<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Dosen Konseling dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Logic untuk data dashboard dosen konseling
        // Contoh: daftar pengajuan konseling baru, jadwal hari ini, dll.
        return view('dosen-konseling.dashboard');
    }
}