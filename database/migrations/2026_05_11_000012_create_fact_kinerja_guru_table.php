<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fact_kinerja_guru', function (Blueprint $table) {
            $table->unsignedBigInteger('id_fact')->autoIncrement();
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_waktu');
            $table->unsignedBigInteger('id_mata_pelajaran');
            $table->unsignedBigInteger('id_absensi')->nullable();
            $table->unsignedBigInteger('id_pelatihan')->nullable();
            $table->unsignedBigInteger('id_prestasi')->nullable();
            $table->integer('jumlah_jam_mengajar')->default(0);
            $table->integer('jumlah_kehadiran')->default(0);
            $table->integer('jumlah_pelatihan')->default(0);
            $table->integer('jumlah_prestasi')->default(0);

            // Foreign keys
            $table->foreign('id_guru')->references('id_guru')->on('dim_guru');
            $table->foreign('id_waktu')->references('id_waktu')->on('dim_waktu');
            $table->foreign('id_mata_pelajaran')->references('id_mata_pelajaran')->on('dim_mata_pelajaran');
            $table->foreign('id_absensi')->references('id_absensi')->on('dim_absensi');
            $table->foreign('id_pelatihan')->references('id_pelatihan')->on('dim_pelatihan');
            $table->foreign('id_prestasi')->references('id_prestasi')->on('dim_prestasi');

            // Indexes
            $table->index('id_guru', 'idx_fact_guru');
            $table->index('id_waktu', 'idx_fact_waktu');
            $table->index('id_mata_pelajaran', 'idx_fact_mapel');
            $table->index('id_absensi', 'idx_fact_absensi');
            $table->index('id_pelatihan', 'idx_fact_pelatihan');
            $table->index('id_prestasi', 'idx_fact_prestasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fact_kinerja_guru');
    }
};
