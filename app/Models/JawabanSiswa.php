<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    //
    protected $table = 'jawaban_siswa';

    protected $fillable = [
        'hasil_pengerjaan_id',
        'butir_soal_id',
        'jawaban',
        'benar'
    ];

    public function butirSoal()
    {
        return $this->belongsTo(ButirSoal::class);
    }
}
