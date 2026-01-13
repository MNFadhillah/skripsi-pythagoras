<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ButirSoal;
use App\Models\PaketSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DataSoalController extends Controller
{
    public function data_soal()
    {
        $soal = ButirSoal::with('paketSoal')
            ->orderBy('created_at', 'desc')
            ->get();

        $paketSoal = PaketSoal::orderBy('judul')->get();

        return view('guru.data_soal', compact('soal', 'paketSoal'));
    }

    public function data_soal_json($id)
    {
        try {
            $soal = ButirSoal::with('paketSoal')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'pertanyaan' => $soal->pertanyaan,
                'opsi_jawaban' => $soal->opsi_jawaban,
                'kunci_jawaban' => $soal->kunci_jawaban,
                'paket_soal' => $soal->paketSoal->judul ?? 'Tidak ada paket',
                'created_at' => $soal->created_at->format('d-m-Y H:i'),
                'updated_at' => $soal->updated_at->format('d-m-Y H:i')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_soal_id' => 'required',
            'pertanyaan'    => 'required',
            'opsi'          => 'required|array',
            'kunci_jawaban' => 'required',
            'gambar'        => 'nullable|image|max:2048',
        ]);

        $pertanyaanData = [
            'text' => trim($request->pertanyaan),
            'image' => null 
        ];

        // LOGIKA UPLOAD LANGSUNG KE PUBLIC
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = 'soal_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Tentukan tujuan langsung ke folder public
            $tujuanUpload = public_path('storage/soal');
            
            // Buat folder jika belum ada
            if (!File::exists($tujuanUpload)) {
                File::makeDirectory($tujuanUpload, 0755, true);
            }

            // Pindahkan file ke sana
            $file->move($tujuanUpload, $namaFile);
            
            // Simpan path database
            $pertanyaanData['image'] = '/storage/soal/' . $namaFile;
        }

        // Format Opsi
        $opsiFormatted = [];
        foreach ($request->opsi as $key => $val) {
            $opsiFormatted[$key] = [
                'text'  => $val['text'] ?? '',
                'image' => null 
            ];
        }

        ButirSoal::create([
            'paket_soal_id' => $request->paket_soal_id,
            'pertanyaan'    => $pertanyaanData,
            'opsi_jawaban'  => $opsiFormatted,
            'kunci_jawaban' => $request->kunci_jawaban,
        ]);

        return response()->json(['success' => true, 'message' => 'Soal berhasil ditambahkan']);
    }

    public function destroy($id)
    {
        try {
            $soal = ButirSoal::findOrFail($id);

            // Jika pertanyaan STRING → cari & hapus gambar
            $pertanyaan = $soal->pertanyaan;
            
            // Convert to string if it's an array
            if (is_array($pertanyaan)) {
                $pertanyaan = json_encode($pertanyaan);
            }
            
            if (is_string($pertanyaan)) {
                preg_match_all(
                    '/\/storage\/([^\s"]+\.(jpg|jpeg|png|gif|webp))/i',
                    $pertanyaan,
                    $matches
                );

                if (!empty($matches[1])) {
                    foreach ($matches[1] as $path) {
                        if (Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                }
            }

            // HAPUS DATA
            $soal->delete();

            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function editJson($id)
    {
        try {
            $soal = ButirSoal::findOrFail($id);
            
            // Normalisasi data pertanyaan (Array/Object/String)
            $rawPertanyaan = $soal->pertanyaan;
            $text = '';
            $gambar = null;

            if (is_array($rawPertanyaan) || is_object($rawPertanyaan)) {
                $data = (array) $rawPertanyaan;
                $text = $data['text'] ?? '';
                // Ambil path gambar
                $gambar = $data['image'] ?? $data['gambar'] ?? null;
            } 
            elseif (is_string($rawPertanyaan)) {
                $text = $rawPertanyaan;
                // Regex ambil gambar dari string legacy
                if (preg_match('/\/storage\/soal\/[^\s"]+\.(jpg|jpeg|png|gif|webp)/i', $text, $m)) {
                    $gambar = $m[0]; 
                    $text = str_replace($m[0], '', $text);
                }
            }

            return response()->json([
                'success' => true,
                'id' => $soal->id,
                'paket_soal_id' => $soal->paket_soal_id,
                'pertanyaan' => trim($text), // Teks pertanyaan bersih
                'gambar' => $gambar,         // Path gambar (misal: /storage/soal/abc.jpg)
                'opsi' => $soal->opsi_jawaban,
                'kunci_jawaban' => $soal->kunci_jawaban,
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memuat data'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $soal = ButirSoal::findOrFail($id);

        $request->validate([
            'paket_soal_id'   => 'required',
            'pertanyaan_text' => 'required',
            'opsi'            => 'required|array',
            'kunci_jawaban'   => 'required|in:A,B,C,D',
            'gambar'          => 'nullable|image|max:2048'
        ]);

        // 1. Siapkan Struktur Data Baru
        $pertanyaanData = [
            'text' => trim($request->pertanyaan_text),
            'image' => null
        ];

        // 2. Cari Gambar Lama (untuk dihapus nanti jika perlu)
        $oldImage = null;
        if (is_array($soal->pertanyaan)) {
            $oldImage = $soal->pertanyaan['image'] ?? $soal->pertanyaan['gambar'] ?? null;
        } elseif (is_string($soal->pertanyaan)) {
             if (preg_match('/\/storage\/soal\/[^\s"]+/', $soal->pertanyaan, $m)) $oldImage = $m[0];
        }

        // 3. LOGIKA UPDATE GAMBAR (SINKRON DENGAN PUBLIC FOLDER)
        
        // KASUS A: User mencentang Hapus Gambar
        if ($request->has('hapus_gambar') && $request->hapus_gambar == '1') {
            if ($oldImage) {
                // Hapus file fisik lama
                $path = public_path(ltrim($oldImage, '/')); 
                if (File::exists($path)) File::delete($path);
            }
            $pertanyaanData['image'] = null;
        } 
        // KASUS B: User Upload Gambar Baru
        elseif ($request->hasFile('gambar')) {
            // Hapus file fisik lama dulu (biar tidak nyampah)
            if ($oldImage) {
                $path = public_path(ltrim($oldImage, '/'));
                if (File::exists($path)) File::delete($path);
            }

            // Simpan file baru
            $file = $request->file('gambar');
            $namaFile = 'soal_' . time() . '.' . $file->getClientOriginalExtension();
            $tujuan = public_path('storage/soal');
            
            // Pastikan folder ada
            if (!File::exists($tujuan)) File::makeDirectory($tujuan, 0755, true);

            $file->move($tujuan, $namaFile);
            
            $pertanyaanData['image'] = '/storage/soal/' . $namaFile;
        } 
        // KASUS C: Tidak diapa-apain (Keep Gambar Lama)
        else {
            $pertanyaanData['image'] = $oldImage;
        }

        // 4. Format Opsi
        $opsiFormatted = [];
        foreach ($request->opsi as $k => $v) {
            $opsiFormatted[$k] = [
                'text' => $v['text'] ?? '',
                'image' => null // (Future proofing)
            ];
        }

        // 5. Simpan ke Database
        $soal->update([
            'paket_soal_id' => $request->paket_soal_id,
            'pertanyaan'    => $pertanyaanData,
            'opsi_jawaban'  => $opsiFormatted,
            'kunci_jawaban' => $request->kunci_jawaban
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Soal berhasil diperbarui'
        ]);
    }


}