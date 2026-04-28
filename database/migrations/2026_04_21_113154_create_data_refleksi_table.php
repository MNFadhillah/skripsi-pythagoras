<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_refleksi', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Penanda subbab materi (misal: 'materi_1')
            $table->string('kode_materi');
            
            // Tempat menyimpan seluruh jawaban secara fleksibel
            $table->json('jawaban'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_refleksi');
    }
};