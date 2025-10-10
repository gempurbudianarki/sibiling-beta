<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Http\Controllers\Controller;
use App\Models\HasilKonseling;
use App\Models\JadwalKonseling;
use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class KasusController extends Controller
{
    /**
     * Menampilkan riwayat kasus yang sudah selesai (Tuntas).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query ini sudah benar untuk menampilkan riwayat, tidak perlu diubah.
        $kasusQuery = Konseling::with('mahasiswa')
            ->whereHas('jadwalKonseling.hasilKonseling');

        if ($search) {
            $kasusQuery->whereHas('mahasiswa', function (Builder $query) use ($search) {
                $query->where('nm_mhs', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%");
            });
        }
        
        // Mengambil hanya kasus yang benar-benar sudah selesai
        $kasusQuery->where('status', 'Selesai')
                   ->orderBy('updated_at', 'desc');

        $riwayatKasus = $kasusQuery->paginate(15);

        return view('dosen-konseling.kasus.index', compact('riwayatKasus'));
    }

    /**
     * Menampilkan detail dari satu kasus konseling.
     */
    public function show(Konseling $konseling)
    {
        // Eager load relasi untuk ditampilkan di view
        $konseling->load(['mahasiswa.prodi', 'jadwalKonseling.hasilKonseling']);

        return view('dosen-konseling.kasus.show', compact('konseling'));
    }

    /**
     * [BARU] Menyimpan hasil sesi konseling dari form.
     * Ini method yang hilang sebelumnya.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input yang masuk
        $validated = $request->validate([
            'konseling_id' => 'required|exists:konseling,id',
            'jadwal_id' => 'required|exists:jadwal_konseling,id',
            'hasil_konseling' => 'required|string|min:10',
            // 'action' akan berisi 'Tuntas' atau 'Lanjutan', tergantung tombol yg diklik
            'action' => 'required|string|in:Tuntas,Lanjutan', 
        ]);

        // 2. Simpan dulu hasil konselingnya, apapun aksinya
        HasilKonseling::create([
            'id_konseling' => $validated['konseling_id'],
            'id_jadwal' => $validated['jadwal_id'],
            'hasil_konseling' => $validated['hasil_konseling'],
        ]);

        // 3. Ambil model terkait untuk di-update
        $konseling = Konseling::findOrFail($validated['konseling_id']);
        $jadwal = JadwalKonseling::findOrFail($validated['jadwal_id']);
        
        // Tandai jadwal ini sebagai 'Selesai' karena sesinya sudah berlangsung
        $jadwal->update(['status' => 'Selesai']);

        // 4. Logika utama berdasarkan tombol yang ditekan
        if ($validated['action'] === 'Tuntas') {
            // Jika Tuntas, selesaikan kasus konseling
            $konseling->update(['status' => 'Selesai']);
            $message = 'Hasil konseling berhasil disimpan dan kasus telah dituntaskan.';

        } else { // Berarti aksinya adalah 'Lanjutan'
            // Jika perlu lanjutan, kembalikan statusnya ke 'Terverifikasi'
            // agar bisa dibuatkan jadwal baru lagi oleh Dosen Konseling.
            $konseling->update(['status' => 'Terverifikasi']);
            $message = 'Hasil sesi berhasil disimpan. Kasus ini memerlukan sesi lanjutan.';
        }

        // 5. Redirect ke dashboard dengan pesan sukses
        return redirect()->route('dosen-konseling.dashboard')->with('success', $message);
    }
}