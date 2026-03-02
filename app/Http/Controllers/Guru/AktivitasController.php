<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AktivitasBelajar; // Pakai Model Baru
use App\Models\PaketSoal;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = AktivitasBelajar::with(['paket_soal','kelas'])->latest()->get();
        $listPaket = PaketSoal::orderBy('judul')->get();
        $listKelas = Kelas::orderBy('nama_kelas')->get(); // TAMBAHAN

        return view('guru.aktivitas', compact('aktivitas', 'listPaket', 'listKelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|in:konsep,tripel,istimewa,penerapan,evaluasi',
            'kelas_id' => 'required|exists:kelas,id',
            'durasi_menit' => 'nullable|integer|min:1',
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;

        // Jika status aktif dan waktu mulai/selesai tidak diisi, set otomatis
        if ($data['status'] && (empty($data['waktu_mulai']) || empty($data['waktu_selesai']))) {
            $now = now();
            $data['waktu_mulai'] = $now;
            $data['waktu_selesai'] = $now->copy()->addMinutes($data['durasi_menit'] ?? 60);
        }

        AktivitasBelajar::create($data);
        return response()->json(['success' => true, 'message' => 'Aktivitas berhasil dibuat!']);
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
        'judul' => 'required|string',
        'kategori' => 'required|in:konsep,tripel,istimewa,penerapan,evaluasi',
        'kelas_id' => 'required|exists:kelas,id',
        'tipe' => 'required',
        'poin_didapat' => 'required|integer',
        'durasi_menit' => 'nullable|integer|min:1',
    ]);

    $data = $request->all();
    $data['status'] = $request->has('status') ? 1 : 0;

    if ($data['status'] && (empty($data['waktu_mulai']) || empty($data['waktu_selesai']))) {
        $now = now();
        $data['waktu_mulai'] = $now;
        $data['waktu_selesai'] = $now->copy()->addMinutes($data['durasi_menit'] ?? 60);
    }

    $aktivitas->update($data);
    return response()->json(['success' => true, 'message' => 'Aktivitas diperbarui']);
}

    public function destroy($id)
    {
        AktivitasBelajar::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Aktivitas dihapus']);
    }
}