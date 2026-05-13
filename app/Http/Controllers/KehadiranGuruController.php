<?php

namespace App\Http\Controllers;

use App\Models\DataAbsensiGuru;
use App\Models\DataGuru;
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

        // Sebelumnya:
        // $totalGuru = (clone $statsQuery)->distinct('nama_guru')->count('nama_guru');

        // Ganti dengan:
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
        $kehadiranRataRata = round((($totalHariKerja - $totalAbsen) / $totalHariKerja) * 100, 2);
        

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
        $guruUnionRingkasan = DB::table('data_guru')
            ->select('nama_guru', 'nip', DB::raw("bidang_studi as jabatan"))
            ->where('periode_tahun', $tahun)
            ->union(
                DB::table('data_absensi_guru')
                    ->select('nama_guru', 'nip', 'jabatan')
                    ->where('periode_tahun', $tahun)
            );

        $ringkasanGuru = DB::table(DB::raw("(SELECT nama_guru, MAX(nip) as nip, MAX(jabatan) as jabatan FROM ({$guruUnionRingkasan->toSql()}) as u GROUP BY nama_guru) as gabungan"))
            ->mergeBindings($guruUnionRingkasan)
            ->select(
                'gabungan.nama_guru',
                'gabungan.nip',
                'gabungan.jabatan',
                DB::raw('COALESCE(SUM(a.sakit), 0) as total_sakit'),
                DB::raw('COALESCE(SUM(a.izin), 0) as total_izin'),
                DB::raw('COALESCE(SUM(a.alpa), 0) as total_alpa'),
                DB::raw('COUNT(a.periode_bulan) as jumlah_bulan')
            )
            ->leftJoin('data_absensi_guru as a', function ($join) use ($tahun, $bulan) {
                $join->on('gabungan.nama_guru', '=', 'a.nama_guru')
                    ->where('a.periode_tahun', '=', $tahun);
                if ($bulan) {
                    $join->where('a.periode_bulan', '=', $bulan);
                }
            })
            ->when($search, fn($q) => $q->where('gabungan.nama_guru', 'like', "%{$search}%"))
            ->groupBy('gabungan.nama_guru', 'gabungan.nip', 'gabungan.jabatan')
            ->orderBy('gabungan.nama_guru')
            ->paginate(15);

        $ringkasanGuru->appends([
            'tahun'  => $tahun,
            'bulan'  => $bulan,
            'search' => $search,
        ]);

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

        return view('kehadiran-guru', compact(
            'tahun',
            'bulan',
            // 'totalGuru',
            'kehadiranRataRata',
            'persenKehadiran',
            'totalIzinSakit',
            'totalAlpa',
            'selisihGuruAktif',
            'guruAktif',
            'trenKehadiran',
            'ringkasanGuru',
            'daftarBulan',
            'daftarTahun',
            'namaBulan',
            'search',
        ));
    }
}
