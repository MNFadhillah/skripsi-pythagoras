<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AktivitasBelajar;
use App\Models\HasilPengerjaan;
use App\Models\PaketSoal;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Badge;

// Panggil ProgressController agar kita bisa mencontek datanya!
use App\Http\Controllers\Siswa\ProgressController;

class MenuController extends Controller
{
    public function dashboard()
    {
        $user = User::find(Auth::id());
        $userId = $user->id;

        // --- BAGIAN 1: Ambil Data Aktivitas ---
        $aktivitas = AktivitasBelajar::where('status', 1)->orderBy('id', 'asc')->get();

        // --- BAGIAN 2: Hitung Rata-rata ---
        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();

        $totalSkor = 0;
        $jumlahPaketDiambil = 0;

        foreach ($semuaPaket as $paket) {
            $bestScoreRaw = HasilPengerjaan::where('paket_soal_id', $paket->id)
                ->where('user_id', $userId)
                ->max('skor_akhir');

            if ($bestScoreRaw !== null) {
                $totalSkor += $bestScoreRaw;
                $jumlahPaketDiambil++;
            }
        }

        $rataRata = $jumlahPaketDiambil > 0 ? round($totalSkor / $jumlahPaketDiambil, 2) : 0;

        // ========================================================
        // --- BAGIAN 3: SINKRONISASI PROGRESS MUTLAK 100% ---
        // ========================================================
        $progressCtrl = new ProgressController();

        try {
            $response = $progressCtrl->getDetail();
            $detailProgres = $response->getData();

            $totalProgressKeseluruhan = $detailProgres->total_progress ?? 0;
            $progMateri1 = $detailProgres->materi->m1->persen ?? 0;

            $progKuis1 = $detailProgres->kuis->k1->persen ?? 0;
            $progKuis2 = $detailProgres->kuis->k2->persen ?? 0;
            $progKuis3 = $detailProgres->kuis->k3->persen ?? 0;
            $progKuis4 = $detailProgres->kuis->k4->persen ?? 0;

            $progEval = $detailProgres->kuis->eval->persen ?? 0;
        } catch (\Exception $e) {
            $totalProgressKeseluruhan = 0;
            $progMateri1 = 0;
            $progKuis1 = 0;
            $progKuis2 = 0;
            $progKuis3 = 0;
            $progKuis4 = 0;
            $progEval = 0;
        }

        // --- LENCANA / BADGES BERDASARKAN POIN ---
        BadgeController::checkAndAwardBadgesByPoints($user);

        $user->refresh();
        $user->load('badges');

        $allBadges = Badge::orderBy('id', 'asc')->get();
        $totalBadgesCount = $allBadges->count();
        $earnedBadgeIds = $user->badges->pluck('id')->toArray();
        $earnedBadgesCount = count($earnedBadgeIds);

        $latestBadge = $user->badges()
            ->orderByDesc('badge_user.created_at')
            ->first();

        // Mengisi nama lencana terakhir
        $lastBadgeName = $latestBadge ? $latestBadge->name : 'Belum ada lencana';

        // DI SINI PERUBAHANNYA: Mengambil nama file gambar dari database, bukan lagi null
        $lastBadgeImagePath = $latestBadge ? $latestBadge->image_path : null;

        $userPoints = $user->points ?? 0;

        // --- BAGIAN 5: Kirim ke View ---
        return view('siswa.menu.dashboard', compact(
            'aktivitas',
            'rataRata',
            'progMateri1',
            'totalProgressKeseluruhan',
            'totalBadgesCount',
            'earnedBadgesCount',
            'lastBadgeName',
            'lastBadgeImagePath', // Sekarang variabel ini sudah membawa string nama file gambar
            'allBadges',
            'earnedBadgeIds',
            'progKuis1',
            'progKuis2',
            'progKuis3',
            'progKuis4',
            'progEval',
            'userPoints'
        ));
    }

