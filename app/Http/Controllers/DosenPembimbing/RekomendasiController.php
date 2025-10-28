<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RekomendasiController extends Controller
{
    public function index()
    {
        return redirect()->route('dosen-pembimbing.mahasiswa');
    }

    public function create(Mahasiswa $mahasiswa)
    {
        return view('dosen-pembimbing.rekomendasi.create', compact('mahasiswa'));
    }

    /**
     * Menyimpan rekomendasi baru ke dalam database sebagai pengajuan konseling.
     */
    public function store(Request $request)
    {
        // ================== VALIDASI BARU SESUAI FORM SOP ==================
        $request->validate([
            'nim_mahasiswa' => 'required|string|exists:mahasiswa,nim',
            'aspek_permasalahan' => 'required|array|min:1', // Pastikan minimal satu aspek dipilih
            'aspek_permasalahan.*' => 'string', // Pastikan semua isinya string
            'permasalahan_segera' => 'required|string|min:10',
            'upaya_dilakukan' => 'required|string|min:10',
            'harapan_pa' => 'required|string|min:10',
        ]);
        // ====================================================================

        $dosenWali = Auth::user()->dosen;

        // ================== PENYIMPANAN DATA (ALUR BARU) ==================
        Konseling::create([
            'nim_mahasiswa' => $request->nim_mahasiswa,
            'id_dosen_wali' => $dosenWali->email_dos,
            'tgl_pengajuan' => Carbon::now(),
            
            // --- PERUBAHAN KRUSIAL ADA DI SINI ---
            // Mengubah status agar masuk ke antrian mahasiswa, bukan Dosen Konseling.
            'status_konseling' => 'Menunggu Kelengkapan Mahasiswa', 
            // --- BATAS PERUBAHAN ---

            'sumber_pengajuan' => 'dosen_pa',
            // Menyimpan data dari form SOP
            'aspek_permasalahan' => $request->aspek_permasalahan, // Disimpan sebagai JSON/array
            'permasalahan_segera' => $request->permasalahan_segera,
            'upaya_dilakukan' => $request->upaya_dilakukan,
            'harapan_pa' => $request->harapan_pa,
            // Menggabungkan aspek menjadi satu teks deskriptif untuk kolom 'permasalahan' utama
            'permasalahan' => 'Rekomendasi Dosen PA terkait aspek: ' . implode(', ', $request->aspek_permasalahan)
        ]);
        // ========================================================================

        // --- Perubahan pesan sukses untuk mencerminkan alur baru ---
        return redirect()->route('dosen-pembimbing.mahasiswa')->with('success', 'Rekomendasi konseling telah berhasil dikirim ke mahasiswa untuk dilengkapi.');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
}