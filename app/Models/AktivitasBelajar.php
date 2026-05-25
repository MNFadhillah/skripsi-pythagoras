<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AktivitasBelajar extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_belajar'; // Pastikan nama tabel benar

    protected $fillable = [
        'kelas_id',
        'paket_soal_id',
        'judul',
        'kategori',
        'instruksi',
        'tipe',           // Dari ERD
        'poin_didapat',   // Dari ERD
        'waktu_mulai',
        'waktu_selesai',
        'durasi_menit',
        'token',
        'status'
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime:Y-m-d H:i:s',
        'waktu_selesai' => 'datetime:Y-m-d H:i:s',
        'status' => 'boolean',
        'durasi_menit' => 'integer',
    ];

    protected $appends = ['is_currently_active'];

    // --- ACCESSOR: Otomatis Menghitung Status Real-time ---
    public function getIsCurrentlyActiveAttribute()
    {
        $now = Carbon::now();
        
        // Pastikan waktu mulai dan selesai ada isinya, lalu cek apakah sekarang di antara keduanya
        $isTimeValid = $this->waktu_mulai && $this->waktu_selesai && $now->between($this->waktu_mulai, $this->waktu_selesai);
        
        // Return TRUE jika toggle dinyalakan (status = 1) DAN waktunya valid
        return $this->status == 1 && $isTimeValid;
    }

    // Relasi ke Paket Soal
    public function paket_soal()
    {
        return $this->belongsTo(PaketSoal::class, 'paket_soal_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}