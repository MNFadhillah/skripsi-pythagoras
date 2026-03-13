<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('hasil_pengerjaan', function (Blueprint $table) {
            // Tambahkan kolom json (nullable agar tidak error untuk data lama)
            $table->json('snapshot_jawaban')->nullable()->after('skor_akhir'); 
        });
    }

    public function down()
    {
        Schema::table('hasil_pengerjaans', function (Blueprint $table) {
            $table->dropColumn('snapshot_jawaban');
        });
    }
};
