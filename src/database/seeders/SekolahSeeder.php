<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Sekolah::create([
            'npsn' => '20601453', // contoh NPSN SMKN 1 Kab. Tangerang
            'nama_sekolah' => 'SMKN 1 KABUPATEN TANGERANG',
            'alamat' => 'Jl. Syeh Mubarok, Kec. Tigaraksa, Kabupaten Tangerang, Banten',
        ]);
    }
}
