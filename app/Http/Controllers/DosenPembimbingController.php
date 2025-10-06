<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DosenPembimbingController extends Controller
{
    /**
     * Menampilkan dashboard untuk dosen pembimbing.
     */
    public function index()
    {
        $dosenEmail = Auth::user()->email;
        $jumlahMahasiswa = Mahasiswa::where('id_dosen_wali', $dosenEmail)->count();

        $konselingDiajukan = 0;
        $konselingAktif = 0;
        $konselingSelesai = 0;

        return view('dosen-pembimbing.dashboard', compact(
            'jumlahMahasiswa',
            'konselingDiajukan',
            'konselingAktif',
            'konselingSelesai'
        ));
    }

    /**
     * Menampilkan daftar mahasiswa yang menjadi bimbingan dosen PA.
     */
    public function showMahasiswa()
    {
        $dosenEmail = Auth::user()->email;
        $mahasiswaBimbingan = Mahasiswa::where('id_dosen_wali', $dosenEmail)
                                        ->orderBy('angkatan', 'desc')
                                        ->orderBy('nm_mhs', 'asc')
                                        ->paginate(15);

        return view('dosen-pembimbing.mahasiswa', compact('mahasiswaBimbingan'));
    }

    /**
     * Menampilkan form untuk merekomendasikan konseling.
     */
    public function showRekomendasiForm()
    {
        $dosenEmail = Auth::user()->email;
        $mahasiswaBimbingan = Mahasiswa::where('id_dosen_wali', $dosenEmail)
                                        ->with('prodi')
                                        ->orderBy('nm_mhs', 'asc')
                                        ->get();

        return view('dosen-pembimbing.rekomendasi', compact('mahasiswaBimbingan'));
    }

    /**
     * Menyimpan data rekomendasi konseling dari Dosen PA.
     */
    public function storeRekomendasi(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|exists:mahasiswa,nim',
            'permasalahan_segera' => 'required|string|min:20',
            'harapan_konseling' => 'required|string|min:20',
        ]);

        try {
            Konseling::create([
                'nim_mahasiswa' => $validated['nim'],
                'id_dosen_wali' => Auth::user()->email,
                'tgl_pengajuan' => now(),
                'status_konseling' => 'Diajukan',
                'sumber_pengajuan' => 'dosen_pa',
                'permasalahan_segera' => $validated['permasalahan_segera'],
                // INI ADALAH BARIS YANG SUDAH DIPERBAIKI TOTAL
                'harapan_konseling' => $validated['harapan_konseling'],
            ]);

            return redirect()->route('dosen-pembimbing.rekomendasi')
                             ->with('status', 'rekomendasi-sent');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan rekomendasi konseling: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->withErrors(['database' => 'Terjadi kesalahan pada server. Gagal mengirim rekomendasi.']);
        }
    }
}