<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaController;
use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pasien\JanjiPeriksaController;
use App\Http\Controllers\Pasien\RiwayatPeriksaController;
use App\Http\Controllers\Dokter\ObatController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {

    Route :: prefix('jadwal-periksa')->group(function () {
        Route :: get('/', [JadwalPeriksaController::class, 'index'])->name('dokter.jadwal-periksa.index');
        Route :: get('/create', [JadwalPeriksaController::class, 'create'])->name('dokter.jadwal-periksa.create');
    });
    Route::get('janji-periksa', [PeriksaController::class, 'index'])->name('dokter.janji');
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    // Route untuk fitur periksa
    Route::get('/periksa/{janji}/create', [PeriksaController::class, 'create'])->name('dokter.periksa.create');
    Route::post('/periksa', [PeriksaController::class, 'store'])->name('dokter.periksa.store');
    Route::get('/periksa/{id}/edit', [PeriksaController::class, 'edit'])->name('dokter.periksa.edit');
    Route::patch('/periksa/{id}', [PeriksaController::class, 'update'])->name('dokter.periksa.update');
});



Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route:: prefix('janjiperiksa')->group(function () {
        Route::get('/', [JanjiPeriksaController::class, 'index'])->name('pasien.janjiperiksa.index');
        Route::post('/', [JanjiPeriksaController::class, 'store'])->name('pasien.janjiperiksa.store');
    });
    Route::prefix('riwayat-periksa')->group(function(){
        Route::get('/', [RiwayatPeriksaController::class, 'index'])->name('pasien.riwayat-periksa.index');
        Route::get('/{id}/detail', [RiwayatPeriksaController::class, 'detail'])->name('pasien.riwayat-periksa.detail');
        Route::get('/{id}/riwayat', [RiwayatPeriksaController::class, 'riwayat'])->name('pasien.riwayat-periksa.riwayat');
        Route::post('/pasien/riwayat-periksa', [RiwayatPeriksaController::class, 'store'])->name('pasien.riwayat-periksa.store');
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Tambahkan route ini
Route::patch('/dokter/jadwal-periksa/{id}/status', [JadwalPeriksaController::class, 'toggleStatus'])->name('dokter.jadwal-periksa.status');
Route::get('/obat/trash', [ObatController::class, 'trash'])->name('obat.trash');
Route::post('/obat/{id}/restore', [ObatController::class, 'restore'])->name('obat.restore');
Route::delete('/obat/{id}/force-delete', [ObatController::class, 'forceDelete'])->name('obat.forceDelete');

require __DIR__.'/auth.php';
// require __DIR__.'/pasien.php';
require __DIR__.'/dokter.php';
