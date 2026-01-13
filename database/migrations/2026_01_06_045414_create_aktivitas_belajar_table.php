<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aktivitas_belajar', function (Blueprint $table) {
            $table->id();

            // 1. RELASI (Opsional/Nullable karena tipe 'materi' mungkin tidak butuh soal)
            $table->foreignId('paket_soal_id')
                  ->nullable()
                  ->constrained('paket_soal')
                  ->onDelete('set null'); // Jika paket dihapus, aktivitas jangan hilang, tapi null-kan saja

            // 2. INFO DASAR (Sesuai ERD Anda)
            $table->string('judul');
            $table->text('instruksi')->nullable();
            
            // 3. GAMIFIKASI (Sesuai ERD Anda)
            $table->enum('tipe', ['kuis', 'evaluasi', 'streak'])->default('kuis');
            $table->integer('poin_didapat')->default(0); // Poin jika selesai

            // 4. KONTROL WAKTU (Fitur Buka/Tutup)
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->integer('durasi_menit')->default(60);

            // 5. KEAMANAN & STATUS
            $table->string('token', 6)->nullable();
            $table->boolean('status')->default(0); // 0: Draft/Tutup, 1: Terbit/Buka

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aktivitas_belajar');
    }
};