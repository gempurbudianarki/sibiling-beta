<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Konseling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Menampilkan daftar riwayat pengajuan konseling mahasiswa.
     */
    public function index()
    {
        $nim = Auth::user()->mahasiswa->nim;
        
        // ================== PERBAIKAN DI SINI ==================

        // 1. Ambil data konseling mahasiswa
        $query = Konseling::where('nim_mahasiswa', $nim);

        // 2. Eager load relasi yang dibutuhkan untuk modal detail
        // Kita butuh data mahasiswa, user (untuk nama), dan prodi
        $query->with(['mahasiswa.user', 'mahasiswa.prodi']); 
                             
        // 3. Urutkan berdasarkan tgl_pengajuan terbaru dan ambil datanya
        $riwayat = $query->latest('tgl_pengajuan')->get();

        // 4. Kirim data '$riwayat' ke view 
        return view('mahasiswa.riwayat.index', compact('riwayat'));

        // ================== BATAS PERBAIKAN ==================
    }

    /**
     * Menampilkan detail satu riwayat konseling (HALAMAN INI TIDAK DIPAKAI LAGI JIKA PAKAI MODAL).
     * Tapi kita biarkan saja kodenya untuk referensi atau jika dibutuhkan nanti.
     */
    public function show(Konseling $konseling)
    {
        // Pastikan mahasiswa hanya bisa melihat riwayat miliknya
        if ($konseling->nim_mahasiswa !== Auth::user()->mahasiswa->nim) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // Load relasi yang dibutuhkan (jika halaman ini masih dipakai)
        $konseling->load('mahasiswa.user', 'mahasiswa.prodi', 'jadwalSesi.hasilKonseling', 'dosenWali.user');

        return view('mahasiswa.riwayat.show', compact('konseling'));
    }
}