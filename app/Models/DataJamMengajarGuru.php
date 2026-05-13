<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataJamMengajarGuru extends Model
{
    public $timestamps = false;

    protected $table = 'data_jam_mengajar_guru';

    protected $fillable = [
        'nama_guru',
        'kode',
        'nip',
        'jenis_kelamin',
        'bidang_studi',
        'periode_tahun',
        'x_1', 'x_2', 'x_3',
        'xi_1', 'xi_2', 'xi_3',
        'xii_1', 'xii_2', 'xii_3',
        'sd', 'smp', 'slb',
    ];

    protected $casts = [
        'periode_tahun' => 'integer',
        'x_1' => 'integer', 'x_2' => 'integer', 'x_3' => 'integer',
        'xi_1' => 'integer', 'xi_2' => 'integer', 'xi_3' => 'integer',
        'xii_1' => 'integer', 'xii_2' => 'integer', 'xii_3' => 'integer',
        'sd' => 'integer', 'smp' => 'integer', 'slb' => 'integer',
    ];

    /**
     * Total jam mengajar di semua kelas
     */
    public function getTotalJamAttribute(): int
    {
        return $this->x_1 + $this->x_2 + $this->x_3
             + $this->xi_1 + $this->xi_2 + $this->xi_3
             + $this->xii_1 + $this->xii_2 + $this->xii_3;
    }

    /**
     * Total jam kelas X
     */
    public function getTotalKelasXAttribute(): int
    {
        return $this->x_1 + $this->x_2 + $this->x_3;
    }

    /**
     * Total jam kelas XI
     */
    public function getTotalKelasXiAttribute(): int
    {
        return $this->xi_1 + $this->xi_2 + $this->xi_3;
    }

    /**
     * Total jam kelas XII
     */
    public function getTotalKelasXiiAttribute(): int
    {
        return $this->xii_1 + $this->xii_2 + $this->xii_3;
    }

    /**
     * Scope: filter by tahun
     */
    public function scopeByTahun($query, ?int $tahun)
    {
        if ($tahun) {
            return $query->where('periode_tahun', $tahun);
        }
        return $query;
    }

    /**
     * Scope: search
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('nama_guru', 'like', "%{$keyword}%")
                  ->orWhere('bidang_studi', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }
}
