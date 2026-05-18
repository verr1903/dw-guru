<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\DimPrestasi;
use App\Models\FactKinerjaGuru;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RekapKinerjaRingkasanSheet implements FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    protected int|string $tahun;

    protected array $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    public function __construct(int|string $tahun)
    {
        $this->tahun = $tahun;
    }

    public function array(): array
    {
        $isSemua   = $this->tahun === 'semua';
        $labelJudul = $isSemua ? 'Semua Tahun' : $this->tahun;

        // ── Stat Cards ────────────────────────────────────────────────
        $jamQ = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu');
        if (!$isSemua) $jamQ->where('dim_waktu.tahun', $this->tahun);
        $totalJam = $jamQ->sum('fact_kinerja_guru.jumlah_jam_mengajar');

        $guruQ = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu');
        if (!$isSemua) $guruQ->where('dim_waktu.tahun', $this->tahun);
        $totalGuru = $guruQ->distinct('fact_kinerja_guru.id_guru')->count('fact_kinerja_guru.id_guru');

        $presQ = DimPrestasi::query();
        if (!$isSemua) $presQ->whereYear('tanggal_kegiatan', $this->tahun);
        $totalPrestasi = $presQ->count();

        $statQ = DB::table(DB::raw('(SELECT DISTINCT id_guru, id_waktu, id_absensi FROM fact_kinerja_guru) as fact_unique'))
            ->join('dim_waktu',   'fact_unique.id_waktu',   '=', 'dim_waktu.id_waktu')
            ->join('dim_absensi', 'fact_unique.id_absensi', '=', 'dim_absensi.id_absensi');
        if (!$isSemua) $statQ->where('dim_waktu.tahun', $this->tahun);
        $kehadiranStats = $statQ->selectRaw('
            SUM(dim_absensi.jumlah_hadir) as total_hadir,
            SUM(dim_absensi.jumlah_sakit) as total_sakit,
            SUM(dim_absensi.jumlah_izin)  as total_izin,
            SUM(dim_absensi.jumlah_alpha) as total_alpa
        ')->first();

        $totalHadir = $kehadiranStats->total_hadir ?? 0;
        $totalAbsen = ($kehadiranStats->total_sakit ?? 0) + ($kehadiranStats->total_izin ?? 0) + ($kehadiranStats->total_alpa ?? 0);
        $totalAll   = $totalHadir + $totalAbsen;
        $pctHadir   = $totalAll > 0 ? round(($totalHadir / $totalAll) * 100, 2) : 0;

        // ── Tren Bulanan ──────────────────────────────────────────────
        $trenQ = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',         'f.id_waktu',   '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da',  'f.id_absensi', '=', 'da.id_absensi');
        if (!$isSemua) $trenQ->where('w.tahun', $this->tahun);

        if ($isSemua) {
            $trenQ->selectRaw("
                w.tahun, w.bulan,
                SUM(f.jumlah_jam_mengajar)            as total_jam,
                SUM(da.jumlah_hadir)                  as total_hadir,
                SUM(da.jumlah_sakit + da.jumlah_izin) as total_izin,
                SUM(da.jumlah_alpha)                  as total_alpha
            ")->groupBy('w.tahun', 'w.bulan')->orderBy('w.tahun')->orderBy('w.bulan');
        } else {
            $trenQ->selectRaw("
                w.bulan,
                SUM(f.jumlah_jam_mengajar)            as total_jam,
                SUM(da.jumlah_hadir)                  as total_hadir,
                SUM(da.jumlah_sakit + da.jumlah_izin) as total_izin,
                SUM(da.jumlah_alpha)                  as total_alpha
            ")->groupBy('w.bulan')->orderBy('w.bulan');
        }

        $trenBulan = $trenQ->get();

        // ── Build array ───────────────────────────────────────────────
        $rows[] = ["REKAP KINERJA GURU — {$labelJudul}"];                   // Row 1
        $rows[] = ["SMA Cendana Pekanbaru"];                                 // Row 2
        $rows[] = ['RINGKASAN UMUM'];                                        // Row 3  ← hapus [] sebelumnya
        $rows[] = ['Total Jam Mengajar', number_format($totalJam), 'jam'];  // Row 4
        $rows[] = ['Tingkat Kehadiran',  "{$pctHadir}%", ''];               // Row 5
        $rows[] = ['Guru Aktif',         $totalGuru, 'guru'];               // Row 6
        $rows[] = ['TREN BULANAN'];                                          // Row 7

        if ($isSemua) {
            $rows[] = ['Tahun', 'Bulan', 'Total Jam', 'Hadir', 'Izin/Sakit', 'Alfa']; // Row 10 ← naik dari 11
            foreach ($trenBulan as $t) {
                $rows[] = [
                    $t->tahun,
                    $this->namaBulan[$t->bulan] ?? $t->bulan,
                    (int) $t->total_jam,
                    (int) $t->total_hadir,
                    (int) $t->total_izin,
                    (int) $t->total_alpha,
                ];
            }
            $rows[] = [
                'Total',
                '',
                (int) $trenBulan->sum('total_jam'),
                (int) $trenBulan->sum('total_hadir'),
                (int) $trenBulan->sum('total_izin'),
                (int) $trenBulan->sum('total_alpha'),
            ];
        } else {
            $rows[] = ['Bulan', 'Total Jam', 'Hadir', 'Izin/Sakit', 'Alfa']; // Row 10
            foreach ($trenBulan as $t) {
                $rows[] = [
                    $this->namaBulan[$t->bulan] ?? $t->bulan,
                    (int) $t->total_jam,
                    (int) $t->total_hadir,
                    (int) $t->total_izin,
                    (int) $t->total_alpha,
                ];
            }
            $rows[] = [
                'Total',
                (int) $trenBulan->sum('total_jam'),
                (int) $trenBulan->sum('total_hadir'),
                (int) $trenBulan->sum('total_izin'),
                (int) $trenBulan->sum('total_alpha'),
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return $this->tahun === 'semua' ? 'Ringkasan Semua Tahun' : "Ringkasan {$this->tahun}";
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '111827']],
        ]);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 11, 'color' => ['rgb' => '6b7280']],
        ]);

        // RINGKASAN UMUM → row 3
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '374151']],
        ]);

        // Isi ringkasan → row 4, 5, 6 (bukan range 5–8 yang menimpa A7)
        foreach (range(4, 6) as $r) {
            $sheet->getStyle("A{$r}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => '374151']],
            ]);
        }

        // TREN BULANAN → row 7
        $sheet->getStyle('A7')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '374151']],
        ]);

        // Header kolom tren → row 8
        $lastCol = $this->tahun === 'semua' ? 'F' : 'E';
        $sheet->getStyle("A8:{$lastCol}8")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '6b7280']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'd1d5db']]],
        ]);
        $sheet->getRowDimension(8)->setRowHeight(22);

        // Data mulai row 9
        $lastRow = $sheet->getHighestRow();
        for ($r = 9; $r <= $lastRow; $r++) {
            $isLast = ($r === $lastRow);
            $sheet->getStyle("A{$r}:{$lastCol}{$r}")->applyFromArray([
                'font' => $isLast ? ['bold' => true] : [],
                'fill' => $isLast
                    ? ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f3f4f6']]
                    : ($r % 2 === 0
                        ? ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f9fafb']]
                        : []),
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'e5e7eb']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $numCol = $this->tahun === 'semua' ? 'C' : 'B';
            $sheet->getStyle("{$numCol}{$r}:{$lastCol}{$r}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        return [];
    }
}
