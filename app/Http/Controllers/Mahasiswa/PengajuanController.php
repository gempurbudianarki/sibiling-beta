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
     * Menampilkan form untuk pengajuan mandiri.
     */
    public function create()
    {
        // Ambil data mahasiswa yang sedang login, beserta relasi prodi dan user (untuk nama)
        $mahasiswa = Auth::user()->mahasiswa->load('prodi', 'user');
        
        $hasActivePengajuan = Konseling::where('nim_mahasiswa', $mahasiswa->nim)
            ->whereNotIn('status_konseling', ['Selesai', 'Ditolak'])
            ->exists();

        if ($hasActivePengajuan) {
            return redirect()->route('mahasiswa.riwayat.index')
                ->with('error', 'Anda sudah memiliki pengajuan konseling yang sedang diproses. Harap selesaikan proses tersebut terlebih dahulu.');
        }

        // Kirim data mahasiswa ke view
        return view('mahasiswa.pengajuan.create', compact('mahasiswa'));
    }

    /**
     * Menyimpan pengajuan mandiri baru.
     */
    public function store(Request $request)
    {
        // --- VALIDASI BARU SESUAI PERMINTAAN ---
        $request->validate([
            'no_hp_mahasiswa' => 'nullable|string|max:15',
            'tipe_konseli' => 'required|string',
            'jenis_permasalahan' => 'required|array|min:1',
            'jenis_permasalahan.*' => 'string',
            'deskripsi_masalah' => 'required|string|min:20', // Kondisi saat ini
            'tujuan_konseling' => 'required|string|min:10', // Tujuan layanan
            'asesmen_k10' => 'required|array|size:10', // 10 pertanyaan K10
            'asesmen_k10.*' => 'required|string', // Setiap jawaban K10 wajib diisi
            'persetujuan' => 'required|accepted', // Informed Consent
        ], [
            'jenis_permasalahan.required' => 'Pilih minimal satu jenis permasalahan.',
            'asesmen_k10.required' => 'Asesmen 10 pertanyaan wajib diisi semua.',
            'persetujuan.required' => 'Anda harus menyetujui pernyataan untuk melanjutkan.',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        // --- SIMPAN/UPDATE NO. WA MAHASISWA ---
        // (Asumsi kolom di tabel mahasiswa adalah 'no_hp')
        if ($mahasiswa->no_hp !== $request->no_hp_mahasiswa) {
             $mahasiswa->no_hp = $request->no_hp_mahasiswa;
             $mahasiswa->save();
        }
        
        Konseling::create([
            'nim_mahasiswa' => $mahasiswa->nim,
            'id_dosen_wali' => $mahasiswa->id_dosen_wali,
            'tgl_pengajuan' => Carbon::now(),
            'status_konseling' => 'Menunggu Verifikasi',
            'sumber_pengajuan' => 'mahasiswa', // Pengajuan mandiri
            
            // --- DATA BARU SESUAI FORMULIR ---
            'tipe_konseli' => $request->tipe_konseli,
            'jenis_permasalahan' => $request->jenis_permasalahan,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'tujuan_konseling' => $request->tujuan_konseling,
            'asesmen_k10' => $request->asesmen_k10,
            'persetujuan_diberikan_pada' => Carbon::now(),
            
            // 'shim' data untuk kompatibilitas kolom lama (PENTING)
            'permasalahan' => $request->deskripsi_masalah, 
            'harapan_konseling' => $request->tujuan_konseling,
        ]);

        return redirect()->route('mahasiswa.riwayat.index')->with('success', 'Pengajuan konseling Anda telah berhasil dikirim.');
    }

    // ========================================================================
    // --- METHOD ALUR REKOMENDASI DOSEN WALI ---
    // ========================================================================

    /**
     * Menampilkan form untuk melengkapi pengajuan yang direkomendasikan Dosen Wali.
     */
    public function lengkapi(Konseling $konseling)
    {
        // Ambil data mahasiswa yang sedang login, beserta relasi prodi dan user (untuk nama)
        $mahasiswa = Auth::user()->mahasiswa->load('prodi', 'user');
        
        // Keamanan: Pastikan mahasiswa hanya bisa mengakses miliknya
        if ($konseling->nim_mahasiswa !== $mahasiswa->nim) {
            abort(403, 'AKSI TIDAK DIIZINKAN. (Bukan Milik Anda)');
        }
        
        // Keamanan: Pastikan hanya status ini yang bisa mengakses form ini
        if ($konseling->status_konseling !== 'Menunggu Kelengkapan Mahasiswa') {
            abort(403, 'AKSI TIDAK DIIZINKAN. (Status Salah)');
        }

        // Kirim data mahasiswa & konseling (data Dosen Wali) ke view
        return view('mahasiswa.pengajuan.lengkapi', compact('konseling', 'mahasiswa'));
    }

    /**
     * Menyimpan data kelengkapan dari mahasiswa dan meneruskan ke Dosen Konseling.
     */
    public function updateLengkapan(Request $request, Konseling $konseling)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Keamanan: Pastikan mahasiswa hanya bisa mengakses miliknya
        if ($konseling->nim_mahasiswa !== $mahasiswa->nim) {
            abort(403, 'AKSI TIDAK DIIZINKAN. (Bukan Milik Anda)');
        }

        // Keamanan: Pastikan hanya status ini yang bisa di-submit
        if ($konseling->status_konseling !== 'Menunggu Kelengkapan Mahasiswa') {
            abort(403, 'AKSI TIDAK DIIZINKAN. (Status Salah)');
        }

        // --- VALIDASI BARU SESUAI PERMINTAAN ---
        $request->validate([
            'no_hp_mahasiswa' => 'nullable|string|max:15',
            'tipe_konseli' => 'required|string',
            'jenis_permasalahan' => 'required|array|min:1',
            'jenis_permasalahan.*' => 'string',
            'deskripsi_masalah' => 'required|string|min:20', // Kondisi saat ini
            'tujuan_konseling' => 'required|string|min:10', // Tujuan layanan
            'asesmen_k10' => 'required|array|size:10', // 10 pertanyaan K10
            'asesmen_k10.*' => 'required|string', // Setiap jawaban K10 wajib diisi
            'persetujuan' => 'required|accepted', // Informed Consent
        ], [
            'jenis_permasalahan.required' => 'Pilih minimal satu jenis permasalahan.',
            'asesmen_k10.required' => 'Asesmen 10 pertanyaan wajib diisi semua.',
            'persetujuan.required' => 'Anda harus menyetujui pernyataan untuk melanjutkan.',
        ]);

        // --- SIMPAN/UPDATE NO. WA MAHASISWA ---
        if ($mahasiswa->no_hp !== $request->no_hp_mahasiswa) {
            $mahasiswa->no_hp = $request->no_hp_mahasiswa;
            $mahasiswa->save();
        }

        // Lakukan pembaruan data
        $konseling->update([
            // --- DATA BARU SESUAI FORMULIR ---
            'tipe_konseli' => $request->tipe_konseli,
            'jenis_permasalahan' => $request->jenis_permasalahan,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'tujuan_konseling' => $request->tujuan_konseling,
            'asesmen_k10' => $request->asesmen_k10,
            'persetujuan_diberikan_pada' => Carbon::now(),
            
            // 'shim' data untuk kompatibilitas kolom lama (PENTING)
            'permasalahan' => $request->deskripsi_masalah, 
            'harapan_konseling' => $request->tujuan_konseling,
            
            // --- PERUBAHAN STATUS KRUSIAL ---
            'status_konseling' => 'Menunggu Verifikasi', 
        ]);

        return redirect()->route('mahasiswa.riwayat.index')->with('success', 'Data pengajuan telah dilengkapi dan berhasil diteruskan ke Dosen Konseling.');
    }

    // ========================================================================
    // --- METHOD LAMA (REVISI) --- KITA UPDATE JUGA
    // ========================================================================

    /**
     * Menampilkan form untuk mengedit pengajuan yang perlu direvisi.
     */
    public function edit(Konseling $konseling)
    {
        // Ambil data mahasiswa yang sedang login, beserta relasi prodi dan user (untuk nama)
        $mahasiswa = Auth::user()->mahasiswa->load('prodi', 'user');

        // Keamanan: Pastikan mahasiswa only bisa mengedit miliknya & statusnya benar
        if ($konseling->nim_mahasiswa !== $mahasiswa->nim || $konseling->status_konseling !== 'Perlu Revisi') {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // Kirim data mahasiswa & konseling (data lama) ke view
        return view('mahasiswa.pengajuan.edit', compact('konseling', 'mahasiswa'));
    }

    /**
     * Menyimpan perubahan dari form edit (revisi).
     */
    public function update(Request $request, Konseling $konseling)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Keamanan: Pastikan mahasiswa hanya bisa mengupdate miliknya
        if ($konseling->nim_mahasiswa !== $mahasiswa->nim) {
            abort(403);
        }

        // Keamanan: Hanya status 'Perlu Revisi' yang boleh pakai method ini
        if ($konseling->status_konseling !== 'Perlu Revisi') {
             abort(403, 'AKSI TIDAK DIIZINKAN. (Status Salah)');
        }

        // --- VALIDASI BARU SESUAI PERMINTAAN ---
        $request->validate([
            'no_hp_mahasiswa' => 'nullable|string|max:15',
            'tipe_konseli' => 'required|string',
            'jenis_permasalahan' => 'required|array|min:1',
            'jenis_permasalahan.*' => 'string',
            'deskripsi_masalah' => 'required|string|min:20', // Kondisi saat ini
            'tujuan_konseling' => 'required|string|min:10', // Tujuan layanan
            'asesmen_k10' => 'required|array|size:10', // 10 pertanyaan K10
            'asesmen_k10.*' => 'required|string', // Setiap jawaban K10 wajib diisi
            'persetujuan' => 'required|accepted', // Informed Consent
        ], [
            'jenis_permasalahan.required' => 'Pilih minimal satu jenis permasalahan.',
            'asesmen_k10.required' => 'Asesmen 10 pertanyaan wajib diisi semua.',
            'persetujuan.required' => 'Anda harus menyetujui pernyataan untuk melanjutkan.',
        ]);

        // --- SIMPAN/UPDATE NO. WA MAHASISWA ---
         if ($mahasiswa->no_hp !== $request->no_hp_mahasiswa) {
            $mahasiswa->no_hp = $request->no_hp_mahasiswa;
            $mahasiswa->save();
        }

        // Lakukan pembaruan data
        $konseling->update([
            // --- DATA BARU SESUAI FORMULIR ---
            'tipe_konseli' => $request->tipe_konseli,
            'jenis_permasalahan' => $request->jenis_permasalahan,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'tujuan_konseling' => $request->tujuan_konseling,
            'asesmen_k10' => $request->asesmen_k10,
            'persetujuan_diberikan_pada' => Carbon::now(),
            
            // 'shim' data untuk kompatibilitas kolom lama (PENTING)
            'permasalahan' => $request->deskripsi_masalah, 
            'harapan_konseling' => $request->tujuan_konseling,
            
            // --- PERUBAHAN STATUS KRUSIAL ---
            'status_konseling' => 'Menunggu Verifikasi', 
        ]);

        return redirect()->route('mahasiswa.riwayat.index')->with('success', 'Pengajuan Anda telah berhasil diperbarui dan dikirim kembali untuk verifikasi.');
    }
}