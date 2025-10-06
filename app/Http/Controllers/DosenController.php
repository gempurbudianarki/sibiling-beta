<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ==================================================================
        // ==== PERBAIKAN: Menyamakan nama variabel dengan yang ada di view ====
        // ==================================================================
        $all_dosen = Dosen::orderBy('nm_dos', 'asc')->paginate(15);
        
        return view('dosen.index', compact('all_dosen'));
    }

    // Metode lain bisa ditambahkan di sini jika diperlukan.
}