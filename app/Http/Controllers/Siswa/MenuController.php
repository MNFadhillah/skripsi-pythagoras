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

class MenuController extends Controller
{
public function dashboard()
    {
        // --- BAGIAN 1: Ambil Data Aktivitas (Kode Lama) ---
        $aktivitas = AktivitasBelajar::where('status', 1)->orderBy('id', 'asc')->get();


        // --- BAGIAN 2: Hitung Rata-rata (Salinan dari fungsi nilai_siswa) ---
        $userId = Auth::id();
        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();
        
        $totalSkor = 0;
        $jumlahPaketDiambil = 0;

        foreach ($semuaPaket as $paket) {
            // Ambil nilai tertinggi user untuk paket ini
            $bestScoreRaw = HasilPengerjaan::where('paket_soal_id', $paket->id)
                                            ->where('user_id', $userId)
                                            ->max('skor_akhir');

            // Jika user sudah pernah mengerjakan (nilainya tidak null)
            if ($bestScoreRaw !== null) {
                $totalSkor += $bestScoreRaw; 
                $jumlahPaketDiambil++;
            }
        }

        // Hitung rumus rata-rata
        $rataRata = $jumlahPaketDiambil > 0 ? round($totalSkor / $jumlahPaketDiambil, 2) : 0;


        // --- BAGIAN 3: Kirim ke View ---
        // Tambahkan 'rataRata' ke dalam compact
        return view('siswa.menu.dashboard', compact('aktivitas', 'rataRata'));
    }

public function leaderboard()
{
    // 1. Ambil semua siswa + relasi kelas
    $semuaSiswa = User::where('role', 'siswa')
                        ->with('kelas')
                        ->get();

    $semuaPaket = PaketSoal::all();

    $leaderboardData = [];

    foreach ($semuaSiswa as $siswa) {

        $totalNilai = 0;
        $jumlahPaketDikerjakan = 0;

        // 2. Ambil nilai terbaik per paket
        foreach ($semuaPaket as $paket) {

            $maxScore = HasilPengerjaan::where('user_id', $siswa->id)
                                        ->where('paket_soal_id', $paket->id)
                                        ->max('skor_akhir');

            if ($maxScore !== null) {
                $totalNilai += $maxScore;
                $jumlahPaketDikerjakan++;
            }
        }

        // 3. Hitung rata-rata
        $rataRata = $jumlahPaketDikerjakan > 0
            ? $totalNilai / $jumlahPaketDikerjakan
            : 0;

        $leaderboardData[] = [
            'id' => $siswa->id,
            'nama' => $siswa->name,
            'kelas' => $siswa->kelas ? $siswa->kelas->nama_kelas : 'Belum Masuk Kelas',
            'total_nilai' => $totalNilai,
            'jumlah_paket' => $jumlahPaketDikerjakan,
            'rata_rata' => round($rataRata, 2),
        ];
    }

    // 4. Urutkan berdasarkan rata-rata tertinggi
    $leaderboardSorted = collect($leaderboardData)
                            ->sortByDesc('rata_rata')
                            ->values();

    return view('siswa.menu.leaderboard', compact('leaderboardSorted'));
}

public function nilai_siswa()
{
    $userId = Auth::id(); // Ambil ID user yang sedang login (misal: 3 untuk fadhil)

    // 1. Ambil Riwayat (PERBAIKAN: Tambahkan where user_id)
    $riwayat = HasilPengerjaan::with('paketSoal')
                    ->where('user_id', $userId) // <--- PENTING: Filter punya user saja
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
        // PERBAIKAN: Tambahkan where user_id agar max score yang diambil adalah milik user login
        $bestScoreRaw = HasilPengerjaan::where('paket_soal_id', $paket->id)
                            ->where('user_id', $userId) // <--- PENTING: Filter punya user saja
                            ->max('skor_akhir');

        // LOGIC UBAH SKOR
        // Jika user belum mengerjakan ($bestScoreRaw null), biarkan null
        $finalScore = $bestScoreRaw !== null ? ($bestScoreRaw) : null;

        $rekapNilai[] = [
            'nama_paket' => $paket->nama_paket ?? $paket->judul,
            'nilai' => $finalScore !== null ? $finalScore : '-' // Tampilkan '-' jika belum ada nilai
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
        $user->save();

        return redirect()->back()->with('success', 'Berhasil bergabung ke kelas ' . $kelas->nama_kelas);
    }
}
