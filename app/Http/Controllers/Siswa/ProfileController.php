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

        // 1. Hitung Progres Keseluruhan (Sinkron 100% dengan ProgressController)
        $totalProgress = $this->hitungTotalProgress($userId);

        // 2. Hitung Rata-rata Skor Kuis (Sinkron dengan Halaman Nilai Siswa)
        $rataRataKuis = $this->hitungRataRataKuisRemedial($userId);

        // 3. Ambil Data Lencana (Badge)
        $semuaLencana = Badge::all();
        $lencanaSiswa = $user->badges()->pluck('badges.id')->toArray();
        $totalLencanaTerkumpul = count($lencanaSiswa);

        // Hitung berapa kuis yang SUDAH dikerjakan minimal 1 kali
        $jumlahKuisDikerjakan = HasilPengerjaan::where('user_id', $userId)
                                ->select('paket_soal_id')
                                ->distinct()
                                ->count();

        return view('siswa.profile', compact(
            'user', 
            'totalProgress', 
            'rataRataKuis', 
            'jumlahKuisDikerjakan', 
            'semuaLencana', 
            'lencanaSiswa', 
            'totalLencanaTerkumpul'
        ));
    }

    /**
     * Helper untuk menghitung total progres keseluruhan (materi + kuis)
     * DISAMAKAN PERSIS LOGIKANYA DENGAN ProgressController
     */
    private function hitungTotalProgress($userId)
    {
        $totalCheckpoint = [
            'materi_1_konsep_pythagoras'   => 16,
            'materi_2_tripel_pythagoras'   => 8,
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

    /**
     * Menyimpan/Update Foto Profil (Avatar) Siswa
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        $user = User::find(Auth::id());

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke folder public/images/avatars
            $file->move(public_path('images/avatars'), $filename);

            // Hapus foto lama jika bukan foto default
            if ($user->avatar && file_exists(public_path('images/avatars/' . $user->avatar))) {
                unlink(public_path('images/avatars/' . $user->avatar));
            }

            // Update database
            $user->avatar = $filename;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui!',
                'avatar_url' => asset('images/avatars/' . $filename)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah gambar.']);
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

