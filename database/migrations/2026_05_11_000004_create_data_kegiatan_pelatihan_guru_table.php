<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_kegiatan_pelatihan_guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guru', 100);
            $table->string('nip', 50)->nullable();
            $table->string('nama_kegiatan', 150);
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_kegiatan_pelatihan_guru');
    }
};
