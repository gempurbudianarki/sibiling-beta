<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Admin\RoleAssignmentController;

// Role-specific Dashboard Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\DosenKonseling\DashboardController as DosenKonselingDashboardController;
use App\Http\Controllers\DosenPembimbing\DashboardController as DosenPembimbingDashboardController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;


Route::get('/', function () {
    return view('welcome');
});

// The main dashboard route now acts as a dispatcher.
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('dosen', DosenController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::get('assign-roles', [RoleAssignmentController::class, 'index'])->name('roles.index');
    Route::post('assign-roles', [RoleAssignmentController::class, 'assign'])->name('roles.assign');
});

// Dosen Konseling Routes
Route::middleware(['auth', 'verified', 'role:dosen_konseling'])->prefix('dosen-konseling')->name('dosen-konseling.')->group(function () {
    Route::get('/dashboard', [DosenKonselingDashboardController::class, 'index'])->name('dashboard');
    // ... rute lain untuk dosen konseling bisa ditambahkan di sini
});

// Dosen Pembimbing Routes
Route::middleware(['auth', 'verified', 'role:dosen_pembimbing'])->prefix('dosen-pembimbing')->name('dosen-pembimbing.')->group(function () {
    Route::get('/dashboard', [DosenPembimbingDashboardController::class, 'index'])->name('dashboard');
    // ... rute lain untuk dosen pembimbing bisa ditambahkan di sini
});

// Mahasiswa Routes
Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    // ... rute lain untuk mahasiswa bisa ditambahkan di sini
});


require __DIR__.'/auth.php';