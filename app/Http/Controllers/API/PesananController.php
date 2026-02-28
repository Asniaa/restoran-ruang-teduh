<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['meja', 'detailPesanan.menu'])->get();
        return response()->json([
            'success' => true,
            'data' => $pesanan
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'operational_day_id' => 'required|integer',
            'meja_id' => 'nullable|integer',
            'jenis_pesanan' => 'required|in:dine_in,take_away',
            'status' => 'required|in:open,preparing,ready,paid,cancelled,delivered',
            'waktu_pesan' => 'required|date',
            'detail_pesanan' => 'required|array',
            'detail_pesanan.*.menu_id' => 'required|integer',
            'detail_pesanan.*.kuantitas' => 'required|integer|min:1',
            'detail_pesanan.*.catatan' => 'nullable|string'
        ]);

        // Buat pesanan
        $pesanan = Pesanan::create([
            'operational_day_id' => $validated['operational_day_id'],
            'meja_id' => $validated['meja_id'],
            'jenis_pesanan' => $validated['jenis_pesanan'],
            'status' => $validated['status'],
            'waktu_pesan' => $validated['waktu_pesan']
        ]);

        // Buat detail pesanan
        foreach ($validated['detail_pesanan'] as $detail) {
            $pesanan->detailPesanan()->create([
                'menu_id' => $detail['menu_id'],
                'kuantitas' => $detail['kuantitas'],
                'catatan' => $detail['catatan'] ?? null
            ]);
        }

        // Load relasi
        $pesanan->load(['meja', 'detailPesanan.menu']);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat',
            'data' => $pesanan
        ], 201);
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['meja', 'detailPesanan.menu'])->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pesanan
        ]);
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'operational_day_id' => 'sometimes|integer',
            'meja_id' => 'nullable|integer',
            'jenis_pesanan' => 'sometimes|in:dine_in,take_away',
            'status' => 'sometimes|in:open,preparing,ready,paid,cancelled,delivered',
            'waktu_pesan' => 'sometimes|date'
        ]);

        $pesanan->update($validated);
        $pesanan->load(['meja', 'detailPesanan.menu']);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil diupdate',
            'data' => $pesanan
        ]);
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        // Hapus detail pesanan dulu
        $pesanan->detailPesanan()->delete();

        // Hapus pesanan
        $pesanan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dihapus'
        ]);
    }
}