<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataAbsensiGuru extends Model
{
    public $timestamps = false;

    protected $table = 'data_absensi_guru';

    protected $fillable = [
        'nama_guru',
        'nip',
        'jabatan',
        'periode_bulan',
        'periode_tahun',
        'sakit',
        'izin',
        'alpa',
    ];

    protected $casts = [
        'periode_bulan' => 'integer',
        'periode_tahun' => 'integer',
        'sakit' => 'integer',
        'izin' => 'integer',
        'alpa' => 'integer',
    ];

    /**
     * Total hari tidak hadir
     */
    public function getTotalTidakHadirAttribute(): int
    {
        return $this->sakit + $this->izin + $this->alpa;
    }

    /**
     * Scope: filter by bulan dan tahun
     */
    public function scopeByPeriode($query, ?int $bulan, ?int $tahun)
    {
        if ($bulan) {
            $query->where('periode_bulan', $bulan);
        }
        if ($tahun) {
            $query->where('periode_tahun', $tahun);
        }
        return $query;
    }

    /**
     * Scope: search by nama guru
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if ($keyword) {
            return $query->where('nama_guru', 'like', "%{$keyword}%");
        }
        return $query;
    }
}
