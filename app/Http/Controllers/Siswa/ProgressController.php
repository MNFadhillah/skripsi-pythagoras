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

class ProgressController extends Controller
{
    /**
     * Menyimpan progres checkpoint siswa
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        $materi_id = $request->materi_id;
        $checkpoint_code = $request->checkpoint_code;
        // Ambil data points dari request (default 0 jika tidak ada)
        $earnedPoints = $request->input('points', 0);

        // 1. Simpan progres ke database (jika belum ada)
        $progress = progres_siswa::firstOrCreate(
            [
                'user_id'         => $user->id,
                'materi_id'       => $materi_id,
                'checkpoint_code' => $checkpoint_code
            ],
            ['is_completed' => 1]
        );

        // --- TAMBAHAN LOGIKA POIN ---
        // Kita cek apakah progress ini BARU saja dibuat (artinya siswa baru pertama kali menyelesaikan)
        // Jika wasRecentlyCreated bernilai true, maka poin ditambahkan.
        // Jika false (siswa sudah pernah mengerjakannya), poin tidak ditambah lagi (mencegah farming poin).
        if ($progress->wasRecentlyCreated && $earnedPoints > 0) {
            $user->points += $earnedPoints;
            $user->save();
        }
        // ----------------------------

        // 2. Hitung total progres keseluruhan (materi + kuis)
        $totalProgress = $this->hitungTotalProgress($user->id);

        // 3. Logika pemberian lencana (contoh untuk materi 1)
        $badgeEarned = false;
        $badgeData = null;

        if ($totalProgress == 100 && str_contains($materi_id, 'materi_1_konsep')) {
            $badgeId = 1; 
            if (!$user->badges()->where('badge_id', $badgeId)->exists()) {
                $user->badges()->attach($badgeId);
                $badge = Badge::find($badgeId);
                $badgeEarned = true;
                $badgeData = [
                    'name'  => $badge->name,
                    'image' => asset('images/badges/' . $badge->image_path)
                ];
            }
        }

        // 4. Kembalikan respons, sertakan total_points terbaru
        return response()->json([
            'success'             => true,
            'progress_percentage' => $totalProgress,
            'total_points'        => $user->points, // Mengirim total poin terbaru ke frontend
            'badge_earned'        => $badgeEarned,
            'badge_data'          => $badgeData
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

    /**
     * Helper untuk menghitung total progres keseluruhan (materi + kuis)
     */
    private function hitungTotalProgress($userId)
    {
        // Total checkpoint per materi
        // Ganti array manual dengan ini:
        $totalCheckpoint = $this->getConfigCheckpoint();

        // Hitung persentase materi
        $totalMateriPersen = 0;
        foreach ($totalCheckpoint as $materiId => $total) {
            $selesai = progres_siswa::where('user_id', $userId)
                        ->where('materi_id', $materiId)
                        ->count();
            $persen = ($total > 0) ? round(($selesai / $total) * 100) : 0;
            $totalMateriPersen += min($persen, 100);
        }

        // Hitung persentase kuis (maks 100 per kuis)
        $progKuis = [0, 0, 0, 0, 0]; // indeks 0=kuis1, 1=kuis2, 2=kuis3, 3=kuis4, 4=eval
        $semuaPaket = PaketSoal::all();
        foreach ($semuaPaket as $paket) {
            $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);
            $sudah = HasilPengerjaan::where('user_id', $userId)
                    ->where('paket_soal_id', $paket->id)
                    ->exists();
            if ($sudah) {
                if (str_contains($namaPaket, 'kuis 1')) $progKuis[0] = 100;
                elseif (str_contains($namaPaket, 'kuis 2')) $progKuis[1] = 100;
                elseif (str_contains($namaPaket, 'kuis 3')) $progKuis[2] = 100;
                elseif (str_contains($namaPaket, 'kuis 4')) $progKuis[3] = 100;
                elseif (str_contains($namaPaket, 'evaluasi')) $progKuis[4] = 100;
            }
        }
        $totalKuisPersen = array_sum($progKuis);

        // Total komponen: 4 materi + 5 kuis = 9
        $jumlahKomponen = count($totalCheckpoint) + 5;
        $totalSemuaPersen = $totalMateriPersen + $totalKuisPersen;
        return round($totalSemuaPersen / $jumlahKomponen);
    }

    /**
     * Konfigurasi Global Jumlah Checkpoint
     * Ubah angka di sini saja jika ada penambahan materi/soal
     */
    private function getConfigCheckpoint()
    {
        return [
            'materi_1_konsep_pythagoras'   => 16,
            'materi_2_tripel_pythagoras'   => 8,
            'materi_3_segitiga_istimewa'   => 10,
            'materi_4_penerapan_pythagoras' => 8,
        ];
    }
}

