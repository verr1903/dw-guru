<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKegiatanPelatihanGuru extends Model
{
    public $timestamps = false;

    protected $table = 'data_kegiatan_pelatihan_guru';

    protected $fillable = [
        'nama_guru',
        'nip',
        'nama_kegiatan',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Durasi pelatihan (hari)
     */
    public function getDurasiHariAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Scope: search
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('nama_guru', 'like', "%{$keyword}%")
                  ->orWhere('nama_kegiatan', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }
}
