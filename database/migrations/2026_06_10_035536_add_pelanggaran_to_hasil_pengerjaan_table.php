<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_pengerjaan', function (Blueprint $table) {
            $table->unsignedInteger('pelanggaran_count')->default(0)->after('skor_akhir');
            $table->json('pelanggaran_logs')->nullable()->after('pelanggaran_count');
            $table->boolean('terindikasi_curang')->default(false)->after('pelanggaran_logs');
        });
    }

    public function down(): void
    {
        Schema::table('hasil_pengerjaan', function (Blueprint $table) {
            $table->dropColumn([
                'pelanggaran_count',
                'pelanggaran_logs',
                'terindikasi_curang'
            ]);
        });
    }
};