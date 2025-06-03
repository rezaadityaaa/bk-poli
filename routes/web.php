<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {

    Route :: prefix('jadwal-periksa')->group(function () {
        Route :: get('/', [JadwalPeriksaController::class, 'index'])->name('dokter.jadwal-periksa.index');
        Route :: get('/create', [JadwalPeriksaController::class, 'create'])->name('dokter.jadwal-periksa.create');
     
       

    });
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');
});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Tambahkan route ini
Route::patch('/dokter/jadwal-periksa/{id}/status', [JadwalPeriksaController::class, 'toggleStatus'])->name('dokter.jadwal-periksa.status');

require __DIR__.'/auth.php';
// require __DIR__.'/pasien.php';
require __DIR__.'/dokter.php';
