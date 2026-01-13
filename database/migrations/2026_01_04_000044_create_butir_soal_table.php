<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('butir_soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_soal_id')
                ->constrained('paket_soal')
                ->onDelete('cascade');

            $table->text('pertanyaan');
            $table->json('opsi_jawaban');
            $table->char('kunci_jawaban', 1); // A, B, C, D
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('butir_soal');
    }
};
