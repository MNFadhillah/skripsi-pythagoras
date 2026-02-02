<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    // Sesuaikan dengan kolom di database Anda
    protected $fillable = [
        'guru_id',
        'nama_kelas',
        'token',
    ];

    // Relasi: Kelas dimiliki 1 Guru
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // Relasi: Kelas punya banyak Siswa
    public function siswa()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }
}