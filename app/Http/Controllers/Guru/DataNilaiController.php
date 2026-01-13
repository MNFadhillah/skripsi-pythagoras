<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\HasilPengerjaan;
use Illuminate\Http\Request;
use App\Models\PaketSoal;
use App\Models\ButirSoal;


class DataNilaiController extends Controller
{
    public function index()
    {
        // Sama seperti sebelumnya
        $dataNilai = HasilPengerjaan::with(['user', 'paketSoal'])
                    ->whereNotNull('user_id')
                    ->latest()
                    ->get();

        return view('guru.data_nilai', compact('dataNilai'));
    }

    public function show($id)
    {
        // Eager Load relasi jawaban detail
        $hasil = HasilPengerjaan::with(['user', 'paketSoal', 'jawabanSiswa.butirSoal'])
                ->findOrFail($id);

        // KITA RETURN JSON AGAR BISA DIOLAH DI SATU HALAMAN BLADE
        return response()->json([
            'success' => true,
            'data' => $hasil
        ]);
    }

    public function analisis(Request $request)
    {
        // 1. Ambil semua paket soal untuk dropdown filter
        $listPaket = PaketSoal::all();
        
        $selectedPaket = null;
        $daftarSoal = [];
        $dataHasil = [];

        // 2. Jika guru sudah memilih paket soal
        if ($request->has('paket_id') && $request->paket_id != '') {
            $paketId = $request->paket_id;
            $selectedPaket = PaketSoal::find($paketId);

            // Ambil daftar soal (untuk header tabel 1, 2, 3...) urut berdasarkan ID atau nomor
            $daftarSoal = ButirSoal::where('paket_soal_id', $paketId)->orderBy('id')->get();

            // Ambil hasil pengerjaan siswa pada paket ini
            // Eager load 'jawabanSiswa' agar tidak berat query-nya
            $dataHasil = HasilPengerjaan::with(['user', 'jawabanSiswa'])
                        ->where('paket_soal_id', $paketId)
                        ->whereNotNull('user_id')
                        ->latest()
                        ->get();
        }

        return view('guru.analisis_nilai', compact('listPaket', 'selectedPaket', 'daftarSoal', 'dataHasil'));
    }
}