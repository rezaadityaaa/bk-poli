<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JanjiPeriksa;
use App\Models\Periksa;
use App\Models\Obat;
use App\Models\DetailPeriksa;

class JanjiPeriksaController extends Controller
{
    public function index()
    {
        // Ambil semua janji untuk dokter yang sedang login
        $janji = JanjiPeriksa::with(['pasien', 'jadwalPeriksa'])
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
            'biaya_periksa' => 'required|numeric',
            'obat_ids' => 'nullable|array',
            'obat_ids.*' => 'exists:obats,id',
        ]);

        $periksa = Periksa::create([
            'id_janji_periksa' => $validated['id_janji_periksa'],
            'tgl_periksa' => $validated['tgl_periksa'],
            'catatan' => $validated['catatan'],
            'biaya_periksa' => $validated['biaya_periksa'],
        ]);

        // Simpan resep jika ada
        if (!empty($validated['obat_ids'])) {
            foreach ($validated['obat_ids'] as $obatId) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                ]);
            }
        }

        return redirect()->route('dokter.janjiperiksa.index')->with('status', 'periksa-created');
    }

}