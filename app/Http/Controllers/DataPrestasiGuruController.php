<?php

namespace App\Http\Controllers;

use App\Models\DataPrestasiGuru;
use Illuminate\Http\Request;

class DataPrestasiGuruController extends Controller
{
    public function index(Request $request)
    {
        $query = DataPrestasiGuru::query();

        if ($request->search) {
            $query->search($request->search);
        }
        if ($request->tingkat) {
            $query->byTingkat($request->tingkat);
        }

        return response()->json($query->orderByDesc('tanggal_kegiatan')->paginate(20));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'tanggal_kegiatan' => 'nullable|date',
            'kegiatan' => 'required|string|max:150',
            'prestasi' => 'required|string|max:150',
            'penyelenggara_kegiatan' => 'required|string|max:150',
            'tingkat_kegiatan' => 'required|string|max:50',
        ]);

        $data = DataPrestasiGuru::create($validated);

        return response()->json(['message' => 'Data prestasi berhasil ditambahkan.', 'data' => $data], 201);
    }

    public function show(DataPrestasiGuru $dataPrestasiGuru)
    {
        return response()->json($dataPrestasiGuru);
    }

    public function update(Request $request, DataPrestasiGuru $dataPrestasiGuru)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'tanggal_kegiatan' => 'nullable|date',
            'kegiatan' => 'required|string|max:150',
            'prestasi' => 'required|string|max:150',
            'penyelenggara_kegiatan' => 'required|string|max:150',
            'tingkat_kegiatan' => 'required|string|max:50',
        ]);

        $dataPrestasiGuru->update($validated);

        return response()->json(['message' => 'Data prestasi berhasil diperbarui.', 'data' => $dataPrestasiGuru]);
    }

    public function destroy(DataPrestasiGuru $dataPrestasiGuru)
    {
        $dataPrestasiGuru->delete();

        return response()->json(['message' => 'Data prestasi berhasil dihapus.']);
    }
}
