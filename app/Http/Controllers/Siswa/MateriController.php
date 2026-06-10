<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\progres_siswa;
use Illuminate\Http\Request;
use App\Traits\ProgresTrait; 

class MateriController extends Controller
{
    use ProgresTrait; 

    public function konsep()
    {
        $userId = Auth::id();
        $materiId = 'materi_1_konsep_pythagoras'; // ID Spesifik Materi

        $completedCheckpoints = progres_siswa::where('user_id', $userId)
            ->where('materi_id', $materiId)
            ->pluck('checkpoint_code')
            ->toArray();

        // Tarik progres KHUSUS materi ini
        $materiProgress = $this->hitungProgressMateri($userId, $materiId);

        return view('siswa.konsep.materi', compact('completedCheckpoints', 'materiProgress'));
    }

    public function tripel()
    {
        $userId = Auth::id();
        $materiId = 'materi_2_tripel_pythagoras';

        $completedCheckpoints = progres_siswa::where('user_id', $userId)
            ->where('materi_id', $materiId)
            ->pluck('checkpoint_code')
            ->toArray();

        $materiProgress = $this->hitungProgressMateri($userId, $materiId);

        return view('siswa.tripel.materi', compact('completedCheckpoints', 'materiProgress'));
    }

    public function istimewa()
    {
        $userId = Auth::id();
        $materiId = 'materi_3_segitiga_istimewa';

        $completedCheckpoints = progres_siswa::where('user_id', $userId)
            ->where('materi_id', $materiId)
            ->pluck('checkpoint_code')
            ->toArray();

        $materiProgress = $this->hitungProgressMateri($userId, $materiId);

        return view('siswa.istimewa.materi', compact('completedCheckpoints', 'materiProgress'));
    }

    public function penerapan()
    {
        $userId = Auth::id();
        $materiId = 'materi_4_penerapan_pythagoras';

        $completedCheckpoints = progres_siswa::where('user_id', $userId)
            ->where('materi_id', $materiId)
            ->pluck('checkpoint_code')
            ->toArray();

        $materiProgress = $this->hitungProgressMateri($userId, $materiId);

        return view('siswa.penerapan.materi', compact('completedCheckpoints', 'materiProgress'));
    }

    public function pendahuluan()
    {
        return view('siswa.pendahuluan.pengantar');
    }
}