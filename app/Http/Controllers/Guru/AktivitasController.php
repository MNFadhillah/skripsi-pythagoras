<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AktivitasBelajar; // Pakai Model Baru
use App\Models\PaketSoal;
use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = AktivitasBelajar::with('paket_soal')->latest()->get();
        $listPaket = PaketSoal::orderBy('judul')->get();
        return view('guru.aktivitas', compact('aktivitas', 'listPaket'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'judul'         => 'required|string',
            'kategori'      => 'required|in:konsep,tripel,istimewa,penerapan,evaluasi', // <--- Validasi Kategori
            'tipe'          => 'required|in:materi,kuis,streak,evaluasi',
            'paket_soal_id' => 'required_unless:tipe,materi', 
            'poin_didapat'  => 'required|integer',
            'waktu_mulai'   => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        // 2. Simpan
        AktivitasBelajar::create([
            'judul'         => $request->judul,
            'kategori'      => $request->kategori, // <--- Simpan Kategori
            'paket_soal_id' => $request->paket_soal_id,
            'tipe'          => $request->tipe,
            'poin_didapat'  => $request->poin_didapat,
            'instruksi'     => $request->instruksi,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'durasi_menit'  => $request->durasi_menit ?? 60,
            'token'         => $request->token ? strtoupper($request->token) : null,
            'status'        => $request->has('status') ? 1 : 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Aktivitas berhasil dibuat']);
    }

    public function edit($id)
    {
        $data = AktivitasBelajar::findOrFail($id);
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $aktivitas = AktivitasBelajar::findOrFail($id);

        $request->validate([
            'judul'         => 'required|string',
            'kategori' => 'required|in:konsep,tripel,istimewa,penerapan,evaluasi',
            'tipe'          => 'required',
            'poin_didapat'  => 'required|integer',
            'waktu_mulai'   => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        $aktivitas->update([
            'judul'         => $request->judul,
            'kategori' => $request->kategori,
            'paket_soal_id' => $request->paket_soal_id,
            'tipe'          => $request->tipe,
            'poin_didapat'  => $request->poin_didapat,
            'instruksi'     => $request->instruksi,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'durasi_menit'  => $request->durasi_menit,
            'token'         => $request->token ? strtoupper($request->token) : null,
            'status'        => $request->has('status') ? 1 : 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Aktivitas diperbarui']);
    }

    public function destroy($id)
    {
        AktivitasBelajar::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Aktivitas dihapus']);
    }
}