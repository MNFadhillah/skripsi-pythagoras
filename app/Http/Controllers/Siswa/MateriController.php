<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    //
    public function konsep()
    {
        return view('siswa.konsep.materi');
    }
    public function tripel()
    {
        return view('siswa.tripel.materi');
    }
    public function istimewa()
    {
        return view('siswa.istimewa.materi');
    }
    public function penerapan()
    {
        return view('siswa.penerapan.materi');
    }
    public function pendahuluan() {
        return view('siswa.pendahuluan.pengantar');
    }
}
