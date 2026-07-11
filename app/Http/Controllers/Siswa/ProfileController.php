<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\progres_siswa;
use App\Models\HasilPengerjaan;
use App\Models\PaketSoal;
use App\Models\Badge;

class ProfileController extends Controller
{
public function index()
    {
        /** @var \App\Models\User $user */  
        $user = Auth::user();
        $userId = $user->id;

        // 1. Hitung Progres Keseluruhan
        $totalProgress = $this->hitungTotalProgress($userId);

        // 2. Hitung Rata-rata Skor Kuis
        $rataRataKuis = $this->hitungRataRataKuisRemedial($userId);

        // 3. Ambil Data Lencana (Badge)
        $semuaLencana = Badge::all();
        $lencanaSiswa = $user->badges()->pluck('badges.id')->toArray();
        $totalLencanaTerkumpul = count($lencanaSiswa);

        // 4. Hitung berapa kuis yang SUDAH dikerjakan
        $jumlahKuisDikerjakan = HasilPengerjaan::where('user_id', $userId)
                                ->select('paket_soal_id')
                                ->distinct()
                                ->count();

        // 5. AMBIL DAFTAR AVATAR BAWAAN SISTEM (BARIS INI YANG TERLEWATKAN)
        $daftarAvatar = $this->getSystemAvatars();

        return view('siswa.profile', compact(
            'user', 
            'totalProgress', 
            'rataRataKuis', 
            'jumlahKuisDikerjakan', 
            'semuaLencana', 
            'lencanaSiswa', 
            'totalLencanaTerkumpul',
            'daftarAvatar' 
        ));
    }

    /**
     * Helper untuk menghitung total progres keseluruhan (materi + kuis)
     * DISAMAKAN PERSIS LOGIKANYA DENGAN ProgressController
     */
    private function hitungTotalProgress($userId)
    {
        $totalCheckpoint = [
            'materi_1_konsep_pythagoras'   => 15,
            'materi_2_tripel_pythagoras'   => 9,
            'materi_3_segitiga_istimewa'   => 6,
            'materi_4_penerapan_pythagoras' => 8,
        ];

        $persenMateri = [];
        foreach ($totalCheckpoint as $materiId => $total) {
            $selesai = progres_siswa::where('user_id', $userId)->where('materi_id', $materiId)->count();
            $persen = ($total > 0) ? round(($selesai / $total) * 100) : 0;
            $persenMateri[] = min($persen, 100);
        }

        $progKuis = [0, 0, 0, 0, 0];
        $semuaPaket = PaketSoal::orderBy('id', 'asc')->get();
        foreach ($semuaPaket as $paket) {
            $namaPaket = strtolower($paket->nama_paket ?? $paket->judul);
            $sudah = HasilPengerjaan::where('user_id', $userId)->where('paket_soal_id', $paket->id)->exists();
            if ($sudah) {
                if (str_contains($namaPaket, 'kuis 1')) $progKuis[0] = 100;
                elseif (str_contains($namaPaket, 'kuis 2')) $progKuis[1] = 100;
                elseif (str_contains($namaPaket, 'kuis 3')) $progKuis[2] = 100;
                elseif (str_contains($namaPaket, 'kuis 4')) $progKuis[3] = 100;
                elseif (str_contains($namaPaket, 'evaluasi')) $progKuis[4] = 100;
            }
        }

        $totalSemuaPersen = array_sum($persenMateri) + array_sum($progKuis);
        $jumlahKomponen = count($totalCheckpoint) + 5;
        
        return round($totalSemuaPersen / $jumlahKomponen);
    }

    /**
     * Helper untuk menghitung Rata-rata Kuis menggunakan aturan Pengayaan & Remedial
     */
    private function hitungRataRataKuisRemedial($userId)
    {
        $semuaPaket = PaketSoal::all();
        $totalSkor = 0;
        $jumlahPaketDiambil = 0;
        $kkm = 70; 

        foreach ($semuaPaket as $paket) {
            $riwayatPaket = HasilPengerjaan::where('paket_soal_id', $paket->id)
                                ->where('user_id', $userId)
                                ->whereNotNull('waktu_selesai')
                                ->orderBy('created_at', 'asc')
                                ->get();

            if ($riwayatPaket->count() > 0) {
                $skorPertama = $riwayatPaket->first()->skor_akhir;
                $finalScore = null;

                if ($skorPertama >= $kkm) {
                    $finalScore = $skorPertama; 
                } else {
                    $skorTertinggi = $riwayatPaket->max('skor_akhir');
                    if ($skorTertinggi >= $kkm) {
                        $finalScore = $kkm;
                    } else {
                        $finalScore = $skorTertinggi; 
                    }
                }

                $totalSkor += $finalScore; 
                $jumlahPaketDiambil++;
            }
        }

        if ($jumlahPaketDiambil > 0) {
            $rataRataAngka = round($totalSkor / $jumlahPaketDiambil, 1);
            return str_replace('.', ',', $rataRataAngka); 
        }

        return 0;
    }

