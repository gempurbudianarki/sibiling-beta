<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Models\Konseling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    /**
     * Menampilkan daftar pengajuan konseling yang relevan untuk Dosen Konseling.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'menunggu'); 

        $query = Konseling::with('mahasiswa')->orderBy('tgl_pengajuan', 'desc');

        if ($status == 'disetujui') {
            // Menampilkan yang sudah disetujui tapi belum dijadwalkan
            $query->where('status_konseling', 'disetujui');
        } else {
            // Default: Menampilkan semua yang butuh tindakan (dari mahasiswa ATAU dosen wali)
            $query->whereIn('status_konseling', ['Menunggu Verifikasi', 'pending']);
        }

        $pengajuan = $query->paginate(10);

        return view('dosen-konseling.pengajuan.index', compact('pengajuan', 'status'));
    }

    /**
     * Menampilkan detail pengajuan konseling.
     */
    public function show(Konseling $pengajuan): View
    {
        $pengajuan->load('mahasiswa.prodi');
        return view('dosen-konseling.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Memperbarui status pengajuan (disetujui/ditolak).
     */
    public function updateStatus(Request $request, Konseling $pengajuan): RedirectResponse
    {
        // === PERBAIKAN UTAMA DI SINI ===
        // Menyesuaikan nilai validasi agar cocok dengan view
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'alasan_penolakan' => 'required_if:status,ditolak|nullable|string|min:10',
        ]);

        if ($request->status == 'disetujui') {
            $pengajuan->status_konseling = 'disetujui';
            $pengajuan->alasan_penolakan = null;
        } else {
            $pengajuan->status_konseling = 'Ditolak';
            $pengajuan->alasan_penolakan = $request->alasan_penolakan;
        }

        $pengajuan->save();

        $pesan = $request->status == 'disetujui' ? 'Pengajuan berhasil disetujui.' : 'Pengajuan telah ditolak.';

        return redirect()->route('dosen-konseling.pengajuan.index')->with('success', $pesan);
    }
}