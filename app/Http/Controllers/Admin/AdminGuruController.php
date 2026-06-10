<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AdminGuruController extends Controller
{
    public function index()
    {
        return view('admin.guru.index');
    }

    public function data()
    {
        $guru = User::where('role', 'guru')->select('users.*');
        return DataTables::of($guru)
            ->addIndexColumn()
            ->addColumn('actions', function ($user) {
                $btn = '<button class="btn btn-sm btn-primary edit-guru" data-id="' . $user->id . '"><i class="bi bi-pencil"></i></button> ';
                $btn .= '<button class="btn btn-sm btn-warning reset-pwd text-white" data-id="' . $user->id . '" data-name="' . $user->name . '"><i class="bi bi-key"></i></button> ';
                $btn .= '<button class="btn btn-sm btn-danger delete-guru" data-id="' . $user->id . '" data-name="' . $user->name . '"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru', // Otomatis mengunci role guru
        ]);

        return response()->json(['success' => true, 'message' => 'Data Guru berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $user = User::where('role', 'guru')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'guru')->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only('name', 'email');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        return response()->json(['success' => true, 'message' => 'Data Guru berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $user = User::where('role', 'guru')->findOrFail($id);
        
        // Putuskan hubungan wali kelas terlebih dahulu jika ada kelas yang diampu guru ini
        Kelas::where('guru_id', $id)->update(['guru_id' => null]);
        
        $user->delete();
        return response()->json(['success' => true, 'message' => 'Data Guru berhasil dihapus.']);
    }

    public function resetPassword($id)
    {
        $user = User::where('role', 'guru')->findOrFail($id);
        $user->update(['password' => Hash::make('password123')]);
        return response()->json(['success' => true, 'message' => "Password {$user->name} direset menjadi: password123"]);
    }
}