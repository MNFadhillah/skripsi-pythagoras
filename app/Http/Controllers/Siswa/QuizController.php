<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AktivitasBelajar; // Ganti PaketSoal jadi Aktivitas
use App\Models\HasilPengerjaan;
use App\Models\ButirSoal;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
            'isEvaluasi'      => $aktivitas->kategori === 'evaluasi', // 🔥 TAMBAHAN
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
        $aktivitas = AktivitasBelajar::with('paket_soal.butir_soal')->findOrFail($aktivitasId);
        $user = Auth::user(); 
        $now = Carbon::now();

        // Cek Status & Waktu (Validasi standar)
        if (!$aktivitas->status) {
            return response()->json(['error' => 'Aktivitas ditutup.'], 403);
        }
        if ($aktivitas->waktu_selesai && $now->gt($aktivitas->waktu_selesai)) {
            return response()->json(['error' => 'Waktu habis.'], 403);
        }

        $paket = $aktivitas->paket_soal;
        if (!$paket) {
            return response()->json(['error' => 'Paket soal tidak ditemukan'], 404);
        }

        // Jika evaluasi dan sudah pernah selesai → blokir
        if ($aktivitas->kategori === 'evaluasi') {
            $sudah = HasilPengerjaan::where('user_id', $user->id)
                ->where('paket_soal_id', $paket->id)
                ->whereNotNull('waktu_selesai')
                ->exists();

            if ($sudah) {
                return response()->json([
                    'error' => 'Evaluasi hanya bisa dikerjakan sekali.'
                ], 403);
            }
        }

        // Kita cek: apakah siswa ini sudah pernah mulai kuis ini sebelumnya?
        $pengerjaan = HasilPengerjaan::where('user_id', $user->id)
                        ->where('paket_soal_id', $paket->id) 
                        ->whereNull('waktu_selesai') // Cari yang belum selesai
                        ->first();

        // Jika BELUM ADA, kita buatkan "TIMER START" sekarang juga
        if (!$pengerjaan) {
            HasilPengerjaan::create([
                'user_id'       => $user->id,
                'paket_soal_id' => $paket->id,
                // Kolom aktivitas_belajar_id dihapus karena tidak ada di tabel Anda
                'waktu_mulai'   => Carbon::now(), // <--- INI PENCATAT WAKTU MULAI REAL-TIME
                'waktu_selesai' => null,
                'skor_akhir'    => 0
            ]);
        }
        // ============================================

        return response()->json([
            'id_aktivitas' => $aktivitas->id,
            'id_paket'     => $paket->id,
            'judul'        => $aktivitas->judul,
            'durasi_menit' => $aktivitas->durasi_menit,
            'soal'         => $paket->butir_soal->map(function ($s) {
                return [
                    'id'      => $s->id,
                    'text'    => is_array($s->pertanyaan) ? ($s->pertanyaan['text'] ?? '') : $s->pertanyaan,
                    'image'   => is_array($s->pertanyaan) ? ($s->pertanyaan['image'] ?? null) : null,
                    'options' => $s->opsi_jawaban,
                ];
            }),
        ]);
    }
    /**
     * Submit Jawaban
     */
    /**
     * Submit Jawaban
     */
public function submit(Request $request)
    {
        $request->validate([
            'aktivitas_id'    => 'required|exists:aktivitas_belajar,id',
            'jawaban'         => 'required|array',
            'jawaban.*.soal_id' => 'required|exists:butir_soal,id',
        ]);

        $user = Auth::user();
        $aktivitasId = $request->aktivitas_id;
        $jawabanSiswa = $request->jawaban;

        $aktivitas = AktivitasBelajar::findOrFail($aktivitasId);
        $paketId = $aktivitas->paket_soal_id;
        $totalSoalReal = ButirSoal::where('paket_soal_id', $paketId)->count();

        // 1. CARI TIMER YANG SUDAH DIMULAI OLEH FUNGSI API
        $hasil = HasilPengerjaan::where('user_id', $user->id)
                    ->where('paket_soal_id', $paketId)
                    ->whereNull('waktu_selesai')
                    ->latest()
                    ->first();

        // 2. LOGIC UPDATE WAKTU
        if ($hasil) {
            // Jika ketemu (Normal), Update Waktu Selesai jadi SEKARANG
            $hasil->waktu_selesai = Carbon::now();
        } else {
            // Jika tidak ketemu (Error/Bypass), Buat Baru (Terpaksa pakai rumus lama biar ga error)
            $hasil = HasilPengerjaan::create([
                'user_id'       => $user->id,
                'paket_soal_id' => $paketId,
                'waktu_mulai'   => Carbon::now()->subMinutes($aktivitas->durasi_menit),
                'waktu_selesai' => Carbon::now(),
                'skor_akhir'    => 0
            ]);
        }

        // 3. KOREKSI NILAI
$skor = 0;
        $detailJawaban = []; 

        foreach ($jawabanSiswa as $item) {
            $soal = ButirSoal::find($item['soal_id']);
            if (!$soal) continue;

            $inputJawaban = $item['jawaban'] ?? null;
            $benar = ($inputJawaban == $soal->kunci_jawaban);
            if ($benar) $skor++;

            JawabanSiswa::updateOrCreate(
                ['hasil_pengerjaan_id' => $hasil->id, 'butir_soal_id' => $soal->id],
                ['jawaban' => $inputJawaban, 'benar' => $benar]
            );

            // Tentukan teks soal untuk dikirim ke frontend
            $textSoal = is_array($soal->pertanyaan) ? ($soal->pertanyaan['text'] ?? '') : $soal->pertanyaan;

            $detailJawaban[] = [
                'soal_id'    => $soal->id,
                'pertanyaan' => $textSoal, // BARU: Tambahkan ini agar tidak "Soal Gambar" terus
                'benar'      => $benar,
                'jawaban'    => $inputJawaban,
                'kunci'      => $soal->kunci_jawaban
            ];
        }

        $nilaiAkhir = ($totalSoalReal > 0) ? round(($skor / $totalSoalReal) * 100) : 0;
        $hasil->skor_akhir = $nilaiAkhir;
        $hasil->save();

        return response()->json([
            'status'       => 'ok',
            'hasil_id'     => $hasil->id,
            'skor'         => $nilaiAkhir,
            'total_soal'   => $totalSoalReal, // BARU: Kirim ke JS agar tidak NaN
            'jumlah_benar' => $skor,          // BARU: Kirim ke JS agar tidak NaN
            'detail'       => $detailJawaban
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