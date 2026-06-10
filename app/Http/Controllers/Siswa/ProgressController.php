<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\progres_siswa;
use App\Models\Badge;
use App\Models\PaketSoal;
use App\Models\HasilPengerjaan;
use App\Traits\ProgresTrait;

class ProgressController extends Controller
{
    use ProgresTrait;
    /**
     * Menyimpan progres checkpoint siswa
     */
public function store(Request $request)
{
    $user = User::find(Auth::id());

    $materi_id = $request->materi_id;
    $checkpoint_code = $request->checkpoint_code;

    // Ambil poin dari request
    $earnedPoints = (int) $request->input('points', 0);

    // 1. Simpan progres jika belum pernah diselesaikan
    $progress = progres_siswa::firstOrCreate(
        [
            'user_id'         => $user->id,
            'materi_id'       => $materi_id,
            'checkpoint_code' => $checkpoint_code,
        ],
        [
            'is_completed' => 1,
        ]
    );

    // Poin yang benar-benar didapatkan
    $actualPointsEarned = 0;

    // 2. Tambahkan poin hanya jika checkpoint baru dibuat
    if ($progress->wasRecentlyCreated && $earnedPoints > 0) {
        $actualPointsEarned = $earnedPoints;

        $user->increment('points', $actualPointsEarned);
        $user->refresh();
    }

    // 3. Hitung total progres keseluruhan
    $totalProgress = $this->hitungTotalProgress($user->id);

    // 4. Cek badge berdasarkan total poin
    $badgeResult = $this->checkAndAwardCompletionBadge($user->id);

    // 5. Refresh ulang data user agar total poin terbaru terbaca
    $user->refresh();

    return response()->json([
        'success'             => true,
        'progress_percentage' => $totalProgress,
        'total_points'        => $user->points ?? 0,

        // ini poin yang benar-benar diperoleh pada request ini
        'points_earned'       => $actualPointsEarned,

        // ini hasil badge berdasarkan poin
        'badge_earned'        => $badgeResult['badge_earned'],
        'badge_data'          => $badgeResult['badge_data'],
    ]);
}

    /**
     * Mengambil data detail progres siswa untuk modal
     */
    public function getDetail()
    {
        $user = Auth::user();
        $userId = $user->id;

        // ===== 1. Hitung progres materi 1–4 =====
        // Definisikan jumlah checkpoint per materi (sesuaikan dengan data sebenarnya)

        $totalCheckpoint = $this->getConfigCheckpoint();

        $persenMateri = [];
        foreach ($totalCheckpoint as $materiId => $total) {
            $selesai = progres_siswa::where('user_id', $userId)
                ->where('materi_id', $materiId)
                ->count();
            $persen = ($total > 0) ? round(($selesai / $total) * 100) : 0;
            $persen = min($persen, 100); // maksimal 100%
            $persenMateri[$materiId] = $persen;
        }

        // ===== 2. Hitung status kuis (Kuis 1–4 & Evaluasi) =====
        $progKuis = [
            'kuis1' => 0,
            'kuis2' => 0,
            'kuis3' => 0,
            'kuis4' => 0,
            'eval'  => 0,
        ];

        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();
        foreach ($semuaPaket as $paket) {
            $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);
            $sudahMengerjakan = HasilPengerjaan::where('paket_soal_id', $paket->id)
                ->where('user_id', $userId)
                ->exists();

            if ($sudahMengerjakan) {
                if (str_contains($namaPaket, 'kuis 1')) {
                    $progKuis['kuis1'] = 100;
                } elseif (str_contains($namaPaket, 'kuis 2')) {
                    $progKuis['kuis2'] = 100;
                } elseif (str_contains($namaPaket, 'kuis 3')) {
                    $progKuis['kuis3'] = 100;
                } elseif (str_contains($namaPaket, 'kuis 4')) {
                    $progKuis['kuis4'] = 100;
                } elseif (str_contains($namaPaket, 'evaluasi')) {
                    $progKuis['eval'] = 100;
                }
            }
        }

        // ===== 3. Hitung total progres keseluruhan (rata-rata) =====
        $totalSemuaPersen = array_sum($persenMateri) + array_sum($progKuis);
        $jumlahKomponen = count($persenMateri) + count($progKuis); // 4 materi + 5 kuis = 9
        $totalProgressKeseluruhan = round($totalSemuaPersen / $jumlahKomponen);

        // ===== 4. Susun data untuk dikembalikan =====
        return response()->json([
            'nama'           => $user->name,
            'identitas'      => $user->email,
            'total_progress' => $totalProgressKeseluruhan,
            'materi' => [
                'm1' => [
                    'nama'   => 'Materi 1: Menemukan Konsep',
                    'persen' => $persenMateri['materi_1_konsep_pythagoras'],
                    'info'   => '',
                ],
                'm2' => [
                    'nama'   => 'Materi 2: Tripel Pythagoras',
                    'persen' => $persenMateri['materi_2_tripel_pythagoras'],
                    'info'   => '',
                ],
                'm3' => [
                    'nama'   => 'Materi 3: Segitiga Istimewa',
                    'persen' => $persenMateri['materi_3_segitiga_istimewa'],
                    'info'   => '',
                ],
                'm4' => [
                    'nama'   => 'Materi 4: Penerapan Teorema Pythagoras',
                    'persen' => $persenMateri['materi_4_penerapan_pythagoras'],
                    'info'   => '',
                ],
            ],
            'kuis' => [
                'k1' => [
                    'nama'   => 'Kuis 1: Konsep Pythagoras',
                    'persen' => $progKuis['kuis1'],
                ],
                'k2' => [
                    'nama'   => 'Kuis 2: Tripel Pythagoras',
                    'persen' => $progKuis['kuis2'],
                ],
                'k3' => [
                    'nama'   => 'Kuis 3: Segitiga Istimewa',
                    'persen' => $progKuis['kuis3'],
                ],
                'k4' => [
                    'nama'   => 'Kuis 4: Penerapan Pythagoras',
                    'persen' => $progKuis['kuis4'],
                ],
                'eval' => [
                    'nama'   => 'Evaluasi Akhir',
                    'persen' => $progKuis['eval'],
                ],
            ],
        ]);
    }
}
