<?php

namespace App\Http\Controllers;

use App\Models\FactKinerjaGuru;
use App\Models\DimGuru;
use App\Models\DimWaktu;
use App\Models\DimMataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JamMengajarController extends Controller
{
    public function index(Request $request)
    {
        $tahun  = $request->input('tahun', 'all'); // 'all' = semua tahun (default)
        $search = $request->input('search');
        $mapel  = $request->input('mapel');
        $guru   = $request->input('guru');
        $isAll  = ($tahun === 'all');

        // ── Daftar pilihan filter ─────────────────────────────────────
        $daftarTahun = DimWaktu::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $daftarGuru  = DimGuru::orderBy('nama_guru')->pluck('nama_guru');
        $daftarMapel = DimMataPelajaran::orderBy('nama_mata_pelajaran')
            ->pluck('nama_mata_pelajaran');

        // ── Base join ─────────────────────────────────────────────────
        $baseQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',           'f.id_waktu',          '=', 'w.id_waktu')
            ->join('dim_guru as g',            'f.id_guru',           '=', 'g.id_guru')
            ->join('dim_mata_pelajaran as mp', 'f.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran');

        // Terapkan slicer global
        if (!$isAll) $baseQuery->where('w.tahun', $tahun);
        if ($guru)   $baseQuery->where('g.nama_guru', $guru);
        if ($mapel)  $baseQuery->where('mp.nama_mata_pelajaran', $mapel);

        // ── CHART 1: Distribusi Jam Per Guru (Donut) ──────────────────
        $distribusiPerGuru = (clone $baseQuery)
            ->select('g.nama_guru', DB::raw('SUM(f.jumlah_jam_mengajar) as total_jam'))
            ->groupBy('g.id_guru', 'g.nama_guru')
            ->orderByDesc('total_jam')
            ->get()
            ->map(fn($item) => [
                'nama_guru' => $item->nama_guru,
                'total_jam' => (int) $item->total_jam,
            ]);

        $totalJamKeseluruhan = $distribusiPerGuru->sum('total_jam');
        $distribusiPerGuru   = $distribusiPerGuru->map(function ($item) use ($totalJamKeseluruhan) {
            $item['persentase'] = $totalJamKeseluruhan > 0
                ? round(($item['total_jam'] / $totalJamKeseluruhan) * 100)
                : 0;
            return $item;
        })->values();

        // ── CHART 2: Beban Per Mata Pelajaran (Bar) ───────────────────
        $bebanPerMapel = (clone $baseQuery)
            ->select('mp.nama_mata_pelajaran', DB::raw('SUM(f.jumlah_jam_mengajar) as total_jam'))
            ->groupBy('mp.nama_mata_pelajaran')
            ->orderByDesc('total_jam')
            ->get()
            ->map(fn($item) => [
                'nama_mata_pelajaran' => $item->nama_mata_pelajaran,
                'total_jam'           => (int) $item->total_jam,
            ])
            ->values();

        // ── CHART 3: Tren Per Bulan (Line) ───────────────────────────
        // Saat isAll: group by tahun+bulan agar muncul semua titik
        $trenPerBulan = (clone $baseQuery)
            ->select(
                'w.bulan',
                'w.tahun',
                DB::raw('SUM(f.jumlah_jam_mengajar) as total_jam'),
                DB::raw('SUM(f.jumlah_kehadiran) as total_kehadiran')
            )
            ->groupBy('w.bulan', 'w.tahun')
            ->orderBy('w.tahun')
            ->orderBy('w.bulan')
            ->get()
            ->map(fn($item) => [
                'bulan'           => (int) $item->bulan,
                // label X-axis: kalau all tampilkan "Jan 2023", kalau per tahun cukup "Jan"
                'nama_bulan'      => $isAll
                    ? $this->namaBulan((int) $item->bulan) . ' ' . $item->tahun
                    : $this->namaBulan((int) $item->bulan),
                'total_jam'       => (int) $item->total_jam,
                'total_kehadiran' => (int) $item->total_kehadiran,
            ])
            ->values();

        // ── TABLE DATA ────────────────────────────────────────────────
        $tableQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',    'f.id_waktu',   '=', 'w.id_waktu')
            ->join('dim_guru as g',     'f.id_guru',    '=', 'g.id_guru')
            ->join('dim_absensi as da', 'f.id_absensi', '=', 'da.id_absensi')
            ->select(
                'g.id_guru',
                'g.nama_guru',
                DB::raw('SUM(f.jumlah_jam_mengajar) as jumlah_jam_mengajar'),
                DB::raw('COUNT(da.id_absensi) as total_hari_mengajar'),
                DB::raw('COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) as jumlah_kehadiran'),
            )
            ->groupBy('g.id_guru', 'g.nama_guru');

        if (!$isAll) $tableQuery->where('w.tahun', $tahun);
        if ($guru)   $tableQuery->where('g.nama_guru', $guru);
        if ($search) $tableQuery->where('g.nama_guru', 'like', "%{$search}%");

        $tableData = $tableQuery
            ->orderBy('g.nama_guru')
            ->paginate(10)
            ->appends(['tahun' => $tahun, 'search' => $search, 'mapel' => $mapel, 'guru' => $guru]);

        return view('jam-mengajar', compact(
            'tahun', 'isAll',
            'guru', 'mapel', 'search',
            'distribusiPerGuru', 'bebanPerMapel', 'trenPerBulan',
            'tableData', 'daftarGuru', 'daftarMapel', 'daftarTahun',
        ));
    }

    private function namaBulan(int $bulan): string
    {
        return [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ][$bulan] ?? '';
    }

    public function detailGuru(Request $request)
    {
        $idGuru = $request->input('id_guru');
        $tahun  = $request->input('tahun');
        $isAll  = ($tahun === 'all' || !$tahun);

        $jamQuery = DB::table('fact_kinerja_guru as f')
            ->join('dim_waktu as w',           'f.id_waktu',          '=', 'w.id_waktu')
            ->join('dim_mata_pelajaran as mp', 'f.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->select(
                'w.bulan', 'w.tahun', 'mp.nama_mata_pelajaran',
                DB::raw('SUM(f.jumlah_jam_mengajar) as jumlah_jam_mengajar'),
            )
            ->where('f.id_guru', $idGuru)
            ->when(!$isAll, fn($q) => $q->where('w.tahun', $tahun))
            ->groupBy('w.tahun', 'w.bulan', 'mp.nama_mata_pelajaran')
            ->get()
            ->keyBy(fn($r) => $r->tahun . '-' . $r->bulan . '-' . $r->nama_mata_pelajaran);

        $hadirQuery = DB::table(
            DB::raw('(SELECT DISTINCT id_guru, id_waktu, id_mata_pelajaran, id_absensi FROM fact_kinerja_guru WHERE id_guru = ' . (int)$idGuru . ') as f')
        )
            ->join('dim_waktu as w',           'f.id_waktu',          '=', 'w.id_waktu')
            ->join('dim_mata_pelajaran as mp', 'f.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('dim_absensi as da',        'f.id_absensi',        '=', 'da.id_absensi')
            ->select(
                'w.bulan', 'w.tahun', 'mp.nama_mata_pelajaran',
                DB::raw('COUNT(CASE WHEN da.jumlah_hadir > 0 THEN 1 END) as jumlah_kehadiran'),
            )
            ->when(!$isAll, fn($q) => $q->where('w.tahun', $tahun))
            ->groupBy('w.tahun', 'w.bulan', 'mp.nama_mata_pelajaran')
            ->get()
            ->keyBy(fn($r) => $r->tahun . '-' . $r->bulan . '-' . $r->nama_mata_pelajaran);

        $rows = $jamQuery->map(function ($item) use ($hadirQuery) {
            $key   = $item->tahun . '-' . $item->bulan . '-' . $item->nama_mata_pelajaran;
            $hadir = $hadirQuery->get($key);
            return [
                'bulan'               => (int) $item->bulan,
                'nama_bulan'          => $this->namaBulan((int) $item->bulan),
                'tahun'               => $item->tahun,
                'nama_mata_pelajaran' => $item->nama_mata_pelajaran,
                'jumlah_jam_mengajar' => (int) $item->jumlah_jam_mengajar,
                'jumlah_kehadiran'    => $hadir ? (int) $hadir->jumlah_kehadiran : 0,
                'total_hari_mengajar' => (int) $item->jumlah_jam_mengajar,
            ];
        })->values();

        return response()->json($rows);
    }
}