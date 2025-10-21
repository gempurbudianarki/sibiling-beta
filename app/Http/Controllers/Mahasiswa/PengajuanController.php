<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konseling;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function create()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        
        $hasActivePengajuan = Konseling::where('nim_mahasiswa', $mahasiswa->nim)
            ->whereNotIn('status_konseling', ['Selesai', 'Ditolak'])
            ->exists();

        if ($hasActivePengajuan) {
            return redirect()->route('mahasiswa.riwayat.index')
                ->with('error', 'Anda sudah memiliki pengajuan konseling yang sedang diproses. Harap selesaikan proses tersebut terlebih dahulu.');
        }

        return view('mahasiswa.pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bidang_layanan' => 'required|string',
            'jenis_konseli' => 'required|string',
            'tujuan_konseling' => 'required|string|min:10',
            'deskripsi_masalah' => 'required|string|min:20',
            'assessment' => 'required|array|size:10',
            'assessment.*' => 'required|string',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;
        
        Konseling::create([
            'nim_mahasiswa' => $mahasiswa->nim,
            'id_dosen_wali' => $mahasiswa->id_dosen_wali,
            'tgl_pengajuan' => Carbon::now(),
            'status_konseling' => 'Menunggu Verifikasi',
            'sumber_pengajuan' => 'mahasiswa',
            'bidang_layanan' => $request->bidang_layanan,
            'jenis_konseli' => $request->jenis_konseli,
            'tujuan_konseling' => $request->tujuan_konseling,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'hasil_asesmen' => $request->assessment,
            'permasalahan' => $request->deskripsi_masalah, 
            'harapan_konseling' => $request->tujuan_konseling,
        ]);

        return redirect()->route('mahasiswa.riwayat.index')->with('success', 'Pengajuan konseling Anda telah berhasil dikirim.');
    }

    /**
     * Menampilkan form untuk mengedit pengajuan yang perlu direvisi.
     */
    public function edit(Konseling $konseling)
    {
        // Keamanan: Pastikan mahasiswa hanya bisa mengedit miliknya & statusnya benar
        if ($konseling->nim_mahasiswa !== Auth::user()->mahasiswa->nim || $konseling->status_konseling !== 'Perlu Revisi') {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        return view('mahasiswa.pengajuan.edit', compact('konseling'));
    }

    /**
     * Menyimpan perubahan dari form edit.
     */
    public function update(Request $request, Konseling $konseling)
    {
        // Keamanan: Pastikan mahasiswa hanya bisa mengupdate miliknya
        if ($konseling->nim_mahasiswa !== Auth::user()->mahasiswa->nim) {
            abort(403);
        }

        // Validasi sama seperti saat membuat pengajuan baru
        $request->validate([
            'bidang_layanan' => 'required|string',
            'jenis_konseli' => 'required|string',
            'tujuan_konseling' => 'required|string|min:10',
            'deskripsi_masalah' => 'required|string|min:20',
            'assessment' => 'required|array|size:10',
            'assessment.*' => 'required|string',
        ]);

        // Lakukan pembaruan data
        $konseling->update([
            'bidang_layanan' => $request->bidang_layanan,
            'jenis_konseli' => $request->jenis_konseli,
            'tujuan_konseling' => $request->tujuan_konseling,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'hasil_asesmen' => $request->assessment,
            'permasalahan' => $request->deskripsi_masalah, 
            'harapan_konseling' => $request->tujuan_konseling,
            'status_konseling' => 'Menunggu Verifikasi', // Kembalikan status untuk diverifikasi ulang
        ]);

        return redirect()->route('mahasiswa.riwayat.index')->with('success', 'Pengajuan Anda telah berhasil diperbarui dan dikirim kembali untuk verifikasi.');
    }
}