<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaTemplateExport;

class AdminSiswaController extends Controller
{
    public function index()
    {
        return view('admin.siswa.index');
    }

    public function data()
    {
        $siswa = User::where('role', 'siswa')->select('users.*');
        return DataTables::of($siswa)
            ->addIndexColumn()
            ->addColumn('actions', function ($user) {
                $btn = '<button class="btn btn-sm btn-primary edit-siswa" data-id="' . $user->id . '"><i class="bi bi-pencil"></i></button> ';
                $btn .= '<button class="btn btn-sm btn-warning reset-pwd text-white" data-id="' . $user->id . '" data-name="' . $user->name . '"><i class="bi bi-key"></i></button> ';
                $btn .= '<button class="btn btn-sm btn-danger delete-siswa" data-id="' . $user->id . '" data-name="' . $user->name . '"><i class="bi bi-trash"></i></button>';
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
            'role' => 'siswa', // Otomatis mengunci role siswa
            'points' => 0      // Inisialisasi poin gamifikasi awal
        ]);

        return response()->json(['success' => true, 'message' => 'Data Siswa berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);
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
        return response()->json(['success' => true, 'message' => 'Data Siswa berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);
        $user->delete();
        return response()->json(['success' => true, 'message' => 'Data Siswa berhasil dihapus.']);
    }

    public function resetPassword($id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);
        $user->update(['password' => Hash::make('password123')]);
        return response()->json(['success' => true, 'message' => "Password {$user->name} direset menjadi: password123"]);
    }

    public function importExcel(Request $request)
    {
        // Validasi ekstensi file dan ukuran maksimal (2MB)
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048'
        ], [
            'file_excel.required' => 'Silakan pilih file Excel terlebih dahulu.',
            'file_excel.mimes'    => 'Format file harus berupa .xlsx atau .xls',
            'file_excel.max'      => 'Ukuran file maksimal adalah 2MB.'
        ]);

        try {
            // Eksekusi import data menggunakan class SiswaImport
            Excel::import(new SiswaImport, $request->file('file_excel'));

            return response()->json([
                'success' => true,
                'message' => 'Seluruh data siswa dari file Excel berhasil di-import sekaligus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membaca file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadTemplate()
    {
        // Mengunduh file template dengan nama 'template_import_siswa.xlsx'
        return Excel::download(new SiswaTemplateExport, 'template_import_siswa.xlsx');
    }
}