<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    /**
     * Menampilkan semua kasus yang sudah selesai atau sedang berjalan.
     */
    public function index()
    {
        // Ambil semua kasus yang sudah melewati tahap persetujuan
        $riwayatKasus = Konseling::whereIn('status_konseling', ['Terjadwal', 'Butuh Sesi Lanjutan', 'Selesai'])
            ->with('mahasiswa.user')
            ->latest('tgl_pengajuan')
            ->paginate(10);

        return view('dosen-konseling.kasus.index', compact('riwayatKasus'));
    }

    /**
     * Menampilkan file kasus yang komprehensif.
     */
    public function show(Konseling $konseling)
    {
        // Eager load semua data yang dibutuhkan untuk ditampilkan
        $konseling->load([
            'mahasiswa.user', 
            'mahasiswa.prodi', 
            'dosenWali.user',
            'jadwalSesi.hasilKonseling' // Memuat semua sesi dan hasilnya
        ]);

        return view('dosen-konseling.kasus.show', compact('konseling'));
    }
}