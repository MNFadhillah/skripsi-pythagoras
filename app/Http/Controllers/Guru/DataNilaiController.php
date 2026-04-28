<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\HasilPengerjaan;
use Illuminate\Http\Request;
use App\Models\PaketSoal;
use App\Models\ButirSoal;
use App\Models\Kelas;
use App\Exports\DataNilaiExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DataNilaiController extends Controller
{
    /**
     * Ambil data nilai siswa yang sudah diproses, hanya dari kelas yang diampu guru.
     *
     * @param int|null $kelasId (optional) ID kelas yang difilter (harus milik guru)
     * @return \Illuminate\Support\Collection
     */
    private function getProcessedData($kelasId = null)
    {
        $guruId = Auth::id();

        // Kelas yang diampu oleh guru ini
        $kelasGuru = Kelas::where('guru_id', $guruId)->pluck('id');

        if ($kelasGuru->isEmpty()) {
            return collect(); // tidak ada kelas, data kosong
        }

        // Query siswa hanya yang kelas_id-nya ada di $kelasGuru
        $usersQuery = \App\Models\User::with('kelas')
            ->where('role', 'siswa')
            ->whereIn('kelas_id', $kelasGuru);

        // Jika ada filter kelas, pastikan kelas tersebut termasuk milik guru
        if ($kelasId && in_array($kelasId, $kelasGuru->toArray())) {
            $usersQuery->where('kelas_id', $kelasId);
        }

        $users = $usersQuery->get();

        $userIds = $users->pluck('id');
        $hasilPengerjaan = HasilPengerjaan::with('paketSoal')
            ->whereIn('user_id', $userIds)
            ->whereNotNull('waktu_selesai')
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('user_id');

        $dataSiswa = $users->map(function ($user) use ($hasilPengerjaan) {
            $nilai = [
                'kuis_1' => '-', 'kuis_2' => '-', 'kuis_3' => '-',
                'kuis_4' => '-', 'evaluasi' => '-',
            ];

            if (isset($hasilPengerjaan[$user->id])) {
                $riwayatPerPaket = $hasilPengerjaan[$user->id]->groupBy('paket_soal_id');
                $kkm = 70;

                foreach ($riwayatPerPaket as $paketId => $attempts) {
                    $judul = strtolower($attempts->first()->paketSoal->judul ?? '');
                    $skorPertama = $attempts->first()->skor_akhir;
                    $finalScore = null;

                    if ($skorPertama >= $kkm) {
                        $finalScore = $skorPertama;
                    } else {
                        $skorTertinggi = $attempts->max('skor_akhir');
                        $finalScore = ($skorTertinggi >= $kkm) ? $kkm : $skorTertinggi;
                    }

                    if (preg_match('/kuis[\s\-_]*1\b/i', $judul)) $nilai['kuis_1'] = $finalScore;
                    elseif (preg_match('/kuis[\s\-_]*2\b/i', $judul)) $nilai['kuis_2'] = $finalScore;
                    elseif (preg_match('/kuis[\s\-_]*3\b/i', $judul)) $nilai['kuis_3'] = $finalScore;
                    elseif (preg_match('/kuis[\s\-_]*4\b/i', $judul)) $nilai['kuis_4'] = $finalScore;
                    elseif (str_contains($judul, 'evaluasi')) $nilai['evaluasi'] = $finalScore;
                }
            }

            return [
                'user_id' => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'kelas'   => $user->kelas->nama_kelas ?? '-',
                'nilai'   => $nilai
            ];
        });

        return $dataSiswa->values();
    }

    /**
     * Tampilkan halaman data nilai dengan filter kelas hanya milik guru.
     */
    public function index(Request $request)
    {
        $guruId = Auth::id();
        // Hanya kelas yang diampu guru
        $listKelas = Kelas::where('guru_id', $guruId)->orderBy('nama_kelas')->get();

        $kelasId = $request->input('kelas_id');
        // Pastikan filter hanya jika kelas tersebut memang milik guru
        if ($kelasId && !$listKelas->contains('id', $kelasId)) {
            $kelasId = null;
        }

        $dataSiswa = $this->getProcessedData($kelasId);

        return view('guru.data_nilai', compact('dataSiswa', 'listKelas', 'kelasId'));
    }

    /**
     * Ekspor data nilai (hanya siswa dari kelas yang diampu guru).
     */
    public function export(Request $request)
    {
        $guruId = Auth::id();
        $kelasGuru = Kelas::where('guru_id', $guruId)->pluck('id');

        $kelasId = $request->input('kelas_id');
        if ($kelasId && !in_array($kelasId, $kelasGuru->toArray())) {
            $kelasId = null;
        }

        $dataSiswa = $this->getProcessedData($kelasId);
        $namaFile = 'rekap_nilai_' . ($kelasId ? 'kelas_' . $kelasId : 'semua_siswa') . '.xlsx';

        return Excel::download(new DataNilaiExport($dataSiswa), $namaFile);
    }

    /**
     * Tampilkan detail riwayat pengerjaan siswa (hanya jika siswa berada di kelas guru).
     */
    public function riwayat($userId)
    {
        $guruId = Auth::id();
        $kelasGuru = Kelas::where('guru_id', $guruId)->pluck('id');

        $siswa = \App\Models\User::where('role', 'siswa')->findOrFail($userId);
        if (!$kelasGuru->contains($siswa->kelas_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak melihat riwayat siswa ini.'
            ], 403);
        }

        $hasil = HasilPengerjaan::with(['paketSoal', 'jawabanSiswa' => function($q) {
                $q->orderBy('butir_soal_id', 'asc');
            }])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        $groupedData = [];

        foreach ($hasil as $item) {
            $paketJudul = $item->paketSoal->judul ?? 'Paket Dihapus';

            if (!isset($groupedData[$paketJudul])) {
                $groupedData[$paketJudul] = [];
            }

            $matrix = [];
            foreach ($item->jawabanSiswa as $jawaban) {
                $matrix[] = (int)$jawaban->benar === 1;
            }

            $statusLulus = $item->skor_akhir >= 70;
            $waktuBase = $item->waktu_mulai ? Carbon::parse($item->waktu_mulai) : $item->created_at;
            $tanggalFix = $waktuBase->format('d/m/Y');
            $jamMulai = $item->waktu_mulai ? Carbon::parse($item->waktu_mulai)->format('H:i:s') : '-';
            $jamSelesai = $item->waktu_selesai ? Carbon::parse($item->waktu_selesai)->format('H:i:s') : '-';

            $groupedData[$paketJudul][] = [
                'tanggal' => $tanggalFix,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'skor' => $item->skor_akhir,
                'status_lulus' => $statusLulus,
                'matrix' => $matrix,
                'total_soal' => count($matrix)
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $groupedData
        ]);
    }

    // Method show dan analisis (tidak diubah, opsional)
    public function show($id)
    {
        $hasil = HasilPengerjaan::with(['user', 'paketSoal', 'jawabanSiswa.butirSoal'])
            ->findOrFail($id);
        return response()->json(['success' => true, 'data' => $hasil]);
    }

    public function analisis(Request $request)
    {
        $listPaket = PaketSoal::all();
        $selectedPaket = null;
        $daftarSoal = [];
        $dataHasil = [];

        if ($request->has('paket_id') && $request->paket_id != '') {
            $paketId = $request->paket_id;
            $selectedPaket = PaketSoal::find($paketId);
            $daftarSoal = ButirSoal::where('paket_soal_id', $paketId)->orderBy('id')->get();
            $dataHasil = HasilPengerjaan::with(['user', 'jawabanSiswa'])
                ->where('paket_soal_id', $paketId)
                ->whereNotNull('user_id')
                ->latest()
                ->get();
        }

        return view('guru.analisis_nilai', compact('listPaket', 'selectedPaket', 'daftarSoal', 'dataHasil'));
    }
}