<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_jam_mengajar_guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guru', 100);
            $table->string('kode', 50);
            $table->string('nip', 50);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('bidang_studi', 100);
            $table->smallInteger('periode_tahun');
            $table->integer('x_1')->default(0);
            $table->integer('x_2')->default(0);
            $table->integer('x_3')->default(0);
            $table->integer('xi_1')->default(0);
            $table->integer('xi_2')->default(0);
            $table->integer('xi_3')->default(0);
            $table->integer('xii_1')->default(0);
            $table->integer('xii_2')->default(0);
            $table->integer('xii_3')->default(0);
            $table->integer('sd')->default(0);
            $table->integer('smp')->default(0);
            $table->integer('slb')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_jam_mengajar_guru');
    }
};
