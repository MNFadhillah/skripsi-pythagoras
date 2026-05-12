<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\progres_siswa; // Sesuaikan nama model Anda (misal: ProgresSiswa)
use App\Models\HasilPengerjaan;
use App\Models\PaketSoal;
use App\Models\Badge;
use Illuminate\Support\Facades\Auth;

class PencapaianSiswaController extends Controller
{
    public function index()
    {
        $guruId = Auth::id();
        // Hanya kelas yang diampu oleh guru ini
        $kelasList = Kelas::where('guru_id', $guruId)->orderBy('nama_kelas', 'asc')->get();
        $badges = Badge::withCount('users')->get();

        return view('guru.pencapaian_siswa', compact('kelasList', 'badges'));
    }

    // ==========================================
    // DATA UNTUK TAB PROGRES (DataTables)
    // ==========================================
    public function data(Request $request)
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        // Jika guru tidak punya kelas, kembalikan data kosong
        if (empty($kelasIds)) {
            return response()->json(['data' => []]);
        }

        $query = User::with('kelas')
            ->where('role', 'siswa')
            ->whereIn('kelas_id', $kelasIds);

        if ($request->filled('kelas_id') && in_array($request->kelas_id, $kelasIds)) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswa = $query->get();
        $data = [];

        // Definisikan jumlah checkpoint per materi
        $totalCheckpoint = [
            'materi_1_konsep_pythagoras'   => 16,
            'materi_2_tripel_pythagoras'   => 8,
            'materi_3_segitiga_istimewa'   => 6,
            'materi_4_penerapan_pythagoras' => 8,
        ];

        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();

        foreach ($siswa as $index => $s) {
            // Hitung progres setiap materi
            $totalMateriPersen = 0;
            foreach ($totalCheckpoint as $materiId => $total) {
                $selesai = progres_siswa::where('user_id', $s->id)
                    ->where('materi_id', $materiId)
                    ->count();
                $persen = ($total > 0) ? round(($selesai / $total) * 100) : 0;
                $persen = min($persen, 100);
                $totalMateriPersen += $persen;
            }

            // Hitung status kuis
            $progKuis = [0, 0, 0, 0, 0];
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

            $totalSemuaPersen = $totalMateriPersen + $totalKuisPersen;
            $jumlahKomponen = count($totalCheckpoint) + 5;
            $percentage = round($totalSemuaPersen / $jumlahKomponen);

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

    // ==========================================
    // DATA UNTUK TAB LEADERBOARD (DataTables)
    // ==========================================
    public function dataLeaderboard(Request $request)
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        if (empty($kelasIds)) {
            return response()->json(['data' => []]);
        }

        $query = User::where('role', 'siswa')->with('kelas')
            ->whereIn('kelas_id', $kelasIds);

        if ($request->filled('kelas_id') && in_array($request->kelas_id, $kelasIds)) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $semuaSiswa = $query->get();

        $leaderboardData = [];
        foreach ($semuaSiswa as $siswa) {
            $leaderboardData[] = [
                'id' => $siswa->id,
                'nama' => $siswa->name,
                'kelas' => $siswa->kelas?->nama_kelas ?? 'Belum Masuk Kelas',
                'points' => $siswa->points ?? 0,
            ];
        }

        // Urutkan berdasarkan points tertinggi
        $leaderboardSorted = collect($leaderboardData)
            ->sortByDesc('points')
            ->values()
            ->toArray();

        $formattedData = [];
        foreach ($leaderboardSorted as $index => $item) {
            $rank = $index + 1;
            $formattedData[] = [
                'peringkat' => $this->formatPeringkat($rank),
                'nama' => '<span class="fw-bold">' . e($item['nama']) . '</span>',
                'kelas' => '<span class="badge bg-light text-dark border">' . e($item['kelas']) . '</span>',
                'points' => '<span class="fw-bold fs-6">' . number_format($item['points'], 0, ',', '.') . ' Pts</span>',
            ];
        }

        return response()->json(['data' => $formattedData]);
    }

    // ==========================================
    // DETAIL PROGRES SISWA (Modal)
    // ==========================================
    public function detail($user_id)
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        $siswa = User::with('kelas')->findOrFail($user_id);

        // Pastikan siswa berada di kelas yang diampu guru
        if (!in_array($siswa->kelas_id, $kelasIds)) {
            abort(403, 'Anda tidak berhak melihat detail siswa ini.');
        }

