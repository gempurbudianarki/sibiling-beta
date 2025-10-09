<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Ambil data mahasiswa dengan pagination, urutkan berdasarkan angkatan terbaru, lalu nama.
        // Eager load relasi 'prodi' untuk menghindari N+1 query problem.
        $mahasiswa = Mahasiswa::with('prodi')
            ->orderBy('angkatan', 'desc')
            ->orderBy('nm_mhs', 'asc')
            ->paginate(15); // Ambil 15 data per halaman

        // Kirim data ke view
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Display the specified resource for API requests.
     * Ini akan digunakan oleh modal detail.
     */
    public function show(Mahasiswa $mahasiswa): JsonResponse
    {
        // Load relasi prodi untuk memastikan datanya ada
        $mahasiswa->load('prodi');
        return response()->json($mahasiswa);
    }

    // Method create, store, edit, update, destroy bisa dibiarkan kosong untuk saat ini
    // karena kita tidak menggunakannya.
}