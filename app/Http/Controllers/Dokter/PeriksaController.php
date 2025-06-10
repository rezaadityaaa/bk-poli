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
    // Ambil semua janji periksa untuk dokter yang sedang login
    $janji = JanjiPeriksa::with(['pasien', 'jadwalPeriksa'])
        ->where('status', 'belum')
        ->whereHas('jadwalPeriksa', function ($query) {
            $query->where('id_dokter', Auth::id());
        })->get();

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
        $biaya_pemeriksaan = 100000;

        // Hitung total harga obat
        $total_harga_obat = 0;
        if (!empty($validated['obat_ids'])) {
            $total_harga_obat = \App\Models\Obat::whereIn('id', $validated['obat_ids'])->sum('harga');
        }

        $total_biaya = $biaya_pemeriksaan + $total_harga_obat;

        $periksa = \App\Models\Periksa::create([
            'id_janji_periksa' => $validated['id_janji_periksa'],
            'tgl_periksa' => $validated['tgl_periksa'],
            'catatan' => $validated['catatan'],
            'biaya_periksa' => $total_biaya,
        ]);

        // Tandai janji sudah diperiksa
        JanjiPeriksa::where('id', $validated['id_janji_periksa'])->update(['status' => 'sudah']);

        // Simpan resep jika ada
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
}
