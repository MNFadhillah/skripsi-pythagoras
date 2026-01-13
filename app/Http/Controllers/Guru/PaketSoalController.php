<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PaketSoal;
use Illuminate\Http\Request;

class PaketSoalController extends Controller
{
    public function index()
    {
        // Mengambil data urut dari yang terbaru
        $paketSoal = PaketSoal::withCount('butir_soal')->orderBy('created_at', 'desc')->get();
        return view('guru.paket_soal', compact('paketSoal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe'      => 'required|in:kuis,evaluasi,streak', // Sesuai ENUM database
        ]);

        PaketSoal::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tipe'      => $request->tipe,
        ]);

        return response()->json(['success' => true, 'message' => 'Paket soal berhasil dibuat']);
    }

    public function edit($id)
    {
        try {
            $paket = PaketSoal::findOrFail($id);
            return response()->json([
                'success' => true,
                'data'    => $paket
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe'      => 'required|in:kuis,evaluasi,streak',
        ]);

        $paket = PaketSoal::findOrFail($id);
        
        $paket->update([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tipe'      => $request->tipe,
        ]);

        return response()->json(['success' => true, 'message' => 'Paket soal berhasil diperbarui']);
    }

    public function destroy($id)
    {
        try {
            $paket = PaketSoal::findOrFail($id);
            
            // Opsional: Cek apakah paket ini punya butir soal?
            // Jika ada relasi: $paket->butir_soal()->delete();
            
            $paket->delete();

            return response()->json(['success' => true, 'message' => 'Paket soal berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }

   public function show($id)
{
    try {
        $paket = PaketSoal::with(['butir_soal' => function ($q) {
            $q->orderBy('id', 'asc');
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $paket->id,
                'judul' => $paket->judul,
                'butir_soal' => $paket->butir_soal->map(function ($s) {

                    // NORMALISASI PERTANYAAN
                    $text = '';
                    $image = null;

                    if (is_array($s->pertanyaan)) {
                        $text  = $s->pertanyaan['text'] ?? '';
                        $image = $s->pertanyaan['image'] ?? null;
                    } else {
                        $text = $s->pertanyaan;
                    }

                    return [
                        'id'            => $s->id,
                        'pertanyaan'    => $text,
                        'gambar'        => $image, // ⬅️ PENTING
                        'opsi_jawaban'  => $s->opsi_jawaban,
                        'kunci_jawaban' => $s->kunci_jawaban,
                    ];
                })
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Paket tidak ditemukan'
        ], 404);
    }
}



}