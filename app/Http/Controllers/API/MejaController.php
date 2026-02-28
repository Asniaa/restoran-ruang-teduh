<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::all();
        return response()->json([
            'success' => true,
            'data' => $meja
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|string|max:255',
            'status' => 'required|in:available,occupied'
        ]);

        $meja = Meja::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil ditambahkan',
            'data' => $meja
        ], 201);
    }

    public function show($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json([
                'success' => false,
                'message' => 'Meja tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $meja
        ]);
    }

    public function update(Request $request, $id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json([
                'success' => false,
                'message' => 'Meja tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nomor_meja' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:available,occupied'
        ]);

        $meja->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil diupdate',
            'data' => $meja
        ]);
    }

    public function destroy($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json([
                'success' => false,
                'message' => 'Meja tidak ditemukan'
            ], 404);
        }

        $meja->delete();

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil dihapus'
        ]);
    }
}