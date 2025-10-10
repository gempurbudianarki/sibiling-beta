<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Models\HasilKonseling;
use App\Models\Konseling;
use App\Models\JadwalKonseling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $jadwal = new LengthAwarePaginator([], 0, 15); // Default Paginator kosong
        if ($user->dosen) {
            $dosenId = $user->dosen->email_dos;
            $jadwal = JadwalKonseling::where('id_dosen_konseling', $dosenId)
                ->with('konseling.mahasiswa')
                ->orderBy('tgl_sesi', 'desc')
                ->orderBy('waktu_mulai', 'desc')
                ->paginate(10);
        }
        return view('dosen-konseling.jadwal.index', compact('jadwal'));
    }

    public function create(Konseling $pengajuan): View|RedirectResponse
    {
        if ($pengajuan->status_konseling !== 'disetujui') {
            return redirect()->route('dosen-konseling.dashboard')
                ->with('error', 'Pengajuan ini belum disetujui atau sudah dijadwalkan.');
        }
        $pengajuan->load('mahasiswa');
        return view('dosen-konseling.jadwal.create', compact('pengajuan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_konseling' => 'required|exists:konseling,id_konseling',
            'tgl_sesi' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'jenis_sesi' => 'required|in:online,offline',
        ]);

        $user = Auth::user();
        if (!$user->dosen) {
            return back()->with('error', 'Profil dosen Anda tidak ditemukan.');
        }

        // Tidak ada yang perlu diubah di sini, karena Model sudah diperbaiki
        JadwalKonseling::create([
            'id_konseling' => $request->id_konseling,
            'id_dosen_konseling' => $user->dosen->email_dos,
            'tgl_sesi' => $request->tgl_sesi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi' => $request->lokasi,
            'jenis_sesi' => $request->jenis_sesi,
            'status_sesi' => 'dijadwalkan',
        ]);

        $konseling = Konseling::find($request->id_konseling);
        $konseling->status_konseling = 'terjadwal';
        $konseling->save();

        return redirect()->route('dosen-konseling.jadwal.index')
            ->with('success', 'Jadwal konseling berhasil dibuat.');
    }

    public function mulaiSesi(JadwalKonseling $jadwal): View
    {
        $jadwal->load('konseling.mahasiswa');
        return view('dosen-konseling.jadwal.mulai-sesi', compact('jadwal'));
    }

    public function simpanSesi(Request $request, JadwalKonseling $jadwal): RedirectResponse
    {
        $request->validate([
            'catatan_sesi' => 'required|string|min:10',
            'rekomendasi' => 'nullable|string',
            'status_akhir' => 'required|in:tuntas,lanjutan',
        ]);

        DB::transaction(function () use ($request, $jadwal) {
            // Simpan ke tabel hasil_konseling
            HasilKonseling::create([
                'id_jadwal' => $jadwal->id_jadwal,
                'catatan_sesi' => $request->catatan_sesi,
                'rekomendasi' => $request->rekomendasi,
                'status_akhir' => $request->status_akhir,
            ]);

            // Update status sesi di tabel jadwal_konseling
            $jadwal->status_sesi = 'selesai';
            $jadwal->save();

            $konseling = $jadwal->konseling;
            // Jika 'tuntas', selesaikan juga kasus utamanya
            if ($request->status_akhir === 'tuntas') {
                $konseling->status_konseling = 'selesai';
            } else {
                // Jika 'lanjutan', kembalikan status ke 'disetujui' agar bisa dijadwalkan lagi
                $konseling->status_konseling = 'disetujui';
            }
            $konseling->save();
        });
        
        return redirect()->route('dosen-konseling.dashboard')
            ->with('success', 'Hasil sesi konseling berhasil disimpan.');
    }
}
