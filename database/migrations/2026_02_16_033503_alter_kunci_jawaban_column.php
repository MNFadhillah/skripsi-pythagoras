<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('butir_soal', function (Blueprint $table) {
        $table->string('kunci_jawaban', 255)->change();
    });
}

public function down()
{
    Schema::table('butir_soal', function (Blueprint $table) {
        $table->string('kunci_jawaban', 1)->change();
    });
}

};
