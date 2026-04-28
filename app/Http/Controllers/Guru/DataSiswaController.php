<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Http\Request;
use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\JawabanSiswa;
use App\Models\HasilPengerjaan;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DataSiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa yang berada di kelas yang diampu guru.
     */
    public function index(Request $request)
    {
        $guruId = Auth::id();

        // Kelas-kelas yang diampu oleh guru ini (wali kelas)
        $dataKelas = Kelas::where('guru_id', $guruId)->get();

        // Jika guru tidak memiliki kelas, tampilkan data kosong
        if ($dataKelas->isEmpty()) {
            $dataSiswa = collect();
            return view('guru.data_siswa', compact('dataSiswa', 'dataKelas'));
        }

        // Daftar ID kelas yang diizinkan
        $allowedClassIds = $dataKelas->pluck('id')->toArray();

        // Query siswa hanya yang kelas_id-nya termasuk dalam allowedClassIds
        $query = User::with('kelas')
            ->where('role', 'siswa')
            ->whereIn('kelas_id', $allowedClassIds);

        // Filter berdasarkan kelas (jika parameter ada dan kelas tersebut valid)
        if ($request->filled('kelas_id') && in_array($request->kelas_id, $allowedClassIds)) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $dataSiswa = $query->latest()->get();

        return view('guru.data_siswa', compact('dataSiswa', 'dataKelas'));
    }

    /**
     * Update data siswa (hanya jika siswa berada di kelas yang diampu).
     */
    public function update(Request $request, $id)
    {
        $guruId = Auth::id();

        // Cari siswa
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // Cek apakah kelas siswa termasuk dalam kelas yang diampu guru
        $kelasGuru = Kelas::where('guru_id', $guruId)->pluck('id');
        if (!$kelasGuru->contains($siswa->kelas_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak mengubah data siswa ini.'
            ], 403);
        }

        // Validasi input
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $request->validate($rules, [
            'name.required'  => 'Nama siswa wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email ini sudah digunakan oleh pengguna lain.',
            'password.min'   => 'Password minimal 6 karakter.'
        ]);

        // Update data
        $siswa->name = $request->name;
        $siswa->email = $request->email;
        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diperbarui!'
        ]);
    }

    /**
     * Hapus siswa beserta seluruh riwayat pengerjaannya.
     * Hanya dapat menghapus siswa yang berada di kelas yang diampu guru.
     */
    public function destroy($id)
    {
        $guruId = Auth::id();
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        $kelasGuru = Kelas::where('guru_id', $guruId)->pluck('id');
        if (!$kelasGuru->contains($siswa->kelas_id)) {
            return response()->json(['success' => false, 'message' => 'Anda tidak berhak menghapus siswa ini.'], 403);
        }

        try {
            // Hapus semua jawaban siswa terlebih dahulu
            JawabanSiswa::whereIn('hasil_pengerjaan_id', HasilPengerjaan::where('user_id', $id)->pluck('id'))->delete();;

            // Hapus hasil pengerjaan
            HasilPengerjaan::where('user_id', $id)->delete();

            // Hapus siswa
            $siswa->delete();

            return response()->json(['success' => true, 'message' => 'Data siswa beserta riwayat pengerjaannya berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Ekspor data siswa (hanya siswa yang berada di kelas yang diampu guru).
     */
    public function export(Request $request)
    {
        $guruId = Auth::id();
        $dataKelas = Kelas::where('guru_id', $guruId)->get();

        if ($dataKelas->isEmpty()) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas, tidak dapat mengekspor data siswa.');
        }

        $allowedClassIds = $dataKelas->pluck('id')->toArray();

        // Siapkan nama file
        $namaKelas = 'Semua_Kelas';
        if ($request->filled('kelas_id') && in_array($request->kelas_id, $allowedClassIds)) {
            $kelas = Kelas::find($request->kelas_id);
            if ($kelas) {
                $namaKelas = str_replace(' ', '_', $kelas->nama_kelas);
                if (!str_contains(strtolower($namaKelas), 'kelas')) {
                    $namaKelas = 'Kelas_' . $namaKelas;
                }
            }
        }

        $tanggal = date('d-m-Y');
        $fileName = 'Data_Siswa_' . $namaKelas . '_' . $tanggal . '.xlsx';

        // Panggil export class dengan filter dan allowedClassIds
        return Excel::download(new SiswaExport($request, $allowedClassIds), $fileName);
    }
}