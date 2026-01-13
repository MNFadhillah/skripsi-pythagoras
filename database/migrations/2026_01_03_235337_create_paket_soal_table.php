<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_soal', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['kuis', 'evaluasi', 'streak'])->default('kuis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_soal');
    }
};
