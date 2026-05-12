<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPrestasiGuru extends Model
{
    public $timestamps = false;

    protected $table = 'data_prestasi_guru';

    protected $fillable = [
        'nama_guru',
        'nip',
        'tanggal_kegiatan',
        'kegiatan',
        'prestasi',
        'penyelenggara_kegiatan',
        'tingkat_kegiatan',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];

    /**
     * Scope: search
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('nama_guru', 'like', "%{$keyword}%")
                  ->orWhere('kegiatan', 'like', "%{$keyword}%")
                  ->orWhere('prestasi', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }

    /**
     * Scope: filter by tingkat
     */
    public function scopeByTingkat($query, ?string $tingkat)
    {
        if ($tingkat) {
            return $query->where('tingkat_kegiatan', $tingkat);
        }
        return $query;
    }
}