    public function leaderboard()
    {
        $user = Auth::user();
        // Jika siswa belum masuk kelas, leaderboard dikosongkan
        if (!$user->kelas_id) {
            $leaderboardSorted = collect();
            $kelasAktif = 'Belum Masuk Kelas';
            return view('siswa.menu.leaderboard', compact(
                'leaderboardSorted',
                'kelasAktif'
            ));
        }
        $kelasAktif = $user->kelas ? $user->kelas->nama_kelas : 'Kelas Tidak Diketahui';
        // Ambil hanya siswa yang berada di kelas yang sama dengan siswa login
        $semuaSiswa = User::where('role', 'siswa')
            ->where('kelas_id', $user->kelas_id)
            ->with('kelas')
            ->get();

        $leaderboardData = [];

        foreach ($semuaSiswa as $siswa) {
            $leaderboardData[] = [
                'id' => $siswa->id,
                'nama' => $siswa->name,
                'kelas' => $siswa->kelas ? $siswa->kelas->nama_kelas : 'Belum Masuk Kelas',
                'poin' => $siswa->points ?? 0,
                'avatar' => $siswa->avatar,
            ];
        }

        $leaderboardSorted = collect($leaderboardData)
            ->sortByDesc('poin')
            ->values();

        return view('siswa.menu.leaderboard', compact(
            'leaderboardSorted',
            'kelasAktif'
        ));
    }

    public function nilai_siswa()
    {
        $userId = Auth::id();

        // Ambil semua riwayat pengerjaan siswa
        $riwayat = HasilPengerjaan::with('paketSoal')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Daftar kategori tetap untuk halaman nilai
        $kategoriPaket = [
            'kuis_1' => [
                'label' => 'Kuis 1',
                'keyword' => 'kuis 1',
            ],
            'kuis_2' => [
                'label' => 'Kuis 2',
                'keyword' => 'kuis 2',
            ],
            'kuis_3' => [
                'label' => 'Kuis 3',
                'keyword' => 'kuis 3',
            ],
            'kuis_4' => [
                'label' => 'Kuis 4',
                'keyword' => 'kuis 4',
            ],
            'evaluasi' => [
                'label' => 'Evaluasi',
                'keyword' => 'evaluasi',
            ],
        ];

        $semuaPaket = PaketSoal::all();

        $rekapNilai = [];
        $totalSkor = 0;
        $jumlahPaketDiambil = 0;
        $kkm = 70;

        foreach ($kategoriPaket as $key => $kategori) {
            // Cari paket soal berdasarkan keyword judul
            $paketIds = $semuaPaket
                ->filter(function ($paket) use ($kategori) {
                    $judul = strtolower($paket->nama_paket ?? $paket->judul ?? '');

                    return str_contains($judul, $kategori['keyword']);
                })
                ->pluck('id')
                ->values()
                ->toArray();

            // Ambil riwayat pengerjaan siswa untuk kategori ini
            $riwayatPaket = $riwayat
                ->filter(function ($item) use ($paketIds) {
                    return in_array((int) $item->paket_soal_id, array_map('intval', $paketIds))
                        && !is_null($item->waktu_selesai);
                })
                ->sortBy('created_at')
                ->values();

            $finalScore = null;

            if ($riwayatPaket->count() > 0) {
                $skorPertama = $riwayatPaket->first()->skor_akhir;

                if ($skorPertama >= $kkm) {
                    $finalScore = $skorPertama;
                } else {
                    $skorTertinggi = $riwayatPaket->max('skor_akhir');

                    if ($skorTertinggi >= $kkm) {
                        $finalScore = $kkm;
                    } else {
                        $finalScore = $skorTertinggi;
                    }
                }
            }

            $rekapNilai[$key] = [
                'label' => $kategori['label'],
                'keyword' => $kategori['keyword'],
                'paket_ids' => $paketIds,
                'nilai' => $finalScore !== null ? $finalScore : '-',
            ];

            if ($finalScore !== null) {
                $totalSkor += $finalScore;
                $jumlahPaketDiambil++;
            }
        }

        $rataRata = $jumlahPaketDiambil > 0
            ? round($totalSkor / $jumlahPaketDiambil, 2)
            : 0;

        return view('siswa.menu.nilai_siswa', compact('riwayat', 'rekapNilai', 'rataRata'));
    }

    public function petunjuk()
    {
        return view('siswa.menu.petunjuk');
    }

    public function gabungKelas(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // 1. Cari kelas berdasarkan token
        $kelas = Kelas::where('token', $request->token)->first();

        // 2. Jika kelas tidak ditemukan
        if (!$kelas) {
            return redirect()->back()->with('error', 'Token salah! Kelas tidak ditemukan.');
        }

        // 3. Update data user (siswa) agar masuk ke kelas tersebut
        $user = User::find(Auth::id());
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $user->kelas_id = $kelas->id;
        $user->save();

        return redirect()->back()->with('success', 'Berhasil bergabung ke kelas ' . $kelas->nama_kelas);
    }
}
