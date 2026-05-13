<?php

namespace App\Http\Controllers;

use App\Models\DataKegiatanPelatihanGuru;
use App\Models\DataPrestasiGuru;
use Illuminate\Http\Request;

class PelatihanPrestasiController extends Controller
{
    public function index(Request $request)
    {
        $tahun   = $request->input('tahun', 2024);
        $search  = $request->input('search');
        $tingkat = $request->input('tingkat');
        $tab     = $request->input('tab', 'prestasi'); // 'prestasi' | 'pelatihan'

        // ===== STAT CARDS =====

        $totalPrestasi = DataPrestasiGuru::whereYear('tanggal_kegiatan', $tahun)->count();

        $totalPelatihanTahunIni = DataKegiatanPelatihanGuru::whereYear('start_date', $tahun)->count();

        $guruBerprestasi = DataPrestasiGuru::whereYear('tanggal_kegiatan', $tahun)
            ->distinct('nama_guru')
            ->count('nama_guru');

        $guruPelatihan = DataKegiatanPelatihanGuru::whereYear('start_date', $tahun)
            ->distinct('nama_guru')
            ->count('nama_guru');

        // ===== CHART: Prestasi per Tingkat =====
        $prestasiPerTingkat = DataPrestasiGuru::whereYear('tanggal_kegiatan', $tahun)
            ->selectRaw('tingkat_kegiatan, COUNT(*) as jumlah')
            ->groupBy('tingkat_kegiatan')
            ->orderByDesc('jumlah')
            ->get();

        // ===== CHART: Pelatihan per Bulan =====
        $pelatihanPerBulan = DataKegiatanPelatihanGuru::whereYear('start_date', $tahun)
            ->selectRaw('MONTH(start_date) as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('jumlah', 'bulan')
            ->toArray();

        // ===== TABLE: Prestasi =====
        $prestasiQuery = DataPrestasiGuru::whereYear('tanggal_kegiatan', $tahun)
            ->search($search)
            ->byTingkat($tingkat)
            ->orderByDesc('tanggal_kegiatan');

        $prestasiData = $prestasiQuery->paginate(10, ['*'], 'prestasi_page');
        $prestasiData->appends([
            'tahun'   => $tahun,
            'search'  => $search,
            'tingkat' => $tingkat,
            'tab'     => 'prestasi',
        ]);

        // ===== TABLE: Pelatihan =====
        $pelatihanQuery = DataKegiatanPelatihanGuru::whereYear('start_date', $tahun)
            ->search($search)
            ->orderByDesc('start_date');

        $pelatihanData = $pelatihanQuery->paginate(10, ['*'], 'pelatihan_page');
        $pelatihanData->appends([
            'tahun'  => $tahun,
            'search' => $search,
            'tab'    => 'pelatihan',
        ]);

        // ===== FILTER =====
        $daftarTingkat = DataPrestasiGuru::select('tingkat_kegiatan')
            ->distinct()
            ->orderBy('tingkat_kegiatan')
            ->pluck('tingkat_kegiatan');

        $daftarTahun = DataPrestasiGuru::whereNotNull('tanggal_kegiatan')
    ->selectRaw('YEAR(tanggal_kegiatan) as tahun')
    ->distinct()
    ->orderByDesc('tahun')
    ->pluck('tahun');

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April',   5 => 'Mei',       6 => 'Juni',
            7 => 'Juli',    8 => 'Agustus',   9 => 'September',
            10 => 'Oktober',11 => 'November', 12 => 'Desember',
        ];

        return view('pelatihan-prestasi', compact(
            'tahun',
            'search',
            'tingkat',
            'tab',
            'totalPrestasi',
            'totalPelatihanTahunIni',
            'guruBerprestasi',
            'guruPelatihan',
            'prestasiPerTingkat',
            'pelatihanPerBulan',
            'prestasiData',
            'pelatihanData',
            'daftarTingkat',
            'daftarTahun',
            'namaBulan',
        ));
    }
}