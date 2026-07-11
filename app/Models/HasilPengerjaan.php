<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPengerjaan extends Model
{
    protected $table = 'hasil_pengerjaan';

    protected $fillable = [
        'paket_soal_id',
        'user_id',
        'skor_akhir',
        'snapshot_jawaban',
        'waktu_mulai',
        'waktu_selesai',

        // Tambahan untuk anti-cheat
        'pelanggaran_count',
        'pelanggaran_logs',
        'terindikasi_curang',
    ];

    protected $casts = [
        'pelanggaran_logs' => 'array',
        'snapshot_jawaban' => 'array',
        'terindikasi_curang' => 'boolean',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function paketSoal()
    {
        return $this->belongsTo(PaketSoal::class);
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
