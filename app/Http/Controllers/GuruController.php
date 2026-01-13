<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    //
    public function dashboard()
    {
        return view('guru.dashboard');
    }
    public function data_siswa()
    {
        return view('guru.data_siswa');
    }
    public function data_nilai()
    {
        return view('guru.data_nilai');
    }
    public function data_kelas()
    {
        return view('guru.data_kelas');
    }
    public function data_soal()
    {
        return view('guru.data_soal');
    }

    public function data_evaluasi()
    {
        return view('guru.data_evaluasi');
    }
}
