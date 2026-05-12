<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guru', 100);
            $table->string('nip', 50)->nullable();
            $table->string('bidang_studi', 100);
            $table->integer('tahun_lulus');
            $table->integer('tahun_mengajar');
            $table->smallInteger('periode_tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_guru');
    }
};
