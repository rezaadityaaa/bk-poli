<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\JadwalPeriksa;
use App\Models\JadwalPeriksas;

class JadwalPeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokter= User::where('role', 'dokter')->first();    
        $jadwalPeriksas = [
            [
                'id_dokter' => $dokter->id,
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'status' => true,
            ],
            [
                'id_dokter' => $dokter->id,
                'hari' => 'Selasa',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '17:00:00',
                'status' => true,
            ],
        ];
        foreach ($jadwalPeriksas as $jadwalPeriksa) {
            JadwalPeriksa::create($jadwalPeriksa);
        }
    }
}
