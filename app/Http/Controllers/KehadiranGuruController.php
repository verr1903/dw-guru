<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KehadiranGuruController extends Controller
{
    /**
     * Halaman kehadiran guru — struktur menyesuaikan Power BI dashboard
     * Query utama menggunakan fact_kinerja_guru + dim_guru + dim_waktu + dim_absensi
     */
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', 2024);
        $bulan  = $request->input('bulan');   // null = semua bulan
        $search = $request->input('search');

        // ─── BASE SUBQUERY (sama dengan Power BI) ────────────────────────────
        // SELECT g.id_guru, g.nama_guru, w.tanggal, w.nama_hari, w.bulan, w.tahun,
        //        da.jumlah_hadir, da.jumlah_izin, da.jumlah_alpha,
        //        flag_hadir, flag_izin, flag_alpha, 1 AS total_hari
        // FROM fact_kinerja_guru f
        // JOIN dim_guru g ON f.id_guru = g.id_guru
        // JOIN dim_waktu w ON f.id_waktu = w.id_waktu
        // LEFT JOIN dim_absensi da ON f.id_absensi = da.id_absensi

        // ─── STAT CARDS ──────────────────────────────────────────────────────

        // Total Guru (distinct)
        $totalGuruQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g', 'f.id_guru', '=', 'g.id_guru')
            ->join('dim_waktu as w', 'f.id_waktu', '=', 'w.id_waktu')
            ->where('w.tahun', $tahun);
        if ($bulan) {
            $totalGuruQuery->where('w.bulan', $bulan);
        }
        $totalGuru = (clone $totalGuruQuery)->distinct('g.id_guru')->count('g.id_guru');

        // Agregat kehadiran (flag_hadir, flag_izin, flag_alpha)
        $aggQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g', 'f.id_guru', '=', 'g.id_guru')
            ->join('dim_waktu as w', 'f.id_waktu', '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->where('w.tahun', $tahun)
            ->selectRaw("
    SUM(da.jumlah_hadir) AS total_hadir,
    SUM(da.jumlah_sakit + da.jumlah_izin) AS total_izin,
    SUM(da.jumlah_alpha) AS total_alpha
");
        if ($bulan) {
            $aggQuery->where('w.bulan', $bulan);
        }
        $agg = $aggQuery->first();

        $totalHadir  = $agg->total_hadir  ?? 0;
        $totalIzin   = $agg->total_izin   ?? 0;
        $totalAlpha  = $agg->total_alpha  ?? 0;
        $totalHari   = $agg->total_hari   ?? 1;

        $guruHadir = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g', 'f.id_guru', '=', 'g.id_guru')
            ->join('dim_waktu as w', 'f.id_waktu', '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->where('w.tahun', $tahun)
            ->where('da.jumlah_hadir', '>', 0)
            ->when($bulan, fn($q) => $q->where('w.bulan', $bulan))
            ->distinct()
            ->count('g.id_guru');

        $guruIzin = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g', 'f.id_guru', '=', 'g.id_guru')
            ->join('dim_waktu as w', 'f.id_waktu', '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->where('w.tahun', $tahun)
            ->whereRaw('(da.jumlah_sakit + da.jumlah_izin) > 0')
            ->when($bulan, fn($q) => $q->where('w.bulan', $bulan))
            ->distinct('g.id_guru')
            ->count('g.id_guru');

        $guruAlfa = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g', 'f.id_guru', '=', 'g.id_guru')
            ->join('dim_waktu as w', 'f.id_waktu', '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->where('w.tahun', $tahun)
            ->where('da.jumlah_alpha', '>', 0)
            ->when($bulan, fn($q) => $q->where('w.bulan', $bulan))
            ->distinct('g.id_guru')
            ->count('g.id_guru');
        $totalStatus = $totalHadir + $totalIzin + $totalAlpha;

        $persenKehadiran = $totalStatus > 0
            ? round(($totalHadir / $totalStatus) * 100, 2)
            : 0;

        // ─── TREN KEHADIRAN PER BULAN (dalam %) ──────────────────────────────
        $trenKehadiran = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g', 'f.id_guru', '=', 'g.id_guru')
            ->join('dim_waktu as w', 'f.id_waktu', '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->where('w.tahun', $tahun)
            ->selectRaw("
                w.bulan AS periode_bulan,
                COUNT(*) AS total_hari,
                SUM(da.jumlah_hadir) AS total_hadir,
                SUM(da.jumlah_sakit + da.jumlah_izin) AS total_izin,
                SUM(da.jumlah_alpha) AS total_alpha,

                ROUND(
                    SUM(da.jumlah_hadir) * 100.0 /
                    NULLIF(
                        SUM(da.jumlah_hadir)
                        + SUM(da.jumlah_izin)
                        + SUM(da.jumlah_alpha),
                    0)
                , 2) AS persen_kehadiran
            ")
            ->groupBy('w.bulan')
            ->orderBy('w.bulan')
            ->get();

        // ─── RINGKASAN PER GURU (tabel utama) ────────────────────────────────
        $ringkasanQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_guru as g', 'f.id_guru', '=', 'g.id_guru')
            ->join('dim_waktu as w', 'f.id_waktu', '=', 'w.id_waktu')
            ->leftJoin('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->where('w.tahun', $tahun)
            ->selectRaw("
        g.id_guru,
        g.nama_guru,
        g.nip,
        g.jabatan,

        COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
            AS total_hadir_kerja,

        COUNT(
            CASE
                WHEN (da.jumlah_sakit + da.jumlah_izin) > 0
                THEN 1
            END
        ) AS total_izin,

        COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END)
            AS total_alfa,

        (
            COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
            +
           COUNT(
                CASE
                    WHEN (da.jumlah_sakit + da.jumlah_izin) > 0
                    THEN 1
                END
            )
            +
            COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END)
        ) AS total_hari_kerja,

        ROUND(
            (
                COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
        ) * 100.0
            /
            NULLIF(
                (
                    COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END)
                    +
                    COUNT(
    CASE
        WHEN (da.jumlah_sakit + da.jumlah_izin) > 0
        THEN 1
    END
)
                    +
                    COUNT(CASE WHEN da.jumlah_alpha > 0 THEN 1 END)
                ),
            0)
        , 2) AS persen_kehadiran_guru
    ")
            ->groupBy(
                'g.id_guru',
                'g.nama_guru',
                'g.nip',
                'g.jabatan'
            )
            ->orderBy('g.nama_guru');

        if ($bulan) {
            $ringkasanQuery->where('w.bulan', $bulan);
        }
        if ($search) {
            $ringkasanQuery->where('g.nama_guru', 'like', "%{$search}%");
        }

        $ringkasanGuru = $ringkasanQuery->paginate(15)->withQueryString();

        // ─── FILTER OPTIONS ───────────────────────────────────────────────────
        $daftarTahun = DB::table('dim_waktu')
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $daftarBulan = DB::table('dim_waktu')
            ->select('bulan')
            ->where('tahun', $tahun)
            ->distinct()
            ->orderBy('bulan')
            ->pluck('bulan');

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

        return view('kehadiran-guru', compact(
            'tahun',
            'bulan',
            'search',
            'totalGuru',
            'guruHadir',
            'guruIzin',
            'guruAlfa',
            'persenKehadiran',
            'totalHadir',
            'totalIzin',
            'totalAlpha',
            'totalHari',
            'trenKehadiran',
            'ringkasanGuru',
            'daftarTahun',
            'daftarBulan',
            'namaBulan',
        ));
    }
}
