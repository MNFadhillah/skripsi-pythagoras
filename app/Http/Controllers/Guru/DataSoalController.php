<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ButirSoal;
use App\Models\PaketSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SoalImport;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Excel as ExcelExcel;


class DataSoalController extends Controller
{
    /**
     * Menampilkan halaman data soal
     */
    public function data_soal(Request $request)
    {
        $query = ButirSoal::with('paketSoal')
            ->orderBy('created_at', 'desc');

        if ($request->filled('paket_soal_id')) {
            $query->where('paket_soal_id', $request->paket_soal_id);
        }

        $soal = $query->get();
        $paketSoal = PaketSoal::orderBy('judul')->get();

        return view('guru.data_soal', compact('soal', 'paketSoal'));
    }

    /**
     * JSON Detail Soal
     */
    public function data_soal_json($id)
    {
        try {
            $soal = ButirSoal::with('paketSoal')->findOrFail($id);

            return response()->json([
                'success'        => true,
                'pertanyaan'     => $soal->pertanyaan,
                'opsi_jawaban'   => $soal->opsi_jawaban,
                'kunci_jawaban'  => $soal->kunci_jawaban,
                'paket_soal'     => $soal->paketSoal->judul ?? '-',
                'created_at'     => $soal->created_at->format('d-m-Y H:i'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan'
            ], 404);
        }
    }

    /**
     * JSON Edit Modal
     */
    public function editJson($id)
    {
        try {
            $soal = ButirSoal::findOrFail($id);

            $text = $soal->pertanyaan['text'] ?? '';
            $gambar = $soal->pertanyaan['image'] ?? null;

            return response()->json([
                'success'        => true,
                'id'             => $soal->id,
                'paket_soal_id'  => $soal->paket_soal_id,
                'pertanyaan'     => $text,
                'gambar'         => $gambar,
                'opsi'           => $soal->opsi_jawaban,
                'kunci_jawaban'  => $soal->kunci_jawaban,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data'
            ], 500);
        }
    }

    /**
     * Simpan Soal Baru (Manual)
     */
    public function store(Request $request)
    {
        // 1. Tentukan apakah ini soal Isian atau Pilihan Ganda
        $isIsian = $request->input('tipe_soal', 'pg') === 'isian';

        // 2. Validasi Dasar
        $rules = [
            'paket_soal_id' => 'required|exists:paket_soal,id',
            'pertanyaan'    => 'required',
            'gambar'        => 'nullable|image|max:2048',
        ];

        // 3. Validasi Kondisional
        if ($isIsian) {
            // Jika Isian: Wajib isi kunci_jawaban_isian (Text)
            $rules['kunci_jawaban_isian'] = 'required';
        } else {
            // Jika PG: Wajib isi kunci_jawaban_pg (A-D) dan Opsi
            $rules['kunci_jawaban_pg'] = 'required|in:A,B,C,D';
            $rules['opsi'] = 'required|array';
        }

        $request->validate($rules);

        // 4. Proses Simpan Gambar
        $pertanyaanData = [
            'text'  => trim($request->pertanyaan),
            'image' => null,
        ];

        if ($request->hasFile('gambar')) {
            $path = public_path('storage/soal');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $file = $request->file('gambar');
            $namaFile = 'soal_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $namaFile);

            $pertanyaanData['image'] = '/storage/soal/' . $namaFile;
        }

        // 5. Proses Opsi dan Kunci Jawaban
            if ($isIsian) {
                // Kita simpan array kosong.
                // Karena di Model ada casts 'array', Laravel otomatis ubah jadi JSON "[]"
                $opsiFormatted = []; 
                $kunciFinal = $request->kunci_jawaban_isian;
            } else {
            // Logic PG: Format opsi jadi array JSON, Kunci diambil dari dropdown
            $opsiFormatted = [];
            foreach ($request->opsi as $key => $val) {
                $opsiFormatted[$key] = [
                    'text'  => $val['text'] ?? '',
                    'image' => null,
                ];
            }
            $kunciFinal = $request->kunci_jawaban_pg;
        }

        // 6. Simpan ke Database
        ButirSoal::create([
            'paket_soal_id' => $request->paket_soal_id,
            'pertanyaan'    => $pertanyaanData,
            'opsi_jawaban'  => $opsiFormatted,
            'kunci_jawaban' => $kunciFinal,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil ditambahkan'
        ]);
    }

    /**
     * Update Soal
     */
    public function update(Request $request, $id)
    {
        $soal = ButirSoal::findOrFail($id);

        // 1. Cek tipe soal dari input edit
        $isIsian = $request->tipe_soal === 'isian';

        // 2. Validasi Dasar
        $rules = [
            'paket_soal_id'   => 'required|exists:paket_soal,id',
            'pertanyaan_text' => 'required',
            'gambar'          => 'nullable|image|max:2048',
        ];

        // 3. Validasi Kondisional
        if ($isIsian) {
            $rules['kunci_jawaban_isian'] = 'required';
        } else {
            $rules['kunci_jawaban_pg'] = 'required|in:A,B,C,D';
            $rules['opsi'] = 'required|array';
        }

        $request->validate($rules);

        // 4. Proses Gambar (Pertahankan lama jika tidak ada upload baru)
        $pathGambarLama = $soal->pertanyaan['image'] ?? null;
        $pertanyaanData = [
            'text'  => trim($request->pertanyaan_text),
            'image' => $pathGambarLama,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus file lama fisik
            if ($pathGambarLama) {
                $this->hapusFileFisik($pathGambarLama);
            }

            $path = public_path('storage/soal');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $file = $request->file('gambar');
            $namaFile = 'soal_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $namaFile);

            $pertanyaanData['image'] = '/storage/soal/' . $namaFile;
        }

        // 5. Proses Opsi dan Kunci Jawaban
        if ($isIsian) {
            $opsiFormatted = [];
            $kunciFinal = $request->kunci_jawaban_isian;
        } else {
            $opsiFormatted = [];
            foreach ($request->opsi as $key => $val) {
                $opsiFormatted[$key] = [
                    'text'  => $val['text'] ?? '',
                    'image' => null,
                ];
            }
            $kunciFinal = $request->kunci_jawaban_pg;
        }

        // 6. Update Database
        $soal->update([
            'paket_soal_id' => $request->paket_soal_id,
            'pertanyaan'    => $pertanyaanData,
            'opsi_jawaban'  => $opsiFormatted,
            'kunci_jawaban' => $kunciFinal,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil diperbarui'
        ]);
    }

    /**
     * Hapus Soal
     */
    public function destroy($id)
    {
        try {
            $soal = ButirSoal::findOrFail($id);

            $gambar = $soal->pertanyaan['image'] ?? null;

            if ($gambar) {
                $this->hapusFileFisik($gambar);
            }

            $soal->delete();

            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus soal'
            ], 500);
        }
    }

    /**
     * Helper hapus file fisik
     */
    private function hapusFileFisik($relativePath)
    {
        $cleanPath = ltrim($relativePath, '/');
        $fullPath = public_path($cleanPath);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }


    /**
     * Import Soal dari Excel
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
            'paket_soal_id_import' => 'required|exists:paket_soal,id',
        ]);

        try {

            Excel::import(
                new SoalImport($request->paket_soal_id_import),
                $request->file('file_excel'),
                null,
                ExcelExcel::XLSX
            );


            return response()->json([
                'success' => true,
                'message' => 'Import berhasil! Data soal telah ditambahkan.'
            ]);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $failures = $e->failures();
            // Ambil error pertama saja
            $pesan = 'Baris ' . $failures[0]->row() . ': ' . $failures[0]->errors()[0];

            return response()->json([
                'success' => false,
                'message' => 'Validasi Excel Gagal: ' . $pesan
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download Template Import Soal
     */
    public function downloadTemplate()
    {
        return Excel::download(new class implements FromArray, WithHeadings, WithStyles {

            public function headings(): array {
                return [
                    'tipe_soal',
                    'pertanyaan',
                    'opsi_a',
                    'opsi_b',
                    'opsi_c',
                    'opsi_d',
                    'kunci_jawaban',
                    'gambar'
                ];
            }

            public function array(): array {
                return [

                    // =============================
                    // CONTOH SOAL PILIHAN GANDA
                    // =============================
                    [
                        'pg',
                        '2 + 2 = ?',
                        '3',
                        '4',
                        '5',
                        '6',
                        'B',
                        '' // Tempel gambar di kolom ini (H2)
                    ],

                    // =============================
                    // CONTOH SOAL ISIAN
                    // =============================
                    [
                        'isian',
                        'Sebutkan ibu kota Indonesia',
                        '',
                        '',
                        '',
                        '',
                        'Jakarta',
                        '' // Tempel gambar jika ada (H3)
                    ],

                ];
            }

            public function styles(Worksheet $sheet)
            {
                // Bold header
                $sheet->getStyle('A1:H1')->getFont()->setBold(true);

                // Lebar kolom
                $sheet->getColumnDimension('A')->setWidth(15);
                $sheet->getColumnDimension('B')->setWidth(40);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(20);
                $sheet->getColumnDimension('G')->setWidth(18);
                $sheet->getColumnDimension('H')->setWidth(50);

                // Tinggi baris agar muat gambar
                $sheet->getRowDimension(2)->setRowHeight(120);
                $sheet->getRowDimension(3)->setRowHeight(120);

                // Border pada area contoh
                $sheet->getStyle('A1:H3')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                return [];
            }

        }, 'template_import_soal.xlsx');
    }

}