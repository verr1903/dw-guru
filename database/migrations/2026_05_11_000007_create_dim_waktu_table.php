<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dim_waktu', function (Blueprint $table) {
            $table->unsignedBigInteger('id_waktu')->autoIncrement();
            $table->date('tanggal');
            $table->tinyInteger('bulan');
            $table->smallInteger('tahun');
            $table->string('nama_hari', 20);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dim_waktu');
    }
};
