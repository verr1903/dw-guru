<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RekapKinerjaExport implements WithMultipleSheets
{
    protected int|string $tahun;  // ← tambahkan |string

    public function __construct(int|string $tahun)  // ← sama
    {
        $this->tahun = $tahun;
    }

    public function sheets(): array
    {
        return [
            new RekapKinerjaRingkasanSheet($this->tahun),
            new JamMengajarExport($this->tahun),
            new KehadiranGuruExport($this->tahun),
        ];
    }
}
