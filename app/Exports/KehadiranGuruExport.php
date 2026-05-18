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

class KehadiranGuruExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithStyles,
    ShouldAutoSize
{
    protected int|string $tahun;

    public function __construct(int|string $tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $isSemua = $this->tahun === 'semua';

        $q = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g',         'f.id_guru',    '=', 'g.id_guru')
            ->join('dim_waktu as w',        'f.id_waktu',   '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi');

        if (!$isSemua) {
            $q->where('w.tahun', $this->tahun);
        }

        if ($isSemua) {
            $q->selectRaw("
                w.tahun,
                g.nip, g.nama_guru, g.jabatan,
                COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)                            AS total_hadir,
                COUNT(CASE WHEN da.jumlah_sakit  > 0 THEN 1 END)                            AS total_sakit,
                COUNT(CASE WHEN da.jumlah_izin   > 0 THEN 1 END)                            AS total_izin,
                COUNT(CASE WHEN da.jumlah_alpha  > 0 THEN 1 END)                            AS total_alfa,
                ROUND(
                    COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) * 100.0
                    / NULLIF(
                        COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
                        + COUNT(CASE WHEN (da.jumlah_sakit + da.jumlah_izin) > 0 THEN 1 END)
                        + COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END)
                    , 0)
                , 2) AS persen_kehadiran
            ")
            ->groupBy('w.tahun', 'g.id_guru', 'g.nip', 'g.nama_guru', 'g.jabatan')
            ->orderBy('w.tahun')->orderBy('g.nama_guru');
        } else {
            $q->selectRaw("
                g.nip, g.nama_guru, g.jabatan,
                COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)                            AS total_hadir,
                COUNT(CASE WHEN da.jumlah_sakit  > 0 THEN 1 END)                            AS total_sakit,
                COUNT(CASE WHEN da.jumlah_izin   > 0 THEN 1 END)                            AS total_izin,
                COUNT(CASE WHEN da.jumlah_alpha  > 0 THEN 1 END)                            AS total_alfa,
                ROUND(
                    COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) * 100.0
                    / NULLIF(
                        COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
                        + COUNT(CASE WHEN (da.jumlah_sakit + da.jumlah_izin) > 0 THEN 1 END)
                        + COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END)
                    , 0)
                , 2) AS persen_kehadiran
            ")
            ->groupBy('g.id_guru', 'g.nip', 'g.nama_guru', 'g.jabatan')
            ->orderBy('g.nama_guru');
        }

        $rows = $q->get();

        return $rows->map(function ($row, $index) use ($isSemua) {
            $status = match (true) {
                $row->persen_kehadiran >= 90 => 'Baik',
                $row->persen_kehadiran >= 75 => 'Cukup',
                default                      => 'Kurang',
            };

            $base = [
                'no'               => $index + 1,
                'nip'              => $row->nip,
                'nama_guru'        => $row->nama_guru,
                'jabatan'          => $row->jabatan,
                'total_hadir'      => (int) $row->total_hadir,
                'total_sakit'      => (int) $row->total_sakit,
                'total_izin'       => (int) $row->total_izin,
                'total_alfa'       => (int) $row->total_alfa,
                'persen_kehadiran' => (float) $row->persen_kehadiran,
                'status'           => $status,
            ];

            if ($isSemua) {
                $base = array_merge(['no' => $index + 1, 'tahun' => $row->tahun], array_slice($base, 1));
            }

            return $base;
        });
    }

    public function headings(): array
    {
        $base = ['No', 'NIP', 'Nama Guru', 'Jabatan', 'Hadir', 'Sakit', 'Izin', 'Alfa', '% Kehadiran', 'Status'];
        if ($this->tahun === 'semua') {
            array_splice($base, 1, 0, ['Tahun']);
        }
        return $base;
    }

    public function title(): string
    {
        return $this->tahun === 'semua' ? 'Kehadiran Semua Tahun' : "Kehadiran {$this->tahun}";
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow  = $sheet->getHighestRow();
        $isSemua  = $this->tahun === 'semua';
        $lastCol  = $isSemua ? 'K' : 'J';
        $numStart = $isSemua ? 'F' : 'E';
        $numEnd   = $isSemua ? 'J' : 'I';
        $statCol  = $isSemua ? 'K' : 'J';

        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3b82f6']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'bfdbfe']]],
        ]);

        $sheet->getStyle("A2:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'e5e7eb']]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);

        for ($row = 2; $row <= $lastRow; $row++) {
            if ($row % 2 === 0) {
                $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'eff6ff']],
                ]);
            }
        }

        $sheet->getStyle("{$numStart}2:{$numEnd}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("{$statCol}2:{$statCol}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Color-code Status column
        for ($row = 2; $row <= $lastRow; $row++) {
            $statusCell = $sheet->getCell("{$statCol}{$row}")->getValue();
            $color = match ($statusCell) {
                'Baik'  => ['font' => '065f46', 'fill' => 'd1fae5'],
                'Cukup' => ['font' => '92400e', 'fill' => 'fef3c7'],
                default => ['font' => '991b1b', 'fill' => 'fee2e2'],
            };
            $sheet->getStyle("{$statCol}{$row}")->applyFromArray([
                'font' => ['color' => ['rgb' => $color['font']], 'bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color['fill']]],
            ]);
        }

        return [];
    }
}