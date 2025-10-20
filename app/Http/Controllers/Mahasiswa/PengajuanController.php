<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konseling;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    /**
     * Menampilkan form untuk membuat pengajuan konseling baru.
     */
    public function create()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        
        // Cek apakah mahasiswa sudah punya pengajuan yang masih aktif (bukan Selesai atau Ditolak)
        $hasActivePengajuan = Konseling::where('nim_mahasiswa', $mahasiswa->nim)
            ->whereNotIn('status_konseling', ['Selesai', 'Ditolak'])
            ->exists();

        // Jika ada, redirect kembali dengan pesan error
        if ($hasActivePengajuan) {
            return redirect()->route('mahasiswa.riwayat.index')
                ->with('error', 'Anda sudah memiliki pengajuan konseling yang sedang diproses. Harap selesaikan proses tersebut terlebih dahulu.');
        }

        return view('mahasiswa.pengajuan.create', compact('mahasiswa'));
    }

    /**
     * Menyimpan pengajuan konseling baru dari mahasiswa.
     */
    public function store(Request $request)
    {
        // ================== VALIDASI BARU SESUAI FORM ASESMEN ==================
        $request->validate([
            'bidang_layanan' => 'required|string',
            'jenis_konseli' => 'required|string',
            'tujuan_konseling' => 'required|string|min:10',
            'deskripsi_masalah' => 'required|string|min:20',
            'assessment' => 'required|array|size:10', // Memastikan 10 pertanyaan asesmen dijawab
            'assessment.*' => 'required|string',
        ]);
        // ======================================================================

        $mahasiswa = Auth::user()->mahasiswa;
        
        // Buat record baru di tabel 'konseling' dengan data yang sesuai
        Konseling::create([
            'nim_mahasiswa' => $mahasiswa->nim,
            'id_dosen_wali' => $mahasiswa->id_dosen_wali,
            'tgl_pengajuan' => Carbon::now(),
            'status_konseling' => 'Menunggu Verifikasi',
            'sumber_pengajuan' => 'mahasiswa',
            
            // Menyimpan semua data dari form baru
            'bidang_layanan' => $request->bidang_layanan,
            'jenis_konseli' => $request->jenis_konseli,
            'tujuan_konseling' => $request->tujuan_konseling,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'hasil_asesmen' => $request->assessment, // Disimpan sebagai JSON

            // Mengisi kolom-kolom lama dengan data yang relevan atau default
            'permasalahan' => $request->deskripsi_masalah, 
            'harapan_konseling' => $request->tujuan_konseling,
        ]);

        return redirect()->route('mahasiswa.riwayat.index')->with('success', 'Pengajuan konseling Anda telah berhasil dikirim. Dosen Konseling akan segera meninjaunya.');
    }
}