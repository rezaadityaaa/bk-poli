<?php

namespace App\Http\Controllers\pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JanjiPeriksa;
use Illuminate\Support\Facades\Auth;

class RiwayatPeriksaController extends Controller
{
    public function index()
    {
        $no_rm = Auth::user()->no_rm;
        $janjiPeriksas = JanjiPeriksa::where('id_pasien', Auth::user()->id)->get();

        return view('pasien.riwayat-periksa.index')->with([
            'no_rm' => $no_rm,
            'janjiPeriksas' => $janjiPeriksas,
        ]);
    }

    public function riwayat($id)
    {
        $janjiPeriksa = JanjiPeriksa::with([
            'jadwalPeriksa.dokter',
            'periksa.detailPeriksas.obat' // <-- TAMBAHKAN INI
        ])->findOrFail($id);
        $riwayat = $janjiPeriksa->riwayatPeriksa;

        return view('pasien.riwayat-periksa.riwayat')->with([
            'riwayat' => $riwayat,
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }
    public function detail($id)
    {
        $janjiPeriksa = JanjiPeriksa::with([
            'jadwalPeriksa.dokter',
            'periksa.detailPeriksas.obat' // <-- TAMBAHKAN INI
        ])->findOrFail($id);

        return view('pasien.riwayat-periksa.detail', [
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }
}
