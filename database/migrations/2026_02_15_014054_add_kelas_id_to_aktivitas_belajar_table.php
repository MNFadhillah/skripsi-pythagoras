<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('aktivitas_belajar', function (Blueprint $table) {
            // 1. Buat kolomnya nullable (boleh kosong) dulu
            // agar data lama yang sudah ada tidak error
            $table->foreignId('kelas_id')
                ->nullable() // <--- TAMBAHKAN INI
                ->after('id')
                ->constrained('kelas')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('aktivitas_belajar', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });
    }
};
