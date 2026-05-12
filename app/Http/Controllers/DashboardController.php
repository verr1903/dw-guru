<?php

namespace App\Http\Controllers;

use App\Models\DataGuru;
use App\Models\DataAbsensiGuru;
use App\Models\DataJamMengajarGuru;
use App\Models\DataPrestasiGuru;
use App\Models\DataKegiatanPelatihanGuru;
use App\Models\FactKinerjaGuru;
use App\Models\DimWaktu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', 2024);
        $bulan = $request->input('bulan');

        // ===== STAT CARDS =====

        // Total jam mengajar tahun ini
        $totalJamMengajar = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->selectRaw('SUM(x_1 + x_2 + x_3 + xi_1 + xi_2 + xi_3 + xii_1 + xii_2 + xii_3 + sd + smp + slb) as total')
            ->value('total') ?? 0;

        // Total jam tahun lalu (untuk perbandingan)
        $totalJamTahunLalu = DataJamMengajarGuru::where('periode_tahun', $tahun - 1)
            ->selectRaw('SUM(x_1 + x_2 + x_3 + xi_1 + xi_2 + xi_3 + xii_1 + xii_2 + xii_3 + sd + smp + slb) as total')
            ->value('total') ?? 0;

        $persenPerubahanJam = $totalJamTahunLalu > 0
            ? round((($totalJamMengajar - $totalJamTahunLalu) / $totalJamTahunLalu) * 100)
            : 0;

        // Kehadiran rata-rata
        $absensiStats = DataAbsensiGuru::where('periode_tahun', $tahun)
            ->selectRaw('
                SUM(sakit) as total_sakit,
                SUM(izin) as total_izin,
                SUM(alpa) as total_alpa,
                COUNT(*) as total_records
            ')
            ->first();

        $totalAbsen    = ($absensiStats->total_sakit ?? 0)
            + ($absensiStats->total_izin  ?? 0)
            + ($absensiStats->total_alpa  ?? 0);
        $totalRecords  = $absensiStats->total_records ?? 1;
        $totalHariKerja = $totalRecords * 31;

        $kehadiranRataRata = round((($totalHariKerja - $totalAbsen) / $totalHariKerja) * 100, 2);

        // Guru aktif tahun ini
        // Guru aktif tahun ini — gabungan dari DataGuru + DataAbsensiGuru
        $guruAktif = DB::table(function ($query) use ($tahun) {
            $query->select('nama_guru')
                ->from('data_guru')
                ->where('periode_tahun', $tahun)
                ->union(
                    DB::table('data_absensi_guru')
                        ->select('nama_guru')
                        ->where('periode_tahun', $tahun)
                );
        }, 'gabungan')->distinct()->count('nama_guru');

        // Guru aktif tahun lalu — sama, untuk perbandingan
        $guruAktifTahunLalu = DB::table(function ($query) use ($tahun) {
            $query->select('nama_guru')
                ->from('data_guru')
                ->where('periode_tahun', $tahun - 1)
                ->union(
                    DB::table('data_absensi_guru')
                        ->select('nama_guru')
                        ->where('periode_tahun', $tahun - 1)
                );
        }, 'gabungan')->distinct()->count('nama_guru');

        $selisihGuruAktif = $guruAktif - $guruAktifTahunLalu;

        // Total prestasi
        $totalPrestasi = DataPrestasiGuru::whereYear('tanggal_kegiatan', $tahun)->count();
        $totalPrestasiTahunLalu = DataPrestasiGuru::whereYear('tanggal_kegiatan', $tahun - 1)->count();
        $selisihPrestasi = $totalPrestasi - $totalPrestasiTahunLalu;

        // ===== CHART: Tren Jam Mengajar per Bulan =====
        $trenJamPerBulan = DB::table('data_absensi_guru')
    ->where('periode_tahun', $tahun)
    ->selectRaw('periode_bulan, COUNT(DISTINCT nama_guru) as jumlah_guru')
    ->groupBy('periode_bulan')
    ->orderBy('periode_bulan')
    ->pluck('jumlah_guru', 'periode_bulan')
    ->toArray();

// Tambahkan guru dari data_guru yang tidak ada di absensi ke setiap bulan
$guruHanyaDiDataGuru = DB::table('data_guru')
    ->where('periode_tahun', $tahun)
    ->whereNotIn('nama_guru', function ($q) use ($tahun) {
        $q->select('nama_guru')
          ->from('data_absensi_guru')
          ->where('periode_tahun', $tahun);
    })
    ->count();

// Tambahkan selisih ke setiap bulan yang ada
$trenJamPerBulan = collect($trenJamPerBulan)
    ->map(fn($jumlah) => $jumlah + $guruHanyaDiDataGuru)
    ->toArray();

        // Jam mengajar per guru per tahun (aggregate)
        $jamPerGuru = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->selectRaw('nama_guru, bidang_studi, SUM(x_1 + x_2 + x_3 + xi_1 + xi_2 + xi_3 + xii_1 + xii_2 + xii_3 + sd + smp + slb) as total_jam')
            ->groupBy('nama_guru', 'bidang_studi')
            ->orderByDesc('total_jam')
            ->get();

        // ===== TABLE: Rekap Kinerja Guru =====
        $search = $request->input('search');
        $mapel = $request->input('mapel');

        // TABLE: Rekap Kinerja Guru — sumber dari DataGuru (sama dengan guruAktif)
        $guruUnion = DB::table('data_guru')
    ->select('nama_guru', 'bidang_studi', 'nip')
    ->where('periode_tahun', $tahun)
    ->union(
        DB::table('data_absensi_guru')
            ->select('nama_guru', DB::raw("'' as bidang_studi"), 'nip')
            ->where('periode_tahun', $tahun)
    );

// GROUP BY nama_guru saja agar tidak duplikat meski bidang_studi beda
$guruQuery = DB::table(DB::raw("(SELECT nama_guru, MAX(bidang_studi) as bidang_studi, MAX(nip) as nip FROM ({$guruUnion->toSql()}) as u GROUP BY nama_guru) as gabungan"))
    ->mergeBindings($guruUnion)
    ->select(
        'gabungan.nama_guru',
        'gabungan.bidang_studi',
        'gabungan.nip',
        DB::raw('COALESCE(SUM(
            j.x_1 + j.x_2 + j.x_3 +
            j.xi_1 + j.xi_2 + j.xi_3 +
            j.xii_1 + j.xii_2 + j.xii_3 +
            j.sd + j.smp + j.slb
        ), 0) as jam_total')
    )
    ->leftJoin('data_jam_mengajar_guru as j', function ($join) use ($tahun) {
        $join->on('gabungan.nama_guru', '=', 'j.nama_guru')
             ->where('j.periode_tahun', '=', $tahun);
    })
    ->groupBy('gabungan.nama_guru', 'gabungan.bidang_studi', 'gabungan.nip');

