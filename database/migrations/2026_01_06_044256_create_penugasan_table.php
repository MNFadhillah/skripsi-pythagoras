<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penugasan', function (Blueprint $table) {
            $table->id();
            
            // RELASI KE PAKET SOAL (Soal apa yang dikerjakan?)
            $table->foreignId('paket_soal_id')
                  ->constrained('paket_soal')
                  ->onDelete('cascade'); 
            
            // CATATAN: Bagian 'kelas_id' SAYA HAPUS DULU sesuai permintaan.
            // Nanti bisa ditambahkan belakangan jika tabel kelas sudah siap.

            // INFORMASI DASAR
            $table->string('judul'); // Contoh: "Ulangan Harian Senin"
            $table->text('instruksi')->nullable(); 
            
            // PENGATURAN WAKTU
            $table->dateTime('waktu_mulai');   
            $table->dateTime('waktu_selesai'); 
            $table->integer('durasi_menit')->default(60); 
            
            // KEAMANAN & STATUS
            $table->string('token', 6)->nullable(); 
            $table->boolean('status')->default(0); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penugasan');
    }
};