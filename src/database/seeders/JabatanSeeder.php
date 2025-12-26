<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_jabatan' => 'Kepala Sekolah'],
            ['nama_jabatan' => 'Wakil Kepala Sekolah'],
            ['nama_jabatan' => 'Guru'],
            ['nama_jabatan' => 'Guru Produktif'],
            ['nama_jabatan' => 'Guru BK'],
            ['nama_jabatan' => 'Tata Usaha'],
            ['nama_jabatan' => 'Operator Sekolah'],
            ['nama_jabatan' => 'Bendahara Sekolah'],
            ['nama_jabatan' => 'Staff IT'],
            ['nama_jabatan' => 'Staff Perpustakaan'],
            ['nama_jabatan' => 'Staff Kebersihan'],
        ];

           Jabatan::insert($data);
    }
}
