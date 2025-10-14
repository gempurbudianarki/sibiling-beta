<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konseling; // Pastikan model Konseling di-import
use Carbon\Carbon; // Kita butuh Carbon untuk mengelola tanggal

class PengajuanController extends Controller
{
    /**
     * Menampilkan form untuk membuat pengajuan konseling baru.
     */
    public function create()
    {
        // Mengecek apakah mahasiswa sudah punya pengajuan yang aktif (belum selesai)
        $activeCounseling = Konseling::where('nim_mahasiswa', Auth::user()->nim)
            ->whereNotIn('status_konseling', ['Selesai', 'Ditolak'])
            ->exists();

        // Jika sudah ada, redirect ke dashboard dengan pesan error
        if ($activeCounseling) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah memiliki sesi konseling yang aktif.');
        }

        // Jika tidak ada, tampilkan form
        return view('mahasiswa.pengajuan.create');
    }

    /**
     * Menyimpan data pengajuan konseling baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'bidang_layanan' => 'required|string',
            'jenis_konseli' => 'required|in:baru,lama',
            'tujuan_konseling' => 'required|string|min:20',
            'deskripsi_masalah' => 'required|string|min:50',
            'assessment' => 'required|array|size:10', // Memastikan 10 jawaban asesmen ada
            'assessment.*' => 'required|string', // Memastikan setiap jawaban tidak kosong
        ]);

        // Mengumpulkan jawaban asesmen menjadi satu array
        $hasilAsesmen = [];
        foreach ($validated['assessment'] as $key => $value) {
            $hasilAsesmen['pertanyaan_' . ($key + 1)] = $value;
        }

        // Simpan data ke database
        Konseling::create([
            'nim_mahasiswa' => Auth::user()->nim,
            'id_dosen_wali' => Auth::user()->mahasiswa->dosen_wali, // Asumsi relasi user->mahasiswa sudah ada
            'tgl_pengajuan' => Carbon::now(),
            'status_konseling' => 'Menunggu Verifikasi',
            'sumber_pengajuan' => 'mahasiswa', // Karena ini diajukan oleh mahasiswa
            'bidang_layanan' => $validated['bidang_layanan'],
            'jenis_konseli' => $validated['jenis_konseli'],
            'sumber_rujukan' => 'sendiri', // Default 'sendiri' dari form mahasiswa
            'tujuan_konseling' => $validated['tujuan_konseling'],
            'deskripsi_masalah' => $validated['deskripsi_masalah'],
            'hasil_asesmen' => json_encode($hasilAsesmen), // Simpan sebagai JSON
        ]);

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pengajuan konseling Anda berhasil dikirim.');
    }
}