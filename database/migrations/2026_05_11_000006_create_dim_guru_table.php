<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dim_guru', function (Blueprint $table) {
            $table->unsignedBigInteger('id_guru')->autoIncrement();
            $table->string('nip', 50)->nullable();
            $table->string('nama_guru', 100);
            $table->string('bidang_studi', 100);
            $table->string('jabatan', 100);
            $table->integer('tahun_lulus');
            $table->integer('tahun_mengajar');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dim_guru');
    }
};
