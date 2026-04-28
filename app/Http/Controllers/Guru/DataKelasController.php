<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class DataKelasController extends Controller
{
    public function index()
    {
        // Ambil kelas milik guru yang login
        $kelas = Kelas::where('guru_id', Auth::id())
                      ->withCount('siswa') // Hitung jumlah siswa
                      ->with(['siswa', 'aktivitas']) // <--- TAMBAHAN: Load data siswa & aktivitas
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
    // Di dalam class DataKelasController

    public function manageStudents($id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())->with('siswa')->findOrFail($id);
        $siswaDiKelas = $kelas->siswa;
        $siswaBelum = User::where('role', 'siswa')->whereNull('kelas_id')->get();
        return view('guru.kelas_students', compact('kelas', 'siswaDiKelas', 'siswaBelum'));
    }

    public function addStudent(Request $request, $id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())->findOrFail($id);
        $request->validate(['student_id' => 'required|exists:users,id']);
        $siswa = User::findOrFail($request->student_id);
        if ($siswa->role !== 'siswa') {
            return response()->json(['success' => false, 'message' => 'User bukan siswa'], 422);
        }
        $siswa->update(['kelas_id' => $id]);
        return response()->json(['success' => true, 'message' => 'Siswa ditambahkan ke kelas']);
    }

    public function removeStudent($kelasId, $studentId)
    {
        $kelas = Kelas::where('guru_id', Auth::id())->findOrFail($kelasId);
        $siswa = User::findOrFail($studentId);
        if ($siswa->kelas_id == $kelasId) {
            $siswa->update(['kelas_id' => null]);
            return response()->json(['success' => true, 'message' => 'Siswa dikeluarkan dari kelas']);
        }
        return response()->json(['success' => false, 'message' => 'Siswa tidak berada di kelas ini'], 422);
    }
    
}