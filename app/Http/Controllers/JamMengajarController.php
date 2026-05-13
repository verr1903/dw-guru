<?php

namespace App\Http\Controllers;

use App\Models\DataJamMengajarGuru;
use App\Models\DataGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JamMengajarController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', 2024);
        $search = $request->input('search');
        $mapel = $request->input('mapel');
        $guru = $request->input('guru');

        // ===== TABLE DATA — sumber dari UNION data_guru + data_jam_mengajar_guru =====
        $guruUnion = DB::table('data_guru')
            ->select('nama_guru', 'bidang_studi', 'nip')
            ->where('periode_tahun', $tahun)
            ->union(
                DB::table('data_absensi_guru')
                    ->select('nama_guru', DB::raw("'' as bidang_studi"), 'nip')
                    ->where('periode_tahun', $tahun)
            );

        $jamQuery = DB::table(DB::raw("(SELECT nama_guru, MAX(bidang_studi) as bidang_studi, MAX(nip) as nip FROM ({$guruUnion->toSql()}) as u GROUP BY nama_guru) as gabungan"))
            ->mergeBindings($guruUnion)
            ->select(
                'gabungan.nama_guru',
                'gabungan.bidang_studi',
                'gabungan.nip',
                DB::raw('COALESCE(SUM(j.x_1), 0) as x_1'),
                DB::raw('COALESCE(SUM(j.x_2), 0) as x_2'),
                DB::raw('COALESCE(SUM(j.x_3), 0) as x_3'),
                DB::raw('COALESCE(SUM(j.xi_1), 0) as xi_1'),
                DB::raw('COALESCE(SUM(j.xi_2), 0) as xi_2'),
                DB::raw('COALESCE(SUM(j.xi_3), 0) as xi_3'),
                DB::raw('COALESCE(SUM(j.xii_1), 0) as xii_1'),
                DB::raw('COALESCE(SUM(j.xii_2), 0) as xii_2'),
                DB::raw('COALESCE(SUM(j.xii_3), 0) as xii_3'),
                DB::raw('COALESCE(SUM(j.x_1 + j.x_2 + j.x_3 + j.xi_1 + j.xi_2 + j.xi_3 + j.xii_1 + j.xii_2 + j.xii_3), 0) as total_jam'),
                DB::raw('COALESCE(MAX(j.periode_tahun), ' . $tahun . ') as periode_tahun')
            )
            ->leftJoin('data_jam_mengajar_guru as j', function ($join) use ($tahun) {
                $join->on('gabungan.nama_guru', '=', 'j.nama_guru')
                    ->where('j.periode_tahun', '=', $tahun);
            })
            ->groupBy('gabungan.nama_guru', 'gabungan.bidang_studi', 'gabungan.nip');

        if ($search) {
            $jamQuery->where('gabungan.nama_guru', 'like', "%{$search}%");
        }
        if ($mapel) {
            $jamQuery->where('gabungan.bidang_studi', 'like', "%{$mapel}%");
        }
        if ($guru) {
            $jamQuery->where('gabungan.nama_guru', $guru);
        }

        $jamMengajarData = $jamQuery->orderBy('gabungan.nama_guru')->paginate(15);
        $jamMengajarData->appends([
            'tahun'  => $tahun,
            'search' => $search,
            'mapel'  => $mapel,
            'guru'   => $guru,
        ]);

        // ===== CHART DATA =====
        // ===== CHART DATA — gunakan accessor model =====

        $jamPerGuru = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->get()
            ->map(fn($g) => [
                'nama_guru' => $g->nama_guru,
                'total_jam' => $g->total_jam, // ← accessor
            ])
            ->sortByDesc('total_jam')
            ->take(10)
            ->values();

        $jamPerMapel = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->get()
            ->groupBy('bidang_studi')
            ->map(fn($group, $mapel) => [
                'bidang_studi' => $mapel,
                'total_jam'    => $group->sum('total_jam'), // ← accessor per item
            ])
            ->sortByDesc('total_jam')
            ->values();

        $trenPerTahun = DataJamMengajarGuru::select('periode_tahun')
            ->distinct()
            ->orderBy('periode_tahun')
            ->pluck('periode_tahun')
            ->map(fn($tahunItem) => [
                'periode_tahun' => $tahunItem,
                'total_jam'     => DataJamMengajarGuru::where('periode_tahun', $tahunItem)
                    ->get()
                    ->sum('total_jam'), // ← accessor
            ])
            ->values();

        $daftarGuru = DataGuru::where('periode_tahun', $tahun)
            ->select('nama_guru')
            ->distinct()
            ->orderBy('nama_guru')
            ->pluck('nama_guru');

        $daftarMapel = DataGuru::where('periode_tahun', $tahun)
            ->select('bidang_studi')
            ->distinct()
            ->orderBy('bidang_studi')
            ->pluck('bidang_studi');

        $daftarTahun = DataJamMengajarGuru::select('periode_tahun')
            ->distinct()
            ->orderByDesc('periode_tahun')
            ->pluck('periode_tahun');

        return view('jam-mengajar', compact(
            'tahun',
            'jamMengajarData',
            'jamPerGuru',
            'jamPerMapel',
            'trenPerTahun',
            'daftarGuru',
            'daftarMapel',
            'daftarTahun',
            'search',
            'mapel',
            'guru',
        ));
    }
}
