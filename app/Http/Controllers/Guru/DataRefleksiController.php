<?php

namespace App\Http\Controllers\Guru; // Sesuaikan dengan namespace Anda

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataRefleksi;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DataRefleksiController extends Controller
{
    public function index()
    {
        $guruId = Auth::id();

        // 1. Cari ID kelas-kelas yang diampu oleh guru ini
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id');

        // 2. Cek apakah guru punya kelas (untuk keperluan tampilan Alert/Empty State)
        $hasClass = $kelasIds->isNotEmpty();

        // 3. Ambil ID siswa yang berada di dalam kelas-kelas tersebut
        $siswaIds = User::whereIn('kelas_id', $kelasIds)
                        ->where('role', 'siswa')
                        ->pluck('id');

        // 4. Ambil data refleksi HANYA dari siswa-siswa tersebut
        $dataRefleksi = DataRefleksi::with('user')
                                    ->whereIn('user_id', $siswaIds)
                                    ->latest() // Urutkan dari yang terbaru
                                    ->get();

            return view('guru.data_refleksi', compact('dataRefleksi', 'hasClass'));
    }
}