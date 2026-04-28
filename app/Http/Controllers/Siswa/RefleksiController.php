<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataRefleksi;
use Illuminate\Support\Facades\Auth;

class RefleksiController extends Controller
{
    public function simpan(Request $request)
    {
        // Kumpulkan semua input form, KECUALI token CSRF dan kode_materi
        $dataJawaban = $request->except(['_token', 'kode_materi']);

        // Simpan ke database
        DataRefleksi::create([
            'user_id' => Auth::id(),
            'kode_materi' => $request->input('kode_materi'),
            'jawaban' => $dataJawaban // Laravel akan otomatis merubah array ini jadi JSON
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Refleksi berhasil disimpan!'
        ]);
    }
}