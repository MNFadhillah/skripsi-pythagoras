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
        //
        Schema::create('progres_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID Siswa
            $table->string('materi_id'); // Contoh: 'materi_1'
            $table->string('checkpoint_code'); // Contoh: 'cek_segitiga_jembatan', 'cek_kuadrat', dll.
            $table->boolean('is_completed')->default(true);
            $table->timestamps();

            // Pastikan satu siswa hanya punya 1 record untuk tiap checkpoint di satu materi
            $table->unique(['user_id', 'materi_id', 'checkpoint_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