    private function getSystemAvatars()
    {
        return [
            ['nama' => 'Avatar 1', 'file' => 'avatar1.png', 'harga' => 0],
            ['nama' => 'Avatar 2', 'file' => 'avatar2.png', 'harga' => 0],
            ['nama' => 'Avatar 3', 'file' => 'avatar3.png', 'harga' => 50], // Butuh 50 Poin
            ['nama' => 'Avatar 4', 'file' => 'avatar4.png', 'harga' => 100], // Butuh 100 Poin
            ['nama' => 'Avatar 5', 'file' => 'avatar5.png', 'harga' => 200], // Butuh 200 Poin
            ['nama' => 'Avatar 6', 'file' => 'avatar6.png', 'harga' => 0], // Butuh 200 Poin
            ['nama' => 'Avatar 7', 'file' => 'avatar7.png', 'harga' => 0],
            ['nama' => 'Avatar 8', 'file' => 'avatar8.png', 'harga' => 50],
            ['nama' => 'Avatar 9', 'file' => 'avatar9.png', 'harga' => 100], // Butuh 50 Poin
            ['nama' => 'Avatar 10', 'file' => 'avatar10.png', 'harga' => 200], // Butuh 100 Poin
        ];
    }

    public function selectSystemAvatar(Request $request)
    {
        // PERBAIKAN 1: Sintaks Validasi yang Benar
        $request->validate([
            'avatar_file' => 'required|string'
        ]);

        $user = User::find(Auth::id());
        $avatars = $this->getSystemAvatars();
        
        $chosenAvatar = collect($avatars)->firstWhere('file', $request->avatar_file);

        if (!$chosenAvatar) {
            return response()->json(['success' => false, 'message' => 'Format avatar tidak dikenali.'], 422);
        }

        // VALIDASI SEBAGAI SYARAT THRESHOLD / MILESTONE
        if ($user->points < $chosenAvatar['harga']) {
            return response()->json([
                'success' => false, 
                'message' => 'Kamu harus mengumpulkan minimal ' . $chosenAvatar['harga'] . ' poin untuk membuka karakter ini!'
            ], 400);
        }

        // PENGAMAN FILE: Hapus file lama jika merupakan hasil unggahan mandiri
        $path = public_path('images/avatars');
        if ($user->avatar && !str_starts_with($user->avatar, 'avatar') && file_exists($path . '/' . $user->avatar)) {
            try {
                unlink($path . '/' . $user->avatar);
            } catch (\Exception $e) {
                // Lewati jika file gagal dihapus secara fisik
            }
        }

        // Simpan karakter ke kolom avatar pengguna
        $user->avatar = $chosenAvatar['file'];
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Avatar berhasil digunakan!',
            'avatar_url' => asset('images/avatars/' . $chosenAvatar['file']),
            'new_points' => $user->points 
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::find(Auth::id());

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            $path = public_path('images/avatars');
            
            // Pengaman: Buat folder otomatis jika belum tersedia di direktori proyek
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $filename);

            // Hapus file lama jika merupakan hasil unggahan mandiri
            if ($user->avatar && !str_starts_with($user->avatar, 'avatar') && file_exists($path . '/' . $user->avatar)) {
                try {
                    unlink($path . '/' . $user->avatar);
                } catch (\Exception $e) {
                    // Lewati jika file tidak ditemukan
                }
            }

            $user->avatar = $filename;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui!',
                'avatar_url' => asset('images/avatars/' . $filename)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah gambar.'], 400);
    }

    /**
     * Memperbarui Nama dan Password Siswa
     */
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        // Aturan validasi dasar
        $rules = [
            'name' => 'required|string|max:255',
        ];

        // Jika siswa mengisi kolom password, tambahkan aturan validasi password
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        // Update Nama
        $user->name = $request->name;

        // Update Password (Jika diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}

