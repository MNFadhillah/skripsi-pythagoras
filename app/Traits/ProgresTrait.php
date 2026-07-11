<?php

namespace App\Traits;

use App\Models\progres_siswa;
use App\Models\PaketSoal;
use App\Models\HasilPengerjaan;
use App\Http\Controllers\Siswa\BadgeController;

trait ProgresTrait
{
    /**
     * Helper untuk menghitung total progres keseluruhan (materi + kuis)
     */
    public function hitungTotalProgress(int $userId)
    {
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
        $progKuis = [0, 0, 0, 0, 0]; // 0=kuis1, 1=kuis2, 2=kuis3, 3=kuis4, 4=eval
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
     */
    public function getConfigCheckpoint()
    {
        return [
            'materi_1_konsep_pythagoras'    => 15,
            'materi_2_tripel_pythagoras'    => 9,
            'materi_3_segitiga_istimewa'    => 6,
            'materi_4_penerapan_pythagoras' => 8,
        ];
    }

    public function hitungProgressMateri($userId, $materiId)
    {
        $checkpoints = $this->getConfigCheckpoint();
        $totalTarget = $checkpoints[$materiId] ?? 0;

        if ($totalTarget == 0) {
            return 0;
        }

        $selesai = progres_siswa::where('user_id', $userId)
            ->where('materi_id', $materiId)
            ->count();

        $persen = round(($selesai / $totalTarget) * 100);
        return min($persen, 100);
    }

    /**
     * Cek dan berikan badge berdasarkan POIN (bukan progres).
     * Mendelegasikan sepenuhnya ke BadgeController::checkAndAwardBadgesByPoints().
     *
     * @param  int  $userId
     * @return array  Badge baru yang diperoleh (bisa kosong [])
     */
    public function checkAndAwardCompletionBadge($userId): array
    {
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return ['badge_earned' => false, 'badge_data' => null];
        }

        $newlyEarned = BadgeController::checkAndAwardBadgesByPoints($user);

        // Pertahankan format return lama agar kode pemanggil tidak perlu diubah besar-besaran
        if (!empty($newlyEarned)) {
            // Kembalikan badge terakhir yang baru didapat
            $last = end($newlyEarned);
            return [
                'badge_earned' => true,
                'badge_data'   => $last,
            ];
        }

        return ['badge_earned' => false, 'badge_data' => null];
    }
}