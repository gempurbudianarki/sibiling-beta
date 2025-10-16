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
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index(): View
    {
        $dosenId = Auth::user()->dosen->getKey(); // Mengambil primary key (email)
        
        $jadwal = JadwalKonseling::where('id_dosen_konseling', $dosenId)
            ->with('konseling.mahasiswa')
            ->orderBy('tgl_sesi', 'desc') // Menggunakan tgl_sesi
            ->paginate(10);
        
        return view('dosen-konseling.jadwal.index', compact('jadwal'));
    }

    public function create(Konseling $pengajuan): View
    {
        return view('dosen-konseling.jadwal.create', ['konseling' => $pengajuan]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_konseling' => 'required|exists:konseling,id_konseling',
            'tgl_sesi' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
        ]);

        $dosen_key = Auth::user()->dosen->getKey();

        JadwalKonseling::create([
            'id_konseling' => $validated['id_konseling'],
            'id_dosen_konseling' => $dosen_key,
            'tgl_sesi' => $validated['tgl_sesi'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'lokasi' => $validated['lokasi'],
            'status_sesi' => 'dijadwalkan',
        ]);

        $konseling = Konseling::find($validated['id_konseling']);
        $konseling->status_konseling = 'Dijadwalkan';
        $konseling->save();

        return redirect()->route('dosen-konseling.jadwal.index')->with('success', 'Jadwal konseling berhasil dibuat.');
    }

    public function mulaiSesi(JadwalKonseling $jadwal): View
    {
        $jadwal->load('konseling.mahasiswa');
        return view('dosen-konseling.jadwal.mulai-sesi', compact('jadwal'));
    }

    public function simpanSesi(Request $request, JadwalKonseling $jadwal): RedirectResponse
    {
        $validated = $request->validate([
            'catatan_sesi' => 'required|string|min:10',
            'status_kasus' => 'required|in:Selesai,Lanjut',
        ]);

        DB::transaction(function () use ($validated, $jadwal) {
            HasilKonseling::create([
                'id_jadwal' => $jadwal->id_jadwal,
                'catatan_sesi' => $validated['catatan_sesi'],
                'tindak_lanjut' => $request->input('tindak_lanjut', '-'), // Default value
                'status_kasus' => $validated['status_kasus'],
            ]);

            $jadwal->status_sesi = 'selesai';
            $jadwal->save();

            $konseling = $jadwal->konseling;
            if ($validated['status_kasus'] === 'Selesai') {
                $konseling->status_konseling = 'Selesai';
            } else {
                $konseling->status_konseling = 'Dijadwalkan'; // Tetap terjadwal untuk sesi lanjutan
            }
            $konseling->save();
        });
        
        return redirect()->route('dosen-konseling.dashboard')->with('success', 'Hasil sesi konseling berhasil disimpan.');
    }
}