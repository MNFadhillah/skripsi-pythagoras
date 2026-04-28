<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get(); // tambahkan ini
        return view('admin.users.index', compact('kelasList'));
    }

    public function data(Request $request)
    {
        $users = User::with('kelas')->select('users.*');
        return DataTables::of($users)
            ->addIndexColumn()  // <-- Tambahkan ini untuk nomor urut
            ->addColumn('kelas_name', function ($user) {
                return $user->kelas ? $user->kelas->nama_kelas : '-';
            })
            ->addColumn('actions', function ($user) {
                $btn = '<button class="btn btn-sm btn-primary edit-user" data-id="'.$user->id.'" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-pencil"></i></button> ';
                $btn .= '<button class="btn btn-sm btn-warning reset-pwd" data-id="'.$user->id.'" data-name="'.$user->name.'"><i class="bi bi-key"></i></button> ';
                $btn .= '<button class="btn btn-sm btn-danger delete-user" data-id="'.$user->id.'" data-name="'.$user->name.'"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        $kelasList = Kelas::all();
        return view('admin.users.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:siswa,guru,admin',
            'kelas_id' => 'nullable|exists:kelas,id', // hanya untuk siswa
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:siswa,guru,admin',
            'kelas_id' => 'nullable|exists:kelas,id',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only('name', 'email', 'role', 'kelas_id');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        // Cegah menghapus diri sendiri
         if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return back()->with('success', 'User dihapus.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'password123'; // atau random
        $user->update(['password' => Hash::make($newPassword)]);
        return back()->with('success', "Password {$user->name} direset menjadi: {$newPassword}");
    }
}