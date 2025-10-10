<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Models\Mahasiswa;
use App\Models\Konseling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RekomendasiController extends Controller
{
    public function index(): View
    {
        $dosenEmail = Auth::user()->dosen->email_dos;

        $rekomendasiDibuat = Konseling::where('rekomendation_dari', $dosenEmail)
            ->with('mahasiswa.prodi')
            ->latest('tgl_pengajuan')
            ->paginate(10);

        return view('dosen-pembimbing.rekomendasi.index', compact('rekomendasiDibuat'));
    }

    public function create(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load('prodi');
        return view('dosen-pembimbing.rekomendasi.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        // ... (fungsi store biarkan sama) ...
        $request->validate([
            'nim_mahasiswa' => 'required|exists:mahasiswa,nim',
            'aspek_permasalahan' => 'required|array|min:1',
            'permasalahan_segera' => 'required|string|min:10',
            'upaya_dilakukan' => 'required|string|min:10',
            'harapan_pa' => 'required|string|min:10',
        ]);

        Konseling::create([
            'nim_mahasiswa' => $request->nim_mahasiswa,
            'id_dosen_wali' => Auth::user()->dosen->email_dos,
            'tgl_pengajuan' => now(),
            'status_konseling' => 'menunggu_verifikasi',
            'sumber_pengajuan' => 'dosen_pa',
            'rekomendation_dari' => Auth::user()->dosen->email_dos,
            'aspek_permasalahan' => json_encode($request->aspek_permasalahan),
            'permasalahan_segera' => $request->permasalahan_segera,
            'upaya_dilakukan' => $request->upaya_dilakukan,
            'harapan_pa' => $request->harapan_pa,
        ]);

        return redirect()->route('dosen-pembimbing.mahasiswa')->with('success', 'Rekomendasi konseling berhasil dikirim.');
    }

    /**
     * Menampilkan form untuk mengedit rekomendasi yang ditolak.
     */
    public function edit(Konseling $rekomendasi): View
    {
        // Pastikan hanya Dosen PA yang benar yang bisa mengedit
        if ($rekomendasi->rekomendation_dari !== Auth::user()->dosen->email_dos) {
            abort(403, 'Anda tidak berhak mengakses halaman ini.');
        }

        $rekomendasi->load('mahasiswa.prodi');
        return view('dosen-pembimbing.rekomendasi.edit', compact('rekomendasi'));
    }

    /**
     * Menyimpan perubahan pada rekomendasi dan mengirimkannya kembali.
     */
    public function update(Request $request, Konseling $rekomendasi)
    {
        // Pastikan hanya Dosen PA yang benar yang bisa mengupdate
        if ($rekomendasi->rekomendation_dari !== Auth::user()->dosen->email_dos) {
            abort(403);
        }

        $request->validate([
            'aspek_permasalahan' => 'required|array|min:1',
            'permasalahan_segera' => 'required|string|min:10',
            'upaya_dilakukan' => 'required|string|min:10',
            'harapan_pa' => 'required|string|min:10',
        ]);

        $rekomendasi->update([
            'aspek_permasalahan' => json_encode($request->aspek_permasalahan),
            'permasalahan_segera' => $request->permasalahan_segera,
            'upaya_dilakukan' => $request->upaya_dilakukan,
            'harapan_pa' => $request->harapan_pa,
            'status_konseling' => 'menunggu_verifikasi', // Status kembali ke awal
            'alasan_penolakan' => null, // Hapus alasan penolakan setelah direvisi
            'tgl_pengajuan' => now(), // Update tanggal pengajuan
        ]);

        return redirect()->route('dosen-pembimbing.mahasiswa')->with('success', 'Rekomendasi berhasil diperbarui dan dikirim ulang.');
    }
}