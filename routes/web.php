<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\RoleAssignmentController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Controllers\DosenKonselingController; // <-- Penambahan baru
use App\Http\Middleware\IsDosenPembimbing;
use App\Http\Middleware\IsDosenKonseling; // <-- Penambahan baru
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard utama yang cerdas, ini kita pertahankan
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Mengambil rute asli dari GitHub, sekarang dilindungi middleware admin
    Route::get('/dosen', [DosenController::class, 'index'])->middleware(IsAdmin::class)->name('dosen.index');
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->middleware(IsAdmin::class)->name('mahasiswa.index');

    // GRUP RUTE KHUSUS UNTUK DOSEN PEMBIMBING (Dari file asli Anda)
    Route::middleware(IsDosenPembimbing::class)->prefix('dosen-pembimbing')->name('dosen-pembimbing.')->group(function () {
        Route::get('mahasiswa', [DosenPembimbingController::class, 'showMahasiswa'])->name('mahasiswa');
        Route::get('rekomendasi', [DosenPembimbingController::class, 'showRekomendasiForm'])->name('rekomendasi');
        Route::post('rekomendasi', [DosenPembimbingController::class, 'storeRekomendasi'])->name('rekomendasi.store');
    });

    // GRUP RUTE KHUSUS UNTUK DOSEN KONSELING (Fitur baru yang kita tambahkan)
    Route::middleware(IsDosenKonseling::class)->prefix('dosen-konseling')->name('dosen-konseling.')->group(function () {
        Route::get('pengajuan', [DosenKonselingController::class, 'daftarPengajuan'])->name('pengajuan.index');
        Route::get('pengajuan/{id_konseling}', [DosenKonselingController::class, 'showPengajuan'])->name('pengajuan.show');
        Route::post('pengajuan/{id_konseling}/verifikasi', [DosenKonselingController::class, 'verifikasi'])->name('pengajuan.verifikasi');
        Route::get('jadwal', [DosenKonselingController::class, 'daftarJadwal'])->name('jadwal.index');
        Route::get('jadwal/{id_konseling}/create', [DosenKonselingController::class, 'createJadwal'])->name('jadwal.create');
        Route::post('jadwal/{id_konseling}', [DosenKonselingController::class, 'storeJadwal'])->name('jadwal.store');
        Route::get('kasus-aktif', [DosenKonselingController::class, 'daftarKasusAktif'])->name('kasus.index');
        Route::get('kasus-aktif/{id_jadwal}/hasil/create', [DosenKonselingController::class, 'createHasil'])->name('kasus.hasil.create');
        Route::post('kasus-aktif/{id_jadwal}/hasil', [DosenKonselingController::class, 'storeHasil'])->name('kasus.hasil.store');
        Route::get('kasus-aktif/hasil/{id_hasil}', [DosenKonselingController::class, 'showHasil'])->name('kasus.hasil.show');
    });

    // GRUP RUTE KHUSUS UNTUK ADMIN (Pengelolaan Peran)
    Route::middleware(IsAdmin::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('roles', [RoleAssignmentController::class, 'index'])->name('roles.index');
        Route::get('roles/{user}/edit', [RoleAssignmentController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{user}', [RoleAssignmentController::class, 'update'])->name('roles.update');
        Route::get('roles/search', [RoleAssignmentController::class, 'search'])->name('roles.search');
    });
});

Route::get('/api/mahasiswa/search', [MahasiswaController::class, 'searchApi']);

require __DIR__ . '/auth.php';