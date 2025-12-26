<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('karyawans', function (Blueprint $table) {
            $table->id();

            // Relasi ke user
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Identitas lengkap karyawan
            $table->string('nama_lengkap');
            $table->string('nip')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('nik')->nullable();
            $table->string('jenis_kelamin')->nullable();  
            $table->string('agama')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();

            // Kontak
            $table->string('email_karyawan')->unique();
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();

            // Foreign key JABATAN (INI YANG BENER)
            $table->foreignId('jabatan_id')
                  ->nullable()
                  ->constrained('jabatans')
                  ->nullOnDelete();

            // Informasi pekerjaan
            $table->string('status_kepegawaian')->nullable();
            $table->string('bidang_studi')->nullable();
            $table->string('unit_kerja')->nullable();

            // Sekolah
            $table->unsignedBigInteger('sekolah_id')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
