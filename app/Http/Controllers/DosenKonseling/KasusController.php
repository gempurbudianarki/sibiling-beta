<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Untuk sementara, kita tampilkan teks ini.
        // Nanti kita akan kembangkan untuk menampilkan riwayat kasus yang pernah ditangani.
        return "Halaman Riwayat Kasus (dalam pengembangan)";
    }
}