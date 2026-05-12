<?php

namespace App\Http\Controllers;

use App\Models\DataGuru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tahun = $request->input('tahun');

        $query = DataGuru::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('bidang_studi', 'like', "%{$search}%");
            });
        }

        if ($tahun) {
            $query->where('periode_tahun', $tahun);
        }

        $guru = $query->orderBy('nama_guru')->paginate(15);

        $daftarTahun = DataGuru::select('periode_tahun')
            ->distinct()
            ->orderByDesc('periode_tahun')
            ->pluck('periode_tahun');

        return view('pengaturan', compact('guru', 'search', 'tahun', 'daftarTahun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengaturan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'bidang_studi' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer|min:1900|max:2100',
            'tahun_mengajar' => 'required|integer|min:1900|max:2100',
            'periode_tahun' => 'required|integer|min:2020|max:2030',
        ]);

        DataGuru::create($validated);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataGuru $guru)
    {
        return response()->json($guru);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataGuru $guru)
    {
        return response()->json($guru);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataGuru $guru)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'bidang_studi' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer|min:1900|max:2100',
            'tahun_mengajar' => 'required|integer|min:1900|max:2100',
            'periode_tahun' => 'required|integer|min:2020|max:2030',
        ]);

        $guru->update($validated);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataGuru $guru)
    {
        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
