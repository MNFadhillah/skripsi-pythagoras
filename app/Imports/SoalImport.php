<?php

namespace App\Imports;

use App\Models\ButirSoal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use ZipArchive;

class SoalImport implements ToCollection, WithHeadingRow
{
    protected $paket_soal_id;
    protected $images = [];

    public function __construct($paket_soal_id)
    {
        $this->paket_soal_id = $paket_soal_id;
    }

    public function collection(Collection $rows)
    {
        $uploadedFile = request()->file('file_excel');
        $filePath = $uploadedFile->getRealPath();

        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();

        $drawings = $worksheet->getDrawingCollection();
        Log::info('Total gambar ditemukan: ' . count($drawings));

        foreach ($drawings as $drawing) {
            $coordinates = $drawing->getCoordinates();
            if (strpos($coordinates, ':') !== false) {
                $coordinates = explode(':', $coordinates)[0];
            }

            $column = preg_replace('/[0-9]/', '', $coordinates);
            $row = (int) preg_replace('/[^0-9]/', '', $coordinates);

            Log::info("Gambar ditemukan di koordinat: {$coordinates} (Kolom {$column}, Baris {$row})");

            // Hanya proses kolom H dan baris >= 2
            if (strtoupper($column) !== 'H' || $row < 2) {
                Log::info("Gambar diabaikan (bukan kolom H atau baris header)");
                continue;
            }

            $imageContents = null;
            $extension = 'png';

            if ($drawing instanceof Drawing) {
                $path = $drawing->getPath();

                // Cek apakah path adalah stream zip://
                if (strpos($path, 'zip://') === 0) {
                    // Format: zip://path_to_zip#entry
                    $parts = explode('#', substr($path, 6)); // hapus 'zip://'
                    $zipPath = $parts[0];
                    $entry = $parts[1] ?? '';

                    Log::info("Zip path: {$zipPath}, entry: {$entry}");

                    if (file_exists($zipPath)) {
                        $zip = new ZipArchive();
                        if ($zip->open($zipPath) === true) {
                            $imageContents = $zip->getFromName($entry);
                            $zip->close();

                            // Ambil ekstensi dari entry
                            $ext = pathinfo($entry, PATHINFO_EXTENSION);
                            if (!empty($ext) && in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
                                $extension = $ext;
                            }
                        } else {
                            Log::warning("Gagal membuka zip: {$zipPath}");
                        }
                    } else {
                        Log::warning("Zip file tidak ditemukan: {$zipPath}");
                    }
                } else {
                    // Path biasa
                    if (file_exists($path) && is_readable($path)) {
                        $imageContents = file_get_contents($path);
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if (!empty($ext) && in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
                            $extension = $ext;
                        }
                    } else {
                        Log::warning("Path gambar tidak ditemukan atau tidak readable: {$path}");
                    }
                }
            } elseif ($drawing instanceof MemoryDrawing) {
                // Kode untuk MemoryDrawing (copy-paste) - sama seperti sebelumnya
                ob_start();
                $callable = $drawing->getRenderingFunction();
                $resource = $drawing->getImageResource();
                if (is_callable($callable) && $resource) {
                    call_user_func($callable, $resource);
                    $imageContents = ob_get_clean();

                    $mime = $drawing->getMimeType();
                    switch ($mime) {
                        case MemoryDrawing::MIMETYPE_JPEG: $extension = 'jpg'; break;
                        case MemoryDrawing::MIMETYPE_PNG: $extension = 'png'; break;
                        case MemoryDrawing::MIMETYPE_GIF: $extension = 'gif'; break;
                        default: $extension = 'png';
                    }
                } else {
                    ob_end_clean();
                }
            }

            if ($imageContents) {
                $folderPath = public_path('storage/soal');
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, 0755, true);
                }

                $filename = 'soal_' . time() . '_' . uniqid() . '_row' . $row . '.' . $extension;
                $saved = file_put_contents($folderPath . '/' . $filename, $imageContents);

                if ($saved === false) {
                    Log::error("Gagal menyimpan gambar untuk baris {$row}");
                    continue;
                }

                $this->images[$row] = '/storage/soal/' . $filename;
                Log::info("Gambar tersimpan untuk baris {$row}: {$filename}");
            } else {
                Log::warning("Gambar kosong atau gagal dibaca untuk baris {$row}");
            }
        }

        // Simpan data ke database (sama seperti sebelumnya)
        foreach ($rows as $index => $rowData) {
            $excelRowIndex = $index + 2;
            $imagePath = $this->images[$excelRowIndex] ?? null;

            if (empty($rowData['pertanyaan']) && empty($imagePath)) {
                continue;
            }

            $pertanyaanJson = [
                'text'  => (string) ($rowData['pertanyaan'] ?? ''),
                'image' => $imagePath
            ];

            $tipe = strtolower(trim($rowData['tipe_soal'] ?? 'pg'));
            $kunci = trim($rowData['kunci_jawaban'] ?? '');

            if ($tipe === 'isian') {
                ButirSoal::create([
                    'paket_soal_id' => $this->paket_soal_id,
                    'pertanyaan'    => $pertanyaanJson,
                    'opsi_jawaban'  => [],
                    'kunci_jawaban' => $kunci,
                ]);
            } else {
                $opsi = [
                    'A' => ['text' => (string)($rowData['opsi_a'] ?? ''), 'image' => null],
                    'B' => ['text' => (string)($rowData['opsi_b'] ?? ''), 'image' => null],
                    'C' => ['text' => (string)($rowData['opsi_c'] ?? ''), 'image' => null],
                    'D' => ['text' => (string)($rowData['opsi_d'] ?? ''), 'image' => null],
                ];

                ButirSoal::create([
                    'paket_soal_id' => $this->paket_soal_id,
                    'pertanyaan'    => $pertanyaanJson,
                    'opsi_jawaban'  => $opsi,
                    'kunci_jawaban' => strtoupper($kunci),
                ]);
            }
        }
    }
}