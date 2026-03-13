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
        
        // Cek apakah siswa sudah pernah menyelesaikan kuis ini
        $riwayatSelesai = HasilPengerjaan::where('user_id', Auth::id())
                            ->where('paket_soal_id', $aktivitas->paket_soal_id)
                            ->whereNotNull('waktu_selesai')
                            ->orderBy('created_at', 'asc')
                            ->get();
                            
        $jumlahPercobaan = $riwayatSelesai->count();
        $nilaiPertama = $jumlahPercobaan > 0 ? $riwayatSelesai->first()->skor_akhir : null;

        return view('siswa.templatekuis', [
            'aktivitas'       => $aktivitas,
            'paket'           => $aktivitas->paket_soal,
            'materiSekarang'  => $aktivitas->judul,
            'nextMateriUrl'   => route('siswa.tripel.materi'),
            'backMateriUrl'   => route('siswa.konsep.materi'),
            'isEvaluasi'      => $aktivitas->kategori === 'evaluasi',
            'statusAktivitas' => [
                'status'        => $aktivitas->status,
                'waktu_mulai'   => $aktivitas->waktu_mulai,
                'waktu_selesai' => $aktivitas->waktu_selesai,
            ],
            // Kirim variabel ini ke view
            'jumlahPercobaan' => $jumlahPercobaan,
            'nilaiPertama'    => $nilaiPertama,
            'kkm'             => 70
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

        // 1. Validasi standar (status dan evaluasi)
        if (!$aktivitas->is_currently_active) {
            $jenisText = ($aktivitas->kategori === 'evaluasi') ? 'Evaluasi' : 'Kuis';
            return response()->json([
                'error' => "Maaf, $jenisText ini belum dibuka oleh guru atau batas waktu pengerjaannya telah habis."
            ], 403);
        }
        
        $paket = $aktivitas->paket_soal;
        if (!$paket) {
            return response()->json(['error' => 'Paket soal tidak ditemukan'], 404);
        }

        if ($aktivitas->kategori === 'evaluasi') {
            $sudahSelesai = HasilPengerjaan::where('user_id', $user->id)
                                ->where('paket_soal_id', $paket->id)
                                ->whereNotNull('waktu_selesai')
                                ->exists();

            if ($sudahSelesai) {
                return response()->json(['error' => 'Anda sudah mengerjakan Evaluasi Akhir ini. Evaluasi hanya dapat dikerjakan satu kali.'], 403);
            }
        }

        // --- LOGIKA BARU: PENANGANAN SESI TERBENGKALAI & ANTI-CHEAT ---
        
        $pengerjaanAktif = HasilPengerjaan::where('user_id', $user->id)
                            ->where('paket_soal_id', $paket->id) 
                            ->whereNull('waktu_selesai')
                            ->first();

        $sisaDetik = $aktivitas->durasi_menit * 60; // Default sisa waktu

        if ($pengerjaanAktif) {
            // Hitung apakah waktu sebenarnya sudah habis sejak dia pertama kali klik "Mulai"
            $waktuMulaiDb = Carbon::parse($pengerjaanAktif->waktu_mulai);
            $batasWaktu = $waktuMulaiDb->copy()->addMinutes($aktivitas->durasi_menit);

            if ($now->greaterThanOrEqualTo($batasWaktu)) {
                // JIKA WAKTU HABIS SAAT DITINGGALKAN: Auto Submit Paksa (Nilai 0)
                $pengerjaanAktif->update([
                    'waktu_selesai' => $batasWaktu,
                    'skor_akhir' => 0
                ]);
                $pengerjaanAktif = null; // Reset variabel agar buat sesi baru (kecuali Evaluasi)

                // Jika ini evaluasi, dia sudah menyia-nyiakan satu-satunya kesempatan.
                if ($aktivitas->kategori === 'evaluasi') {
                    return response()->json(['error' => 'Waktu pengerjaan Evaluasi Anda telah habis saat Anda meninggalkan halaman. Status otomatis diselesaikan dengan nilai 0.'], 403);
                }
            } else {
                // JIKA WAKTU MASIH ADA: Lanjutkan, tapi potong sisa detiknya
                $sisaDetik = $now->diffInSeconds($batasWaktu);
            }
        }

        // Jika tidak ada sesi aktif (atau baru saja di-auto-close di atas), buat baru
        if (!$pengerjaanAktif) {
            HasilPengerjaan::create([
                'user_id'       => $user->id,
                'paket_soal_id' => $paket->id,
                'waktu_mulai'   => $now,
                'waktu_selesai' => null,
                'skor_akhir'    => 0
            ]);
            $sisaDetik = $aktivitas->durasi_menit * 60;
        }

        return response()->json([
            'id_aktivitas' => $aktivitas->id,
            'id_paket'     => $paket->id,
            'judul'        => $aktivitas->judul,
            'durasi_menit' => $aktivitas->durasi_menit,
            'sisa_detik'   => (int) $sisaDetik, // Kirim sisa waktu asli ke Javascript
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
            'aktivitas_id'         => 'required|exists:aktivitas_belajar,id',
            'jawaban'              => 'required|array',
            'jawaban.*.soal_id'    => 'required|exists:butir_soal,id',
            'waktu_mulai_aktual'   => 'required|date_format:Y-m-d H:i:s', 
            'waktu_selesai_aktual' => 'required|date_format:Y-m-d H:i:s', 
        ]);

        $user = Auth::user();
        $aktivitasId = $request->aktivitas_id;
        $jawabanSiswa = $request->jawaban;

        $aktivitas = AktivitasBelajar::findOrFail($aktivitasId);
        $paketId = $aktivitas->paket_soal_id;
        $totalSoalReal = ButirSoal::where('paket_soal_id', $paketId)->count();

        $waktuMulaiAktual = Carbon::parse($request->waktu_mulai_aktual);
        $waktuSelesaiAktual = Carbon::parse($request->waktu_selesai_aktual);

        // --- BAGIAN 3: CARI DATA PENGERJAAN ---
        // Pastikan kita HANYA mencari data yang 'waktu_selesai' masih NULL (sedang berjalan)
        $hasil = HasilPengerjaan::where('user_id', $user->id)
                    ->where('paket_soal_id', $paketId)
                    ->whereNull('waktu_selesai') // <--- TAMBAHKAN BARIS INI
                    ->latest()
                    ->first();

        if ($hasil) {
            $hasil->waktu_mulai = $waktuMulaiAktual; 
            $hasil->waktu_selesai = $waktuSelesaiAktual;
        } else {
            // Jika tidak ketemu (jarang terjadi tapi untuk jaga-jaga), buat baru
            $hasil = HasilPengerjaan::create([
                'user_id'       => $user->id,
                'paket_soal_id' => $paketId,
                'waktu_mulai'   => $waktuMulaiAktual,
                'waktu_selesai' => $waktuSelesaiAktual,
                'skor_akhir'    => 0
            ]);
        }

        // --- BAGIAN 4: LOGIKA SKOR & SNAPSHOT (Tetap sama) ---
        $skor = 0;
        $detailJawaban = []; 
        $snapshotArray = []; 

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

            $textSoal = is_array($soal->pertanyaan) ? ($soal->pertanyaan['text'] ?? '') : $soal->pertanyaan;
            $gambarSoal = is_array($soal->pertanyaan) ? ($soal->pertanyaan['image'] ?? null) : null;

            $detailJawaban[] = [
                'soal_id'    => $soal->id,
                'pertanyaan' => $textSoal, 
                'benar'      => $benar,
                'jawaban'    => $inputJawaban,
                'kunci'      => $soal->kunci_jawaban
            ];

            $snapshotArray[] = [
                'soal_id'       => $soal->id,
                'pertanyaan'    => $textSoal,
                'gambar'        => $gambarSoal,
                'opsi_jawaban'  => $soal->opsi_jawaban, 
                'kunci_jawaban' => $soal->kunci_jawaban,
                'jawaban_siswa' => $inputJawaban,
                'is_benar'      => $benar
            ];
        }

        $nilaiAkhir = ($totalSoalReal > 0) ? round(($skor / $totalSoalReal) * 100) : 0;
        
        $hasil->skor_akhir = $nilaiAkhir;
        $hasil->snapshot_jawaban = $snapshotArray; 
        $hasil->save();

        return response()->json([
            'status'       => 'ok',
            'hasil_id'     => $hasil->id,
            'skor'         => $nilaiAkhir,
            'total_soal'   => $totalSoalReal, 
            'jumlah_benar' => $skor,          
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
        
        $detail = [];

        // 🔥 CEK APAKAH ADA DATA SNAPSHOT
        if (!empty($hasil->snapshot_jawaban)) {
            // JIKA ADA: Gunakan data dari Snapshot JSON
            // Karena di Model sudah di-cast array, kita tinggal looping
            foreach ($hasil->snapshot_jawaban as $snap) {
                $detail[] = [
                    'soal_text'     => $snap['pertanyaan'] ?? '',
                    'gambar'        => $snap['gambar'] ?? null,
                    'jawaban_siswa' => $snap['jawaban_siswa'] ?? null,
                    'jawaban_benar' => $snap['kunci_jawaban'] ?? '',
                    'benar'         => $snap['is_benar'] ?? false,
                    'options'       => $snap['opsi_jawaban'] ?? []
                ];
            }
        } 
        else {
            // JIKA TIDAK ADA SNAPSHOT (Fallback untuk data lama sebelum fitur ini dibuat):
            // Gunakan cara lama, ambil langsung dari tabel ButirSoal yang mungkin sudah berubah
            $detail = $hasil->jawabanSiswa->map(function ($jawaban) {
                $text = is_array($jawaban->butirSoal->pertanyaan) 
                    ? ($jawaban->butirSoal->pertanyaan['text'] ?? '') 
                    : $jawaban->butirSoal->pertanyaan;

                $gambar = is_array($jawaban->butirSoal->pertanyaan) 
                    ? ($jawaban->butirSoal->pertanyaan['image'] ?? null) 
                    : null;

                return [
                    'soal_text'     => $text,
                    'gambar'        => $gambar,
                    'jawaban_siswa' => $jawaban->jawaban,
                    'jawaban_benar' => $jawaban->butirSoal->kunci_jawaban,
                    'benar'         => $jawaban->benar,
                    'options'       => $jawaban->butirSoal->opsi_jawaban
                ];
            })->toArray(); // Pastikan diubah jadi array agar format json respon-nya konsisten
        }
        
        return response()->json([
            'skor'       => $hasil->skor_akhir,
            'total_soal' => count($detail), // Hitung dari panjang array detail
            'detail'     => $detail
        ]);
    }
}