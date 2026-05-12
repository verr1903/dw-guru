<?php

namespace App\Http\Controllers;

use App\Models\DataAbsensiGuru;
use App\Models\DataJamMengajarGuru;
use App\Models\DataGuru;
use App\Models\DataPrestasiGuru;
use App\Models\DataKegiatanPelatihanGuru;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Halaman laporan
     */
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', 2024);
        $search = $request->input('search');

        // ===== STAT CARDS =====
        // Total jam minggu ini (approximate: per tahun / 52)
        $totalJamTahun = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->selectRaw('SUM(x_1 + x_2 + x_3 + xi_1 + xi_2 + xi_3 + xii_1 + xii_2 + xii_3 + sd + smp + slb) as total')
            ->value('total') ?? 0;

        // Tingkat kehadiran
        $absensiStats = DataAbsensiGuru::where('periode_tahun', $tahun)
            ->selectRaw('SUM(sakit + izin + alpa) as total_absen, COUNT(*) as records')
            ->first();

        $totalRecords = $absensiStats->records ?? 1;
        $totalHariKerja = $totalRecords * 31;
        $totalAbsen = $absensiStats->total_absen ?? 0;
        $persenKehadiran = round((($totalHariKerja - $totalAbsen) / $totalHariKerja) * 100);

        // Total prestasi
        $totalPrestasi = DataPrestasiGuru::count();

        // Total pelatihan
        $totalPelatihan = DataKegiatanPelatihanGuru::count();

        // ===== CHART: Tren kehadiran per bulan =====
        $trenKehadiran = DataAbsensiGuru::where('periode_tahun', $tahun)
            ->selectRaw('
                periode_bulan,
                SUM(sakit) as total_sakit,
                SUM(izin) as total_izin,
                SUM(alpa) as total_alpa,
                COUNT(*) as total_guru
            ')
            ->groupBy('periode_bulan')
            ->orderBy('periode_bulan')
            ->get();

        // ===== TABLE: Detail kinerja guru =====
        $guruKinerja = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->when($search, fn($q) => $q->where('nama_guru', 'like', "%{$search}%"))
            ->selectRaw('nama_guru, nip, bidang_studi, SUM(x_1 + x_2 + x_3 + xi_1 + xi_2 + xi_3 + xii_1 + xii_2 + xii_3 + sd + smp + slb) as total_jam')
            ->groupBy('nama_guru', 'nip', 'bidang_studi')
            ->orderBy('nama_guru')
            ->paginate(10);

        // Absensi per guru for table
        $absensiPerGuru = DataAbsensiGuru::where('periode_tahun', $tahun)
            ->selectRaw('nama_guru, SUM(sakit + izin + alpa) as total_absen, SUM(izin) as total_izin, SUM(alpa) as total_alpa')
            ->groupBy('nama_guru')
            ->get()
            ->keyBy('nama_guru');

        // Prestasi per guru for table
        $prestasiPerGuru = DataPrestasiGuru::selectRaw('nama_guru, COUNT(*) as jumlah')
            ->groupBy('nama_guru')
            ->pluck('jumlah', 'nama_guru');

        $daftarTahun = DataAbsensiGuru::select('periode_tahun')
            ->distinct()
            ->orderByDesc('periode_tahun')
            ->pluck('periode_tahun');

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('laporan', compact(
            'tahun',
            'totalJamTahun',
            'persenKehadiran',
            'totalPrestasi',
            'totalPelatihan',
            'trenKehadiran',
            'guruKinerja',
            'absensiPerGuru',
            'prestasiPerGuru',
            'daftarTahun',
            'namaBulan',
            'search',
        ));
    }
}
