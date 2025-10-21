<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $nim_mahasiswa = Auth::user()->mahasiswa->nim;

        $riwayatKonseling = Konseling::where('nim_mahasiswa', $nim_mahasiswa)
                                     ->latest('tgl_pengajuan')
                                     ->get();

        return view('mahasiswa.riwayat.index', compact('riwayatKonseling'));
    }

    public function show(Konseling $konseling)
    {
        if ($konseling->nim_mahasiswa !== Auth::user()->mahasiswa->nim) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
        }

        // ================== PERBAIKAN NAMA RELASI DI SINI ==================
        $konseling->load('jadwalSesi.hasilKonseling'); // Diubah dari 'jadwal'
        // =================================================================

        return view('mahasiswa.riwayat.show', compact('konseling'));
    }
}