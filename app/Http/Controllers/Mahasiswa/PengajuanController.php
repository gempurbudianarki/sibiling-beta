<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konseling;
use App\Models\Dosen;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    /**
     * Menampilkan form untuk membuat pengajuan konseling baru.
     */
    public function create()
    {
        $activeCounseling = Konseling::where('nim_mahasiswa', Auth::user()->nim)
            ->whereNotIn('status_konseling', ['Selesai', 'Ditolak'])
            ->exists();

        if ($activeCounseling) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah memiliki sesi konseling yang sedang aktif.');
        }

        return view('mahasiswa.pengajuan.create');
    }

    /**
     * Menyimpan data pengajuan konseling baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bidang_layanan' => 'required|string',
            'jenis_konseli' => 'required|in:baru,lama',
            'tujuan_konseling' => 'required|string|min:20',
            'deskripsi_masalah' => 'required|string|min:50',
            'assessment' => 'required|array|size:10',
            'assessment.*' => 'required|string',
        ], [
            'bidang_layanan.required' => 'Bidang layanan wajib dipilih.',
            'jenis_konseli.required' => 'Mohon pilih apakah Anda konseli baru atau lama.',
            'tujuan_konseling.min' => 'Tujuan konseling minimal harus 20 karakter.',
            'deskripsi_masalah.min' => 'Deskripsi masalah minimal harus 50 karakter.',
            'assessment.size' => 'Harap jawab semua 10 pertanyaan asesmen.',
        ]);

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa || !$mahasiswa->id_dosen_wali) {
            return redirect()->back()->withInput()->with('error', 'Data Dosen Wali Anda tidak ditemukan. Silakan hubungi admin.');
        }

        $dosenWali = Dosen::find($mahasiswa->id_dosen_wali);

        if (!$dosenWali) {
             return redirect()->back()->withInput()->with('error', 'Data Dosen Wali yang terhubung dengan Anda tidak valid. Silakan hubungi admin.');
        }

        $hasilAsesmen = [];
        foreach ($validated['assessment'] as $key => $value) {
            $hasilAsesmen['pertanyaan_' . ($key + 1)] = $value;
        }

        Konseling::create([
            // === PERBAIKAN UTAMA DI SINI ===
            // Mengambil NIM langsung dari objek $mahasiswa yang sudah valid.
            'nim_mahasiswa' => $mahasiswa->nim,
            'id_dosen_wali' => $dosenWali->email_dos,
            'tgl_pengajuan' => Carbon::now(),
            'status_konseling' => 'Menunggu Verifikasi',
            'sumber_pengajuan' => 'mahasiswa',
            'bidang_layanan' => $validated['bidang_layanan'],
            'jenis_konseli' => $validated['jenis_konseli'],
            'sumber_rujukan' => 'sendiri',
            'tujuan_konseling' => $validated['tujuan_konseling'],
            'deskripsi_masalah' => $validated['deskripsi_masalah'],
            'hasil_asesmen' => json_encode($hasilAsesmen),
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pengajuan konseling Anda berhasil dikirim dan sedang menunggu verifikasi.');
    }
}