<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataNilaiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $dataSiswa;

    // Terima data dari controller
    public function __construct($dataSiswa)
    {
        $this->dataSiswa = $dataSiswa;
    }

    public function collection()
    {
        return $this->dataSiswa;
    }

    // Mapping: Menentukan kolom mana saja yang mau diambil dari array data
    public function map($siswa): array
    {
        return [
            $siswa['name'],
            $siswa['kelas'],
            $siswa['nilai']['kuis_1'],
            $siswa['nilai']['kuis_2'],
            $siswa['nilai']['kuis_3'],
            $siswa['nilai']['kuis_4'],
            $siswa['nilai']['evaluasi'],
        ];
    }

    // Header Excel
    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Kuis 1',
            'Kuis 2',
            'Kuis 3',
            'Kuis 4',
            'Evaluasi',
        ];
    }

    // Styling opsional (membuat header tebal)
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}