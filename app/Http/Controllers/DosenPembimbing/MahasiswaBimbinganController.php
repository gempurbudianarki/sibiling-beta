<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class MahasiswaBimbinganController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa bimbingan.
     */
    public function index(): View
    {
        // 1. Ambil user yang sedang login
        $user = Auth::user();
        
        // 2. Cari profil dosen berdasarkan email user yang login
        // Kita gunakan find() karena primaryKey di model Dosen adalah 'email_dos'
        $dosen = Dosen::find($user->email);

        // Inisialisasi paginator kosong
        $mahasiswaBimbingan = new LengthAwarePaginator([], 0, 15);

        // 3. Jika profil dosen ditemukan, baru kita cari mahasiswa bimbingannya
        if ($dosen) {
            // Langsung query ke model Mahasiswa
            // cari semua yang kolom 'id_dosen_wali'-nya cocok dengan 'email_dos' dosen ini
            $mahasiswaBimbingan = Mahasiswa::where('id_dosen_wali', $dosen->getKey())
                ->with('prodi', 'konseling') // Eager load prodi dan riwayat konseling
                ->orderBy('angkatan', 'desc')
                ->orderBy('nm_mhs', 'asc')
                ->paginate(15);
        }

        return view('dosen-pembimbing.mahasiswa.index', compact('mahasiswaBimbingan'));
    }
}