<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
        protected $fillable = [
        'nama_lengkap',
        'nis',
        'nisn',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'jurusan',
        'tahun_lulus',
        'ijazah_path',
        'status_verifikasi',
        'catatan_verifikasi',
        'ocr_result',
    ];
}
