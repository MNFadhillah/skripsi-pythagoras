<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Http\Request;
use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\JawabanSiswa;
use Maatwebsite\Excel\Facades\Excel;
use illuminate\support\Facades\Hash;

class DataSiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa
     */
    public function index(Request $request)
    {
        // 1. Ambil data kelas untuk mengisi Dropdown filter
        $dataKelas = Kelas::all(); 

        // 2. Query dasar (hanya ambil user dengan role siswa)
        $query = User::with('kelas')->where('role', 'siswa'); 

        // 3. Logika Filter Berdasarkan Kelas (Tetap dipertahankan agar dropdown filter berfungsi)
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // 4. LOGIKA PENCARIAN MANUAL DIHAPUS 
        // (Karena DataTables akan mencari secara otomatis di browser)

        // 5. Eksekusi query dengan GET (Bukan Paginate)
        // Gunakan get() agar DataTables menerima semua data untuk diproses di client-side
        $dataSiswa = $query->latest()->get();

        return view('guru.data_siswa', compact('dataSiswa', 'dataKelas'));
    }

    /**
     * (OPSIONAL) Hapus siswa
     * — saat ini masih dummy / belum dipakai
     */
public function destroy($id)
    {
        // 1. Cari data siswa
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        try {
            // 2. Cari semua riwayat pengerjaan kuis milik siswa ini
            $riwayatPengerjaan = \App\Models\HasilPengerjaan::where('user_id', $id)->get();

            // 3. Hapus data secara berurutan dari yang paling "anak"
            foreach ($riwayatPengerjaan as $hasil) {
                // Hapus detail jawaban siswa di kuis ini (agar tidak kena error foreign key lagi)
                // Jika $hasil adalah stdClass (mis. hasil query builder) kita harus menghapus lewat query berbasis id
                $hasilId = is_object($hasil) && isset($hasil->id) ? $hasil->id : null;

                if ($hasilId) {
                    // Hapus jawaban siswa yang terkait dengan hasil ini tanpa mengandalkan relasi model
                    JawabanSiswa::where('hasil_pengerjaan_id', $hasilId)->delete();

                    // Hapus hasil pengerjaan lewat query model
                    \App\Models\HasilPengerjaan::where('id', $hasilId)->delete();
                } else {
                    // Jika $hasil sudah berupa model Eloquent, pakai relasi dan delete model langsung
                    // Asumsi nama relasi di model HasilPengerjaan adalah 'jawabanSiswa'
                    if (is_object($hasil) && method_exists($hasil, 'jawabanSiswa')) {
                        $hasil->jawabanSiswa()->delete();
                    } elseif (isset($hasil->hasil_pengerjaan_id)) {
                        // fallback untuk struktur lain
                        JawabanSiswa::where('hasil_pengerjaan_id', $hasil->hasil_pengerjaan_id)->delete();
                    }

                    // Hapus model jika metode delete tersedia
                    if (is_object($hasil) && method_exists($hasil, 'delete')) {
                        $hasil->delete();
                    }
                }
            }

            // 4. Setelah semua riwayat kuis bersih, BARU hapus data Siswanya
            $siswa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa beserta riwayat pengerjaannya berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            // Tangkap error jika terjadi masalah lain
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

public function update(Request $request, $id)
    {
        // 1. Siapkan aturan wajib (Nama & Email saja)
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ];

        // 2. JIKA password diisi, baru tambahkan aturan wajib min:6
        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        // 3. Jalankan Validasi
        $request->validate($rules, [
            'name.required'  => 'Nama siswa wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email ini sudah digunakan oleh pengguna lain.',
            'password.min'   => 'Password minimal 6 karakter.'
        ]);

        // 4. Cari & Update Data
        $siswa = User::where('role', 'siswa')->findOrFail($id);
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


    public function export(Request $request)
    {
        // 1. Set nama kelas default (jika export semua siswa)
        $namaKelas = 'Semua_Kelas';

        // 2. Cek apakah guru memfilter berdasarkan kelas tertentu
        if ($request->filled('kelas_id')) {
            $kelas = Kelas::find($request->kelas_id);
            
            if ($kelas) {
                // Mengubah spasi menjadi garis bawah agar nama file rapi (contoh: VIII A -> VIII_A)
                $namaKelas = str_replace(' ', '_', $kelas->nama_kelas);
                
                // Tambahkan awalan "Kelas_" jika nama kelasnya belum mengandung kata itu
                if (!str_contains(strtolower($namaKelas), 'kelas')) {
                    $namaKelas = 'Kelas_' . $namaKelas;
                }
            }
        }

        // 3. Format tanggal hari ini (Contoh: 11-02-2026)
        $tanggal = date('d-m-Y');
        
        // 4. Rangkai nama file akhir
        $fileName = 'Data_Siswa_' . $namaKelas . '_' . $tanggal . '.xlsx';
        
        // Memanggil class SiswaExport dan mengirimkan request filter yang aktif
        return Excel::download(new SiswaExport($request), $fileName);
    }
}
