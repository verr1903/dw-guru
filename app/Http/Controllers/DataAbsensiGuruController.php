<?php

namespace App\Http\Controllers;

use App\Models\DataAbsensiGuru;
use Illuminate\Http\Request;

class DataAbsensiGuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $query = DataAbsensiGuru::query();

        if ($search) {
            $query->where('nama_guru', 'like', "%{$search}%");
        }
        if ($bulan) {
            $query->where('periode_bulan', $bulan);
        }
        if ($tahun) {
            $query->where('periode_tahun', $tahun);
        }

        $data = $query->orderBy('nama_guru')->orderBy('periode_tahun')->orderBy('periode_bulan')->paginate(20);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:100',
            'periode_bulan' => 'required|integer|min:1|max:12',
            'periode_tahun' => 'required|integer',
            'sakit' => 'required|integer|min:0',
            'izin' => 'required|integer|min:0',
            'alpa' => 'required|integer|min:0',
        ]);

        $absensi = DataAbsensiGuru::create($validated);

        return response()->json(['message' => 'Data absensi berhasil ditambahkan.', 'data' => $absensi], 201);
    }

    public function show(DataAbsensiGuru $dataAbsensiGuru)
    {
        return response()->json($dataAbsensiGuru);
    }

    public function update(Request $request, DataAbsensiGuru $dataAbsensiGuru)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:100',
            'periode_bulan' => 'required|integer|min:1|max:12',
            'periode_tahun' => 'required|integer',
            'sakit' => 'required|integer|min:0',
            'izin' => 'required|integer|min:0',
            'alpa' => 'required|integer|min:0',
        ]);

        $dataAbsensiGuru->update($validated);

        return response()->json(['message' => 'Data absensi berhasil diperbarui.', 'data' => $dataAbsensiGuru]);
    }

    public function destroy(DataAbsensiGuru $dataAbsensiGuru)
    {
        $dataAbsensiGuru->delete();

        return response()->json(['message' => 'Data absensi berhasil dihapus.']);
    }
}
