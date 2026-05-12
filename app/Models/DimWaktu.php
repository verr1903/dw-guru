<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DimWaktu extends Model
{
    public $timestamps = false;

    protected $table = 'dim_waktu';

    protected $primaryKey = 'id_waktu';

    protected $fillable = [
        'tanggal',
        'bulan',
        'tahun',
        'nama_hari',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'bulan' => 'integer',
        'tahun' => 'integer',
    ];

    public function factKinerja(): HasMany
    {
        return $this->hasMany(FactKinerjaGuru::class, 'id_waktu', 'id_waktu');
    }

    /**
     * Nama bulan dalam Bahasa Indonesia
     */
    public function getNamaBulanAttribute(): string
    {
        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        return $bulanNames[$this->bulan] ?? '';
    }
}
