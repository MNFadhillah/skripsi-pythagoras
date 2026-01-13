<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ButirSoal;

class PaketSoal extends Model
{
    //
    protected $table = 'paket_soal';    

    protected $fillable = [
        'judul',
        'deskripsi',
        'tipe',
    ];

    public function butir_soal()
    {
        // 'paket_soal_id' adalah foreign key di tabel butir_soal
        return $this->hasMany(ButirSoal::class, 'paket_soal_id', 'id');
    }

    // Tambahkan di dalam class PaketSoal
    public function penugasan()
    {
        return $this->hasMany(Penugasan::class, 'paket_soal_id');
    }
}
