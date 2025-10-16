<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class KasusController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $kasusQuery = Konseling::with('mahasiswa')
            ->whereHas('jadwal', function (Builder $query) {
                $query->whereHas('hasilKonseling');
            });

        if ($search) {
            $kasusQuery->whereHas('mahasiswa', function (Builder $query) use ($search) {
                $query->where('nm_mhs', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // === PERUBAHAN DI SINI ===
        $riwayatKasus = $kasusQuery->where('status_konseling', 'Selesai')
                   ->orderBy('tgl_pengajuan', 'desc')
                   ->paginate(15);

        // Dan di sini
        return view('dosen-konseling.kasus.index', compact('riwayatKasus'));
    }

    public function show(Konseling $konseling): View
    {
        $konseling->load('mahasiswa', 'jadwal.hasilKonseling', 'jadwal.dosenKonseling');
        return view('dosen-konseling.kasus.show', compact('konseling'));
    }
}