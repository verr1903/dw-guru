<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_absensi_guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guru', 100);
            $table->string('nip', 50)->nullable();
            $table->string('jabatan', 100);
            $table->tinyInteger('periode_bulan');
            $table->smallInteger('periode_tahun');
            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('alpa')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_absensi_guru');
    }
};
