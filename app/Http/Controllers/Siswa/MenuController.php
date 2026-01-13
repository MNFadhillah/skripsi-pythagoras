<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AktivitasBelajar;

class MenuController extends Controller
{
    public function dashboard()
{
    // 1. Ambil semua aktivitas yang Statusnya AKTIF (1)
    // Urutkan berdasarkan ID atau Kategori sesuai selera
    $aktivitas = AktivitasBelajar::where('status', 1)->orderBy('id', 'asc')->get();

    // 2. Kirim variabel $aktivitas ke view menggunakan compact
    return view('siswa.menu.dashboard', compact('aktivitas'));
}



    public function leaderboard()
    {
        return view('siswa.menu.leaderboard');
    }
    public function nilai_siswa()
    {
        return view('siswa.menu.nilai_siswa');
    }
    public function petunjuk()
    {
        return view('siswa.menu.petunjuk');
    }
}
