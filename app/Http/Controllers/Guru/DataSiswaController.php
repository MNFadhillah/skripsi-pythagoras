<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa
     */
    public function index(Request $request)
    {
        // Ambil user dengan role siswa
        $dataSiswa = User::where('role', 'siswa')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('guru.data_siswa', compact('dataSiswa'));
    }

    /**
     * (OPSIONAL) Hapus siswa
     * — saat ini masih dummy / belum dipakai
     */
    public function destroy($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // HATI-HATI: aktifkan jika benar-benar ingin hapus
        // $siswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil dihapus'
        ]);
    }
}
