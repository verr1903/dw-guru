<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DimGuru extends Model
{
    public $timestamps = false;

    protected $table = 'dim_guru';

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'nip',
        'nama_guru',
        'bidang_studi',
        'jabatan',
        'tahun_lulus',
        'tahun_mengajar',
    ];

    protected $casts = [
        'tahun_lulus' => 'integer',
        'tahun_mengajar' => 'integer',
    ];

    /**
     * Relasi: satu guru memiliki banyak fact kinerja
     */
    public function factKinerja(): HasMany
    {
        return $this->hasMany(FactKinerjaGuru::class, 'id_guru', 'id_guru');
    }

    /**
     * Scope: search
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('nama_guru', 'like', "%{$keyword}%")
                  ->orWhere('nip', 'like', "%{$keyword}%")
                  ->orWhere('bidang_studi', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }
}
