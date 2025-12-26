<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawans';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nip',
        'nuptk',
        'nik',
        'jenis_kelamin',
        'agama',
        'tanggal_lahir',
        'tempat_lahir',
        'email_karyawan',
        'no_hp',
        'alamat',
        'jabatan',
        'status_kepegawaian',
        'bidang_studi',
        'unit_kerja',
        'sekolah_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sekolah()
    {
    return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function jabatan()
    {
    return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
