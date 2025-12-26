<?php

namespace App\Filament\Admin\Resources\KaryawanResource\Pages;

use App\Filament\Admin\Resources\KaryawanResource;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateKaryawan extends CreateRecord
{
  protected static string $resource = KaryawanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // password awal
        $passwordAwal = Carbon::parse($data['tanggal_lahir'])->format('Ymd');

        // buat user
        $user = User::create([
            'name'     => $data['nama_lengkap'],
            'email'    => $data['email_karyawan'],
            'password' => Hash::make($passwordAwal),
        ]);

        // beri role otomatis
        $user->assignRole('staff');

        // masukkan user_id ke tabel karyawan
        $data['user_id'] = $user->id;

        return $data;
    
    }
}