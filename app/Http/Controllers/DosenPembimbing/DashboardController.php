<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Dosen Pembimbing dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Logic untuk data dashboard dosen pembimbing
        // Contoh: daftar mahasiswa bimbingan, notifikasi status konseling mereka, dll.
        return view('dosen-pembimbing.dashboard');
    }
}