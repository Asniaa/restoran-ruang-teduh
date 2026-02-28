<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Get pesanan for Dapur (Kitchen)
     * Filter: status preparing atau ready
     */
    public function getDapurPesanan()
    {
        try {
            $pesanan = Pesanan::with(['detailPesanan.menu', 'meja'])
                ->whereIn('status', ['open', 'preparing', 'ready'])
                ->orderBy('waktu_pesan', 'asc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $pesanan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pesanan for Pelayan (Waiter/Waitress)
     * Semua pesanan aktif
     */
    public function getPelayanPesanan()
    {
        try {
            $pesanan = Pesanan::with(['detailPesanan.menu', 'meja'])
                ->whereNotIn('status', ['paid', 'cancelled'])
                ->orderBy('waktu_pesan', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $pesanan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pesanan for Kasir (Cashier)
     * Filter: pesanan yang ready/delivered (siap dibayar)
     */
    public function getKasirPesanan()
    {
        try {
            $pesanan = Pesanan::with(['detailPesanan.menu', 'meja'])
                ->whereIn('status', ['ready', 'delivered'])
                ->orderBy('waktu_pesan', 'desc')
                ->get()
                ->map(function($p) {
                    // Hitung total dari detail_pesanan
                    $p->total_harga = $p->detailPesanan->sum(function($detail) {
                        return $detail->harga_saat_pesan * $detail->kuantitas;
                    });
                    return $p;
                });
            
            return response()->json([
                'success' => true,
                'data' => $pesanan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment history untuk Kasir
     */
    public function getKasirRiwayat()
    {
        try {
            $payments = Payment::with([
                'pesanan.detailPesanan.menu', 
                'pesanan.meja',
                'karyawan'
            ])
                ->orderBy('waktu_bayar', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $payments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
