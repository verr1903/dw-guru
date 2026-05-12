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
        $guruAktif = DataGuru::where('periode_tahun', $tahun)->count();

        // Guru aktif tahun lalu untuk perbandingan
        $guruAktifTahunLalu = DataGuru::where('periode_tahun', $tahun - 1)->count();
        $selisihGuruAktif = $guruAktif - $guruAktifTahunLalu;

        // Total prestasi
        $totalPrestasi = DataPrestasiGuru::whereYear('tanggal_kegiatan', $tahun)->count();
        $totalPrestasiTahunLalu = DataPrestasiGuru::whereYear('tanggal_kegiatan', $tahun - 1)->count();
        $selisihPrestasi = $totalPrestasi - $totalPrestasiTahunLalu;

        // ===== CHART: Tren Jam Mengajar per Bulan =====
        $trenJamPerBulan = DataAbsensiGuru::where('periode_tahun', $tahun)
            ->selectRaw('periode_bulan, COUNT(DISTINCT nama_guru) as jumlah_guru')
            ->groupBy('periode_bulan')
            ->orderBy('periode_bulan')
            ->pluck('jumlah_guru', 'periode_bulan')
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
        $guruQuery = DataGuru::where('data_guru.periode_tahun', $tahun)
            ->leftJoin('data_jam_mengajar_guru', function ($join) use ($tahun) {
                $join->on('data_guru.nama_guru', '=', 'data_jam_mengajar_guru.nama_guru')
                    ->where('data_jam_mengajar_guru.periode_tahun', '=', $tahun);
            })
            ->selectRaw('
        data_guru.nama_guru,
        data_guru.bidang_studi,
        data_guru.nip,
        COALESCE(SUM(
            data_jam_mengajar_guru.x_1 + data_jam_mengajar_guru.x_2 + data_jam_mengajar_guru.x_3 +
            data_jam_mengajar_guru.xi_1 + data_jam_mengajar_guru.xi_2 + data_jam_mengajar_guru.xi_3 +
            data_jam_mengajar_guru.xii_1 + data_jam_mengajar_guru.xii_2 + data_jam_mengajar_guru.xii_3 +
            data_jam_mengajar_guru.sd + data_jam_mengajar_guru.smp + data_jam_mengajar_guru.slb
        ), 0) as jam_total
    ')
            ->groupBy('data_guru.nama_guru', 'data_guru.bidang_studi', 'data_guru.nip');

        if ($search) {
            $guruQuery->where('data_guru.nama_guru', 'like', "%{$search}%");
        }
        if ($mapel) {
            $guruQuery->where('data_guru.bidang_studi', 'like', "%{$mapel}%");
        }

        $guruData = $guruQuery->orderBy('data_guru.nama_guru')->paginate(10);
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
