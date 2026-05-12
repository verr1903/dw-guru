<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dim_pelatihan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pelatihan')->autoIncrement();
            $table->string('nama_kegiatan', 150);
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dim_pelatihan');
    }
};
