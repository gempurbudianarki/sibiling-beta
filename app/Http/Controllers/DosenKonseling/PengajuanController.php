<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    /**
     * Menampilkan daftar semua pengajuan konseling yang perlu ditangani.
     */
    public function index()
    {
        $pengajuanBaru = Konseling::where('status_konseling', 'Menunggu Verifikasi')
                                  ->with('mahasiswa.user')
                                  ->latest('tgl_pengajuan')
                                  ->get();

        return view('dosen-konseling.pengajuan.index', compact('pengajuanBaru'));
    }

    /**
     * Menampilkan detail satu pengajuan konseling.
     */
    public function show(Konseling $pengajuan)
    {
        $pengajuan->load('mahasiswa.user', 'mahasiswa.prodi');
        return view('dosen-konseling.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Memperbarui status pengajuan (misal: Disetujui, Ditolak, Perlu Revisi).
     */
    public function updateStatus(Request $request, Konseling $pengajuan)
    {
        $request->validate([
            'status_konseling' => 'required|string|in:Disetujui,Ditolak,Perlu Revisi',
            // Alasan wajib diisi jika statusnya 'Ditolak'
            'alasan_penolakan' => 'nullable|string|required_if:status_konseling,Ditolak',
        ]);

        $pengajuan->status_konseling = $request->status_konseling;
        if ($request->status_konseling === 'Ditolak') {
            $pengajuan->alasan_penolakan = $request->alasan_penolakan;
        }
        $pengajuan->save();

        return redirect()->route('dosen-konseling.pengajuan.index')->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}