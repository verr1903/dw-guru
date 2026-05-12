<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataGuru extends Model
{
    public $timestamps = false;

    protected $table = 'data_guru';

    protected $fillable = [
        'nama_guru',
        'nip',
        'bidang_studi',
        'tahun_lulus',
        'tahun_mengajar',
        'periode_tahun',
    ];

    protected $casts = [
        'tahun_lulus' => 'integer',
        'tahun_mengajar' => 'integer',
        'periode_tahun' => 'integer',
    ];

    /**
     * Scope: filter by periode tahun
     */
    public function scopeByTahun($query, int $tahun)
    {
        return $query->where('periode_tahun', $tahun);
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

    /**
     * Hitung lama mengajar (tahun)
     */
    public function getLamaMengajarAttribute(): int
    {
        return $this->periode_tahun - $this->tahun_mengajar;
    }
}
