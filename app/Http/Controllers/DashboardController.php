<?php

namespace App\Http\Controllers;

use App\Models\FactKinerjaGuru;
use App\Models\DimGuru;
use App\Models\DimWaktu;
use App\Models\DimPrestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // ================================================================
    //  MAIN DASHBOARD
    // ================================================================
    public function index(Request $request)
    {
        $tahun  = $request->input('tahun', 2024);
        $search = $request->input('search');
        $mapel  = $request->input('mapel');


        // ============================================================
        // STAT CARD 1 — Total Jam Mengajar
        // ============================================================
        $totalJamMengajar = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->where('dim_waktu.tahun', $tahun)
            ->sum('fact_kinerja_guru.jumlah_jam_mengajar');

        $totalJamTahunLalu = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->where('dim_waktu.tahun', $tahun - 1)
            ->sum('fact_kinerja_guru.jumlah_jam_mengajar');

        $persenPerubahanJam = $totalJamTahunLalu > 0
            ? round((($totalJamMengajar - $totalJamTahunLalu) / $totalJamTahunLalu) * 100)
            : 0;

        // ============================================================
        // STAT CARD 2 — Kehadiran Rata-rata
        // ============================================================
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
            + ($kehadiranStats->total_izin  ?? 0)
            + ($kehadiranStats->total_alpa  ?? 0);
        $totalAll   = $totalHadir + $totalAbsen;

        $kehadiranRataRata = $totalAll > 0
            ? round(($totalHadir / $totalAll) * 100, 2)
            : 0;

        $kehadiranStatsTahunLalu = DB::table(
            DB::raw('(SELECT DISTINCT id_guru, id_waktu, id_absensi FROM fact_kinerja_guru) as fact_unique')
        )
            ->join('dim_waktu',   'fact_unique.id_waktu',   '=', 'dim_waktu.id_waktu')
            ->join('dim_absensi', 'fact_unique.id_absensi', '=', 'dim_absensi.id_absensi')
            ->where('dim_waktu.tahun', $tahun - 1)
            ->selectRaw('
                SUM(dim_absensi.jumlah_hadir) as total_hadir,
                SUM(dim_absensi.jumlah_sakit) as total_sakit,
                SUM(dim_absensi.jumlah_izin)  as total_izin,
                SUM(dim_absensi.jumlah_alpha) as total_alpa
            ')
            ->first();

        $totalHadirLalu = $kehadiranStatsTahunLalu->total_hadir ?? 0;
        $totalAbsenLalu = ($kehadiranStatsTahunLalu->total_sakit ?? 0)
            + ($kehadiranStatsTahunLalu->total_izin  ?? 0)
            + ($kehadiranStatsTahunLalu->total_alpa  ?? 0);
        $totalAllLalu   = $totalHadirLalu + $totalAbsenLalu;

        $kehadiranRataRataTahunLalu = $totalAllLalu > 0
            ? round(($totalHadirLalu / $totalAllLalu) * 100, 2)
            : 0;

        $persenPerubahanKehadiran = round($kehadiranRataRata - $kehadiranRataRataTahunLalu, 2);

        // ============================================================
        // STAT CARD 3 — Guru Aktif
        // ============================================================
        $guruAktif = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->where('dim_waktu.tahun', $tahun)
            ->distinct('fact_kinerja_guru.id_guru')
            ->count('fact_kinerja_guru.id_guru');

        $guruAktifTahunLalu = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->where('dim_waktu.tahun', $tahun - 1)
            ->distinct('fact_kinerja_guru.id_guru')
            ->count('fact_kinerja_guru.id_guru');

        $selisihGuruAktif = $guruAktif - $guruAktifTahunLalu;

        // ============================================================
        // STAT CARD 4 — Total Prestasi
        // ============================================================
        $totalPrestasi          = DimPrestasi::whereYear('tanggal_kegiatan', $tahun)->count();
        $totalPrestasiTahunLalu = DimPrestasi::whereYear('tanggal_kegiatan', $tahun - 1)->count();
        $selisihPrestasi        = $totalPrestasi - $totalPrestasiTahunLalu;

        // ============================================================
        // CHART — Tren Jam Mengajar per Bulan (Power BI query style)
        // SELECT w.bulan, SUM(f.jumlah_jam_mengajar) AS total_jam
        // FROM fact_kinerja_guru f
        // JOIN dim_waktu w ON w.id_waktu = f.id_waktu
        // WHERE w.tahun = :tahun
        // GROUP BY w.bulan
        // ============================================================
        $trenJamPerBulan = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->where('dim_waktu.tahun', $tahun)
            ->selectRaw('dim_waktu.bulan as periode_bulan, SUM(fact_kinerja_guru.jumlah_jam_mengajar) as total_jam')
            ->groupBy('dim_waktu.bulan')
            ->orderBy('dim_waktu.bulan')
            ->pluck('total_jam', 'periode_bulan')
            ->toArray();

        $trenJamPerTahun = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->selectRaw('dim_waktu.tahun as tahun, SUM(fact_kinerja_guru.jumlah_jam_mengajar) as total_jam')
            ->groupBy('dim_waktu.tahun')
            ->orderBy('dim_waktu.tahun')
            ->pluck('total_jam', 'tahun')
            ->toArray();

        // ============================================================
        // CHART — Perbandingan Kinerja Antar Semester (Donut)
        // ============================================================
        $trenSemester = FactKinerjaGuru::join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->where('dim_waktu.tahun', $tahun)
            ->selectRaw('
                CASE WHEN dim_waktu.bulan BETWEEN 1 AND 6 THEN 1 ELSE 2 END as semester,
                SUM(fact_kinerja_guru.jumlah_jam_mengajar) as total_jam
            ')
            ->groupByRaw('CASE WHEN dim_waktu.bulan BETWEEN 1 AND 6 THEN 1 ELSE 2 END')
            ->orderBy('semester')
            ->get();

        // ============================================================
        // TOP 5 GURU — Jam Mengajar
        // ============================================================
        $topGuruJam = DB::table('fact_kinerja_guru')
            ->join('dim_guru',  'fact_kinerja_guru.id_guru',  '=', 'dim_guru.id_guru')
            ->join('dim_waktu', 'fact_kinerja_guru.id_waktu', '=', 'dim_waktu.id_waktu')
            ->where('dim_waktu.tahun', $tahun)
            ->selectRaw('dim_guru.nama_guru, dim_guru.bidang_studi, SUM(fact_kinerja_guru.jumlah_jam_mengajar) as total_jam')
            ->groupBy('dim_guru.nama_guru', 'dim_guru.bidang_studi')
            ->orderByDesc('total_jam')
            ->limit(5)
            ->get();

        // ============================================================
        // TABLE — Rekap Kinerja Guru (paginated)
        // Identik dengan Power BI query — per guru per bulan
        // SELECT g.nama_guru, w.tahun, w.bulan,
        //        SUM(f.jumlah_jam_mengajar) AS total_jam_mengajar,
        //        SUM(da.jumlah_hadir) AS total_hadir,
        //        SUM(da.jumlah_sakit) AS total_sakit,
        //        SUM(da.jumlah_izin)  AS total_izin
        // FROM fact_kinerja_guru f
        // JOIN dim_absensi da ON da.id_absensi = f.id_absensi
        // JOIN dim_guru    g  ON g.id_guru     = f.id_guru
        // JOIN dim_waktu   w  ON w.id_waktu    = f.id_waktu
        // GROUP BY g.nama_guru, w.tahun, w.bulan
        // ============================================================
        $guruQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_absensi as da', 'da.id_absensi', '=', 'f.id_absensi')
            ->join('dim_guru as g',     'g.id_guru',     '=', 'f.id_guru')
            ->join('dim_waktu as w',    'w.id_waktu',    '=', 'f.id_waktu')
            ->where('w.tahun', $tahun)
            ->selectRaw('
                            g.id_guru,
                            g.nama_guru,
                            g.bidang_studi,
                            g.nip,
                            SUM(f.jumlah_jam_mengajar) AS total_jam_mengajar,

                            COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
                                AS total_hadir,

                            COUNT(CASE WHEN da.jumlah_sakit > 0 THEN 1 END)
                                AS total_sakit,

                            COUNT(CASE WHEN da.jumlah_izin > 0 THEN 1 END)
                                AS total_izin,

                            COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END)
                                AS total_alfa
                        ')
            ->groupBy('g.id_guru', 'g.nama_guru', 'g.bidang_studi', 'g.nip');
        // ↑ w.tahun dan w.bulan dihapus dari SELECT dan GROUP BY

        if ($search) {
            $guruQuery->where('g.nama_guru', 'like', "%{$search}%");
        }
        if ($mapel) {
            $guruQuery->where('g.bidang_studi', 'like', "%{$mapel}%");
        }

        $guruData = $guruQuery
            ->orderBy('g.nama_guru')
            ->paginate(10)
            ->appends(['tahun' => $tahun, 'search' => $search, 'mapel' => $mapel]);

        // ============================================================
        // FILTER DROPDOWN
        // ============================================================
        $daftarMapel = DimGuru::select('bidang_studi')
            ->whereNotNull('bidang_studi')
            ->where('bidang_studi', '!=', '-')
            ->distinct()
            ->orderBy('bidang_studi')
            ->pluck('bidang_studi');

        $daftarTahun = DimWaktu::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $namaBulan = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        // ============================================================
        // STAT CARDS — Ringkasan Kehadiran (hari ini / tahun berjalan)
        // ============================================================
        $kehadiranRingkasan = DB::table(
            DB::raw('(SELECT DISTINCT id_guru, id_waktu, id_absensi FROM fact_kinerja_guru) as fact_unique')
        )
            ->join('dim_waktu',   'fact_unique.id_waktu',   '=', 'dim_waktu.id_waktu')
            ->join('dim_absensi', 'fact_unique.id_absensi', '=', 'dim_absensi.id_absensi')
            ->where('dim_waktu.tahun', $tahun)
            ->selectRaw('
                            SUM(dim_absensi.jumlah_hadir) as total_hadir,
                            SUM(dim_absensi.jumlah_sakit + dim_absensi.jumlah_izin) as total_izin,
                            SUM(dim_absensi.jumlah_alpha) as total_alfa
                        ')
            ->first();

        $totalGuru     = $guruAktif; // guru yang aktif di tahun berjalan
        $guruHadir     = $kehadiranRingkasan->total_hadir ?? 0;
        $guruIzin      = $kehadiranRingkasan->total_izin  ?? 0;
        $guruAlfa      = $kehadiranRingkasan->total_alfa   ?? 0;
        $totalAbsenAll = $guruHadir + $guruIzin + $guruAlfa;
        $persenKehadiran = $totalAbsenAll > 0
            ? round(($guruHadir / $totalAbsenAll) * 100, 1)
            : 0;

        return view('dashboard', compact(
            'tahun',
            'totalJamMengajar',
            'persenPerubahanJam',
            'kehadiranRataRata',
            'kehadiranRataRataTahunLalu',
            'persenPerubahanKehadiran',
            'guruAktif',
            'guruAktifTahunLalu',
            'selisihGuruAktif',
            'totalPrestasi',
            'totalPrestasiTahunLalu',
            'selisihPrestasi',
            'trenJamPerBulan',
            'trenSemester',
            'topGuruJam',
            'guruData',
            'daftarMapel',
            'daftarTahun',
            'namaBulan',
            'search',
            'mapel',
            'trenJamPerTahun',
            'totalGuru',
            'guruHadir',
            'guruIzin',
            'guruAlfa',
            'persenKehadiran',
        ));
    }

    // ================================================================
    //  DETAIL PER BULAN (AJAX) — untuk modal di dashboard
    //  Route: GET /dashboard/detail-bulan?id_guru=&tahun=
    // ================================================================
    public function detailBulan(Request $request)
    {
        $idGuru = $request->input('id_guru');
        $tahun  = $request->input('tahun');

        $data = DB::table('fact_kinerja_guru as f')
            ->join('dim_absensi as da', 'da.id_absensi', '=', 'f.id_absensi')
            ->join('dim_guru as g',     'g.id_guru',     '=', 'f.id_guru')
            ->join('dim_waktu as w',    'w.id_waktu',    '=', 'f.id_waktu')
            ->where('g.id_guru', $idGuru)
            ->where('w.tahun', $tahun)
            ->selectRaw('
            w.bulan,
            SUM(f.jumlah_jam_mengajar) AS total_jam_mengajar,

            COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
                AS total_hadir,

            COUNT(CASE WHEN da.jumlah_sakit > 0 THEN 1 END)
                AS total_sakit,

            COUNT(CASE WHEN da.jumlah_izin > 0 THEN 1 END)
                AS total_izin,

            COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END)
                AS total_alfa
        ')
            ->groupBy('w.bulan')
            ->orderBy('w.bulan')
            ->get();

        return response()->json($data);
    }
}
