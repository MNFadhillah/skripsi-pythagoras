<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\progres_siswa;
use App\Models\Badge;

class ProgressController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        $materi_id = $request->materi_id; 
        $checkpoint_code = $request->checkpoint_code;

        // 1. Simpan Progres Siswa ke Database 
        progres_siswa::firstOrCreate(
            // Parameter pertama: Cari data yang cocok
            [
                'user_id'         => $user->id,
                'materi_id'       => $materi_id,
                'checkpoint_code' => $checkpoint_code
            ],
            // Parameter kedua (opsional): Jika tidak ada, buat baru dengan data tambahan ini
            [
                'is_completed'    => 1 
            ]
        );

        // 2. Hitung Persentase Keseluruhan (Sama seperti logika di Dashboard)
        // Asumsi materi 1 (Konsep) memiliki 16 checkpoint total (sesuai kode Anda sebelumnya)
        $totalKeseluruhanCheckpoint = 16; 
        $completedCount = progres_siswa::where('user_id', $user->id)->count();

        $progressPercentage = 0;
        if ($totalKeseluruhanCheckpoint > 0) {
            $progressPercentage = round(($completedCount / $totalKeseluruhanCheckpoint) * 100);
            if ($progressPercentage > 100) {
                $progressPercentage = 100;
            }
        }

        // 3. Logika Pemberian Lencana Berdasarkan Progress 100%
        $badgeEarned = false;
        $badgeData = null;

        // Kondisi: Jika persentase mencapai 100% (atau jumlah completed count = total)
        // DAN checkpoint yang dikirim ini adalah bagian dari "Materi 1 Konsep"
        if ($progressPercentage == 100 && str_contains($materi_id, 'materi_1_konsep')) {
            
            $badgeId = 1; // ID Lencana Pythagoras Explorer

            // Cek agar lencana tidak diberikan ganda
            if (!$user->badges()->where('badge_id', $badgeId)->exists()) {
                
                $user->badges()->attach($badgeId);
                $badge = Badge::find($badgeId);
                
                $badgeEarned = true;
                $badgeData = [
                    'name' => $badge->name,
                    'image' => asset('images/badges/' . $badge->image_path)
                ];
            }
        }

        // 4. Kembalikan Response ke JavaScript
        return response()->json([
            'success' => true,
            'progress_percentage' => $progressPercentage,
            'badge_earned' => $badgeEarned,
            'badge_data' => $badgeData
        ]);
    }
}