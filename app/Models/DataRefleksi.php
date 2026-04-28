<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRefleksi extends Model
{
    use HasFactory;

    // WAJIB: Beri tahu Laravel nama tabel yang benar
    protected $table = 'data_refleksi';

    protected $fillable = [
        'user_id',
        'kode_materi',
        'jawaban',
    ];

    // Otomatis mengubah JSON dari database menjadi Array PHP
    protected $casts = [
        'jawaban' => 'array',
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}