if ($search) {
    $guruQuery->where('gabungan.nama_guru', 'like', "%{$search}%");
}
if ($mapel) {
    $guruQuery->where('gabungan.bidang_studi', 'like', "%{$mapel}%");
}

$guruData = $guruQuery->orderBy('gabungan.nama_guru')->paginate(10);
$guruData->appends([
    'tahun'  => $tahun,
    'search' => $search,
    'mapel'  => $mapel,
]);

        // Ambil kehadiran per guru
        $absensiPerGuru = DataAbsensiGuru::where('periode_tahun', $tahun)
            ->selectRaw('nama_guru, SUM(sakit) as total_sakit, SUM(izin) as total_izin, SUM(alpa) as total_alpa')
            ->groupBy('nama_guru')
            ->pluck('total_sakit', 'nama_guru')
            ->toArray();

        $kehadiranPerGuru = DataAbsensiGuru::where('periode_tahun', $tahun)
            ->selectRaw('nama_guru, SUM(sakit + izin + alpa) as total_absen, COUNT(*) as records')
            ->groupBy('nama_guru')
            ->get()
            ->keyBy('nama_guru');

        // Daftar bidang studi unik untuk filter
        $daftarMapel = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->select('bidang_studi')
            ->distinct()
            ->orderBy('bidang_studi')
            ->pluck('bidang_studi');

        // Daftar tahun yang tersedia
        $daftarTahun = DataAbsensiGuru::select('periode_tahun')
            ->distinct()
            ->orderByDesc('periode_tahun')
            ->pluck('periode_tahun');

        // Bulan names
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

        // Kehadiran tahun lalu untuk perbandingan
        $absensiStatsTahunLalu = DataAbsensiGuru::where('periode_tahun', $tahun - 1)
            ->selectRaw('
                SUM(sakit) as total_sakit,
                SUM(izin) as total_izin,
                SUM(alpa) as total_alpa,
                COUNT(*) as total_records
            ')
            ->first();

        $totalAbsenTahunLalu   = ($absensiStatsTahunLalu->total_sakit ?? 0)
            + ($absensiStatsTahunLalu->total_izin  ?? 0)
            + ($absensiStatsTahunLalu->total_alpa  ?? 0);
        $totalRecordsTahunLalu = $absensiStatsTahunLalu->total_records ?? 1;
        $totalHariKerjaTahunLalu = $totalRecordsTahunLalu * 31;

        $kehadiranRataRataTahunLalu = $totalHariKerjaTahunLalu > 0
            ? round((($totalHariKerjaTahunLalu - $totalAbsenTahunLalu) / $totalHariKerjaTahunLalu) * 100, 2)
            : 0;

        $persenPerubahanKehadiran = $kehadiranRataRataTahunLalu > 0
            ? round($kehadiranRataRata - $kehadiranRataRataTahunLalu, 2)
            : 0;

        // Top 5 guru berdasarkan total jam mengajar
        $topGuruJam = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->get()
            ->map(function ($g) {
                return [
                    'nama_guru'    => $g->nama_guru,
                    'bidang_studi' => $g->bidang_studi,
                    'total_jam'    => $g->total_jam, // accessor model
                ];
            })
            ->sortByDesc('total_jam')
            ->take(5)
            ->values();


        return view('dashboard', compact(
            'tahun',
            'totalJamMengajar',
            'persenPerubahanJam',
            'kehadiranRataRata',
            'guruAktif',
            'totalPrestasiTahunLalu',
            'selisihPrestasi',
            'totalPrestasi',
            'trenJamPerBulan',
            'kehadiranRataRataTahunLalu',
            'persenPerubahanKehadiran',
            'guruAktifTahunLalu',
            'selisihGuruAktif',
            'guruData',
            'kehadiranPerGuru',
            'daftarMapel',
            'topGuruJam',
            'daftarTahun',
            'namaBulan',
            'search',
            'mapel',
        ));
    }
}
