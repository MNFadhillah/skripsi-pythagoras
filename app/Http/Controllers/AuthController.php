<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;

class AuthController extends Controller
{
    /* =====================
       TAMPILAN LOGIN
    ====================== */
    public function showLogin()
    {
        return view('auth.login');
    }

    /* =====================
       PROSES LOGIN (DIPERBAIKI)
    ====================== */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Tambahkan pesan sukses
            session()->flash('success', 'Login berhasil! Selamat datang, ' . Auth::user()->name);

            // Redirect berdasarkan role
            $role = Auth::user()->role;
            if ($role === 'guru') {
                return redirect()->route('guru.dashboard');
            } elseif ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('siswa.menu.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    /* =====================
       TAMPILAN REGISTER
    ====================== */
    public function showRegister()
    {
        return view('auth.register');
    }

    /* =====================
       PROSES REGISTER
    ====================== */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:siswa,guru',
            // Validasi khusus token guru
            'guru_token' => [
                'required_if:role,guru',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->role === 'guru') {
                        // Cek token di database
                        $tokenSetting = Setting::where('key', 'guru_token')->first();

                        // Jika Admin BELUM mengatur token sama sekali di database
                        if (!$tokenSetting || empty($tokenSetting->value)) {
                            $fail('Pendaftaran Guru saat ini ditutup karena Token belum dikonfigurasi oleh Admin.');
                            return; // Hentikan pengecekan lebih lanjut
                        }

                        // Jika token yang dimasukkan tidak sama dengan yang ada di database
                        if ($value !== $tokenSetting->value) {
                            $fail('Token registrasi Guru tidak valid atau salah.');
                        }
                    }
                },
            ],
        ], [
            'guru_token.required_if' => 'Token registrasi wajib diisi untuk mendaftar sebagai Guru.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    /* =====================
       LOGOUT
    ====================== */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}
