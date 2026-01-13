<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AktivitasBelajar; // Ganti PaketSoal jadi Aktivitas
use App\Models\HasilPengerjaan;
use App\Models\ButirSoal;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QuizController extends Controller
{
    /**
     * Menampilkan halaman kuis berdasarkan ID Aktivitas
     */
    public function show($aktivitasId)
{
    $aktivitas = AktivitasBelajar::with('paket_soal')->findOrFail($aktivitasId);

    return view('siswa.templatekuis', [
        'aktivitas'       => $aktivitas,
        'paket'           => $aktivitas->paket_soal,
        'materiSekarang'  => $aktivitas->judul,
        'nextMateriUrl'   => route('siswa.tripel.materi'),
        'backMateriUrl'   => route('siswa.konsep.materi'),

        // ⬇️ INI PENTING
        'statusAktivitas' => [
            'status'        => $aktivitas->status,
            'waktu_mulai'   => $aktivitas->waktu_mulai,
            'waktu_selesai' => $aktivitas->waktu_selesai,
        ],
    ]);
}



    /**
     * API untuk mengambil soal JSON (Dipanggil oleh fetch JS)
     */
    public function api($aktivitasId)
    {
        // Ambil aktivitas dan paket soalnya
        $aktivitas = AktivitasBelajar::with('paket_soal.butir_soal')->findOrFail($aktivitasId);

        $now = Carbon::now();

        if (!$aktivitas->status) {
            return response()->json([
                'error' => 'Hubungi guru Anda untuk informasi lebih lanjut.'
            ], 403);
        }

        if ($aktivitas->waktu_selesai && $now->gt($aktivitas->waktu_selesai)) {
            return response()->json([
                'error' => 'Waktu aktivitas telah berakhir'
            ], 403);
        }


        $paket = $aktivitas->paket_soal;

        if (!$paket) {
            return response()->json(['error' => 'Paket soal tidak ditemukan'], 404);
        }

        // Format data untuk JS
        return response()->json([
            'id_aktivitas' => $aktivitas->id,
            'id_paket'     => $paket->id,
            'judul'        => $aktivitas->judul,
            'durasi_menit' => $aktivitas->durasi_menit, // Ambil durasi dari settingan Guru
            'soal'         => $paket->butir_soal->map(function ($s) {
                
                // Normalisasi pertanyaan (array/string)
                $text = '';
                $image = null;
                
                if (is_array($s->pertanyaan)) {
                    $text = $s->pertanyaan['text'] ?? '';
                    $image = $s->pertanyaan['image'] ?? null;
                } else {
                    $text = $s->pertanyaan;
                    // Logic regex gambar lama jika perlu
                }

                return [
                    'id'            => $s->id,
                    'text'          => $text,
                    'image'         => $image,
                    'options'       => $s->opsi_jawaban,
                    'kunci_jawaban' => $s->kunci_jawaban, // Untuk review client-side (Hati-hati jika ini ujian serius)
                ];
            }),
        ]);
    }

    /**
     * Submit Jawaban
     */
    public function submit(Request $request)
    {
        $request->validate([
            'aktivitas_id'      => 'required|exists:aktivitas_belajar,id',
            'jawaban'           => 'required|array',
            'jawaban.*.soal_id' => 'required|exists:butir_soal,id',
            'jawaban.*.jawaban' => 'nullable|string',
        ]);


        $aktivitasId = $request->aktivitas_id;
        $jawabanSiswa = $request->jawaban;

        // Ambil data
        $aktivitas = AktivitasBelajar::findOrFail($aktivitasId);
        $soalList = ButirSoal::where('paket_soal_id', $aktivitas->paket_soal_id)->get();

        $now = Carbon::now();

        if (!$aktivitas->status) {
            return response()->json([
                'status' => 'blocked',
                'message' => 'Aktivitas sudah ditutup oleh guru.'
            ], 403);
        }

        if ($aktivitas->waktu_selesai && $now->gt($aktivitas->waktu_selesai)) {
            return response()->json([
                'status' => 'expired',
                'message' => 'Waktu pengerjaan sudah habis.'
            ], 403);
        }



        $skor = 0;
        $detailJawaban = [];
        $totalSoal = count($jawabanSiswa);

        // Buat record Hasil
        $hasil = HasilPengerjaan::create([
            'aktivitas_belajar_id' => $aktivitasId, // Pastikan tabel hasil_pengerjaan punya kolom ini!
            'paket_soal_id'        => $aktivitas->paket_soal_id, // Tetap simpan ID paket untuk arsip
            'user_id'              => 1, // Dummy User
            'skor_akhir'           => 0,
            'waktu_mulai'          => now()->subMinutes($aktivitas->durasi_menit), // Estimasi
            'waktu_selesai'        => now(),
        ]);

        // Koreksi Jawaban
        foreach ($jawabanSiswa as $item) {

            $soal = ButirSoal::find($item['soal_id']);
            if (!$soal) continue;

            $jawaban = $item['jawaban'];
            $benar = ($jawaban === $soal->kunci_jawaban);

            if ($benar) $skor++;

            JawabanSiswa::create([
                'hasil_pengerjaan_id' => $hasil->id,
                'butir_soal_id'       => $soal->id,
                'jawaban'             => $jawaban,
                'benar'               => $benar
            ]);

            $pertanyaanText = is_array($soal->pertanyaan)
                ? ($soal->pertanyaan['text'] ?? '')
                : $soal->pertanyaan;

            $detailJawaban[] = [
                'soal_id'       => $soal->id,
                'jawaban_siswa' => $jawaban,
                'jawaban_benar' => $soal->kunci_jawaban,
                'benar'         => $benar,
                'pertanyaan'    => $pertanyaanText
            ];
        }

        // Hitung Nilai Akhir (Skala 100)
        // Rumus: (Benar / Total) * 100
        $nilaiAkhir = ($totalSoal > 0) ? round(($skor / $totalSoal) * 100) : 0;

        // Update Skor
        $hasil->update(['skor_akhir' => $nilaiAkhir]);

        // Logika Gamifikasi: Jika nilai bagus, kasih Poin Aktivitas
        // if ($nilaiAkhir >= 70) { User::tambahPoin($aktivitas->poin_didapat); }

        return response()->json([
            'status'        => 'ok',
            'hasil_id'      => $hasil->id,
            'skor'          => $nilaiAkhir, // Nilai 0-100
            'jumlah_benar'  => $skor,
            'total_soal'    => $totalSoal,
            'detail'        => $detailJawaban
        ]);
    }

    /**
     * Menampilkan Halaman Hasil (Review)
     */
    public function showResult($hasilId)
    {
        // Pastikan relasi 'jawabanSiswa.butirSoal' dan 'paketSoal' ada di model HasilPengerjaan
        $hasil = HasilPengerjaan::with(['jawabanSiswa.butirSoal', 'paketSoal'])
            ->findOrFail($hasilId);
        
        return view('siswa.hasil_kuis', compact('hasil'));
    }

    /**
     * API untuk Mendapatkan Detail Hasil (Opsional jika dibutuhkan JS)
     */
    public function getResultDetail($hasilId)
    {
        $hasil = HasilPengerjaan::with(['jawabanSiswa.butirSoal'])
            ->findOrFail($hasilId);
        
        $detail = $hasil->jawabanSiswa->map(function ($jawaban) {
            $text = is_array($jawaban->butirSoal->pertanyaan) 
                ? ($jawaban->butirSoal->pertanyaan['text'] ?? '') 
                : $jawaban->butirSoal->pertanyaan;

            return [
                'soal_text'     => $text,
                'jawaban_siswa' => $jawaban->jawaban,
                'jawaban_benar' => $jawaban->butirSoal->kunci_jawaban,
                'benar'         => $jawaban->benar,
                'options'       => $jawaban->butirSoal->opsi_jawaban
            ];
        });
        
        return response()->json([
            'skor'       => $hasil->skor_akhir,
            'total_soal' => $hasil->jawabanSiswa->count(),
            'detail'     => $detail
        ]);
    }
}