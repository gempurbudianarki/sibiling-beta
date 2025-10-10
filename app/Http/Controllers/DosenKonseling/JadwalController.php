<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Models\Konseling;
use App\Models\JadwalKonseling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal konseling milik dosen yang login.
     */
    public function index(): View
    {
        $user = Auth::user();
        $jadwal = new LengthAwarePaginator([], 0, 15);

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

    /**
     * FORM untuk membuat jadwal baru dari pengajuan tertentu.
     */
    public function create(Konseling $pengajuan): View
    {
        // Cek kalau pengajuan belum disetujui, kembalikan error
        if ($pengajuan->status_konseling !== 'disetujui') {
            return redirect()->route('dosen-konseling.dashboard')
                ->with('error', 'Pengajuan ini belum disetujui.');
        }

        // Pastikan relasi mahasiswa dimuat biar gak null di view
        $pengajuan->load('mahasiswa');

        // Kirim ke view jadwal.create
        return view('dosen-konseling.jadwal.create', compact('pengajuan'));
    }

    /**
     * Menyimpan jadwal baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_konseling' => 'required|exists:konseling,id_konseling',
            'tgl_sesi' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'jenis_sesi' => 'required|in:online,offline',
        ]);

        $user = Auth::user();

        if (!$user->dosen) {
            return back()->with('error', 'Profil dosen Anda tidak ditemukan.');
        }

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

        // Update status konseling
        $konseling = Konseling::find($request->id_konseling);
        $konseling->status_konseling = 'terjadwal';
        $konseling->save();

        return redirect()->route('dosen-konseling.jadwal.index')
            ->with('success', 'Jadwal konseling berhasil dibuat.');
    }
}
