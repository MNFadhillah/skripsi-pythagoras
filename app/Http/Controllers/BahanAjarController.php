<?php

namespace App\Http\Controllers;

class BahanAjarController extends Controller
{
    private function getPdfData(): array
    {
        $fileName = 'bahan-ajar-pythagoras.pdf';
        $filePath = storage_path('app/bahan-ajar/' . $fileName);

        return [
            'judul' => 'Bahan Ajar Teorema Pythagoras',
            'deskripsi' => 'File bahan ajar ini berisi materi pendukung pembelajaran Teorema Pythagoras yang dapat digunakan oleh siswa dan guru.',
            'fileName' => $fileName,
            'fileExists' => file_exists($filePath),
            'fileSize' => file_exists($filePath)
                ? number_format(filesize($filePath) / 1024 / 1024, 2) . ' MB'
                : '-',
        ];
    }

    public function siswa()
    {
        return view('siswa.pendahuluan.bahan_ajar', array_merge(
            $this->getPdfData(),
            [
                'downloadRoute' => route('siswa.bahan_ajar.download'),
                'previewRoute' => route('siswa.bahan_ajar.preview'),
            ]
        ));
    }

    public function guru()
    {
        return view('guru.bahan_ajar', array_merge(
            $this->getPdfData(),
            [
                'downloadRoute' => route('guru.bahan_ajar.download'),
                'previewRoute' => route('guru.bahan_ajar.preview'),
            ]
        ));
    }

    public function download()
    {
        $fileName = 'bahan-ajar-pythagoras.pdf';
        $filePath = storage_path('app/bahan-ajar/' . $fileName);

        if (!file_exists($filePath)) {
            abort(404, 'File bahan ajar belum tersedia.');
        }

        return response()->download($filePath, 'Bahan Ajar Teorema Pythagoras.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function preview()
    {
        $fileName = 'bahan-ajar-pythagoras.pdf';
        $filePath = storage_path('app/bahan-ajar/' . $fileName);

        if (!file_exists($filePath)) {
            abort(404, 'File bahan ajar belum tersedia.');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Bahan Ajar Teorema Pythagoras.pdf"',
        ]);
    }
}
