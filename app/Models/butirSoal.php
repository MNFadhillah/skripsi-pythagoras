<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ButirSoal extends Model
{
    protected $table = 'butir_soal';

    protected $fillable = [
        'paket_soal_id',
        'pertanyaan',
        'opsi_jawaban',
        'kunci_jawaban'
    ];

    protected $casts = [
        'pertanyaan' => 'array',  // Pertanyaan sebagai array
        'opsi_jawaban' => 'array'
    ];

    // Accessor untuk memudahkan akses
    public function getPertanyaanTextAttribute()
    {
        return $this->pertanyaan['text'] ?? '';
    }

    public function getPertanyaanGambarAttribute()
    {
        return $this->pertanyaan['gambar'] ?? null;
    }

    public function paketSoal()
    {
        return $this->belongsTo(PaketSoal::class, 'paket_soal_id');
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class);
    }
}