        // Definisikan jumlah checkpoint per materi
        $totalCheckpoint = [
            'materi_1_konsep_pythagoras'   => 16,
            'materi_2_tripel_pythagoras'   => 8,
            'materi_3_segitiga_istimewa'   => 6,
            'materi_4_penerapan_pythagoras' => 8,
        ];

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
                if (str_contains($namaPaket, 'kuis 1')) $progKuis['kuis1'] = 100;
                elseif (str_contains($namaPaket, 'kuis 2')) $progKuis['kuis2'] = 100;
                elseif (str_contains($namaPaket, 'kuis 3')) $progKuis['kuis3'] = 100;
                elseif (str_contains($namaPaket, 'kuis 4')) $progKuis['kuis4'] = 100;
                elseif (str_contains($namaPaket, 'evaluasi')) $progKuis['eval'] = 100;
            }
        }

        $totalSemuaPersen = array_sum($persenMateri) + array_sum($progKuis);
        $jumlahKomponen = count($persenMateri) + count($progKuis);
        $totalProgressKeseluruhan = round($totalSemuaPersen / $jumlahKomponen);

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
                'k1' => ['nama' => 'Kuis 1: Konsep Pythagoras', 'persen' => $progKuis['kuis1']],
                'k2' => ['nama' => 'Kuis 2: Tripel Pythagoras', 'persen' => $progKuis['kuis2']],
                'k3' => ['nama' => 'Kuis 3: Segitiga Istimewa', 'persen' => $progKuis['kuis3']],
                'k4' => ['nama' => 'Kuis 4: Penerapan Pythagoras', 'persen' => $progKuis['kuis4']],
                'eval' => ['nama' => 'Evaluasi Akhir', 'persen' => $progKuis['eval']],
            ],
        ];

        return response()->json($detailData);
    }

    // ==========================================
    // DETAIL BADGE (Modal)
    // ==========================================
    public function detailBadge($badge_id)
    {
        $guruId = Auth::id();
        // Ambil ID kelas yang diampu oleh guru ini
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        // Jika guru tidak memiliki kelas, kembalikan data kosong
        if (empty($kelasIds)) {
            return response()->json([
                'nama_badge' => '',
                'gambar_badge' => null,
                'peraih' => []
            ]);
        }

        $badge = Badge::with(['users' => function ($query) use ($kelasIds) {
            $query->select('users.id', 'users.name', 'users.kelas_id')
                ->with('kelas')
                ->whereIn('users.kelas_id', $kelasIds); // Filter hanya siswa di kelas guru
        }])->findOrFail($badge_id);

        $peraih = $badge->users->map(function ($user) {
            return [
                'nama' => $user->name,
                'kelas' => $user->kelas ? $user->kelas->nama_kelas : 'Tanpa Kelas'
            ];
        });

        return response()->json([
            'nama_badge' => $badge->name,
            'gambar_badge' => $badge->image_path ? asset('images/badges/' . $badge->image_path) : null,
            'peraih' => $peraih
        ]);
    }

    // PencapaianSiswaController.php

    public function dataPemahaman(Request $request)
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        if (empty($kelasIds)) {
            return response()->json(['data' => []]);
        }

        $query = User::with('kelas')
            ->where('role', 'siswa')
            ->whereIn('kelas_id', $kelasIds);

        if ($request->filled('kelas_id') && in_array($request->kelas_id, $kelasIds)) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswa = $query->get();

        // Konfigurasi checkpoint (sama seperti di ProgressController)
        $totalCheckpoint = [
            'materi_1_konsep_pythagoras'   => 16,
            'materi_2_tripel_pythagoras'   => 8,
            'materi_3_segitiga_istimewa'   => 6,
            'materi_4_penerapan_pythagoras' => 8,
        ];

        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();
        $data = [];

        foreach ($siswa as $index => $s) {
            // 1. Hitung progres materi (sama seperti ProgressController)
            $totalMateriPersen = 0;
            foreach ($totalCheckpoint as $materiId => $total) {
                $selesai = progres_siswa::where('user_id', $s->id)
                    ->where('materi_id', $materiId)
                    ->count();
                $persen = ($total > 0) ? round(($selesai / $total) * 100) : 0;
                $persen = min($persen, 100);
                $totalMateriPersen += $persen;
            }

            // 2. Hitung progres kuis (binary 0/100 per paket, seperti di ProgressController)
            $progKuis = [0, 0, 0, 0, 0]; // indeks: kuis1, kuis2, kuis3, kuis4, eval
            $nilaiKuis = [];
            foreach ($semuaPaket as $paket) {
                $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);

                $attempts = HasilPengerjaan::where('paket_soal_id', $paket->id)
                    ->where('user_id', $s->id)
                    ->orderBy('created_at', 'asc')
                    ->get();

                if ($attempts->isNotEmpty()) {
                    $skorPertama = $attempts->first()->skor_akhir;
                    $kkm = 70;

                    if ($skorPertama >= $kkm) {
                        $finalScore = $skorPertama;
                    } else {
                        $skorTertinggi = $attempts->max('skor_akhir');
                        $finalScore = ($skorTertinggi >= $kkm) ? $kkm : $skorTertinggi;
                    }

                    if (preg_match('/kuis[\s\-_]*1\b/i', $namaPaket)) {
                        $progKuis[0] = 100;
                        $nilaiKuis[] = $finalScore;
                    } elseif (preg_match('/kuis[\s\-_]*2\b/i', $namaPaket)) {
                        $progKuis[1] = 100;
                        $nilaiKuis[] = $finalScore;
                    } elseif (preg_match('/kuis[\s\-_]*3\b/i', $namaPaket)) {
                        $progKuis[2] = 100;
                        $nilaiKuis[] = $finalScore;
                    } elseif (preg_match('/kuis[\s\-_]*4\b/i', $namaPaket)) {
                        $progKuis[3] = 100;
                        $nilaiKuis[] = $finalScore;
                    } elseif (str_contains($namaPaket, 'evaluasi')) {
                        $progKuis[4] = 100;
                        $nilaiKuis[] = $finalScore;
                    }
                }
            }

            $totalKuisPersen = array_sum($progKuis); // maks 500
            // Total komponen = 4 materi + 5 kuis = 9
            $totalSemuaPersen = $totalMateriPersen + $totalKuisPersen;
            $progresTotal = round($totalSemuaPersen / 9);

            // Rata‑rata nilai kuis (hanya kuis yang sudah dikerjakan)
            $rataNilai = count($nilaiKuis) > 0 ? round(array_sum($nilaiKuis) / count($nilaiKuis), 1) : 0;

            // Tentukan status berdasarkan progres dan rata‑rata nilai
            if ($rataNilai === null) {
                $status = '<span class="badge bg-secondary">Belum Ada Nilai</span>';
            } elseif ($progresTotal >= 70 && $rataNilai >= 70) {
                $status = '<span class="badge bg-success">Baik</span>';
            } elseif ($progresTotal >= 70 && $rataNilai < 70) {
                $status = '<span class="badge bg-warning text-dark">Memerlukan Perhatian</span>';
            } elseif ($progresTotal < 70 && $rataNilai >= 70) {
                $status = '<span class="badge bg-info text-white">Materi Belum Tuntas</span>';
            } else { // progres < 70 dan nilai < 70
                $status = '<span class="badge bg-danger">Memerlukan Bimbingan</span>';
            }

            $data[] = [
                'DT_RowIndex' => $index + 1,
                'nama'        => $s->name,
                'kelas'       => $s->kelas ? $s->kelas->nama_kelas : '<span class="badge bg-secondary">-</span>',
                'user_id'     => $s->id,
                'progres'     => $progresTotal . '%',
                'rata_nilai'  => $rataNilai !== null ? $rataNilai : '-',
                'status'      => $status,
                'aksi'        => '<button class="btn btn-sm btn-info text-white shadow-sm" onclick="showGrafikModal(' . $s->id . ')">
                                <i class="bi bi-bar-chart-fill me-1"></i> Detail</button>'
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function grafikPenguasaan($user_id)
    {
        $guruId = Auth::id();
        $kelasIds = Kelas::where('guru_id', $guruId)->pluck('id')->toArray();

        $siswa = User::with('kelas')->findOrFail($user_id);
        if (!in_array($siswa->kelas_id, $kelasIds)) {
            return response()->json(['success' => false, 'message' => 'Tidak berhak.'], 403);
        }

        // === HITUNG DATA INDIVIDU ===
        $totalCheckpoint = [
            'materi_1_konsep_pythagoras'   => 16,
            'materi_2_tripel_pythagoras'   => 8,
            'materi_3_segitiga_istimewa'   => 6,
            'materi_4_penerapan_pythagoras' => 8,
        ];

        // Progres materi individu
        $totalMateriPersen = 0;
        foreach ($totalCheckpoint as $materiId => $total) {
            $selesai = progres_siswa::where('user_id', $user_id)
                ->where('materi_id', $materiId)
                ->count();
            $persen = ($total > 0) ? round(($selesai / $total) * 100) : 0;
            $persen = min($persen, 100);
            $totalMateriPersen += $persen;
        }

        // Progres kuis dan nilai individu
        $progKuis = [0, 0, 0, 0, 0];
        $nilaiKuis = []; // untuk menyimpan nilai final per kuis (KKM)

        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();
        foreach ($semuaPaket as $paket) {
            $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);
            $attempts = HasilPengerjaan::where('paket_soal_id', $paket->id)
                ->where('user_id', $user_id)
                ->orderBy('created_at', 'asc')
                ->get();
            if ($attempts->isNotEmpty()) {
                $skorPertama = $attempts->first()->skor_akhir;
                $kkm = 70;
                if ($skorPertama >= $kkm) {
                    $finalScore = $skorPertama;
                } else {
                    $skorTertinggi = $attempts->max('skor_akhir');
                    $finalScore = ($skorTertinggi >= $kkm) ? $kkm : $skorTertinggi;
                }
                $nilaiKuis[] = $finalScore;

                if (preg_match('/kuis[\s\-_]*1\b/i', $namaPaket)) $progKuis[0] = 100;
                elseif (preg_match('/kuis[\s\-_]*2\b/i', $namaPaket)) $progKuis[1] = 100;
                elseif (preg_match('/kuis[\s\-_]*3\b/i', $namaPaket)) $progKuis[2] = 100;
                elseif (preg_match('/kuis[\s\-_]*4\b/i', $namaPaket)) $progKuis[3] = 100;
                elseif (str_contains($namaPaket, 'evaluasi')) $progKuis[4] = 100;
            }
        }

        $totalKuisPersen = array_sum($progKuis);
        $progresTotal = round(($totalMateriPersen + $totalKuisPersen) / 9);
        $rataNilai = count($nilaiKuis) > 0 ? round(array_sum($nilaiKuis) / count($nilaiKuis), 1) : 0;

        // === HITUNG RATA-RATA KELAS ===
        $siswaSekelas = User::where('role', 'siswa')
            ->where('kelas_id', $siswa->kelas_id)
            ->where('id', '!=', $user_id) // boleh termasuk diri sendiri, tapi opsional
            ->get();

        $arrProgresKelas = [];
        $arrNilaiKelas = [];

        foreach ($siswaSekelas as $s) {
            // Hitung progres_total untuk setiap siswa di kelas
            $totalMateriK = 0;
            foreach ($totalCheckpoint as $materiId => $total) {
                $selesai = progres_siswa::where('user_id', $s->id)
                    ->where('materi_id', $materiId)
                    ->count();
                $persen = ($total > 0) ? round(($selesai / $total) * 100) : 0;
                $totalMateriK += min($persen, 100);
            }
            $progKuisK = [0, 0, 0, 0, 0];
            $nilaiKuisK = [];
            foreach ($semuaPaket as $paket) {
                $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);
                $attempts = HasilPengerjaan::where('paket_soal_id', $paket->id)
                    ->where('user_id', $s->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
                if ($attempts->isNotEmpty()) {
                    $skorPertama = $attempts->first()->skor_akhir;
                    $kkm = 70;
                    if ($skorPertama >= $kkm) {
                        $finalScore = $skorPertama;
                    } else {
                        $skorTertinggi = $attempts->max('skor_akhir');
                        $finalScore = ($skorTertinggi >= $kkm) ? $kkm : $skorTertinggi;
                    }
                    $nilaiKuisK[] = $finalScore;
                    if (preg_match('/kuis[\s\-_]*1\b/i', $namaPaket)) $progKuisK[0] = 100;
                    elseif (preg_match('/kuis[\s\-_]*2\b/i', $namaPaket)) $progKuisK[1] = 100;
                    elseif (preg_match('/kuis[\s\-_]*3\b/i', $namaPaket)) $progKuisK[2] = 100;
                    elseif (preg_match('/kuis[\s\-_]*4\b/i', $namaPaket)) $progKuisK[3] = 100;
                    elseif (str_contains($namaPaket, 'evaluasi')) $progKuisK[4] = 100;
                }
            }
            $totalKuisK = array_sum($progKuisK);
            $progresTotalK = round(($totalMateriK + $totalKuisK) / 9);
            $arrProgresKelas[] = $progresTotalK;
            $rataNilaiK = count($nilaiKuisK) > 0 ? round(array_sum($nilaiKuisK) / count($nilaiKuisK), 1) : 0;
            if ($rataNilaiK > 0) {
                $arrNilaiKelas[] = $rataNilaiK;
            }
        }

        $rataKelasProgres = count($arrProgresKelas) > 0 ? round(array_sum($arrProgresKelas) / count($arrProgresKelas)) : $progresTotal;
        $rataKelasNilai = count($arrNilaiKelas) > 0 ? round(array_sum($arrNilaiKelas) / count($arrNilaiKelas), 1) : $rataNilai;

        return response()->json([
            'nama'              => $siswa->name,
            'kelas'             => $siswa->kelas->nama_kelas ?? '-',
            'progres_total'     => $progresTotal,
            'rata_nilai'        => $rataNilai,
            'rata_kelas_progres' => $rataKelasProgres,
            'rata_kelas_nilai'  => $rataKelasNilai,
        ]);
    }

    // Helper format peringkat
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
}
