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
        // ================== PERBAIKAN QUERY DI SINI ==================
        // Ambil semua pengajuan yang statusnya butuh tindakan:
        // 'Menunggu Verifikasi' (butuh diverifikasi)
        // 'Disetujui' (butuh dibuatkan jadwal)
        $daftarTugas = Konseling::whereIn('status_konseling', ['Menunggu Verifikasi', 'Disetujui'])
                                  ->with('mahasiswa.user')
                                  ->latest('tgl_pengajuan')
                                  ->get();
        // =============================================================

        return view('dosen-konseling.pengajuan.index', compact('daftarTugas'));
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
     * Memperbarui status pengajuan.
     */
    public function updateStatus(Request $request, Konseling $pengajuan)
    {
        $request->validate([
            'status_konseling' => 'required|string|in:Disetujui,Ditolak,Perlu Revisi',
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