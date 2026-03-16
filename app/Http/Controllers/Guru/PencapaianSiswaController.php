<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\progres_siswa; 
use App\Models\HasilPengerjaan; 
use App\Models\PaketSoal; 
use App\Models\Badge; // PASTIKAN IMPORT MODEL BADGE

class PencapaianSiswaController extends Controller
{
    public function index()
    {
        $kelasList = Kelas::orderBy('nama_kelas', 'asc')->get();
        // Leaderboard tidak lagi dihitung di sini, sudah pindah ke AJAX
        $badges = Badge::withCount('users')->get(); 

        return view('guru.pencapaian_siswa', compact('kelasList', 'badges')); 
    }


    private function hitungRataRataSiswa($siswa, $semuaPaket, $kkm)
    {
        $totalNilaiResmi = 0;
        $jumlahPaketDikerjakan = 0;

        foreach ($semuaPaket as $paket) {
            $riwayat = HasilPengerjaan::where('user_id', $siswa->id)
                        ->where('paket_soal_id', $paket->id)
                        ->whereNotNull('waktu_selesai')
                        ->orderBy('created_at', 'asc')
                        ->get();

            if ($riwayat->count() > 0) {
                $skorPertama = $riwayat->first()->skor_akhir;
                $nilaiFix = ($skorPertama >= $kkm) ? $skorPertama : min(max($riwayat->max('skor_akhir'), 0), $kkm);
                
                $totalNilaiResmi += $nilaiFix;
                $jumlahPaketDikerjakan++;
            }
        }

        return $jumlahPaketDikerjakan > 0 ? round($totalNilaiResmi / $jumlahPaketDikerjakan, 2) : 0;
    }

    private function formatPeringkat($rank)
    {
        if ($rank == 1) {
            return '<span class="fs-4">🥇</span> 1';
        } elseif ($rank == 2) {
            return '<span class="fs-5">🥈</span> 2';
        } elseif ($rank == 3) {
            return '<span class="fs-5">🥉</span> 3';
        }
        return (string) $rank;
    }

    // ==========================================
    // FUNGSI BARU UNTUK DATATABLES LEADERBOARD
    // ==========================================
    public function dataLeaderboard(Request $request)
    {
        // Query siswa
        $query = User::where('role', 'siswa')->with('kelas');
        
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        
        $semuaSiswa = $query->get();
        $semuaPaket = PaketSoal::all();
        $kkm = 70;
        
        // Kumpulkan data mentah
        $leaderboardData = [];
        foreach ($semuaSiswa as $siswa) {
            $rataRata = $this->hitungRataRataSiswa($siswa, $semuaPaket, $kkm);
            
            $leaderboardData[] = [
                'id' => $siswa->id,
                'nama' => $siswa->name,
                'kelas' => $siswa->kelas?->nama_kelas ?? 'Belum Masuk Kelas',
                'rata_rata' => $rataRata,
            ];
        }

        // Urutkan berdasarkan rata-rata tertinggi
        $leaderboardSorted = collect($leaderboardData)
            ->sortByDesc('rata_rata')
            ->values()
            ->toArray();

        // Format untuk DataTables
        $formattedData = [];
        foreach ($leaderboardSorted as $index => $item) {
            $rank = $index + 1;
            $formattedData[] = [
                'peringkat' => $this->formatPeringkat($rank),
                'nama' => '<span class="fw-bold">' . e($item['nama']) . '</span>',
                'kelas' => '<span class="badge bg-light text-dark border">' . e($item['kelas']) . '</span>',
                'rata_rata' => '<span class="fw-bold text-primary fs-6">' . number_format($item['rata_rata'], 2) . '</span>',
            ];
        }

        return response()->json(['data' => $formattedData]);
    }

