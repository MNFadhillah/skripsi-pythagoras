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
        // Kita panggil fungsi getDetail() dari ProgressController
        // Agar angka di Dashboard SAMA PERSIS dengan di Profil dan Modal!
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

            // Fallback jika progress gagal diambil
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

        $lastBadgeName = $latestBadge ? $latestBadge->name : 'Belum ada lencana';

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
        $userId = Auth::id(); // Ambil ID user yang sedang login

        // 1. Ambil Riwayat
        $riwayat = HasilPengerjaan::with('paketSoal')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Logika Rangkuman (Nilai Tertinggi per Paket)
        $semuaPaket = PaketSoal::all()->sortBy(function ($paket) {
            if (str_contains(strtolower($paket->nama_paket ?? $paket->judul), 'kuis 1')) return 1;
            if (str_contains(strtolower($paket->nama_paket ?? $paket->judul), 'kuis 2')) return 2;
            if (str_contains(strtolower($paket->nama_paket ?? $paket->judul), 'kuis 3')) return 3;
            if (str_contains(strtolower($paket->nama_paket ?? $paket->judul), 'kuis 4')) return 4;
            if (str_contains(strtolower($paket->nama_paket ?? $paket->judul), 'evaluasi')) return 5;
            return 99; // selain itu di paling bawah
        });

        $rekapNilai = [];
        $totalSkor = 0;
        $jumlahPaketDiambil = 0;

        foreach ($semuaPaket as $paket) {
            // Ambil SEMUA riwayat pengerjaan user untuk paket ini, urutkan dari yang PERTAMA (paling lama)
            $riwayatPaket = HasilPengerjaan::where('paket_soal_id', $paket->id)
                ->where('user_id', $userId)
                ->whereNotNull('waktu_selesai')
                ->orderBy('created_at', 'asc') // Urutan waktu sangat penting!
                ->get();

            $finalScore = null;

            if ($riwayatPaket->count() > 0) {
                $kkm = 70; // Tentukan nilai KKM Anda

                // Ambil skor percobaan PERTAMA KALI
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

            $rekapNilai[] = [
                'nama_paket' => $paket->nama_paket ?? $paket->judul,
                'nilai' => $finalScore !== null ? $finalScore : '-'
            ];

            if ($finalScore !== null) {
                $totalSkor += $finalScore;
                $jumlahPaketDiambil++;
            }
        }

        // Hitung Rata-rata
        $rataRata = $jumlahPaketDiambil > 0 ? round($totalSkor / $jumlahPaketDiambil, 2) : 0;

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
