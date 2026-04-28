<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    // Fungsi untuk menampilkan halaman Koleksi Lencana
    public function index()
    {
        $user = Auth::user();
        $allBadges = Badge::all();

        // Ambil ID lencana yang sudah dimiliki user agar mudah dicek di View
        $earnedBadgeIds = $user->badges->pluck('id')->toArray();

        return view('badges.index', compact('allBadges', 'earnedBadgeIds'));
    }

    // Contoh fungsi yang bisa dipanggil setelah siswa selesai kuis/Ayo Berlatih
    public function checkAndAwardBadge($user, $kuisTipe, $nilai)
    {
        // KKM > 70 sesuai aturan
        if ($nilai > 70) {
            $badgeId = null;

            // Logika sederhana: tentukan badge ID berdasarkan kuis
            if ($kuisTipe == 'ayo_berlatih_1') {
                $badgeId = 1; // Pastikan ID 1 adalah badge Tuntas Kuis 1 di database
            } elseif ($kuisTipe == 'ayo_berlatih_2') {
                $badgeId = 2;
            } // ... dan seterusnya

            if ($badgeId) {
                // Cek agar tidak tersimpan ganda jika diulang
                if (!$user->badges()->where('badge_id', $badgeId)->exists()) {
                    $user->badges()->attach($badgeId);
                }
            }
        }
    }
}
