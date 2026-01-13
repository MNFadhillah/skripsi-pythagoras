<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasBelajar extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_belajar'; // Pastikan nama tabel benar

    protected $fillable = [
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
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'status' => 'boolean',
    ];

    // Relasi ke Paket Soal
    public function paket_soal()
    {
        return $this->belongsTo(PaketSoal::class, 'paket_soal_id');
    }
}