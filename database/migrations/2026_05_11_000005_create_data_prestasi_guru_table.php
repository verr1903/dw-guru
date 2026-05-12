<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_prestasi_guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guru', 100);
            $table->string('nip', 50)->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->string('kegiatan', 150);
            $table->string('prestasi', 150);
            $table->string('penyelenggara_kegiatan', 150);
            $table->string('tingkat_kegiatan', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_prestasi_guru');
    }
};
