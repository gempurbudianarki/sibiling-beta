<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Konseling;
use Illuminate\Support\Str;

class DosenPembimbingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosen = Dosen::where('email_dos', $user->email)->firstOrFail();
        $jumlahMahasiswa = $dosen->mahasiswaBimbingan()->count();
        return view('dosen-pembimbing.dashboard', [
            'jumlahMahasiswa' => $jumlahMahasiswa
        ]);
    }

    public function showMahasiswa()
    {
        $user = Auth::user();
        $dosen = Dosen::where('email_dos', $user->email)->firstOrFail();
        $mahasiswaBimbingan = $dosen->mahasiswaBimbingan()->with('prodi')->paginate(15);
        return view('dosen-pembimbing.mahasiswa', [
            'mahasiswaBimbingan' => $mahasiswaBimbingan
        ]);
    }

    public function showRekomendasiForm()
    {
        $user = Auth::user();
        $dosen = Dosen::where('email_dos', $user->email)->firstOrFail();
        $mahasiswaList = $dosen->mahasiswaBimbingan()->orderBy('nm_mhs', 'asc')->get();
        return view('dosen-pembimbing.rekomendasi', [
            'mahasiswaList' => $mahasiswaList
        ]);
    }

    public function storeRekomendasi(Request $request)
    {
        $request->validate([
            'mahasiswa_nim' => 'required|exists:mahasiswa,nim',
            'alasan' => 'required|string|min:10',
            'surat_rekomendasi' => 'required|file|mimes:doc,docx|max:2048',
        ]);

        $file = $request->file('surat_rekomendasi');
        $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('surat-rekomendasi', $fileName, 'public');

        // ==== PERBAIKAN LOGIKA PENYIMPANAN DI SINI ====
        Konseling::create([
            'id_mahasiswa' => $request->mahasiswa_nim, // Menggunakan 'id_mahasiswa'
            'permasalahan' => $request->alasan,
            'jenis_konseling' => 'Rekomendasi Dosen PA',
            'status' => 'Diajukan',
            'file_pendukung' => $filePath,
            'tanggal_pengajuan' => now(),
            // Tambahkan ID dosen yang merekomendasikan
            'id_dosen_pembimbing_pengaju' => Auth::user()->id,
        ]);
        
        return redirect()->route('dosen-pembimbing.dashboard')->with('success', 'Rekomendasi konseling berhasil dikirim.');
    }
}