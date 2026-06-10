<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaTemplateExport implements FromArray, WithStyles
{
    public function array(): array
    {
        // Menyusun header kolom dan contoh data di bawahnya
        return [
            ['nama', 'email', 'password'], // Baris 1: Header (Wajib huruf kecil sesuai import)
            ['Ahmad Fauzi', 'ahmad@siswa.com', 'password123'], // Baris 2: Contoh data 1
            ['Siti Aminah', 'siti@siswa.com', ''], // Baris 3: Contoh data 2 (password kosong)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Memberikan style bold (tebal) khusus untuk baris nomor 1 (Header)
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}   