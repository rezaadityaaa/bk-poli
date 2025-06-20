<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JanjiPeriksa;
use App\Models\Periksa;
use App\Models\Obat;
use App\Models\DetailPeriksa;
use Illuminate\Support\Facades\Auth;

class PeriksaController extends Controller
{
    public function index()
{
    // Hanya tampilkan janji yang BELUM ADA di tabel periksa
    $janji = JanjiPeriksa::with(['pasien', 'jadwalPeriksa', 'periksa'])
        ->whereHas('jadwalPeriksa', function ($query) {
            $query->where('id_dokter', Auth::id());
        })
        ->get()
        ->sortBy(function($item) {
            return $item->periksa ? 1 : 0;
        });

    return view('dokter.janji-periksa.index', compact('janji'));
}

    public function create(JanjiPeriksa $janji)
    {
        $obats = Obat::all();

        return view('dokter.janji-periksa.create', [
            'janji' => $janji,
            'obats' => $obats
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_janji_periksa' => 'required|exists:janji_periksas,id',
            'tgl_periksa' => 'required|date',
            'catatan' => 'required|string',
            'obat_ids' => 'nullable|array',
            'obat_ids.*' => 'exists:obats,id',
        ]);

        // Biaya pemeriksaan tetap
        $biaya_pemeriksaan = 150000;

        // Hitung total harga obat dari checkbox yang dipilih
        $total_harga_obat = 0;
        if (!empty($validated['obat_ids'])) {
            $total_harga_obat = Obat::whereIn('id', $validated['obat_ids'])->sum('harga');
        }

        $total_biaya = $biaya_pemeriksaan + $total_harga_obat;

        // Create Periksa
        $periksa = Periksa::create([
            'id_janji_periksa' => $validated['id_janji_periksa'],
            'tgl_periksa' => $validated['tgl_periksa'],
            'catatan' => $validated['catatan'],
            'biaya_periksa' => $total_biaya,
        ]);

        // Simpan detail obat satu per satu
        if (!empty($validated['obat_ids'])) {
            foreach ($validated['obat_ids'] as $obatId) {
                \App\Models\DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                ]);
            }
        }

        return redirect()->route('dokter.janji')->with('status', 'periksa-created');
    }
    public function edit($id)
    {
        $periksa = Periksa::with(['detailPeriksas'])->findOrFail($id);
        $obats = Obat::all();
        $selectedObats = $periksa->detailPeriksas->pluck('id_obat')->toArray();

        return view('dokter.janji-periksa.edit', [
            'periksa' => $periksa,
            'obats' => $obats,
            'selectedObats' => $selectedObats,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'catatan' => 'required|string',
            'obat_ids' => 'nullable|array',
            'obat_ids.*' => 'exists:obats,id',
        ]);

        $periksa = Periksa::findOrFail($id);

        // Hitung ulang biaya
        $biaya_pemeriksaan = 150000;
        $total_harga_obat = 0;
        if (!empty($validated['obat_ids'])) {
            $total_harga_obat = Obat::whereIn('id', $validated['obat_ids'])->sum('harga');
        }
        $total_biaya = $biaya_pemeriksaan + $total_harga_obat;

        // Update periksa
        $periksa->catatan = $validated['catatan'];
        $periksa->biaya_periksa = $total_biaya;
        $periksa->save();

        // Update detail obat
        $periksa->detailPeriksas()->delete();
        if (!empty($validated['obat_ids'])) {
            foreach ($validated['obat_ids'] as $obatId) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                ]);
            }
        }

        return redirect()->route('dokter.janji')->with('status', 'periksa-updated');
    }
}
