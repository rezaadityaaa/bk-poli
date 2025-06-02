<?php

namespace Database\Seeders;

use App\Models\JanjiPeriksa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Periksa;
use App\Models\Detailperiksa;

class PeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $janji = JanjiPeriksa ::first();

        $data = [
            [
                'id_janji_periksa' => $janji->id,
                'tgl_periksa' => now(),
                'catatan' => 'Pasien dalam kondisi stabil',
                'biaya_periksa' => 70000,
            ],
        ];
        foreach ($data as $item) {
            $periksa = Periksa::create($item);
        }
    }
}