<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\AktivitasBelajar;
use App\Models\Kelas;

class ProfileGuruController extends Controller
{
    /**
     * Menampilkan halaman form profil
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Hitung Total Aktivitas (Ini tetap menghitung keseluruhan aktivitas yang tersedia)
        $totalAktivitas = AktivitasBelajar::count();

        // 2. Ambil Data Kelas yang Diampu oleh Guru ini (Maksimal 1 Kelas)
        // Catatan: Sesuaikan 'guru_id' dengan nama kolom di tabel 'kelas' yang menyimpan ID guru.
        $kelas = Kelas::where('guru_id', $user->id)->first();

        // 3. Tentukan Nama Kelas & Hitung Total Siswa Spesifik di Kelas Tersebut
        if ($kelas) {
            $kelasDiampu = $kelas->nama_kelas;

            // Catatan: Sesuaikan 'kelas_id' dengan nama kolom di tabel 'users' yang menyimpan ID kelas siswa.
            // Kita juga bisa menambahkan kondisi tambahan (seperti where role = siswa) jika diperlukan.
            $totalSiswa = User::where('kelas_id', $kelas->id)
                ->where('id', '!=', $user->id)
                ->count();
        } else {
            $kelasDiampu = 'Belum memiliki kelas';
            $totalSiswa  = 0;
        }

        // Variabel $totalKelas dihapus karena guru hanya mengampu 1 kelas.
        // Pastikan variabel ini juga sudah dihapus/diganti di file Blade (profil.blade.php) sesuai pembaruan sebelumnya.
        return view('guru.profil', compact('user', 'totalAktivitas', 'totalSiswa', 'kelasDiampu'));
    }

    /**
     * Memproses update data profil
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        // Validasi input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed' // Confirmed butuh input 'password_confirmation'
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Update data
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Data profil berhasil diperbarui!'
        ]);
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::find(Auth::id());

        // Hapus avatar lama jika ada
        if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        // Simpan avatar baru
        $avatarName = time() . '_' . $user->id . '.' . $request->avatar->extension();
        $request->avatar->storeAs('avatars', $avatarName, 'public');

        $user->avatar = $avatarName;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui!'
        ]);
    }
}
