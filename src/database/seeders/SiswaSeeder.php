<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('siswas')->insert([
            [
                'nama_lengkap' => 'Ahmad Fauzi',
                'nis' => '101001',
                'nisn' => '9988776655',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => Carbon::parse('2005-03-12')->format('Y-m-d'),
                'tempat_lahir' => 'Jakarta',
                'jurusan' => 'IPA',
                'tahun_lulus' => '2023',
            ],
            [
                'nama_lengkap' => 'Siti Rahma',
                'nis' => '101002',
                'nisn' => '9988776656',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => Carbon::parse('2005-07-22')->format('Y-m-d'),
                'tempat_lahir' => 'Bandung',
                'jurusan' => 'IPS',
                'tahun_lulus' => '2023',
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'nis' => '101003',
                'nisn' => null,
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => Carbon::parse('2004-11-05')->format('Y-m-d'),
                'tempat_lahir' => 'Surabaya',
                'jurusan' => 'Bahasa',
                'tahun_lulus' => '2022',
            ],
            [
                'nama_lengkap' => 'Dewi Lestari',
                'nis' => '101004',
                'nisn' => '9988776657',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => Carbon::parse('2005-01-15')->format('Y-m-d'),
                'tempat_lahir' => 'Yogyakarta',
                'jurusan' => 'IPA',
                'tahun_lulus' => '2023',
            ],
        ]);
    }
}
