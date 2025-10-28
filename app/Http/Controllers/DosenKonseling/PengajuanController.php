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
        // Ambil semua pengajuan yang statusnya butuh tindakan:
        // 'Menunggu Verifikasi' (butuh diverifikasi)
        // 'Disetujui' (butuh dibuatkan jadwal)
        $daftarTugas = Konseling::whereIn('status_konseling', ['Menunggu Verifikasi', 'Disetujui'])
                                  ->with('mahasiswa.user') // Eager load relasi
                                  ->latest('tgl_pengajuan')
                                  ->get();

        return view('dosen-konseling.pengajuan.index', compact('daftarTugas'));
    }

    /**
     * Menampilkan detail satu pengajuan konseling.
     */
    public function show(Konseling $pengajuan)
    {
        // Eager load relasi yang dibutuhkan di view 'show'
        $pengajuan->load('mahasiswa.user', 'mahasiswa.prodi');
        return view('dosen-konseling.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Memperbarui status pengajuan.
     */
    public function updateStatus(Request $request, Konseling $pengajuan)
    {
        // Validasi: Pastikan status valid dan alasan wajib diisi jika Ditolak/Revisi
        $request->validate([
            'status_konseling' => 'required|string|in:Disetujui,Ditolak,Perlu Revisi',
            'alasan_penolakan' => 'nullable|string|required_if:status_konseling,Ditolak,Perlu Revisi',
        ], [
            'alasan_penolakan.required_if' => 'Alasan penolakan atau catatan revisi wajib diisi jika status adalah Ditolak atau Perlu Revisi.',
        ]);

        // Update status utama
        $pengajuan->status_konseling = $request->status_konseling;

        // Logika penyimpanan alasan_penolakan yang BENAR
        if ($request->status_konseling === 'Ditolak' || $request->status_konseling === 'Perlu Revisi') {
            // Simpan alasan jika statusnya Ditolak atau Perlu Revisi
             if (!empty($request->alasan_penolakan)) {
                 $pengajuan->alasan_penolakan = $request->alasan_penolakan;
             } else {
                 // Fallback jika input kosong (seharusnya dicegah validasi)
                 $pengajuan->alasan_penolakan = null;
             }
        } else {
            // Jika status Disetujui, pastikan alasan_penolakan dikosongkan
            $pengajuan->alasan_penolakan = null;
        }

        // Simpan perubahan ke database
        $pengajuan->save();

        return redirect()->route('dosen-konseling.pengajuan.index')->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}