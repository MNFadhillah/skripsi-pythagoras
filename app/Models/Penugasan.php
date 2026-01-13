<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;

    protected $table = 'penugasan';

    protected $fillable = [
        'paket_soal_id',
        'judul',
        'instruksi',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_menit',
        'token',
        'status'
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'status' => 'boolean',
    ];

    // RELASI KE PAKET SOAL
    public function paket_soal()
    {
        return $this->belongsTo(PaketSoal::class, 'paket_soal_id');
    }
    
    // Relasi ke Kelas nanti ditambahkan di sini kalau tabelnya sudah ada
    
}