<?php

namespace App\Http\Controllers;

use App\Exports\JamMengajarExport;
use App\Exports\KehadiranGuruExport;
use App\Exports\RekapKinerjaExport;
use App\Models\DimGuru;
use App\Models\DimWaktu;
use App\Models\DimPrestasi;
use App\Models\FactKinerjaGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // ================================================================
    // Helper: ambil data jam mengajar per guru (reusable)
    // ================================================================
    private function queryJamMengajar(int|string $tahun, ?string $search = null)
    {
        $isSemua = ($tahun === 'semua');

        $q = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',           'f.id_waktu',          '=', 'w.id_waktu')
            ->join('dim_guru as g',            'f.id_guru',           '=', 'g.id_guru')
            ->join('dim_mata_pelajaran as mp', 'f.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('dim_absensi as da',        'f.id_absensi',        '=', 'da.id_absensi')
            ->when(!$isSemua, fn($q) => $q->where('w.tahun', $tahun))
            ->select(
                'g.id_guru',
                'g.nama_guru',
                'g.nip',
                'g.jabatan',
                'g.bidang_studi',
                DB::raw('SUM(f.jumlah_jam_mengajar) as total_jam'),
                DB::raw('COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) as total_hari_mengajar')
            )
            ->groupBy('g.id_guru', 'g.nama_guru', 'g.nip', 'g.jabatan', 'g.bidang_studi')
            ->orderBy('g.nama_guru');

        if ($search) {
            $q->where('g.nama_guru', 'like', "%{$search}%");
        }

        return $q;
    }

    // ================================================================
    // Helper: ambil data kehadiran per guru (reusable)
    // ================================================================
    private function queryKehadiran(int|string $tahun, ?string $search = null)
    {
        $isSemua = ($tahun === 'semua');

        $q = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g',        'f.id_guru',    '=', 'g.id_guru')
            ->join('dim_waktu as w',       'f.id_waktu',   '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->when(!$isSemua, fn($q) => $q->where('w.tahun', $tahun))
            ->selectRaw("
            g.id_guru, g.nama_guru, g.nip, g.jabatan,
            COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) AS total_hadir,
            COUNT(CASE WHEN da.jumlah_sakit  > 0 THEN 1 END) AS total_sakit,
            COUNT(CASE WHEN da.jumlah_izin   > 0 THEN 1 END) AS total_izin,
            COUNT(CASE WHEN da.jumlah_alpha  > 0 THEN 1 END) AS total_alfa,
            ROUND(
                COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) * 100.0
                / NULLIF(
                    COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
                    + COUNT(CASE WHEN (da.jumlah_sakit + da.jumlah_izin) > 0 THEN 1 END)
                    + COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END)
                , 0)
            , 2) AS persen_kehadiran
        ")
            ->groupBy('g.id_guru', 'g.nama_guru', 'g.nip', 'g.jabatan')
            ->orderBy('g.nama_guru');

        if ($search) {
            $q->where('g.nama_guru', 'like', "%{$search}%");
        }

        return $q;
    }

    // ================================================================
    // HALAMAN LAPORAN
    // ================================================================
    public function index(Request $request)
    {
        $tahun  = $request->input('tahun', 'semua');  // ← default 'semua'
        $search = $request->input('search');
        $isSemua = ($tahun === 'semua');

        // ── Stat Cards ────────────────────────────────────────────────
        $totalJamMengajar = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->when(!$isSemua, fn($q) => $q->where('dim_waktu.tahun', $tahun))
            ->sum('fact_kinerja_guru.jumlah_jam_mengajar');

        $kehadiranStats = DB::table(
            DB::raw('(SELECT DISTINCT id_guru, id_waktu, id_absensi FROM fact_kinerja_guru) as fact_unique')
        )
            ->join('dim_waktu',   'fact_unique.id_waktu',   '=', 'dim_waktu.id_waktu')
            ->join('dim_absensi', 'fact_unique.id_absensi', '=', 'dim_absensi.id_absensi')
            ->when(!$isSemua, fn($q) => $q->where('dim_waktu.tahun', $tahun))
            ->selectRaw('
            SUM(dim_absensi.jumlah_hadir) as total_hadir,
            SUM(dim_absensi.jumlah_sakit) as total_sakit,
            SUM(dim_absensi.jumlah_izin)  as total_izin,
            SUM(dim_absensi.jumlah_alpha) as total_alpa
        ')
            ->first();

        $totalHadir        = $kehadiranStats->total_hadir ?? 0;
        $totalAbsen        = ($kehadiranStats->total_sakit ?? 0)
            + ($kehadiranStats->total_izin  ?? 0)
            + ($kehadiranStats->total_alpa  ?? 0);
        $totalAll          = $totalHadir + $totalAbsen;
        $kehadiranRataRata = $totalAll > 0 ? round(($totalHadir / $totalAll) * 100, 2) : 0;

        $totalGuru = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->when(!$isSemua, fn($q) => $q->where('dim_waktu.tahun', $tahun))
            ->distinct('fact_kinerja_guru.id_guru')
            ->count('fact_kinerja_guru.id_guru');

        $totalPrestasi = $isSemua
            ? DimPrestasi::count()
            : DimPrestasi::whereYear('tanggal_kegiatan', $tahun)->count();

        // ── Preview (top 5) ───────────────────────────────────────────
        // Helper query yang support semua tahun
        $previewJam = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',           'f.id_waktu',          '=', 'w.id_waktu')
            ->join('dim_guru as g',            'f.id_guru',           '=', 'g.id_guru')
            ->join('dim_mata_pelajaran as mp', 'f.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('dim_absensi as da',        'f.id_absensi',        '=', 'da.id_absensi')
            ->when(!$isSemua, fn($q) => $q->where('w.tahun', $tahun))
            ->select(
                'g.nama_guru',
                'g.bidang_studi',
                DB::raw('SUM(f.jumlah_jam_mengajar) as total_jam'),
                DB::raw('COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) as total_hari_mengajar')
            )
            ->groupBy('g.id_guru', 'g.nama_guru', 'g.bidang_studi')
            ->orderByDesc('total_jam')
            ->limit(5)
            ->get();

        $previewKehadiran = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g',        'f.id_guru',    '=', 'g.id_guru')
            ->join('dim_waktu as w',       'f.id_waktu',   '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->when(!$isSemua, fn($q) => $q->where('w.tahun', $tahun))
            ->selectRaw("
            g.nama_guru,
            ROUND(
                COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) * 100.0
                / NULLIF(
                    COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
                    + COUNT(CASE WHEN (da.jumlah_sakit + da.jumlah_izin) > 0 THEN 1 END)
                    + COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END)
                , 0)
            , 2) AS persen_kehadiran
        ")
            ->groupBy('g.id_guru', 'g.nama_guru')
            ->orderByDesc('persen_kehadiran')
            ->limit(5)
            ->get();

        // ── Tren Bulanan ──────────────────────────────────────────────
        // Jika semua tahun → group by tahun+bulan, jika tidak → group by bulan
        $trenBulanQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',         'f.id_waktu',   '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da',  'f.id_absensi', '=', 'da.id_absensi')
            ->when(!$isSemua, fn($q) => $q->where('w.tahun', $tahun));

        if ($isSemua) {
            $trenBulan = $trenBulanQuery
                ->selectRaw("
                w.tahun, w.bulan,
                SUM(f.jumlah_jam_mengajar)             as total_jam,
                SUM(da.jumlah_hadir)                   as total_hadir,
                SUM(da.jumlah_sakit + da.jumlah_izin)  as total_izin,
                SUM(da.jumlah_alpha)                   as total_alpha
            ")
                ->groupBy('w.tahun', 'w.bulan')
                ->orderBy('w.tahun')
                ->orderBy('w.bulan')
                ->get();
        } else {
            $trenBulan = $trenBulanQuery
                ->selectRaw("
                w.bulan,
                SUM(f.jumlah_jam_mengajar)             as total_jam,
                SUM(da.jumlah_hadir)                   as total_hadir,
                SUM(da.jumlah_sakit + da.jumlah_izin)  as total_izin,
                SUM(da.jumlah_alpha)                   as total_alpha
            ")
                ->groupBy('w.bulan')
                ->orderBy('w.bulan')
                ->get();
        }

        // ── Filter ────────────────────────────────────────────────────
        $daftarTahun = DimWaktu::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        $namaBulan = [
            1  => 'Jan',
            2  => 'Feb',
            3  => 'Mar',
            4  => 'Apr',
            5  => 'Mei',
            6  => 'Jun',
            7  => 'Jul',
            8  => 'Agu',
            9  => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        return view('laporan', compact(
            'tahun',
            'isSemua',
            'search',
            'totalJamMengajar',
            'kehadiranRataRata',
            'totalGuru',
            'totalPrestasi',
            'previewJam',
            'previewKehadiran',
            'trenBulan',
            'daftarTahun',
            'namaBulan',
        ));
    }

    // ================================================================
    // EXPORT PDF — Jam Mengajar
    // ================================================================
    public function exportJamPdf(Request $request)
    {
        $tahun = $request->input('tahun', 'semua');
        if ($tahun !== 'semua') $tahun = (int) $tahun;

        $data = $this->queryJamMengajar($tahun)->get();

        $pdf = Pdf::loadView('exports.jam-mengajar-pdf', compact('data', 'tahun'))
            ->setPaper('a4', 'landscape')
            ->setOption('defaultFont', 'DejaVu Sans');

        $filename = $tahun === 'semua' ? 'laporan-jam-mengajar-semua-tahun.pdf' : "laporan-jam-mengajar-{$tahun}.pdf";
        return $pdf->download($filename);
    }

    // ================================================================
    // EXPORT EXCEL — Jam Mengajar
    // ================================================================
    public function exportJamExcel(Request $request)
    {
        $tahun = $request->input('tahun', 'semua');
        if ($tahun !== 'semua') $tahun = (int) $tahun;

        $filename = $tahun === 'semua' ? 'laporan-jam-mengajar-semua-tahun.xlsx' : "laporan-jam-mengajar-{$tahun}.xlsx";
        return Excel::download(new JamMengajarExport($tahun), $filename);
    }

    // ================================================================
    // EXPORT PDF — Kehadiran Guru
    // ================================================================
    public function exportKehadiranPdf(Request $request)
    {
        $tahun = $request->input('tahun', 'semua');
        if ($tahun !== 'semua') $tahun = (int) $tahun;

        $data = $this->queryKehadiran($tahun)->get();

        $pdf = Pdf::loadView('exports.kehadiran-pdf', compact('data', 'tahun'))
            ->setPaper('a4', 'landscape')
            ->setOption('defaultFont', 'DejaVu Sans');

        $filename = $tahun === 'semua' ? 'laporan-kehadiran-guru-semua-tahun.pdf' : "laporan-kehadiran-guru-{$tahun}.pdf";
        return $pdf->download($filename);
    }

    // ================================================================
    // EXPORT EXCEL — Kehadiran Guru
    // ================================================================
    public function exportKehadiranExcel(Request $request)
    {
        $tahun = $request->input('tahun', 'semua');
        if ($tahun !== 'semua') $tahun = (int) $tahun;

        $filename = $tahun === 'semua' ? 'laporan-kehadiran-guru-semua-tahun.xlsx' : "laporan-kehadiran-guru-{$tahun}.xlsx";
        return Excel::download(new KehadiranGuruExport($tahun), $filename);
    }

    // ================================================================
    // EXPORT PDF — Rekap Dashboard (semua data, multi-section)
    // ================================================================
    public function exportDashboardPdf(Request $request)
    {
        $tahun = $request->input('tahun', 'semua');
        if ($tahun !== 'semua') $tahun = (int) $tahun;
        $isSemua = ($tahun === 'semua');

        $totalJamMengajar = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->when(!$isSemua, fn($q) => $q->where('dim_waktu.tahun', $tahun))
            ->sum('fact_kinerja_guru.jumlah_jam_mengajar');

        $kehadiranStats = DB::table(DB::raw('(SELECT DISTINCT id_guru, id_waktu, id_absensi FROM fact_kinerja_guru) as fact_unique'))
            ->join('dim_waktu',   'fact_unique.id_waktu',   '=', 'dim_waktu.id_waktu')
            ->join('dim_absensi', 'fact_unique.id_absensi', '=', 'dim_absensi.id_absensi')
            ->when(!$isSemua, fn($q) => $q->where('dim_waktu.tahun', $tahun))
            ->selectRaw('
            SUM(dim_absensi.jumlah_hadir) as total_hadir,
            SUM(dim_absensi.jumlah_sakit) as total_sakit,
            SUM(dim_absensi.jumlah_izin)  as total_izin,
            SUM(dim_absensi.jumlah_alpha) as total_alpa
        ')
            ->first();

        $totalHadir        = $kehadiranStats->total_hadir ?? 0;
        $totalAbsen        = ($kehadiranStats->total_sakit ?? 0) + ($kehadiranStats->total_izin ?? 0) + ($kehadiranStats->total_alpa ?? 0);
        $totalAll          = $totalHadir + $totalAbsen;
        $kehadiranRataRata = $totalAll > 0 ? round(($totalHadir / $totalAll) * 100, 2) : 0;

        $totalGuru     = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->when(!$isSemua, fn($q) => $q->where('dim_waktu.tahun', $tahun))
            ->distinct('fact_kinerja_guru.id_guru')
            ->count('fact_kinerja_guru.id_guru');

        $totalPrestasi = $isSemua ? DimPrestasi::count() : DimPrestasi::whereYear('tanggal_kegiatan', $tahun)->count();

        $jamData       = $this->queryJamMengajar($tahun)->get();
        $kehadiranData = $this->queryKehadiran($tahun)->get();

        $trenBulanQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',        'f.id_waktu',   '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->when(!$isSemua, fn($q) => $q->where('w.tahun', $tahun));

        if ($isSemua) {
            $trenBulan = $trenBulanQuery
                ->selectRaw("w.tahun, w.bulan, SUM(f.jumlah_jam_mengajar) as total_jam, SUM(da.jumlah_hadir) as total_hadir, SUM(da.jumlah_sakit + da.jumlah_izin) as total_izin, SUM(da.jumlah_alpha) as total_alpha")
                ->groupBy('w.tahun', 'w.bulan')->orderBy('w.tahun')->orderBy('w.bulan')->get();
        } else {
            $trenBulan = $trenBulanQuery
                ->selectRaw("w.bulan, SUM(f.jumlah_jam_mengajar) as total_jam, SUM(da.jumlah_hadir) as total_hadir, SUM(da.jumlah_sakit + da.jumlah_izin) as total_izin, SUM(da.jumlah_alpha) as total_alpha")
                ->groupBy('w.bulan')->orderBy('w.bulan')->get();
        }

        $namaBulan = [
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

        $pdf = Pdf::loadView('exports.dashboard-pdf', compact(
            'tahun',
            'isSemua',
            'totalJamMengajar',
            'kehadiranRataRata',
            'totalGuru',
            'totalPrestasi',
            'jamData',
            'kehadiranData',
            'trenBulan',
            'namaBulan'
        ))
            ->setPaper('a4', 'landscape')
            ->setOption('defaultFont', 'DejaVu Sans');

        $filename = $isSemua ? 'rekap-kinerja-guru-semua-tahun.pdf' : "rekap-kinerja-guru-{$tahun}.pdf";
        return $pdf->download($filename);
    }

    // ================================================================
    // EXPORT EXCEL — Rekap Dashboard (multi-sheet)
    // ================================================================
    public function exportDashboardExcel(Request $request)
    {
        $tahun = $request->input('tahun', 'semua');
        if ($tahun !== 'semua') $tahun = (int) $tahun;

        // RekapKinerjaExport sudah punya sheets yang support 'semua' via JamMengajarExport & KehadiranGuruExport
        $filename = $tahun === 'semua' ? 'rekap-kinerja-guru-semua-tahun.xlsx' : "rekap-kinerja-guru-{$tahun}.xlsx";
        return Excel::download(new RekapKinerjaExport($tahun), $filename);
    }
}
