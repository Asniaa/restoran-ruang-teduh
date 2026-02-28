<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['pesanan', 'karyawan'])->get();
        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pesanan_id' => 'required|integer|exists:pesanan,id',
            'karyawan_id' => 'required|integer|exists:karyawan,id',
            'metode_pembayaran' => 'required|in:cash,qris',
            'total_bayar' => 'required|numeric|min:0',
            'waktu_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'kembalian' => 'required|numeric|min:0'
        ]);

        // Buat payment
        $payment = Payment::create($validated);

        // Update status pesanan jadi 'paid'
        $pesanan = Pesanan::find($validated['pesanan_id']);
        if ($pesanan) {
            $pesanan->update(['status' => 'paid']);
        }

        $payment->load(['pesanan', 'karyawan']);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diproses',
            'data' => $payment
        ], 201);
    }

    public function show($id)
    {
        $payment = Payment::with(['pesanan', 'karyawan'])->find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment
        ]);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'pesanan_id' => 'sometimes|integer|exists:pesanan,id',
            'karyawan_id' => 'sometimes|integer|exists:karyawan,id',
            'metode_pembayaran' => 'sometimes|in:cash,qris',
            'total_bayar' => 'sometimes|numeric|min:0',
            'waktu_bayar' => 'sometimes|date'
        ]);

        $payment->update($validated);
        $payment->load(['pesanan', 'karyawan']);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diupdate',
            'data' => $payment
        ]);
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dihapus'
        ]);
    }
}