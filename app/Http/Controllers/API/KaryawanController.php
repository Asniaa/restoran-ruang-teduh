<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        return response()->json([
            'success' => true,
            'data' => $karyawan
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'aktif' => 'required|boolean'
        ]);

        $karyawan = Karyawan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil ditambahkan',
            'data' => $karyawan
        ], 201);
    }

    public function show($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $karyawan
        ]);
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'role' => 'sometimes|string|max:255',
            'aktif' => 'sometimes|boolean'
        ]);

        $karyawan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil diupdate',
            'data' => $karyawan
        ]);
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        $karyawan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil dihapus'
        ]);
    }
}