    // ==========================================
    // FUNGSI BARU UNTUK MODAL BADGES
    // ==========================================
    public function detailBadge($badge_id)
    {
        $badge = Badge::with(['users' => function($query) {
            $query->select('users.id', 'users.name', 'users.kelas_id')->with('kelas');
        }])->findOrFail($badge_id);

        $peraih = $badge->users->map(function($user) {
            return [
                'nama' => $user->name,
                'kelas' => $user->kelas ? $user->kelas->nama_kelas : 'Tanpa Kelas'
            ];
        });

        return response()->json([
            'nama_badge' => $badge->name,
            // DI SINI KITA UBAH NAMA KOLOM DAN FOLDERNYA:
            'gambar_badge' => $badge->image_path ? asset('images/badges/' . $badge->image_path) : null, 
            'peraih' => $peraih
        ]);
    }
    public function data(Request $request)
    {
        $query = User::with('kelas')->where('role', 'siswa');

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswa = $query->get();
        $data = [];

        // Definisikan jumlah checkpoint per materi
        $totalCheckpoint = [
            'materi_1_konsep_pythagoras'   => 16,
            'materi_2_tripel_pythagoras'   => 7,
            'materi_3_segitiga_istimewa'   => 10,
            'materi_4_penerapan_pythagoras' => 14,
        ];

        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();

        foreach ($siswa as $index => $s) {
            // --- Hitung progres setiap materi ---
            $totalMateriPersen = 0;
            foreach ($totalCheckpoint as $materiId => $total) {
                $selesai = progres_siswa::where('user_id', $s->id)
                            ->where('materi_id', $materiId)
                            ->count();
                $persen = ($total > 0) ? round(($selesai / $total) * 100) : 0;
                $persen = min($persen, 100);
                $totalMateriPersen += $persen;
            }

            // --- Hitung status kuis ---
            $progKuis = [0, 0, 0, 0, 0]; // indeks 0=kuis1,1=kuis2,2=kuis3,3=kuis4,4=eval
            foreach ($semuaPaket as $paket) {
                $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);
                $sudahMengerjakan = HasilPengerjaan::where('paket_soal_id', $paket->id)
                                    ->where('user_id', $s->id)
                                    ->exists();

                if ($sudahMengerjakan) {
                    if (str_contains($namaPaket, 'kuis 1')) $progKuis[0] = 100;
                    elseif (str_contains($namaPaket, 'kuis 2')) $progKuis[1] = 100;
                    elseif (str_contains($namaPaket, 'kuis 3')) $progKuis[2] = 100;
                    elseif (str_contains($namaPaket, 'kuis 4')) $progKuis[3] = 100;
                    elseif (str_contains($namaPaket, 'evaluasi')) $progKuis[4] = 100;
                }
            }
            $totalKuisPersen = array_sum($progKuis);

            // --- Total keseluruhan (4 materi + 5 kuis) ---
            $totalSemuaPersen = $totalMateriPersen + $totalKuisPersen;
            $jumlahKomponen = count($totalCheckpoint) + 5; // 9
            $percentage = round($totalSemuaPersen / $jumlahKomponen);

            // --- Render progress bar ---
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

        // Definisikan jumlah checkpoint per materi
        $totalCheckpoint = [
            'materi_1_konsep_pythagoras'   => 16,
            'materi_2_tripel_pythagoras'   => 7,
            'materi_3_segitiga_istimewa'   => 10,
            'materi_4_penerapan_pythagoras' => 14,
        ];

        // Hitung persentase setiap materi
        $persenMateri = [];
        foreach ($totalCheckpoint as $materiId => $total) {
            $selesai = progres_siswa::where('user_id', $user_id)
                        ->where('materi_id', $materiId)
                        ->count();
            $persen = ($total > 0) ? round(($selesai / $total) * 100) : 0;
            $persen = min($persen, 100);
            $persenMateri[$materiId] = $persen;
        }

        // Hitung status kuis
        $progKuis = [
            'kuis1' => 0,
            'kuis2' => 0,
            'kuis3' => 0,
            'kuis4' => 0,
            'eval'  => 0,
        ];

        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();
        foreach ($semuaPaket as $paket) {
            $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);
            $sudahMengerjakan = HasilPengerjaan::where('paket_soal_id', $paket->id)
                                ->where('user_id', $user_id)
                                ->exists();

            if ($sudahMengerjakan) {
                if (str_contains($namaPaket, 'kuis 1')) {
                    $progKuis['kuis1'] = 100;
                } elseif (str_contains($namaPaket, 'kuis 2')) {
                    $progKuis['kuis2'] = 100;
                } elseif (str_contains($namaPaket, 'kuis 3')) {
                    $progKuis['kuis3'] = 100;
                } elseif (str_contains($namaPaket, 'kuis 4')) {
                    $progKuis['kuis4'] = 100;
                } elseif (str_contains($namaPaket, 'evaluasi')) {
                    $progKuis['eval'] = 100;
                }
            }
        }

        // Hitung total progres keseluruhan
        $totalSemuaPersen = array_sum($persenMateri) + array_sum($progKuis);
        $jumlahKomponen = count($persenMateri) + count($progKuis); // 9
        $totalProgressKeseluruhan = round($totalSemuaPersen / $jumlahKomponen);

        // Susun data untuk response
        $detailData = [
            'nama'       => $siswa->name,
            'identitas'  => $siswa->email,
            'total_progress' => $totalProgressKeseluruhan,
            'materi' => [
                'm1' => [
                    'nama'   => 'Materi 1: Menemukan Konsep',
                    'persen' => $persenMateri['materi_1_konsep_pythagoras'],
                    'info'   => '',
                ],
                'm2' => [
                    'nama'   => 'Materi 2: Tripel Pythagoras',
                    'persen' => $persenMateri['materi_2_tripel_pythagoras'],
                    'info'   => '',
                ],
                'm3' => [
                    'nama'   => 'Materi 3: Segitiga Istimewa',
                    'persen' => $persenMateri['materi_3_segitiga_istimewa'],
                    'info'   => '',
                ],
                'm4' => [
                    'nama'   => 'Materi 4: Penerapan Teorema Pythagoras',
                    'persen' => $persenMateri['materi_4_penerapan_pythagoras'],
                    'info'   => '',
                ],
            ],
            'kuis' => [
                'k1' => [
                    'nama'   => 'Kuis 1: Konsep Pythagoras',
                    'persen' => $progKuis['kuis1'],
                ],
                'k2' => [
                    'nama'   => 'Kuis 2: Tripel Pythagoras',
                    'persen' => $progKuis['kuis2'],
                ],
                'k3' => [
                    'nama'   => 'Kuis 3: Segitiga Istimewa',
                    'persen' => $progKuis['kuis3'],
                ],
                'k4' => [
                    'nama'   => 'Kuis 4: Penerapan Pythagoras',
                    'persen' => $progKuis['kuis4'],
                ],
                'eval' => [
                    'nama'   => 'Evaluasi Akhir',
                    'persen' => $progKuis['eval'],
                ],
            ],
        ];

        return response()->json($detailData);
    }
}