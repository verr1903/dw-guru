<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dim_mata_pelajaran', function (Blueprint $table) {
            $table->unsignedBigInteger('id_mata_pelajaran')->autoIncrement();
            $table->string('nama_mata_pelajaran', 100);
            $table->string('tingkat_kelas', 20);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dim_mata_pelajaran');
    }
};
