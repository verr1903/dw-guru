<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dim_prestasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_prestasi')->autoIncrement();
            $table->date('tanggal_kegiatan');
            $table->string('kegiatan', 150);
            $table->string('prestasi', 150);
            $table->string('penyelenggara_kegiatan', 150);
            $table->string('tingkat_kegiatan', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dim_prestasi');
    }
};
