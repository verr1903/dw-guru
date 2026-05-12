<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DimPrestasi extends Model
{
    public $timestamps = false;

    protected $table = 'dim_prestasi';

    protected $primaryKey = 'id_prestasi';

    protected $fillable = [
        'tanggal_kegiatan',
        'kegiatan',
        'prestasi',
        'penyelenggara_kegiatan',
        'tingkat_kegiatan',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];

    public function factKinerja(): HasMany
    {
        return $this->hasMany(FactKinerjaGuru::class, 'id_prestasi', 'id_prestasi');
    }
}
