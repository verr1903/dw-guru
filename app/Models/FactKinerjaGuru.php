<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactKinerjaGuru extends Model
{
    public $timestamps = false;

    protected $table = 'fact_kinerja_guru';

    protected $primaryKey = 'id_fact';

    protected $fillable = [
        'id_guru',
        'id_waktu',
        'id_mata_pelajaran',
        'id_absensi',
        'id_pelatihan',
        'id_prestasi',
        'jumlah_jam_mengajar',
        'jumlah_kehadiran',
        'jumlah_pelatihan',
        'jumlah_prestasi',
    ];

    protected $casts = [
        'jumlah_jam_mengajar' => 'integer',
        'jumlah_kehadiran' => 'integer',
        'jumlah_pelatihan' => 'integer',
        'jumlah_prestasi' => 'integer',
    ];

    /**
     * Relasi ke dimensi guru
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(DimGuru::class, 'id_guru', 'id_guru');
    }

    /**
     * Relasi ke dimensi waktu
     */
    public function waktu(): BelongsTo
    {
        return $this->belongsTo(DimWaktu::class, 'id_waktu', 'id_waktu');
    }

    /**
     * Relasi ke dimensi mata pelajaran
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(DimMataPelajaran::class, 'id_mata_pelajaran', 'id_mata_pelajaran');
    }

    /**
     * Relasi ke dimensi absensi
     */
    public function absensi(): BelongsTo
    {
        return $this->belongsTo(DimAbsensi::class, 'id_absensi', 'id_absensi');
    }

    /**
     * Relasi ke dimensi pelatihan
     */
    public function pelatihan(): BelongsTo
    {
        return $this->belongsTo(DimPelatihan::class, 'id_pelatihan', 'id_pelatihan');
    }

    /**
     * Relasi ke dimensi prestasi
     */
    public function prestasi(): BelongsTo
    {
        return $this->belongsTo(DimPrestasi::class, 'id_prestasi', 'id_prestasi');
    }
}
