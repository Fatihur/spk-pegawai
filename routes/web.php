<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;

Route::get('/', fn() => redirect()->route('login'));

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Hasil & Laporan (semua role)
    Route::get('/hasil-penilaian', [PerhitunganController::class, 'perbandingan'])->name('perbandingan');
    Route::get('/laporan/pdf', [PerhitunganController::class, 'exportPdf'])->name('laporan.pdf');

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('kriteria', KriteriaController::class);
        Route::get('/kriteria/{kriteria}/subkriteria', [SubKriteriaController::class, 'index'])->name('subkriteria.index');
        Route::post('/kriteria/{kriteria}/subkriteria', [SubKriteriaController::class, 'store'])->name('subkriteria.store');
        Route::delete('/kriteria/{kriteria}/subkriteria/{subkriteria}', [SubKriteriaController::class, 'destroy'])->name('subkriteria.destroy');
        
        Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/create', [PenilaianController::class, 'create'])->name('penilaian.create');
        Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
        Route::get('/penilaian/show', [PenilaianController::class, 'show'])->name('penilaian.show');
        
        Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
        Route::get('/perhitungan/hitung', [PerhitunganController::class, 'hitung'])->name('perhitungan.hitung');
    });
});
