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

class DataNilaiController extends Controller
{

    // Terima parameter kelasId (bisa null jika pilih "Semua Kelas")
    private function getProcessedData($kelasId = null)
    {
        // 1. Mulai Query
        $query = HasilPengerjaan::with(['user.kelas', 'paketSoal'])
            ->whereNotNull('user_id');

        // 2. JIKA ADA FILTER KELAS, TAMBAHKAN KONDISI "WHERE HAS"
        if ($kelasId) {
            $query->whereHas('user', function($q) use ($kelasId) {
                // Asumsi nama kolom foreign key di tabel users adalah 'kelas_id'
                $q->where('kelas_id', $kelasId);
            });
        }
// AMBIL YANG TERBARU DULU
        $hasilPengerjaan = $query->orderBy('created_at', 'asc')->get();

        $dataSiswa = $hasilPengerjaan->groupBy('user_id')->map(function ($items) {
            $user = $items->first()->user;
            
            $nilai = [
                'kuis_1' => '-', 'kuis_2' => '-', 'kuis_3' => '-', 
                'kuis_4' => '-', 'evaluasi' => '-',
            ];

            foreach ($items as $item) {
                $judul = strtolower($item->paketSoal->judul ?? '');
                
                // PERBAIKAN LOGIC STRING MATCHING
                // Menggunakan regex word boundary agar 'kuis 1' tidak tertukar dengan 'kuis 10'
                if (preg_match('/\bkuis 1\b/', $judul)) $nilai['kuis_1'] = $item->skor_akhir;
                elseif (preg_match('/\bkuis 2\b/', $judul)) $nilai['kuis_2'] = $item->skor_akhir;
                elseif (preg_match('/\bkuis 3\b/', $judul)) $nilai['kuis_3'] = $item->skor_akhir;
                elseif (preg_match('/\bkuis 4\b/', $judul)) $nilai['kuis_4'] = $item->skor_akhir;
                elseif (str_contains($judul, 'evaluasi')) $nilai['evaluasi'] = $item->skor_akhir;
            }

            return [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'kelas' => $user->kelas->nama_kelas ?? '-',
                'nilai' => $nilai
            ];
        })->values();

        return $dataSiswa;
    }

    public function index(Request $request)
    {
        // Ambil filter dari URL (misal: ?kelas_id=1)
        $kelasId = $request->input('kelas_id');
        
        // Ambil data siswa yang sudah difilter
        $dataSiswa = $this->getProcessedData($kelasId);

        // Ambil daftar kelas untuk Dropdown Filter
        $listKelas = Kelas::all(); 

        return view('guru.data_nilai', compact('dataSiswa', 'listKelas', 'kelasId'));
    }

    public function export(Request $request) 
    {
        // Ambil filter dari URL juga saat klik tombol export
        $kelasId = $request->input('kelas_id');
        
        // Ambil data yang sama persis dengan yang ada di tabel
        $dataSiswa = $this->getProcessedData($kelasId);

        // Beri nama file yang dinamis (Opsional)
        $namaFile = 'rekap_nilai_' . ($kelasId ? 'kelas_'.$kelasId : 'semua_siswa') . '.xlsx';
        
        return Excel::download(new DataNilaiExport($dataSiswa), $namaFile);
    }




    public function show($id)
    {
        // Eager Load relasi jawaban detail
        $hasil = HasilPengerjaan::with(['user', 'paketSoal', 'jawabanSiswa.butirSoal'])
                ->findOrFail($id);

        // KITA RETURN JSON AGAR BISA DIOLAH DI SATU HALAMAN BLADE
        return response()->json([
            'success' => true,
            'data' => $hasil
        ]);
    }

    public function analisis(Request $request)
    {
        // 1. Ambil semua paket soal untuk dropdown filter
        $listPaket = PaketSoal::all();
        
        $selectedPaket = null;
        $daftarSoal = [];
        $dataHasil = [];

        // 2. Jika guru sudah memilih paket soal
        if ($request->has('paket_id') && $request->paket_id != '') {
            $paketId = $request->paket_id;
            $selectedPaket = PaketSoal::find($paketId);

            // Ambil daftar soal (untuk header tabel 1, 2, 3...) urut berdasarkan ID atau nomor
            $daftarSoal = ButirSoal::where('paket_soal_id', $paketId)->orderBy('id')->get();

            // Ambil hasil pengerjaan siswa pada paket ini
            // Eager load 'jawabanSiswa' agar tidak berat query-nya
            $dataHasil = HasilPengerjaan::with(['user', 'jawabanSiswa'])
                        ->where('paket_soal_id', $paketId)
                        ->whereNotNull('user_id')
                        ->latest()
                        ->get();
        }

        return view('guru.analisis_nilai', compact('listPaket', 'selectedPaket', 'daftarSoal', 'dataHasil'));
    }

// --- PERBAIKAN UTAMA DI SINI ---
    public function riwayat($userId)
    {
        $hasil = HasilPengerjaan::with(['paketSoal', 'jawabanSiswa' => function($q) {
                        // WAJIB SORTING JAWABAN AGAR MATRIX S1, S2 KONSISTEN
                        // Asumsi ada butir_soal_id, kita urutkan berdasarkan ID soalnya
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

            // Logic Status
            $statusLulus = $item->skor_akhir >= 70;

            // FORMATTING TANGGAL & JAM UNTUK JSON
            // Kita pisahkan di sini supaya JS tidak perlu mikir (tinggal tampilkan)
            
            // 1. Tanggal (Ambil dari waktu mulai, kalau null ambil created_at)
            $waktuBase = $item->waktu_mulai ? Carbon::parse($item->waktu_mulai) : $item->created_at;
            $tanggalFix = $waktuBase->format('d/m/Y'); // Format: 28/01/2026

            // 2. Jam Mulai
            $jamMulai = $item->waktu_mulai ? Carbon::parse($item->waktu_mulai)->format('H:i:s') : '-';

            // 3. Jam Selesai
            $jamSelesai = $item->waktu_selesai ? Carbon::parse($item->waktu_selesai)->format('H:i:s') : '-';

            $groupedData[$paketJudul][] = [
                'tanggal' => $tanggalFix,
                'jam_mulai' => $jamMulai,     // Mengirim key baru biar jelas
                'jam_selesai' => $jamSelesai, // Mengirim key baru biar jelas
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
}