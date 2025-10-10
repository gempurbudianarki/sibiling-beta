<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RekomendasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logika untuk menampilkan daftar rekomendasi
        $rekomendasiDibuat = Konseling::where('sumber_pengajuan', 'dosen_pa')
            ->where('rekomendation_dari', Auth::user()->email)
            ->with('mahasiswa')
            ->latest('tgl_pengajuan')
            ->paginate(10);
            
        /**
         * ===================================================================
         * PERBAIKAN: Menyamakan nama variabel yang dikirim ke view
         * ===================================================================
         * Nama variabel diubah dari 'rekomendasi' menjadi 'rekomendasiDibuat'
         */
        return view('dosen-pembimbing.rekomendasi.index', compact('rekomendasiDibuat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Mahasiswa $mahasiswa)
    {
        return view('dosen-pembimbing.rekomendasi.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim_mahasiswa' => 'required|exists:mahasiswa,nim',
            'aspek_permasalahan' => 'required|array|min:1',
            'permasalahan_segera' => 'required|string|min:10',
            'upaya_dilakukan' => 'required|string|min:10',
            'harapan_pa' => 'required|string|min:10',
        ]);

        $user = Auth::user();

        Konseling::create([
            'nim_mahasiswa' => $request->nim_mahasiswa,
            'id_dosen_wali' => $user->email,
            'tgl_pengajuan' => now(),
            'status_konseling' => 'menunggu_verifikasi',
            'sumber_pengajuan' => 'dosen_pa',
            'rekomendation_dari' => $user->email,
            'aspek_permasalahan' => json_encode($request->aspek_permasalahan),
            'permasalahan_segera' => $request->permasalahan_segera,
            'upaya_dilakukan' => $request->upaya_dilakukan,
            'harapan_pa' => $request->harapan_pa,
        ]);

        return redirect()->route('dosen-pembimbing.mahasiswa')->with('success', 'Rekomendasi konseling berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rekomendasi = Konseling::findOrFail($id);
        $mahasiswa = Mahasiswa::where('nim', $rekomendasi->nim_mahasiswa)->first();
        return view('dosen-pembimbing.rekomendasi.edit', compact('rekomendasi', 'mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'aspek_permasalahan' => 'required|array|min:1',
            'permasalahan_segera' => 'required|string|min:10',
            'upaya_dilakukan' => 'required|string|min:10',
            'harapan_pa' => 'required|string|min:10',
        ]);

        $konseling = Konseling::findOrFail($id);

        $konseling->update([
            'aspek_permasalahan' => json_encode($request->aspek_permasalahan),
            'permasalahan_segera' => $request->permasalahan_segera,
            'upaya_dilakukan' => $request->upaya_dilakukan,
            'harapan_pa' => $request->harapan_pa,
        ]);

        return redirect()->route('dosen-pembimbing.rekomendasi.index')->with('success', 'Rekomendasi konseling berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}