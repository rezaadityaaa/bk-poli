<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $JadwalPeriksas = JadwalPeriksa::where('id_dokter', Auth::user()->id)->get();
    
        return view('dokter.jadwal-periksa.index', compact('JadwalPeriksas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        JadwalPeriksa::create([
            'id_dokter' => Auth::user()->id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => false,
        ]);
        
        return redirect()->route('dokter.jadwal-periksa.index')->with('status', 'jadwal-periksa-created');  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);
        return view('dokter.jadwal-periksa.edit', compact('jadwalPeriksa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);
        $jadwalPeriksa->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('dokter.jadwal-periksa.index')->with('status', 'jadwal-periksa-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);
        $jadwalPeriksa->delete();

        return redirect()->route('dokter.jadwal-periksa.index')->with('status', 'jadwal-periksa-deleted');
    }

    public function toggleStatus($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);

        if (!$jadwal->status) {
            // Nonaktifkan semua jadwal milik dokter ini
            JadwalPeriksa::where('id_dokter', $jadwal->id_dokter)
                ->update(['status' => false]);
            // Aktifkan jadwal yang dipilih
            $jadwal->status = true;
        } else {
            // Jika sedang aktif, ubah jadi nonaktif
            $jadwal->status = false;
        }
        $jadwal->save();

        return redirect()->route('dokter.jadwal-periksa.index');
    }
}
