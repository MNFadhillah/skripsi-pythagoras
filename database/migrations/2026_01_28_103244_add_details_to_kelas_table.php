<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tambah kolom ke tabel 'kelas' yang sudah ada
        Schema::table('kelas', function (Blueprint $table) {
            // Kita taruh setelah kolom 'id' biar rapi
            $table->foreignId('guru_id')->after('id')->constrained('users')->onDelete('cascade'); 
            $table->string('nama_kelas')->after('guru_id');
            $table->string('token', 10)->unique()->after('nama_kelas');
            $table->string('tahun_ajaran')->nullable()->after('token');
            $table->text('deskripsi')->nullable()->after('tahun_ajaran');
        });

        // 2. Tambah kolom 'kelas_id' ke tabel 'users' (untuk Siswa)
        // Kita cek dulu biar gak error kalau sudah ada
        if (!Schema::hasColumn('users', 'kelas_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('kelas_id')->nullable()->after('email')->constrained('kelas')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        // Rollback: Hapus kolom jika migration dibatalkan
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn(['guru_id', 'nama_kelas', 'token', 'tahun_ajaran', 'deskripsi']);
        });
    }
};