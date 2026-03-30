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

        // 1. Hitung Total Aktivitas
        $totalAktivitas = AktivitasBelajar::count();

        // 2. Hitung Total Kelas
        $totalKelas = Kelas::count();

        // 3. Ambil Nama Kelas yang Diampu (Gabungkan dengan koma)
        $kelasDiampu = Kelas::pluck('nama_kelas')->implode(', ');
        if (empty($kelasDiampu)) {
            $kelasDiampu = 'Belum ada kelas yang terdaftar.';
        }

        // 4. Hitung Total Siswa 
        // (Asumsi: di tabel users ada kolom 'role'='siswa', sesuaikan jika strukturmu berbeda. 
        // Jika tidak ada role, bisa pakai trik menghitung semua user kecuali guru itu sendiri: User::where('id', '!=', $user->id)->count())
        $totalSiswa = User::where('id', '!=', $user->id)->count(); 

        return view('guru.profil', compact('user', 'totalAktivitas', 'totalKelas', 'totalSiswa', 'kelasDiampu'));
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