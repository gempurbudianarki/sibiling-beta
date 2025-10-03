<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan halaman utama Manajemen Mahasiswa.
     */
    public function index()
    {
        // Logika awal untuk menampilkan halaman.
        // Pencarian selanjutnya akan ditangani oleh API.
        $all_mahasiswa = Mahasiswa::with('prodi')
                           ->orderBy('angkatan', 'desc')
                           ->orderBy('nm_mhs', 'asc')
                           ->paginate(15);

        return view('mahasiswa.index', [
            'all_mahasiswa' => $all_mahasiswa,
        ]);
    }

    /**
     * API endpoint untuk live search.
     * Fungsi ini akan mengembalikan data dalam format JSON.
     */
    public function searchApi(Request $request)
    {
        $search = $request->input('q');

        $query = Mahasiswa::with('prodi');

        // Jika ada input pencarian, filter berdasarkan nama ATAU nim
        $query->when($search, function ($q, $search) {
            return $q->where('nm_mhs', 'like', $search . '%')
                     ->orWhere('nim', 'like', $search . '%');
        });

        // Ambil 10 hasil teratas yang cocok
        $results = $query->orderBy('nm_mhs', 'asc')
                         ->take(15) 
                         ->get();

        return response()->json($results);
    }
}

