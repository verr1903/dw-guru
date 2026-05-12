<?php

namespace App\Http\Controllers;

use App\Models\DataAbsensiGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KehadiranGuruController extends Controller
{
    /**
     * Halaman kehadiran guru
     */
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', 2024);
        $bulan = $request->input('bulan');
        $search = $request->input('search');

        // ===== STAT CARDS =====
        $statsQuery = DataAbsensiGuru::where('periode_tahun', $tahun);
        if ($bulan) {
            $statsQuery->where('periode_bulan', $bulan);
        }

        $totalGuru = (clone $statsQuery)->distinct('nama_guru')->count('nama_guru');

        $absensiAgg = (clone $statsQuery)
            ->selectRaw('SUM(sakit) as total_sakit, SUM(izin) as total_izin, SUM(alpa) as total_alpa, COUNT(*) as total_records')
            ->first();

        $totalIzinSakit = ($absensiAgg->total_sakit ?? 0) + ($absensiAgg->total_izin ?? 0);
        $totalAlpa = $absensiAgg->total_alpa ?? 0;

        // Persentase kehadiran
        $totalRecords = $absensiAgg->total_records ?? 1;
        $totalHariKerja = $totalRecords * 31; // estimasi
        $totalAbsen = ($absensiAgg->total_sakit ?? 0) + ($absensiAgg->total_izin ?? 0) + ($absensiAgg->total_alpa ?? 0);
        $persenKehadiran = $totalHariKerja > 0
            ? round((($totalHariKerja - $totalAbsen) / $totalHariKerja) * 100)
            : 0;

        // ===== CHART DATA: Tren Kehadiran per Bulan =====
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

        // ===== TABLE DATA =====
        $query = DataAbsensiGuru::where('periode_tahun', $tahun);

        if ($bulan) {
            $query->where('periode_bulan', $bulan);
        }
        if ($search) {
            $query->where('nama_guru', 'like', "%{$search}%");
        }

        $kehadiranData = $query->orderBy('nama_guru')
            ->orderBy('periode_bulan')
            ->paginate(15);

        // Ringkasan per guru (semua bulan)
        $ringkasanGuru = DataAbsensiGuru::where('periode_tahun', $tahun)
            ->when($bulan, fn($q) => $q->where('periode_bulan', $bulan))
            ->when($search, fn($q) => $q->where('nama_guru', 'like', "%{$search}%"))
            ->selectRaw('
                nama_guru, nip, jabatan,
                SUM(sakit) as total_sakit,
                SUM(izin) as total_izin,
                SUM(alpa) as total_alpa,
                COUNT(*) as jumlah_bulan
            ')
            ->groupBy('nama_guru', 'nip', 'jabatan')
            ->orderBy('nama_guru')
            ->paginate(15);

        // Daftar bulan dan tahun
        $daftarBulan = DataAbsensiGuru::where('periode_tahun', $tahun)
            ->select('periode_bulan')
            ->distinct()
            ->orderBy('periode_bulan')
            ->pluck('periode_bulan');

        $daftarTahun = DataAbsensiGuru::select('periode_tahun')
            ->distinct()
            ->orderByDesc('periode_tahun')
            ->pluck('periode_tahun');

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('kehadiran-guru', compact(
            'tahun',
            'bulan',
            'totalGuru',
            'persenKehadiran',
            'totalIzinSakit',
            'totalAlpa',
            'trenKehadiran',
            'ringkasanGuru',
            'daftarBulan',
            'daftarTahun',
            'namaBulan',
            'search',
        ));
    }
}
