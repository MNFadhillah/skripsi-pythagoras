<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            // Terhubung ke tabel users (guru)
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_kelas');
            $table->string('token', 10)->unique(); // Token unik (misal: "X7Y2Z")
            $table->string('tahun_ajaran')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // PENTING: Tambahkan kolom kelas_id di tabel users (untuk Siswa)
        // Jika tabel users sudah ada, buat migration terpisah atau tambahkan manual jika masih development
        if (!Schema::hasColumn('users', 'kelas_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('kelas_id')->nullable()->after('email')->constrained('kelas')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        // Hapus foreign key dulu dari users sebelum drop tabel kelas
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });
        Schema::dropIfExists('kelas');
    }
};
