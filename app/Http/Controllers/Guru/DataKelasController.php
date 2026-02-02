<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DataKelasController extends Controller
{
    public function index()
    {
        // Ambil kelas milik guru yang login
        $kelas = Kelas::where('guru_id', Auth::id())
                      ->withCount('siswa') // Hitung jumlah siswa
                      ->latest()
                      ->get();

        return view('guru.data_kelas', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        // Generate Token 5 Karakter
        do {
            $token = strtoupper(Str::random(5));
        } while (Kelas::where('token', $token)->exists());

        Kelas::create([
            'guru_id'    => Auth::id(),
            'nama_kelas' => $request->nama_kelas,
            'token'      => $token,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())->findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->back()->with('success', 'Nama kelas diperbarui!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())->findOrFail($id);
        $kelas->delete();

        return redirect()->back()->with('success', 'Kelas dihapus.');
    }
}