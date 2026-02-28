<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    public function index()
    {
        $detailPesanan = DetailPesanan::with(['pesanan', 'menu'])->get();
        return response()->json([
            'success' => true,
            'data' => $detailPesanan
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pesanan_id' => 'required|integer',
            'menu_id' => 'required|integer',
            'kuantitas' => 'required|integer|min:1',
            'catatan' => 'nullable|string'
        ]);

        $detail = DetailPesanan::create($validated);
        $detail->load(['pesanan', 'menu']);

        return response()->json([
            'success' => true,
            'message' => 'Detail pesanan berhasil ditambahkan',
            'data' => $detail
        ], 201);
    }

    public function show($id)
    {
        $detail = DetailPesanan::with(['pesanan', 'menu'])->find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Detail pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $detail
        ]);
    }

    public function update(Request $request, $id)
    {
        $detail = DetailPesanan::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Detail pesanan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'pesanan_id' => 'sometimes|integer',
            'menu_id' => 'sometimes|integer',
            'kuantitas' => 'sometimes|integer|min:1',
            'catatan' => 'nullable|string'
        ]);

        $detail->update($validated);
        $detail->load(['pesanan', 'menu']);

        return response()->json([
            'success' => true,
            'message' => 'Detail pesanan berhasil diupdate',
            'data' => $detail
        ]);
    }

    public function destroy($id)
    {
        $detail = DetailPesanan::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Detail pesanan tidak ditemukan'
            ], 404);
        }

        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Detail pesanan berhasil dihapus'
        ]);
    }
} 