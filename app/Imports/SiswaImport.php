<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // 1. Validasi opsional: Jika baris kosong atau email sudah terdaftar, lewati baris ini
        if (empty($row['email']) || User::where('email', $row['email'])->exists()) {
            return null;
        }

        // 2. Mapping kolom Excel ke model User dengan role siswa
        return new User([
            'name'     => $row['nama'],
            'email'    => $row['email'],
            // Jika kolom password di excel kosong, otomatis beri default 'password123'
            'password' => Hash::make($row['password'] ?? 'password123'),
            'role'     => 'siswa',
            'points'   => 0, // Inisialisasi poin gamifikasi awal siswa
        ]);
    }
}