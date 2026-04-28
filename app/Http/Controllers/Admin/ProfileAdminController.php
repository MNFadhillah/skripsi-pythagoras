<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\AktivitasBelajar;
use App\Models\Kelas;

class ProfileAdminController extends Controller
{
    /**
     * Menampilkan halaman profil admin
     */
    public function index()
    {
        $user = Auth::user();

        // Statistik untuk dashboard admin
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru  = User::where('role', 'guru')->count();
        $totalKelas = Kelas::count();
        $totalAktivitas = AktivitasBelajar::count(); // jika ada model AktivitasBelajar

        return view('admin.profile', compact('user', 'totalSiswa', 'totalGuru', 'totalKelas', 'totalAktivitas'));
    }

    /**
     * Update profil admin (nama, email, password)
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed'
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Data profil berhasil diperbarui!'
        ]);
    }

    /**
     * Upload avatar profil
     */
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