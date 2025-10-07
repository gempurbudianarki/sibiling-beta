<?php

namespace App\Http\Controllers;

use App\Models\HasilKonseling;
use App\Models\JadwalKonseling;
use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DosenKonselingController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $pengajuanBaru = Konseling::where('status_konseling', 'Diajukan')->count();
        
        $jadwalMendatang = JadwalKonseling::where('status_sesi', 'dijadwalkan')
                                         ->where('id_dosen_konseling', $user->email) // <-- Sudah benar
                                         ->where('tgl_sesi', '>=', now()->toDateString())
                                         ->count();

        return view('dosen-konseling.dashboard', compact('pengajuanBaru', 'jadwalMendatang'));
    }

    public function daftarPengajuan()
    {
        $konselingTersedia = Konseling::whereIn('status_konseling', ['Diajukan', 'Terverifikasi'])
                                    ->with('mahasiswa', 'jadwal')
                                    ->orderBy('tgl_pengajuan', 'asc')
                                    ->paginate(10);

        return view('dosen-konseling.pengajuan.index', compact('konselingTersedia'));
    }
    
    public function showPengajuan($id_konseling)
    {
        $konseling = Konseling::with('mahasiswa.prodi')->findOrFail($id_konseling);
        return view('dosen-konseling.pengajuan.show', compact('konseling'));
    }

    public function verifikasi(Request $request, $id_konseling)
    {
        $request->validate(['action' => 'required|string|in:setuju,revisi', 'catatan_revisi' => 'nullable|string|required_if:action,revisi|min:10',]);
        try {
            $konseling = Konseling::findOrFail($id_konseling);
            if ($request->action === 'setuju') { $konseling->status_konseling = 'Terverifikasi'; } 
            elseif ($request->action === 'revisi') { $konseling->status_konseling = 'Revisi Diperlukan'; }
            $konseling->save();
            return redirect()->route('dosen-konseling.pengajuan.index')->with('status', 'verifikasi-success');
        } catch (\Exception $e) {
            Log::error('Gagal memverifikasi konseling: ' . $e->getMessage());
            return redirect()->back()->withErrors(['database' => 'Terjadi kesalahan server saat memproses verifikasi.']);
        }
    }

    public function createJadwal($id_konseling){
        $konseling = Konseling::where('status_konseling', 'Terverifikasi')->with('mahasiswa')->findOrFail($id_konseling);
        return view('dosen-konseling.jadwal.create', compact('konseling'));
    }

    public function storeJadwal(Request $request, $id_konseling){
        $request->validate(['tgl_sesi' => 'required|date|after_or_equal:today','waktu_mulai' => 'required|date_format:H:i','waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai','lokasi' => 'required|string|max:255','jenis_sesi' => 'required|string|in:online,offline',]);
        try {
            $konseling = Konseling::findOrFail($id_konseling);

            JadwalKonseling::create([
                'id_konseling' => $konseling->id_konseling,
                'id_dosen_konseling' => Auth::user()->email, // <-- Sudah benar
                'tgl_sesi' => $request->tgl_sesi,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'lokasi' => $request->lokasi,
                'jenis_sesi' => $request->jenis_sesi,
                'status_sesi' => 'dijadwalkan',
            ]);

            $konseling->status_konseling = 'Aktif'; $konseling->save();
            return redirect()->route('dosen-konseling.jadwal.index')->with('status', 'jadwal-created');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan jadwal konseling: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['database' => 'Terjadi kesalahan server. Gagal membuat jadwal.']);
        }
    }

    public function daftarJadwal(){
        $jadwals = JadwalKonseling::where('id_dosen_konseling', Auth::user()->email) // <-- Sudah benar
                                 ->with('konseling.mahasiswa')
                                 ->orderBy('tgl_sesi', 'desc')->orderBy('waktu_mulai', 'asc')
                                 ->paginate(15);
        return view('dosen-konseling.jadwal.index', compact('jadwals'));
    }

    public function daftarKasusAktif()
    {
        $kasusAktif = JadwalKonseling::where('id_dosen_konseling', Auth::user()->email) // <-- Sudah benar
                                ->whereHas('konseling', function($q){
                                    $q->whereIn('status_konseling', ['Aktif', 'Selesai']);
                                })
                                ->with('konseling.mahasiswa', 'hasil')
                                ->orderBy('tgl_sesi', 'desc')
                                ->paginate(15);
        return view('dosen-konseling.kasus.index', compact('kasusAktif'));
    }

    public function createHasil($id_jadwal)
    {
        $jadwal = JadwalKonseling::with('konseling.mahasiswa', 'hasil')
                               ->where('id_dosen_konseling', Auth::user()->email) // <-- Sudah benar
                               ->findOrFail($id_jadwal);
        
        if ($jadwal->hasil) {
            return redirect()->route('dosen-konseling.kasus.index')->with('error', 'Hasil untuk sesi ini sudah diisi.');
        }

        return view('dosen-konseling.kasus.create', compact('jadwal'));
    }
    
    public function storeHasil(Request $request, $id_jadwal)
    {
        $request->validate(['ringkasan_sesi' => 'required|string|min:20','observasi_konselor' => 'required|string|min:20','status_akhir_sesi' => 'required|string|in:lanjut,selesai','tindak_lanjut' => 'nullable|string|required_if:status_akhir_sesi,lanjut|min:10',]);
        try {
            $jadwal = JadwalKonseling::findOrFail($id_jadwal);
            HasilKonseling::create(['id_jadwal' => $jadwal->id_jadwal,'ringkasan_sesi' => $request->ringkasan_sesi,'observasi_konselor' => $request->observasi_konselor,'tindak_lanjut' => $request->tindak_lanjut,'status_akhir_sesi' => $request->status_akhir_sesi,'tgl_pencatatan' => now(),]);
            $jadwal->status_sesi = 'Selesai'; $jadwal->save();
            if ($request->status_akhir_sesi === 'selesai') {
                $konseling = Konseling::find($jadwal->id_konseling);
                $konseling->status_konseling = 'Selesai';
                $konseling->save();
            }
            return redirect()->route('dosen-konseling.kasus.index')->with('status', 'hasil-created');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan hasil konseling: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['database' => 'Gagal menyimpan hasil konseling.']);
        }
    }

    public function showHasil($id_hasil)
    {
        $hasil = HasilKonseling::with('jadwal.konseling.mahasiswa')->findOrFail($id_hasil);
        if ($hasil->jadwal->id_dosen_konseling !== Auth::user()->email) { // <-- Sudah benar
            abort(403, 'Anda tidak memiliki akses untuk melihat hasil ini.');
        }
        return view('dosen-konseling.kasus.show', compact('hasil'));
    }
}