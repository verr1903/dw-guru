<?php

namespace App\Http\Controllers;

use App\Models\DataJamMengajarGuru;
use Illuminate\Http\Request;

class JamMengajarController extends Controller
{
    /**
     * Halaman jam mengajar
     */
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', 2024);
        $search = $request->input('search');
        $mapel = $request->input('mapel');
        $guru = $request->input('guru');

        // ===== TABLE DATA =====
        $query = DataJamMengajarGuru::where('periode_tahun', $tahun);

        if ($search) {
            $query->where('nama_guru', 'like', "%{$search}%");
        }
        if ($mapel) {
            $query->where('bidang_studi', 'like', "%{$mapel}%");
        }
        if ($guru) {
            $query->where('nama_guru', $guru);
        }

        $jamMengajarData = $query->orderBy('nama_guru')->paginate(15);

        // ===== CHART DATA: Total jam per guru =====
        $jamPerGuru = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->selectRaw('nama_guru, SUM(x_1 + x_2 + x_3 + xi_1 + xi_2 + xi_3 + xii_1 + xii_2 + xii_3 + sd + smp + slb) as total_jam')
            ->groupBy('nama_guru')
            ->orderByDesc('total_jam')
            ->limit(10)
            ->get();

        // ===== CHART DATA: Total jam per bidang studi =====
        $jamPerMapel = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->selectRaw('bidang_studi, SUM(x_1 + x_2 + x_3 + xi_1 + xi_2 + xi_3 + xii_1 + xii_2 + xii_3 + sd + smp + slb) as total_jam')
            ->groupBy('bidang_studi')
            ->orderByDesc('total_jam')
            ->get();

        // ===== CHART DATA: Tren per tahun =====
        $trenPerTahun = DataJamMengajarGuru::selectRaw('periode_tahun, SUM(x_1 + x_2 + x_3 + xi_1 + xi_2 + xi_3 + xii_1 + xii_2 + xii_3 + sd + smp + slb) as total_jam')
            ->groupBy('periode_tahun')
            ->orderBy('periode_tahun')
            ->get();

        // Daftar guru dan mapel untuk filter
        $daftarGuru = DataJamMengajarGuru::where('periode_tahun', $tahun)
            ->select('nama_guru')
            ->distinct()
            ->orderBy('nama_guru')
            ->pluck('nama_guru');

        $daftarMapel = DataJamMengajarGuru::where('periode_tahun', $tahun)
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
