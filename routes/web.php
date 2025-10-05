<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\RoleAssignmentController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Middleware\IsDosenPembimbing;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');

    // GRUP RUTE KHUSUS UNTUK DOSEN PEMBIMBING
    Route::middleware(IsDosenPembimbing::class)->prefix('dosen-pembimbing')->name('dosen-pembimbing.')->group(function () {
        Route::get('dashboard', [DosenPembimbingController::class, 'index'])->name('dashboard');
        Route::get('mahasiswa', [DosenPembimbingController::class, 'showMahasiswa'])->name('mahasiswa');
        Route::get('rekomendasi', [DosenPembimbingController::class, 'showRekomendasiForm'])->name('rekomendasi.form');
        
        // ==== TAMBAHKAN RUTE BARU UNTUK MENYIMPAN DATA DI SINI ====
        Route::post('rekomendasi', [DosenPembimbingController::class, 'storeRekomendasi'])->name('rekomendasi.store');
    });

    // GRUP RUTE KHUSUS UNTUK ADMIN
    Route::middleware(IsAdmin::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('roles', [RoleAssignmentController::class, 'index'])->name('roles.index');
        Route::get('roles/{dosen:email_dos}/edit', [RoleAssignmentController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{dosen:email_dos}', [RoleAssignmentController::class, 'update'])->name('roles.update');
        Route::get('roles/search', [RoleAssignmentController::class, 'search'])->name('roles.search');
    });
});

Route::get('/api/mahasiswa/search', [MahasiswaController::class, 'searchApi']);

require __DIR__ . '/auth.php';