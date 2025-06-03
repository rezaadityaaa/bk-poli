<?php

use App\Http\Controllers\Dokter\ObatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dokter\JadwalPeriksaController;

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');
    
    Route::prefix('obat')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('dokter.obat.index');
        Route::get('/create', [ObatController::class, 'create'])->name('dokter.obat.create');
        Route::post('/', [ObatController::class, 'store'])->name('dokter.obat.store');
        Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('dokter.obat.edit');
        Route::patch('/{id}', [ObatController::class, 'update'])->name('dokter.obat.update');
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('dokter.obat.destroy');
    });

    Route::prefix('jadwal-periksa')->group(function () {
        Route::get('/', [App\Http\Controllers\Dokter\JadwalPeriksaController::class, 'index'])->name('dokter.jadwal-periksa.index');
        Route::get('/create', [App\Http\Controllers\Dokter\JadwalPeriksaController::class, 'create'])->name('dokter.jadwal-periksa.create');
        Route::post('/', [App\Http\Controllers\Dokter\JadwalPeriksaController::class, 'store'])->name('dokter.jadwal-periksa.store');
        Route::get('/{id}/edit', [App\Http\Controllers\Dokter\JadwalPeriksaController::class, 'edit'])->name('dokter.jadwal-periksa.edit');
        Route::patch('/{id}', [App\Http\Controllers\Dokter\JadwalPeriksaController::class, 'update'])->name('dokter.jadwal-periksa.update');
        Route::delete('/{id}', [App\Http\Controllers\Dokter\JadwalPeriksaController::class, 'destroy'])->name('dokter.jadwal-periksa.destroy');
    });
});