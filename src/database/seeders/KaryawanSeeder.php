<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            {
        $karyawanList = [
            ['nama' => 'Budi Santoso', 'email' => 'budi.santoso@smkn1.sch.id', 'tgl' => '1984-01-12', 'jabatan_id' => 3],
            ['nama' => 'Siti Aminah', 'email' => 'siti.aminah@smkn1.sch.id', 'tgl' => '1985-03-04', 'jabatan_id' => 3],
            ['nama' => 'Rudi Hartono', 'email' => 'rudi.hartono@smkn1.sch.id', 'tgl' => '1980-07-22', 'jabatan_id' => 2],
            ['nama' => 'Nur Aisyah', 'email' => 'nur.aisyah@smkn1.sch.id', 'tgl' => '1986-11-03', 'jabatan_id' => 4],
            ['nama' => 'Tono Saputra', 'email' => 'tono.saputra@smkn1.sch.id', 'tgl' => '1983-08-15', 'jabatan_id' => 1],
            ['nama' => 'Ayu Lestari', 'email' => 'ayu.lestari@smkn1.sch.id', 'tgl' => '1987-05-19', 'jabatan_id' => 3],
            ['nama' => 'Dedi Priyanto', 'email' => 'dedi.priyanto@smkn1.sch.id', 'tgl' => '1982-02-10', 'jabatan_id' => 5],
            ['nama' => 'Sri Wahyuni', 'email' => 'sri.wahyuni@smkn1.sch.id', 'tgl' => '1985-09-07', 'jabatan_id' => 6],
            ['nama' => 'Agus Salim', 'email' => 'agus.salim@smkn1.sch.id', 'tgl' => '1981-04-30', 'jabatan_id' => 7],
            ['nama' => 'Maya Sari', 'email' => 'maya.sari@smkn1.sch.id', 'tgl' => '1988-12-25', 'jabatan_id' => 3],
        ];

        foreach ($karyawanList as $data) {

            $passwordAwal = Carbon::parse($data['tgl'])->format('Ymd');

            // Buat user login
            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($passwordAwal),
            ]);

            // Beri role staff
            $user->assignRole('staff');

            // Buat data karyawan
            Karyawan::create([
                'user_id' => $user->id,
                'nama_lengkap' => $data['nama'],
                'email_karyawan' => $data['email'],
                'tanggal_lahir' => $data['tgl'],
                'jenis_kelamin' => rand(0,1) ? 'L' : 'P',
                'agama' => 'Islam',
                'tempat_lahir' => 'Tangerang',
                'nik' => fake()->numerify('################'),
                'no_hp' => fake()->phoneNumber(),
                'jabatan_id' => $data['jabatan_id'],
                'status_kepegawaian' => 'ASN',
                'bidang_studi' => 'Umum',
                'unit_kerja' => 'SMKN 1 KABUPATEN TANGERANG',
                'alamat' => 'Kabupaten Tangerang',
                'sekolah_id' => 1,
            ]);
        }
            }
    }
}
