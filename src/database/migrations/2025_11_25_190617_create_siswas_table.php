<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();

            // Identitas siswa
            $table->string('nama_lengkap');
            $table->string('nis')->unique();
            $table->string('nisn')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('whatsapp')->nullable();

            // File ijazah
            $table->string('ijazah_path')->nullable();
            $table->string('ijazah_mime')->nullable();

            // Status verifikasi
            $table->enum('status_verifikasi', [
                'Belum Upload',
                'Sedang Diverifikasi',
                'Terverifikasi',
                'Gagal'
            ])->default('Belum Upload');

            $table->enum('ocr_status', [
                'pending',
                'processing',
                'done'
            ])->default('pending');

            // Hasil OCR mentah
            $table->text('ocr_result')->nullable();

            // Hasil OCR yang sudah di-normalize
            $table->string('ocr_verified_name')->nullable();
            $table->string('ocr_verified_nisn')->nullable();
            $table->string('ocr_verified_tahun_lulus')->nullable();

            // Catatan verifikasi admin
            $table->text('catatan_verifikasi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
