<?php

namespace App\Http\Controllers;

use App\Models\DataJamMengajarGuru;
use Illuminate\Http\Request;

class DataJamMengajarGuruController extends Controller
{
    public function index(Request $request)
    {
        $query = DataJamMengajarGuru::query();

        if ($request->search) {
            $query->search($request->search);
        }
        if ($request->tahun) {
            $query->byTahun($request->tahun);
        }

        return response()->json($query->orderBy('nama_guru')->paginate(20));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'kode' => 'required|string|max:50',
            'nip' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'bidang_studi' => 'required|string|max:100',
            'periode_tahun' => 'required|integer',
            'x_1' => 'integer|min:0', 'x_2' => 'integer|min:0', 'x_3' => 'integer|min:0',
            'xi_1' => 'integer|min:0', 'xi_2' => 'integer|min:0', 'xi_3' => 'integer|min:0',
            'xii_1' => 'integer|min:0', 'xii_2' => 'integer|min:0', 'xii_3' => 'integer|min:0',
            'sd' => 'integer|min:0', 'smp' => 'integer|min:0', 'slb' => 'integer|min:0',
        ]);

        $data = DataJamMengajarGuru::create($validated);

        return response()->json(['message' => 'Data jam mengajar berhasil ditambahkan.', 'data' => $data], 201);
    }

    public function show(DataJamMengajarGuru $dataJamMengajarGuru)
    {
        return response()->json($dataJamMengajarGuru);
    }

    public function update(Request $request, DataJamMengajarGuru $dataJamMengajarGuru)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'kode' => 'required|string|max:50',
            'nip' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'bidang_studi' => 'required|string|max:100',
            'periode_tahun' => 'required|integer',
            'x_1' => 'integer|min:0', 'x_2' => 'integer|min:0', 'x_3' => 'integer|min:0',
            'xi_1' => 'integer|min:0', 'xi_2' => 'integer|min:0', 'xi_3' => 'integer|min:0',
            'xii_1' => 'integer|min:0', 'xii_2' => 'integer|min:0', 'xii_3' => 'integer|min:0',
            'sd' => 'integer|min:0', 'smp' => 'integer|min:0', 'slb' => 'integer|min:0',
        ]);

        $dataJamMengajarGuru->update($validated);

        return response()->json(['message' => 'Data jam mengajar berhasil diperbarui.', 'data' => $dataJamMengajarGuru]);
    }

    public function destroy(DataJamMengajarGuru $dataJamMengajarGuru)
    {
        $dataJamMengajarGuru->delete();

        return response()->json(['message' => 'Data jam mengajar berhasil dihapus.']);
    }
}
