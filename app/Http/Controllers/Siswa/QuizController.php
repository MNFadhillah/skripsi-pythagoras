<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AktivitasBelajar; // Ganti PaketSoal jadi Aktivitas
use App\Models\HasilPengerjaan;
use App\Models\ButirSoal;
use App\Models\JawabanSiswa;
use App\Models\User;
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

        $user = Auth::user();

        // CEK AKSES KELAS
        if ($user->kelas_id != $aktivitas->kelas_id) {
            return redirect()->route('siswa.menu.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke aktivitas ini.');
        }

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

        if ($user->kelas_id != $aktivitas->kelas_id) {
            return response()->json([
                'error' => 'Anda tidak memiliki akses ke aktivitas ini.'
            ], 403);
        }

        if (!$aktivitas->is_currently_active) {
            $jenisText = $aktivitas->kategori === 'evaluasi' ? 'Evaluasi' : 'Kuis';

            return response()->json([
                'error' => "Maaf, $jenisText ini belum dibuka oleh guru atau batas waktu pengerjaannya telah habis."
            ], 403);
        }

        $paket = $aktivitas->paket_soal;

        if (!$paket) {
            return response()->json([
                'error' => 'Paket soal tidak ditemukan'
            ], 404);
        }

        if ($aktivitas->kategori === 'evaluasi') {
            $sudahSelesai = HasilPengerjaan::where('user_id', $user->id)
                ->where('paket_soal_id', $paket->id)
                ->whereNotNull('waktu_selesai')
                ->exists();

            if ($sudahSelesai) {
                return response()->json([
                    'error' => 'Anda sudah mengerjakan Evaluasi Akhir ini. Evaluasi hanya dapat dikerjakan satu kali.'
                ], 403);
            }
        }

        return response()->json([
            'id_aktivitas' => $aktivitas->id,
            'id_paket' => $paket->id,
            'judul' => $aktivitas->judul,
            'durasi_menit' => $aktivitas->durasi_menit,
            'jumlah_soal' => $paket->butir_soal->count(),
        ]);
    }


    public function start($aktivitasId)
    {
        $aktivitas = AktivitasBelajar::with('paket_soal.butir_soal')->findOrFail($aktivitasId);
        $user = Auth::user();
        $now = Carbon::now();

        if ($user->kelas_id != $aktivitas->kelas_id) {
            return response()->json([
                'error' => 'Anda tidak memiliki akses ke aktivitas ini.'
            ], 403);
        }

        if (!$aktivitas->is_currently_active) {
            $jenisText = $aktivitas->kategori === 'evaluasi' ? 'Evaluasi' : 'Kuis';

            return response()->json([
                'error' => "Maaf, $jenisText ini belum dibuka oleh guru atau batas waktunya telah habis."
            ], 403);
        }

        $paket = $aktivitas->paket_soal;

        if (!$paket) {
            return response()->json([
                'error' => 'Paket soal tidak ditemukan.'
            ], 404);
        }

        if ($aktivitas->kategori === 'evaluasi') {
            $sudahSelesai = HasilPengerjaan::where('user_id', $user->id)
                ->where('paket_soal_id', $paket->id)
                ->whereNotNull('waktu_selesai')
                ->exists();

            if ($sudahSelesai) {
                return response()->json([
                    'error' => 'Evaluasi hanya dapat dikerjakan satu kali.'
                ], 403);
            }
        }

        $pengerjaanAktif = HasilPengerjaan::where('user_id', $user->id)
            ->where('paket_soal_id', $paket->id)
            ->whereNull('waktu_selesai')
            ->latest()
            ->first();

        if ($pengerjaanAktif) {
            $waktuMulai = Carbon::parse($pengerjaanAktif->waktu_mulai);
            $batasWaktu = $waktuMulai->copy()->addMinutes((int) $aktivitas->durasi_menit);

            if ($now->greaterThanOrEqualTo($batasWaktu)) {
                $pengerjaanAktif->update([
                    'waktu_selesai' => $batasWaktu,
                    'skor_akhir' => 0,
                    'terindikasi_curang' => true,
                ]);

                if ($aktivitas->kategori === 'evaluasi') {
                    return response()->json([
                        'error' => 'Waktu evaluasi Anda sudah habis. Evaluasi otomatis diselesaikan.'
                    ], 403);
                }

                $pengerjaanAktif = null;
            }
        }

        if (!$pengerjaanAktif) {
            $pengerjaanAktif = HasilPengerjaan::create([
                'user_id' => $user->id,
                'paket_soal_id' => $paket->id,
                'waktu_mulai' => $now,
                'waktu_selesai' => null,
                'skor_akhir' => 0,
                'pelanggaran_count' => 0,
                'pelanggaran_logs' => [],
                'terindikasi_curang' => false,
            ]);
        }

        $waktuMulai = Carbon::parse($pengerjaanAktif->waktu_mulai);
        $batasWaktu = $waktuMulai->copy()->addMinutes((int) $aktivitas->durasi_menit);
        $sisaDetik = max(0, $now->diffInSeconds($batasWaktu, false));

        return response()->json([
            'status' => 'ok',
            'durasi_menit' => $aktivitas->durasi_menit,
            'sisa_detik' => (int) $sisaDetik,
            'soal' => $paket->butir_soal->map(function ($s) {
                return [
                    'id' => $s->id,
                    'text' => is_array($s->pertanyaan) ? ($s->pertanyaan['text'] ?? '') : $s->pertanyaan,
                    'image' => is_array($s->pertanyaan) ? ($s->pertanyaan['image'] ?? null) : null,
                    'options' => $s->opsi_jawaban,
                ];
            })->values(),
        ]);
    }

    public function violation(Request $request)
    {
        $request->validate([
            'aktivitas_id' => 'required|exists:aktivitas_belajar,id',
            'jenis' => 'required|string|max:100',
            'detail' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $aktivitas = AktivitasBelajar::findOrFail($request->aktivitas_id);

        if ($user->kelas_id != $aktivitas->kelas_id) {
            return response()->json([
                'error' => 'Tidak memiliki akses.'
            ], 403);
        }

        $hasil = HasilPengerjaan::where('user_id', $user->id)
            ->where('paket_soal_id', $aktivitas->paket_soal_id)
            ->whereNull('waktu_selesai')
            ->latest()
            ->first();

        if (!$hasil) {
            return response()->json([
                'status' => 'no_active_session'
            ]);
        }

        $logs = $hasil->pelanggaran_logs ?? [];

        if (!is_array($logs)) {
            $logs = [];
        }

        $logs[] = [
            'jenis' => $request->jenis,
            'detail' => $request->detail,
            'waktu' => now()->toDateTimeString(),
            'ip' => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? '', 0, 200),
        ];

        $batasPelanggaran = 3;

        $hasil->pelanggaran_logs = $logs;
        $hasil->pelanggaran_count = count($logs);

        if ($hasil->pelanggaran_count >= $batasPelanggaran) {
            $hasil->terindikasi_curang = true;
        }

        $hasil->save();

        return response()->json([
            'status' => 'ok',
            'pelanggaran_count' => $hasil->pelanggaran_count,
            'batas_pelanggaran' => $batasPelanggaran,
            'terindikasi_curang' => $hasil->terindikasi_curang,
            'lapor_guru' => $hasil->terindikasi_curang,
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'aktivitas_id' => 'required|exists:aktivitas_belajar,id',
            'jawaban' => 'required|array',
            'jawaban.*.soal_id' => 'required|exists:butir_soal,id',
        ]);

        $user = Auth::user();
        $aktivitasId = $request->aktivitas_id;
        $jawabanSiswa = $request->jawaban;

        $aktivitas = AktivitasBelajar::findOrFail($aktivitasId);

        if ($user->kelas_id != $aktivitas->kelas_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke aktivitas ini.'
            ], 403);
        }

        $paketId = $aktivitas->paket_soal_id;
        $totalSoalReal = ButirSoal::where('paket_soal_id', $paketId)->count();

        $riwayatSebelumnya = HasilPengerjaan::where('user_id', $user->id)
            ->where('paket_soal_id', $paketId)
            ->whereNotNull('waktu_selesai')
            ->orderBy('created_at', 'asc')
            ->get();

        $jumlahPercobaan = $riwayatSebelumnya->count();
        $nilaiPertama = $jumlahPercobaan > 0 ? $riwayatSebelumnya->first()->skor_akhir : null;

        $hasil = HasilPengerjaan::where('user_id', $user->id)
            ->where('paket_soal_id', $paketId)
            ->whereNull('waktu_selesai')
            ->latest()
            ->first();

        if (!$hasil) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi pengerjaan tidak ditemukan atau sudah selesai.'
            ], 409);
        }

        $now = Carbon::now();
        $waktuMulaiServer = Carbon::parse($hasil->waktu_mulai);
        $batasWaktu = $waktuMulaiServer->copy()->addMinutes((int) $aktivitas->durasi_menit);

        if ($now->greaterThan($batasWaktu->copy()->addSeconds(10))) {
            $hasil->waktu_selesai = $batasWaktu;
            $hasil->skor_akhir = 0;
            $hasil->terindikasi_curang = true;
            $hasil->save();

            return response()->json([
                'status' => 'timeout',
                'hasil_id' => $hasil->id,
                'skor' => 0,
                'total_soal' => $totalSoalReal,
                'jumlah_benar' => 0,
                'detail' => [],
                'is_passed' => false,
                'remedial_url' => route('siswa.kuis.show', $aktivitas->id),
                'materi_url' => $this->getMateriUrlByKategori($aktivitas->kategori),
                'next_url' => $this->getMateriUrlByKategori($aktivitas->kategori),
                'poin_diberikan' => false,
                'poin_didapat' => 0,
                'message' => 'Waktu pengerjaan sudah habis.'
            ]);
        }

        $hasil->waktu_selesai = $now;

        $skor = 0;
        $detailJawaban = [];
        $snapshotArray = [];

        foreach ($jawabanSiswa as $item) {
            $soal = ButirSoal::where('id', $item['soal_id'])
                ->where('paket_soal_id', $paketId)
                ->first();

            if (!$soal) {
                continue;
            }

            $inputJawaban = $item['jawaban'] ?? null;
            $benar = ($inputJawaban == $soal->kunci_jawaban);

            if ($benar) {
                $skor++;
            }

            JawabanSiswa::updateOrCreate(
                [
                    'hasil_pengerjaan_id' => $hasil->id,
                    'butir_soal_id' => $soal->id
                ],
                [
                    'jawaban' => $inputJawaban,
                    'benar' => $benar
                ]
            );

            $textSoal = is_array($soal->pertanyaan)
                ? ($soal->pertanyaan['text'] ?? '')
                : $soal->pertanyaan;

            $gambarSoal = is_array($soal->pertanyaan)
                ? ($soal->pertanyaan['image'] ?? null)
                : null;

            $detailJawaban[] = [
                'soal_id' => $soal->id,
                'pertanyaan' => $textSoal,
                'benar' => $benar,
                'jawaban' => $inputJawaban,
                'kunci' => $soal->kunci_jawaban
            ];

            $snapshotArray[] = [
                'soal_id' => $soal->id,
                'pertanyaan' => $textSoal,
                'gambar' => $gambarSoal,
                'opsi_jawaban' => $soal->opsi_jawaban,
                'kunci_jawaban' => $soal->kunci_jawaban,
                'jawaban_siswa' => $inputJawaban,
                'is_benar' => $benar
            ];
        }

        $nilaiAkhir = ($totalSoalReal > 0)
            ? round(($skor / $totalSoalReal) * 100)
            : 0;

        $finalNilai = $nilaiAkhir;

        if ($jumlahPercobaan > 0 && $nilaiPertama < 70) {
            if ($finalNilai >= 70) {
                $finalNilai = 70;
            }
        }

        $isPassed = $finalNilai >= 70;

        $pernahLulus = $riwayatSebelumnya->contains(function ($riwayat) {
            return $riwayat->skor_akhir >= 70;
        });

        $hasil->skor_akhir = $finalNilai;
        $hasil->snapshot_jawaban = $snapshotArray;
        $hasil->save();

        $poinDiberikan = false;

        if ($isPassed && !$pernahLulus) {
            User::where('id', $user->id)->increment('points', $aktivitas->poin_didapat);
            $poinDiberikan = true;
        }

        $remedialUrl = route('siswa.kuis.show', $aktivitas->id);
        $materiUrl = $this->getMateriUrlByKategori($aktivitas->kategori);
        $nextUrl = $isPassed
            ? $this->getNextMateriUrl($aktivitas->kategori)
            : $remedialUrl;

        return response()->json([
            'status' => 'ok',
            'hasil_id' => $hasil->id,
            'skor' => $finalNilai,
            'total_soal' => $totalSoalReal,
            'jumlah_benar' => $skor,
            'detail' => $detailJawaban,
            'is_passed' => $isPassed,
            'remedial_url' => $remedialUrl,
            'materi_url' => $materiUrl,
            'next_url' => $nextUrl,
            'poin_diberikan' => $poinDiberikan,
            'poin_didapat' => $aktivitas->poin_didapat,
            'pelanggaran_count' => $hasil->pelanggaran_count ?? 0,
            'terindikasi_curang' => $hasil->terindikasi_curang ?? false,
        ]);
    }



    private function getMateriUrlByKategori($kategori)
    {
        switch ($kategori) {
            case 'konsep':
                return route('siswa.konsep.materi');
            case 'tripel':
                return route('siswa.tripel.materi');
            case 'istimewa':
                return route('siswa.istimewa.materi');
            case 'penerapan':
                return route('siswa.penerapan.materi');
            default:
                return route('siswa.menu.dashboard');
        }
    }

    private function getNextMateriUrl($kategori)
    {
        switch ($kategori) {
            case 'konsep':
                return route('siswa.tripel.materi');
            case 'tripel':
                return route('siswa.istimewa.materi');
            case 'istimewa':
                return route('siswa.penerapan.materi');
            case 'penerapan':
                return route('siswa.menu.dashboard'); // atau evaluasi
            default:
                return route('siswa.menu.dashboard');
        }
    }
    /**
     * Menampilkan Halaman Hasil (Review)
     */
    public function showResult($hasilId)
    {
        $hasil = HasilPengerjaan::with(['jawabanSiswa.butirSoal', 'paketSoal'])
            ->findOrFail($hasilId);

        if ($hasil->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat hasil ini.');
        }

        return view('siswa.hasil_kuis', compact('hasil'));
    }

    /**
     * API untuk Mendapatkan Detail Hasil (Opsional jika dibutuhkan JS)
     */
    public function getResultDetail($hasilId)
    {
        $hasil = HasilPengerjaan::with(['jawabanSiswa.butirSoal'])
            ->findOrFail($hasilId);

        if ($hasil->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses detail hasil ini.');
        }

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
        } else {
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
