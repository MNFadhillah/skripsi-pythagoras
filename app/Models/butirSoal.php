<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ButirSoal extends Model
{
    use HasFactory, SoftDeletes;
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
        // Cek dua kemungkinan key: 'image' (format baru) atau 'gambar' (format lama)
        return $this->pertanyaan['image'] ?? $this->pertanyaan['gambar'] ?? null;
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