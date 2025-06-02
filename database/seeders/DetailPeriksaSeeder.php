<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Obat;

class DetailPeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periksa = Periksa::first();
        $obat =Obat::first();

        $detail = [
            'id_periksa' => $periksa->id,
            'id_obat'=> $obat->id,
        ];
        DetailPeriksa::create($detail);
    }

}
