<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    // Menangkap request filter dari Controller
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // 1. Mengambil data sesuai filter
    public function collection()
    {
        $query = User::with('kelas')->where('role', 'siswa'); 

        if ($this->request->filled('kelas_id')) {
            $query->where('kelas_id', $this->request->kelas_id);
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->latest()->get();
    }

    // 2. Mapping data per baris Excel
    public function map($siswa): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $siswa->name,
            $siswa->email,
            $siswa->kelas->nama_kelas ?? '-',
        ];
    }

    // 3. Membuat Header (Baris Pertama) Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Email',
            'Kelas',
        ];
    }
}