<?php

namespace App\Jobs;

use App\Models\Siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessIjazahOCR implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $SiswaId;

    public function __construct(int $SiswaId)
    {
        $this->SiswaId = $SiswaId;
    }

    public function handle(): void
    {
        $Siswa = Siswa::find($this->SiswaId);

        if (!$Siswa || !$Siswa->ijazah_path) {
            Log::warning("OCR Job: Siswa not found or ijazah_path missing (ID: {$this->SiswaId})");
            return;
        }

        /**
         * =============================================================
         *  FIX PATH — gunakan storage_path agar Laravel yang tentukan
         * =============================================================
         */
        $relative = $Siswa->ijazah_path;

        if (!str_starts_with($relative, 'public/')) {
            $relative = 'public/' . $relative;
        }

        $fullPath = storage_path("app/{$relative}");

        Log::info("OCR: Full file path = {$fullPath}");

        if (!file_exists($fullPath)) {
            Log::error("OCR: FILE NOT FOUND → {$fullPath}");

            $Siswa->update([
                'status_verifikasi'  => 'Gagal',
                'catatan_verifikasi' => 'File ijazah tidak ditemukan di server.',
                'ocr_result'         => json_encode([
                    "error" => "file_not_found",
                    "path_checked" => $fullPath
                ]),
            ]);
            return;
        }

        /**
         * =============================================================
         *  Jalankan Script OCR Python (tanpa modif Docker)
         * =============================================================
         */
        $command = "python3 /var/www/html/ocr/ocr.py \"$fullPath\" 2>&1";
        Log::info("OCR command: {$command}");

        $output = shell_exec($command);

        // simpan raw data
        $Siswa->ocr_result = $output;

        $data = json_decode($output, true);

        $status = 'Gagal';
        $notes  = 'OCR gagal membaca dokumen.';

        /**
         * =============================================================
         *  Validasi JSON hasil OCR (jika valid)
         * =============================================================
         */
        if (is_array($data)) {
            $ocrNama  = strtolower(trim($data['nama'] ?? ''));
            $ocrNisn  = trim($data['nisn'] ?? '');
            $ocrTahun = trim($data['tahun_lulus'] ?? '');

            $dbNama   = strtolower(trim($Siswa->nama_lengkap));
            $dbNisn   = trim($Siswa->nisn);
            $dbTahun  = trim($Siswa->tahun_lulus);

            $mismatch = [];

            if ($ocrNama === $dbNama && $ocrNisn === $dbNisn && $ocrTahun === $dbTahun) {
                $status = 'Terverifikasi';
                $notes  = 'Ijazah valid dan sesuai dengan data sekolah.';
            } else {
                if ($ocrNama !== $dbNama)   $mismatch[] = '- Nama tidak sesuai';
                if ($ocrNisn !== $dbNisn)   $mismatch[] = '- NISN tidak sesuai';
                if ($ocrTahun !== $dbTahun) $mismatch[] = '- Tahun lulus tidak sesuai';

                $notes = "Perbedaan ditemukan:\n" . implode("\n", $mismatch);
            }
        } else {
            Log::error("OCR JSON Decode FAILED! Output:\n{$output}");
        }

        /**
         * =============================================================
         *  Update Siswa
         * =============================================================
         */
        $Siswa->update([
            'status_verifikasi'  => $status,
            'catatan_verifikasi' => $notes,
            'ocr_result'         => $Siswa->ocr_result,
        ]);

        Log::info("OCR DONE for ID {$Siswa->id}, status: {$status}");
    }
}