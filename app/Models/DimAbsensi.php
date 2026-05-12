<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DimAbsensi extends Model
{
    public $timestamps = false;

    protected $table = 'dim_absensi';

    protected $primaryKey = 'id_absensi';

    protected $fillable = [
        'jumlah_hadir',
        'jumlah_sakit',
        'jumlah_izin',
        'jumlah_alpha',
    ];

    protected $casts = [
        'jumlah_hadir' => 'integer',
        'jumlah_sakit' => 'integer',
        'jumlah_izin' => 'integer',
        'jumlah_alpha' => 'integer',
    ];

    public function factKinerja(): HasMany
    {
        return $this->hasMany(FactKinerjaGuru::class, 'id_absensi', 'id_absensi');
    }

    /**
     * Persentase kehadiran
     */
    public function getPersentaseHadirAttribute(): float
    {
        $total = $this->jumlah_hadir + $this->jumlah_sakit + $this->jumlah_izin + $this->jumlah_alpha;
        return $total > 0 ? round(($this->jumlah_hadir / $total) * 100, 1) : 0;
    }
}
