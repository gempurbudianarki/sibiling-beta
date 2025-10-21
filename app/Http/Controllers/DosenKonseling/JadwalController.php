<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Http\Controllers\Controller;
use App\Models\JadwalKonseling;
use App\Models\Konseling;
use App\Models\HasilKonseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal yang dimiliki Dosen Konseling.
     */
    public function index()
    {
        // ================== PERBAIKAN QUERY DI SINI ==================
        // Ambil hanya jadwal yang BELUM memiliki hasil konseling (yang aktif)
        $jadwal = JadwalKonseling::where('id_dosen_konseling', Auth::user()->email)
                                 ->whereDoesntHave('hasilKonseling') // <-- Logika Kunci
                                 ->with('konseling.mahasiswa.user')
                                 ->orderBy('waktu_mulai', 'asc')
                                 ->get();
        // =============================================================
        return view('dosen-konseling.jadwal.index', compact('jadwal'));
    }

    public function create(Konseling $pengajuan)
    {
        if (!in_array($pengajuan->status_konseling, ['Disetujui', 'Butuh Sesi Lanjutan'])) {
            return redirect()->route('dosen-konseling.pengajuan.index')
                             ->with('error', 'Jadwal hanya bisa dibuat untuk kasus yang disetujui atau butuh sesi lanjutan.');
        }

        return view('dosen-konseling.jadwal.create', compact('pengajuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_konseling' => 'required|exists:konseling,id_konseling',
            'tanggal_konseling' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'metode_konseling' => 'required|string|in:Online,Offline',
            'lokasi' => 'nullable|string|required_if:metode_konseling,Offline|max:255',
        ]);

        $waktu_mulai = Carbon::parse($request->tanggal_konseling . ' ' . $request->waktu_mulai);
        $waktu_selesai = Carbon::parse($request->tanggal_konseling . ' ' . $request->waktu_selesai);

        JadwalKonseling::create([
            'id_konseling' => $request->id_konseling,
            'id_dosen_konseling' => Auth::user()->email,
            'tgl_sesi' => $request->tanggal_konseling,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'metode_konseling' => $request->metode_konseling,
            'lokasi' => $request->lokasi,
        ]);

        $konseling = Konseling::find($request->id_konseling);
        $konseling->status_konseling = 'Terjadwal';
        $konseling->save();

        return redirect()->route('dosen-konseling.jadwal.index')->with('success', 'Jadwal konseling berhasil dibuat.');
    }

    public function mulaiSesi(JadwalKonseling $jadwal)
    {
        $jadwal->load('konseling.mahasiswa.user');
        return view('dosen-konseling.jadwal.mulai-sesi', compact('jadwal'));
    }

    public function simpanSesi(Request $request, JadwalKonseling $jadwal)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'prognosis' => 'required|string',
            'rekomendasi' => 'required|string',
            'status_akhir' => 'required|string|in:Selesai,Butuh Sesi Lanjutan',
        ]);

        HasilKonseling::create([
            'id_jadwal' => $jadwal->id_jadwal,
            'diagnosis' => $request->diagnosis,
            'prognosis' => $request->prognosis,
            'rekomendasi' => $request->rekomendasi,
            'evaluasi' => $request->evaluasi,
        ]);

        $konseling = $jadwal->konseling;
        $konseling->status_konseling = $request->status_akhir;
        $konseling->save();
        
        return redirect()->route('dosen-konseling.kasus.index')->with('success', 'Hasil sesi konseling berhasil disimpan.');
    }
}