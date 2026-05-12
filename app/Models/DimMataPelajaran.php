<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DimMataPelajaran extends Model
{
    public $timestamps = false;

    protected $table = 'dim_mata_pelajaran';

    protected $primaryKey = 'id_mata_pelajaran';

    protected $fillable = [
        'nama_mata_pelajaran',
        'tingkat_kelas',
    ];

    public function factKinerja(): HasMany
    {
        return $this->hasMany(FactKinerjaGuru::class, 'id_mata_pelajaran', 'id_mata_pelajaran');
    }
}
