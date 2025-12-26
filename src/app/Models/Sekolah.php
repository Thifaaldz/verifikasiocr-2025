<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
         protected $table = 'sekolahs';

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'alamat',
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'sekolah_id');
    }
}
