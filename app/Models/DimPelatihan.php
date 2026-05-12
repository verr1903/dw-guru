<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DimPelatihan extends Model
{
    public $timestamps = false;

    protected $table = 'dim_pelatihan';

    protected $primaryKey = 'id_pelatihan';

    protected $fillable = [
        'nama_kegiatan',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function factKinerja(): HasMany
    {
        return $this->hasMany(FactKinerjaGuru::class, 'id_pelatihan', 'id_pelatihan');
    }
}
