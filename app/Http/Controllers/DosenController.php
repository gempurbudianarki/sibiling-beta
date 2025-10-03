<?php

namespace App\Http\Controllers;

use App\Models\Dosen; // <-- Jangan lupa mengimpor Model Dosen
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Menampilkan daftar semua dosen.
     */
    public function index()
    {
        // 1. Ambil data dari tabel 'dosen' menggunakan Model 'Dosen'.
        // 2. Gunakan paginate(15) untuk memotong data menjadi beberapa halaman,
        //    dengan 15 data per halaman.
        $all_dosen = Dosen::paginate(15);

        // 3. Kirim data yang sudah dipaginasi ke file view 'dosen.index'.
        //    Data dikirim dalam variabel bernama 'all_dosen'.
        return view('dosen.index', ['all_dosen' => $all_dosen]);
    }
}

