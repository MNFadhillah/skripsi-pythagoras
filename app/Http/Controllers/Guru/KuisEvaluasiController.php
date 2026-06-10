<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AktivitasBelajar; // Tetap gunakan model ini agar database tidak perlu bermigrasi
use App\Models\PaketSoal;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisEvaluasiController extends Controller
{
    public function index()
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();
        $hasClass = !empty($kelasIds);

        // Pengambilan data tetap memakai model AktivitasBelajar
        $aktivitas = AktivitasBelajar::with(['paket_soal', 'kelas'])
            ->whereIn('kelas_id', $kelasIds)
            ->latest()
            ->get();

        $listPaket = PaketSoal::orderBy('judul')->get();
        $listKelas = Kelas::whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        // Mengarahkan ke file view yang baru: kuis_evaluasi.blade.php
        return view('guru.kuis_evaluasi', compact('aktivitas', 'listPaket', 'listKelas', 'hasClass'));
    }

    public function store(Request $request)
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|in:konsep,tripel,istimewa,penerapan,evaluasi',
            'kelas_id' => 'required|exists:kelas,id',
            'durasi_menit' => 'nullable|integer|min:1',
            'kkm' => 'required|integer|min:0|max:100', // TAMBAHKAN VALIDASI KKM
        ]);

        if (!in_array($request->kelas_id, $kelasIds)) {
            return response()->json(['success' => false, 'message' => 'Kelas tidak valid'], 403);
        }

        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($data['status'] && (empty($data['waktu_mulai']) || empty($data['waktu_selesai']))) {
            $now = now();
            $data['waktu_mulai'] = $now;
            $data['waktu_selesai'] = $now->copy()->addMinutes((int) ($data['durasi_menit'] ?? 60));
        }

        AktivitasBelajar::create($data);
        return response()->json(['success' => true, 'message' => 'Kuis/Evaluasi berhasil diterbitkan!']);
    }

    public function edit($id)
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        $data = AktivitasBelajar::whereIn('kelas_id', $kelasIds)->findOrFail($id);

        $now = now();
        $waktuMulai = $data->waktu_mulai ? \Carbon\Carbon::parse($data->waktu_mulai) : null;
        $waktuSelesai = $data->waktu_selesai ? \Carbon\Carbon::parse($data->waktu_selesai) : null;
        $isTimeValid = $waktuMulai && $waktuSelesai && $now->between($waktuMulai, $waktuSelesai);
        $data->is_currently_active = ($data->status == 1 && $isTimeValid);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        $aktivitas = AktivitasBelajar::whereIn('kelas_id', $kelasIds)->findOrFail($id);

        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|in:konsep,tripel,istimewa,penerapan,evaluasi',
            'kelas_id' => 'required|exists:kelas,id',
            'tipe' => 'required',
            'poin_didapat' => 'required|integer',
            'durasi_menit' => 'nullable|integer|min:1',
            'kkm' => 'required|integer|min:0|max:100', // TAMBAHKAN VALIDASI KKM
        ]);

        if (!in_array($request->kelas_id, $kelasIds)) {
            return response()->json(['success' => false, 'message' => 'Kelas tidak valid'], 403);
        }

        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($data['status'] == 1) {
            $now = now();
            $waktuSelesaiInput = !empty($data['waktu_selesai']) ? \Carbon\Carbon::parse($data['waktu_selesai']) : null;
            if (empty($data['waktu_mulai']) || empty($data['waktu_selesai']) || ($waktuSelesaiInput && $waktuSelesaiInput->isPast())) {
                $data['waktu_mulai'] = $now;
                $data['waktu_selesai'] = $now->copy()->addMinutes((int) ($data['durasi_menit'] ?? 60));
            }
        }

        $aktivitas->update($data);
        return response()->json(['success' => true, 'message' => 'Data Kuis/Evaluasi berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        $aktivitas = AktivitasBelajar::whereIn('kelas_id', $kelasIds)->findOrFail($id);
        $aktivitas->delete();
        return response()->json(['success' => true, 'message' => 'Kuis/Evaluasi berhasil dihapus']);
    }
}