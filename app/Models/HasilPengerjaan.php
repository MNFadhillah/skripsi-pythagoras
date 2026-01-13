<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPengerjaan extends Model
{
    protected $table = 'hasil_pengerjaan';

    // TAMBAHKAN user_id di sini
    protected $fillable = [
        'paket_soal_id',
        'user_id',       
        'skor_akhir',
        'waktu_mulai',
        'waktu_selesai'
    ];

    public function paketSoal()
    {
        return $this->belongsTo(PaketSoal::class);
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class);
    }
    
    // OPSIONAL: Tambahkan relasi ke user jika nanti ada
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}