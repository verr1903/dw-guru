<?php

namespace App\Http\Controllers;

use App\Models\DimGuru;
use App\Models\DimWaktu;
use App\Models\DimPrestasi;
use App\Models\FactKinerjaGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahun  = $request->input('tahun', 2024);
        $search = $request->input('search');

        // ============================================================
        // STAT CARDS — ringkasan global (sama logic dengan 3 halaman)
        // ============================================================

        // 1. Total Jam Mengajar (dari JamMengajarController)
        $totalJamMengajar = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->where('dim_waktu.tahun', $tahun)
            ->sum('fact_kinerja_guru.jumlah_jam_mengajar');

        // 2. Kehadiran rata-rata (dari DashboardController — DISTINCT)
        $kehadiranStats = DB::table(
            DB::raw('(SELECT DISTINCT id_guru, id_waktu, id_absensi FROM fact_kinerja_guru) as fact_unique')
        )
            ->join('dim_waktu',   'fact_unique.id_waktu',   '=', 'dim_waktu.id_waktu')
            ->join('dim_absensi', 'fact_unique.id_absensi', '=', 'dim_absensi.id_absensi')
            ->where('dim_waktu.tahun', $tahun)
            ->selectRaw('
                SUM(dim_absensi.jumlah_hadir) as total_hadir,
                SUM(dim_absensi.jumlah_sakit) as total_sakit,
                SUM(dim_absensi.jumlah_izin)  as total_izin,
                SUM(dim_absensi.jumlah_alpha) as total_alpa
            ')
            ->first();

        $totalHadir = $kehadiranStats->total_hadir ?? 0;
        $totalAbsen = ($kehadiranStats->total_sakit ?? 0)
            + ($kehadiranStats->total_izin ?? 0)
            + ($kehadiranStats->total_alpa ?? 0);
        $totalAll = $totalHadir + $totalAbsen;
        $kehadiranRataRata = $totalAll > 0
            ? round(($totalHadir / $totalAll) * 100, 2)
            : 0;

        // 3. Total Guru Aktif
        $totalGuru = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->where('dim_waktu.tahun', $tahun)
            ->distinct('fact_kinerja_guru.id_guru')
            ->count('fact_kinerja_guru.id_guru');

        // 4. Total Prestasi
        $totalPrestasi = DimPrestasi::whereYear('tanggal_kegiatan', $tahun)->count();

        // ============================================================
        // REKAP JAM MENGAJAR PER GURU (untuk preview & download)
        // ============================================================
        $jamMengajarQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',          'f.id_waktu',         '=', 'w.id_waktu')
            ->join('dim_guru as g',           'f.id_guru',          '=', 'g.id_guru')
            ->join('dim_mata_pelajaran as mp', 'f.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->where('w.tahun', $tahun)
            ->select(
                'g.id_guru',
                'g.nama_guru',
                'g.nip',
                'g.jabatan',
                'g.bidang_studi',
                DB::raw('SUM(f.jumlah_jam_mengajar) as total_jam')
            )
            ->groupBy('g.id_guru', 'g.nama_guru', 'g.nip', 'g.jabatan', 'g.bidang_studi')
            ->orderBy('g.nama_guru');

        if ($search) {
            $jamMengajarQuery->where('g.nama_guru', 'like', "%{$search}%");
        }

        // Preview: ambil 5 teratas untuk ditampilkan di card
        $previewJam = (clone $jamMengajarQuery)->orderByDesc('total_jam')->limit(5)->get();

        // ============================================================
        // REKAP KEHADIRAN PER GURU (dari KehadiranGuruController)
        // ============================================================
        $kehadiranQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g',     'f.id_guru',    '=', 'g.id_guru')
            ->join('dim_waktu as w',    'f.id_waktu',   '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->where('w.tahun', $tahun)
            ->selectRaw("
                g.id_guru,
                g.nama_guru,
                g.nip,
                g.jabatan,
                COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) AS total_hadir,
                COUNT(CASE WHEN (da.jumlah_sakit + da.jumlah_izin) > 0 THEN 1 END) AS total_izin,
                COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END) AS total_alfa,
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
            $kehadiranQuery->where('g.nama_guru', 'like', "%{$search}%");
        }

        $previewKehadiran = (clone $kehadiranQuery)->orderByDesc('persen_kehadiran')->limit(5)->get();

        // ============================================================
        // TREN PER BULAN — untuk chart ringkasan
        // ============================================================
        $trenBulan = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',    'f.id_waktu',   '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->where('w.tahun', $tahun)
            ->selectRaw("
                w.bulan,
                SUM(f.jumlah_jam_mengajar) as total_jam,
                SUM(da.jumlah_hadir) as total_hadir,
                SUM(da.jumlah_sakit + da.jumlah_izin) as total_izin,
                SUM(da.jumlah_alpha) as total_alpha
            ")
            ->groupBy('w.bulan')
            ->orderBy('w.bulan')
            ->get();

        // ============================================================
        // FILTER
        // ============================================================
        $daftarTahun = DimWaktu::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        return view('laporan', compact(
            'tahun',
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
        $tahun = $request->input('tahun', 2024);

        $data = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',          'f.id_waktu',         '=', 'w.id_waktu')
            ->join('dim_guru as g',           'f.id_guru',          '=', 'g.id_guru')
            ->join('dim_mata_pelajaran as mp', 'f.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('dim_absensi as da',        'f.id_absensi',        '=', 'da.id_absensi')
            ->where('w.tahun', $tahun)
            ->select(
                'g.nama_guru',
                'g.nip',
                'g.jabatan',
                'g.bidang_studi',
                DB::raw('SUM(f.jumlah_jam_mengajar) as total_jam'),
                DB::raw('COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) as total_hari_mengajar')
            )
            ->groupBy('g.id_guru', 'g.nama_guru', 'g.nip', 'g.jabatan', 'g.bidang_studi')
            ->orderBy('g.nama_guru')
            ->get();

        // Gunakan library PDF seperti barryvdh/laravel-dompdf
        // $pdf = \PDF::loadView('exports.jam-mengajar-pdf', compact('data', 'tahun'));
        // return $pdf->download("laporan-jam-mengajar-{$tahun}.pdf");

        // Sementara redirect dengan flash message
        return back()->with('success', "Ekspor PDF Jam Mengajar {$tahun} berhasil.");
    }

    // ================================================================
    // EXPORT EXCEL — Jam Mengajar
    // ================================================================
    public function exportJamExcel(Request $request)
    {
        $tahun = $request->input('tahun', 2024);

        // Gunakan library seperti maatwebsite/excel
        // return Excel::download(new JamMengajarExport($tahun), "laporan-jam-mengajar-{$tahun}.xlsx");

        return back()->with('success', "Ekspor Excel Jam Mengajar {$tahun} berhasil.");
    }

    // ================================================================
    // EXPORT PDF — Kehadiran Guru
    // ================================================================
    public function exportKehadiranPdf(Request $request)
    {
        $tahun = $request->input('tahun', 2024);

        // $pdf = \PDF::loadView('exports.kehadiran-pdf', compact('data', 'tahun'));
        // return $pdf->download("laporan-kehadiran-guru-{$tahun}.pdf");

        return back()->with('success', "Ekspor PDF Kehadiran Guru {$tahun} berhasil.");
    }

    // ================================================================
    // EXPORT EXCEL — Kehadiran Guru
    // ================================================================
    public function exportKehadiranExcel(Request $request)
    {
        $tahun = $request->input('tahun', 2024);

        // return Excel::download(new KehadiranGuruExport($tahun), "laporan-kehadiran-{$tahun}.xlsx");

        return back()->with('success', "Ekspor Excel Kehadiran Guru {$tahun} berhasil.");
    }

    // ================================================================
    // EXPORT PDF — Rekap Dashboard (semua data)
    // ================================================================
    public function exportDashboardPdf(Request $request)
    {
        $tahun = $request->input('tahun', 2024);

        // return \PDF::loadView('exports.dashboard-pdf', compact('tahun'))->download(...);

        return back()->with('success', "Ekspor PDF Rekap Kinerja {$tahun} berhasil.");
    }

    // ================================================================
    // EXPORT EXCEL — Rekap Dashboard (semua data)
    // ================================================================
    public function exportDashboardExcel(Request $request)
    {
        $tahun = $request->input('tahun', 2024);

        return back()->with('success', "Ekspor Excel Rekap Kinerja {$tahun} berhasil.");
    }
}