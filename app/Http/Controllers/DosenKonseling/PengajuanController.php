<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Models\Konseling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengajuanController extends Controller
{
    public function index()
    {
        $semuaPengajuan = Konseling::with('mahasiswa.prodi')
                                ->latest('tgl_pengajuan')
                                ->paginate(10);

        return view('dosen-konseling.pengajuan.index', compact('semuaPengajuan'));
    }

    public function show(Konseling $pengajuan)
    {
        $pengajuan->load('mahasiswa.prodi', 'mahasiswa.dosenWali');
        return view('dosen-konseling.pengajuan.show', compact('pengajuan'));
    }

    public function updateStatus(Request $request, Konseling $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'alasan_penolakan' => 'nullable|string|required_if:status,ditolak|min:10',
        ]);

        if ($request->status == 'diterima') {
            $pengajuan->status_konseling = 'disetujui';
            $pengajuan->alasan_penolakan = null; // Kosongkan alasan penolakan jika diterima
            $pengajuan->save();
            
            return redirect()->route('dosen-konseling.jadwal.create', ['pengajuan' => $pengajuan->id_konseling])
                             ->with('success', 'Pengajuan disetujui. Silakan buat jadwal konseling.');

        } else { // Jika ditolak
            $pengajuan->status_konseling = 'revisi'; // Ganti status menjadi revisi
            $pengajuan->alasan_penolakan = $request->alasan_penolakan;
            $pengajuan->save();

            // Kembali ke dashboard dengan notifikasi
            return redirect()->route('dosen-konseling.dashboard')->with('success', 'Pengajuan telah ditolak dan statusnya diubah menjadi revisi.');
        }
    }
}