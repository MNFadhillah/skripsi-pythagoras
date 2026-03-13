<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class progres_siswa extends Model
{
    use HasFactory;
    protected $table = 'progres_siswa';

    protected $fillable = [
        'user_id',
        'materi_id',
        'checkpoint_code',
        'is_completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}