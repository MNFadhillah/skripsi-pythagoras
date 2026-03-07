<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
       PROSES LOGIN
    ====================== */
    /* =====================
       PROSES LOGIN
    ====================== */
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

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'guru') {
                return redirect()->route('guru.dashboard');
            }

            return redirect()->route('siswa.menu.dashboard');
        }

        return back()->withErrors([
            // Update pesan error (hapus kata "peran")
            'email' => 'Email atau password salah.',
        ]);
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
