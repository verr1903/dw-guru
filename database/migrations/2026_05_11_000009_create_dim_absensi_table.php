<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dim_absensi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_absensi')->autoIncrement();
            $table->integer('jumlah_hadir')->default(0);
            $table->integer('jumlah_sakit')->default(0);
            $table->integer('jumlah_izin')->default(0);
            $table->integer('jumlah_alpha')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dim_absensi');
    }
};
