<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class JamMengajarExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithStyles,
    ShouldAutoSize
{
    protected int|string $tahun;

    // Jika tahun === 'semua' → include kolom Tahun di output
    public function __construct(int|string $tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $isSemua = $this->tahun === 'semua';

        $q = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',           'f.id_waktu',          '=', 'w.id_waktu')
            ->join('dim_guru as g',            'f.id_guru',           '=', 'g.id_guru')
            ->join('dim_mata_pelajaran as mp', 'f.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('dim_absensi as da',        'f.id_absensi',        '=', 'da.id_absensi');

        if (!$isSemua) {
            $q->where('w.tahun', $this->tahun);
        }

        if ($isSemua) {
            // Group per tahun + guru
            $q->select(
                'w.tahun',
                'g.nip', 'g.nama_guru', 'g.jabatan', 'g.bidang_studi',
                DB::raw('SUM(f.jumlah_jam_mengajar) as total_jam'),
                DB::raw('COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) as total_hari_mengajar')
            )
            ->groupBy('w.tahun', 'g.id_guru', 'g.nip', 'g.nama_guru', 'g.jabatan', 'g.bidang_studi')
            ->orderBy('w.tahun')
            ->orderBy('g.nama_guru');
        } else {
            $q->select(
                'g.nip', 'g.nama_guru', 'g.jabatan', 'g.bidang_studi',
                DB::raw('SUM(f.jumlah_jam_mengajar) as total_jam'),
                DB::raw('COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) as total_hari_mengajar')
            )
            ->groupBy('g.id_guru', 'g.nip', 'g.nama_guru', 'g.jabatan', 'g.bidang_studi')
            ->orderBy('g.nama_guru');
        }

        $rows = $q->get();

        return $rows->map(function ($row, $index) use ($isSemua) {
            $base = [
                'no'           => $index + 1,
                'nip'          => $row->nip,
                'nama_guru'    => $row->nama_guru,
                'jabatan'      => $row->jabatan,
                'bidang_studi' => $row->bidang_studi,
                'total_jam'    => (int) $row->total_jam,
                'hari_mengajar'=> (int) $row->total_hari_mengajar,
            ];
            if ($isSemua) {
                $base = array_merge(['no' => $index + 1, 'tahun' => $row->tahun], array_slice($base, 1));
            }
            return $base;
        });
    }

    public function headings(): array
    {
        $base = ['No', 'NIP', 'Nama Guru', 'Jabatan', 'Bidang Studi', 'Total Jam Mengajar', 'Total Hari Mengajar'];
        if ($this->tahun === 'semua') {
            array_splice($base, 1, 0, ['Tahun']);
        }
        return $base;
    }

    public function title(): string
    {
        return $this->tahun === 'semua' ? 'Jam Mengajar Semua Tahun' : "Jam Mengajar {$this->tahun}";
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow  = $sheet->getHighestRow();
        $lastCol  = $this->tahun === 'semua' ? 'I' : 'H';
        $numStart = $this->tahun === 'semua' ? 'H' : 'G';
        $numEnd   = $this->tahun === 'semua' ? 'I' : 'H';

        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10b981']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'd1fae5']]],
        ]);

        $sheet->getStyle("A2:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'e5e7eb']]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);

        for ($row = 2; $row <= $lastRow; $row++) {
            if ($row % 2 === 0) {
                $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f0fdf4']],
                ]);
            }
        }

        $sheet->getStyle("{$numStart}2:{$numEnd}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(30);

        return [];
    }
}