<?php

namespace App\Http\Controllers;

use App\Models\DataKegiatanPelatihanGuru;
use Illuminate\Http\Request;

class DataKegiatanPelatihanGuruController extends Controller
{
    public function index(Request $request)
    {
        $query = DataKegiatanPelatihanGuru::query();

        if ($request->search) {
            $query->search($request->search);
        }

        return response()->json($query->orderByDesc('start_date')->paginate(20));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'nama_kegiatan' => 'required|string|max:150',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = DataKegiatanPelatihanGuru::create($validated);

        return response()->json(['message' => 'Data pelatihan berhasil ditambahkan.', 'data' => $data], 201);
    }

    public function show(DataKegiatanPelatihanGuru $dataKegiatanPelatihanGuru)
    {
        return response()->json($dataKegiatanPelatihanGuru);
    }

    public function update(Request $request, DataKegiatanPelatihanGuru $dataKegiatanPelatihanGuru)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'nama_kegiatan' => 'required|string|max:150',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $dataKegiatanPelatihanGuru->update($validated);

        return response()->json(['message' => 'Data pelatihan berhasil diperbarui.', 'data' => $dataKegiatanPelatihanGuru]);
    }

    public function destroy(DataKegiatanPelatihanGuru $dataKegiatanPelatihanGuru)
    {
        $dataKegiatanPelatihanGuru->delete();

        return response()->json(['message' => 'Data pelatihan berhasil dihapus.']);
    }
}
