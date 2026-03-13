<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\progres_siswa; 
use App\Models\HasilPengerjaan; // PASTIKAN INI DITAMBAHKAN UNTUK CEK KUIS
use App\Models\PaketSoal; // PASTIKAN INI DITAMBAHKAN UNTUK CEK KUIS

class ProgresSiswaController extends Controller
{
    public function index()
    {
        $kelasList = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('guru.progres_siswa', compact('kelasList')); 
    }

    public function data(Request $request)
    {
        $query = User::with('kelas')->where('role', 'siswa');

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswa = $query->get();
        $data = [];

        // Ambil semua paket soal sekali saja di luar loop untuk efisiensi database
        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();

        foreach ($siswa as $index => $s) {
            
            // --- 1. HITUNG PROGRES MATERI 1 ---
            $totalCheckpoints = 16; 
            $completedCount = progres_siswa::where('user_id', $s->id)
                                           ->where('materi_id', 'materi_1_konsep_pythagoras')
                                           ->count();
                                           
            $progMateri1 = $totalCheckpoints > 0 ? round(($completedCount / $totalCheckpoints) * 100) : 0;
            if ($progMateri1 > 100) $progMateri1 = 100;

            // --- 2. HITUNG STATUS KUIS ---
            $progKuis1 = 0; $progKuis2 = 0; $progKuis3 = 0; $progKuis4 = 0; $progEval = 0;

            foreach ($semuaPaket as $paket) {
                $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);
                
                $sudahMengerjakan = HasilPengerjaan::where('paket_soal_id', $paket->id)
                                                   ->where('user_id', $s->id)
                                                   ->exists();

                if ($sudahMengerjakan) {
                    if (str_contains($namaPaket, 'kuis 1')) $progKuis1 = 100;
                    elseif (str_contains($namaPaket, 'kuis 2')) $progKuis2 = 100;
                    elseif (str_contains($namaPaket, 'kuis 3')) $progKuis3 = 100;
                    elseif (str_contains($namaPaket, 'kuis 4')) $progKuis4 = 100;
                    elseif (str_contains($namaPaket, 'evaluasi')) $progEval = 100;
                }
            }

            // --- 3. HITUNG TOTAL KESELURUHAN (Sama dengan Siswa) ---
            $progMateri2 = 0; $progMateri3 = 0; $progMateri4 = 0; 
            $totalSemuaPersen = $progMateri1 + $progMateri2 + $progMateri3 + $progMateri4 + 
                                $progKuis1 + $progKuis2 + $progKuis3 + $progKuis4 + $progEval;
            
            // Rata-rata keseluruhan (Dibagi 9 item)
            $percentage = round($totalSemuaPersen / 9);


            // --- 4. RENDER UI TABEL ---
            $progressBar = '
                <div class="d-flex align-items-center">
                    <span class="me-2 fw-bold text-dark" style="min-width:35px;">' . $percentage . '%</span>
                    <div class="progress flex-grow-1" style="height: 8px;">
                        <div class="progress-bar ' . ($percentage == 100 ? 'bg-success' : 'bg-primary') . '" 
                             role="progressbar" style="width: ' . $percentage . '%"></div>
                    </div>
                </div>';

            $btnDetail = '<button onclick="showDetailModal(' . $s->id . ')" 
                             class="btn btn-sm btn-info text-white fw-bold shadow-sm">
                             <i class="bi bi-eye-fill"></i> Detail
                          </button>';

            $data[] = [
                'DT_RowIndex' => $index + 1,
                'nama' => $s->name,
                'kelas' => $s->kelas ? $s->kelas->nama_kelas : '<span class="badge bg-secondary">Belum Masuk Kelas</span>',
                'progress' => $progressBar,
                'aksi' => $btnDetail
            ];
        }

        return response()->json(['data' => $data]);
    }


    public function detail($user_id)
    {
        $siswa = User::with('kelas')->findOrFail($user_id);
        
        // --- 1. HITUNG PROGRES MATERI 1 ---
        $totalCpMateri1 = 16;
        $selesaiMateri1 = progres_siswa::where('user_id', $user_id)->where('materi_id', 'materi_1_konsep_pythagoras')->count();
        $persenMateri1 = $totalCpMateri1 > 0 ? round(($selesaiMateri1 / $totalCpMateri1) * 100) : 0;
        if ($persenMateri1 > 100) $persenMateri1 = 100;

        // --- 2. HITUNG STATUS KUIS ---
        $progKuis1 = 0; $progKuis2 = 0; $progKuis3 = 0; $progKuis4 = 0; $progEval = 0;
        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();

        foreach ($semuaPaket as $paket) {
            $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);
            
            $sudahMengerjakan = HasilPengerjaan::where('paket_soal_id', $paket->id)
                                               ->where('user_id', $user_id)
                                               ->exists();

            if ($sudahMengerjakan) {
                if (str_contains($namaPaket, 'kuis 1')) $progKuis1 = 100;
                elseif (str_contains($namaPaket, 'kuis 2')) $progKuis2 = 100;
                elseif (str_contains($namaPaket, 'kuis 3')) $progKuis3 = 100;
                elseif (str_contains($namaPaket, 'kuis 4')) $progKuis4 = 100;
                elseif (str_contains($namaPaket, 'evaluasi')) $progEval = 100;
            }
        }

        // --- 3. HITUNG TOTAL KESELURUHAN ---
        $progMateri2 = 0; $progMateri3 = 0; $progMateri4 = 0; 
        $totalSemuaPersen = $persenMateri1 + $progMateri2 + $progMateri3 + $progMateri4 + 
                            $progKuis1 + $progKuis2 + $progKuis3 + $progKuis4 + $progEval;
        
        // Rata-rata keseluruhan (Dibagi 9 item)
        $totalProgressKeseluruhan = round($totalSemuaPersen / 9);

        // --- 4. SUSUN DATA UNTUK MODAL JAVASCRIPT ---
        $detailData = [
            'nama' => $siswa->name,
            'identitas' => $siswa->email, 
            'total_progress' => $totalProgressKeseluruhan, 
            'materi' => [
                'm1' => ['nama' => 'Materi 1: Menemukan Konsep', 'persen' => $persenMateri1, 'info' => ''],
                'm2' => ['nama' => 'Materi 2: Tripel Pythagoras', 'persen' => $progMateri2, 'info' => 'Locked'],
                'm3' => ['nama' => 'Materi 3: Segitiga Istimewa', 'persen' => $progMateri3, 'info' => 'Locked'],
                'm4' => ['nama' => 'Materi 4: Penerapan Pythagoras', 'persen' => $progMateri4, 'info' => 'Locked'],
            ],
            'kuis' => [
                'k1' => ['nama' => 'Kuis 1: Konsep Pythagoras', 'persen' => $progKuis1],
                'k2' => ['nama' => 'Kuis 2: Tripel Pythagoras', 'persen' => $progKuis2],
                'k3' => ['nama' => 'Kuis 3: Segitiga Istimewa', 'persen' => $progKuis3],
                'k4' => ['nama' => 'Kuis 4: Penerapan Pythagoras', 'persen' => $progKuis4],
                'eval' => ['nama' => 'Evaluasi Akhir', 'persen' => $progEval],
            ]
        ];

        return response()->json($detailData);
    }
}