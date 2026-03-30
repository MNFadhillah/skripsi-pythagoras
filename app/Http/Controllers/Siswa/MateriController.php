<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\progres_siswa;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    //
    public function konsep()
    {
        // Mengambil array berisi 'checkpoint_code' yang sudah dikerjakan oleh siswa ini
        // Asumsi: kamu punya tabel yang menyimpan user_id dan checkpoint_code
        $completedCheckpoints = progres_siswa::where('user_id', Auth::id())
                                        // ->where('materi_id', 'materi_1_konsep_pythagoras') // Aktifkan jika mau difilter per materi
                                        ->pluck('checkpoint_code')
                                        ->toArray();

        return view('siswa.konsep.materi', compact('completedCheckpoints'));
    }
    public function tripel()
    {
        // Ambil data checkpoint yang sudah dikerjakan siswa
        $completedCheckpoints = progres_siswa::where('user_id', Auth::id())
                                        // ->where('materi_id', 'materi_2_tripel_pythagoras') // (Opsional) filter spesifik materi
                                        ->pluck('checkpoint_code')
                                        ->toArray();

        return view('siswa.tripel.materi', compact('completedCheckpoints'));
    }
    public function istimewa()
    {
        // Ambil data checkpoint yang sudah dikerjakan siswa
        $completedCheckpoints = progres_siswa::where('user_id', Auth::id())
                                        // ->where('materi_id', 'materi_3_segitiga_istimewa') // (Opsional) filter spesifik materi
                                        ->pluck('checkpoint_code')
                                        ->toArray();

        return view('siswa.istimewa.materi', compact('completedCheckpoints'));
    }
    public function penerapan()
    {
        // Ambil data checkpoint yang sudah dikerjakan siswa
        $completedCheckpoints = progres_siswa::where('user_id', Auth::id())
                                        // ->where('materi_id', 'materi_3_segitiga_istimewa') // (Opsional) filter spesifik materi
                                        ->pluck('checkpoint_code')
                                        ->toArray();

        return view('siswa.penerapan.materi', compact('completedCheckpoints'));
    }
    public function pendahuluan() {
        return view('siswa.pendahuluan.pengantar');
    }
}
