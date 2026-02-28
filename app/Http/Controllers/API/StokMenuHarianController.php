<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StokMenuHarian;
use Illuminate\Http\Request;

class StokMenuHarianController extends Controller
{
    public function index()
    {
        $stok = StokMenuHarian::with(['operationalDay', 'menu'])->get();
        return response()->json([
            'success' => true,
            'data' => $stok
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'operational_day_id' => 'required|integer|exists:operational_days,id',
            'menu_id' => 'required|integer|exists:menu,id',
            'stok' => 'required|integer|min:0'
        ]);

        $stok = StokMenuHarian::create($validated);
        $stok->load(['operationalDay', 'menu']);

        return response()->json([
            'success' => true,
            'message' => 'Stok menu berhasil ditambahkan',
            'data' => $stok
        ], 201);
    }

    public function show($id)
    {
        $stok = StokMenuHarian::with(['operationalDay', 'menu'])->find($id);

        if (!$stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok menu tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $stok
        ]);
    }

    public function update(Request $request, $id)
    {
        $stok = StokMenuHarian::find($id);

        if (!$stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok menu tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'operational_day_id' => 'sometimes|integer|exists:operational_days,id',
            'menu_id' => 'sometimes|integer|exists:menu,id',
            'stok' => 'sometimes|integer|min:0'
        ]);

        $stok->update($validated);
        $stok->load(['operationalDay', 'menu']);

        return response()->json([
            'success' => true,
            'message' => 'Stok menu berhasil diupdate',
            'data' => $stok
        ]);
    }

    public function destroy($id)
    {
        $stok = StokMenuHarian::find($id);

        if (!$stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok menu tidak ditemukan'
            ], 404);
        }

        $stok->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stok menu berhasil dihapus'
        ]);
    }
}