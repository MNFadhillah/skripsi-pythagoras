<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class SiswaExport implements FromCollection, WithHeadings
{
    protected $request;
    protected $allowedClassIds;

    public function __construct(Request $request, array $allowedClassIds)
    {
        $this->request = $request;
        $this->allowedClassIds = $allowedClassIds;
    }

    public function collection()
    {
        $query = User::where('role', 'siswa')
                     ->whereIn('kelas_id', $this->allowedClassIds)
                     ->with('kelas');

        if ($this->request->filled('kelas_id') && in_array($this->request->kelas_id, $this->allowedClassIds)) {
            $query->where('kelas_id', $this->request->kelas_id);
        }

        $siswa = $query->get();

        return $siswa->map(function ($item) {
            return [
                'Nama' => $item->name,
                'Email' => $item->email,
                'Kelas' => $item->kelas ? $item->kelas->nama_kelas : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Email',
            'Kelas'
        ];
    }
}