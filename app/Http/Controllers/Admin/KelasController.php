<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KelasController extends Controller
{
    public function index()
    {
        return view('admin.kelas.index');
    }

    public function data()
    {
        $kelas = Kelas::with('waliKelas')->select('kelas.*');
        return DataTables::of($kelas)
            ->addIndexColumn()
            ->addColumn('wali_kelas', function ($kelas) {
                return $kelas->waliKelas ? $kelas->waliKelas->name : '-';
            })
            ->addColumn('jumlah_siswa', function ($kelas) {
                return $kelas->siswa()->count();
            })
            ->addColumn('actions', function ($kelas) {
                $btn = '<button class="btn btn-sm btn-info detail-kelas text-white mb-1" data-id="' . $kelas->id . '" data-nama="' . $kelas->nama_kelas . '" title="Detail"><i class="bi bi-eye"></i></button> ';

                // TOMBOL BARU: KELOLA GURU
                $btn .= '<button class="btn btn-sm btn-outline-success kelola-guru mb-1" data-id="' . $kelas->id . '" data-nama="' . $kelas->nama_kelas . '" title="Kelola Guru"><i class="bi bi-person-badge"></i> Guru</button> ';

                $btn .= '<button class="btn btn-sm btn-success manage-siswa mb-1" data-id="' . $kelas->id . '" data-nama="' . $kelas->nama_kelas . '"><i class="bi bi-people"></i> Siswa</button> ';
                $btn .= '<button class="btn btn-sm btn-secondary edit-kelas mb-1" data-id="' . $kelas->id . '" title="Edit"><i class="bi bi-pencil"></i></button> ';
                $btn .= '<button class="btn btn-sm btn-danger delete-kelas mb-1" data-id="' . $kelas->id . '" data-nama="' . $kelas->nama_kelas . '" title="Hapus"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas',
            'guru_id'    => 'nullable|exists:users,id|in:' . User::where('role', 'guru')->pluck('id')->implode(','),
            'token'      => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $kelas = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'guru_id'    => $request->guru_id,
            'token'      => $request->token ?? $this->generateToken(),
        ]);

        return response()->json(['success' => true, 'message' => 'Kelas berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return response()->json($kelas);
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas,' . $id,
            'guru_id'    => 'nullable|exists:users,id',
            'token'      => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $kelas->update($request->only('nama_kelas', 'guru_id', 'token'));
        return response()->json(['success' => true, 'message' => 'Kelas berhasil diupdate']);
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        // Hapus relasi siswa (set kelas_id menjadi null)
        User::where('kelas_id', $id)->update(['kelas_id' => null]);
        $kelas->delete();
        return response()->json(['success' => true, 'message' => 'Kelas dihapus']);
    }

    public function updateGuru(Request $request, $id)
    {
        try {
            $kelas = Kelas::findOrFail($id);

            // Validasi: pastikan jika diisi, ID-nya ada di tabel users
            $request->validate([
                'guru_id' => 'nullable|exists:users,id'
            ], [
                'guru_id.exists' => 'Guru yang dipilih tidak valid atau sudah dihapus.'
            ]);

            // Simpan perubahan
            $kelas->guru_id = $request->guru_id;
            $kelas->save();

            // Refresh model agar Laravel menarik data relasi (waliKelas) yang terbaru
            $kelas->refresh();

            $namaGuru = $kelas->waliKelas ? $kelas->waliKelas->name : 'Dikosongkan';

            return response()->json([
                'success' => true,
                'message' => 'Guru pengampu berhasil diubah menjadi: ' . $namaGuru
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Menangkap error validasi
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Menangkap error database / server
            return response()->json([
                'success' => false,
                'message' => 'Sistem Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // ===================== MANAJEMEN SISWA DALAM KELAS =====================
    public function manageStudents($id)
    {
        $kelas = Kelas::with('siswa')->findOrFail($id);
        $siswaDiKelas = $kelas->siswa;
        $siswaBelum = User::where('role', 'siswa')->whereNull('kelas_id')->get();
        return view('admin.kelas.students', compact('kelas', 'siswaDiKelas', 'siswaBelum'));
    }

    public function addStudent(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id'
        ]);
        $siswa = User::findOrFail($request->student_id);
        if ($siswa->role !== 'siswa') {
            return response()->json(['success' => false, 'message' => 'User bukan siswa'], 422);
        }
        if ($siswa->kelas_id !== null) {
            return response()->json(['success' => false, 'message' => 'Siswa sudah memiliki kelas lain'], 422);
        }
        $siswa->kelas_id = $id;
        $siswa->save();
        return response()->json(['success' => true, 'message' => 'Siswa ditambahkan ke kelas']);
    }

    public function removeStudent($kelasId, $studentId)
    {
        $siswa = User::findOrFail($studentId);
        if ($siswa->kelas_id == $kelasId) {
            $siswa->kelas_id = null;
            $siswa->save();
            return response()->json(['success' => true, 'message' => 'Siswa dikeluarkan dari kelas']);
        }
        return response()->json(['success' => false, 'message' => 'Siswa tidak berada di kelas ini'], 422);
    }

    private function generateToken($length = 5)
    {
        return strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length));
    }
    public function detail($id)
    {
        $kelas = Kelas::with('siswa', 'aktivitas')->findOrFail($id);
        return response()->json([
            'siswa' => $kelas->siswa->map(fn($s) => ['name' => $s->name, 'email' => $s->email]),
            'aktivitas' => $kelas->aktivitas->map(fn($a) => ['judul' => $a->judul, 'tipe' => $a->tipe ?? 'Kuis'])
        ]);
    }
    // ===================== PENGATURAN TOKEN GURU =====================
    public function updateTokenGuru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guru_token' => 'required|string|min:5'
        ], [
            'guru_token.required' => 'Token registrasi tidak boleh kosong.',
            'guru_token.min' => 'Token minimal harus terdiri dari 5 karakter.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        Setting::updateOrCreate(
            ['key' => 'guru_token'],
            ['value' => $request->guru_token]
        );

        return response()->json([
            'success' => true,
            'message' => 'Token Registrasi Guru berhasil diperbarui!'
        ]);
    }
}
