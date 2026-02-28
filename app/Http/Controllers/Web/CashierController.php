<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Pesanan::with(['meja', 'detailPesanan.menu'])
            ->whereIn('status', ['ready', 'delivered'])
            ->orderBy('updated_at', 'asc')
            ->get();

        return view('cashier.index', ['orders' => $orders]);
    }

    public function show($id)
    {
        $order = \App\Models\Pesanan::with(['meja', 'detailPesanan.menu'])->findOrFail($id);

        // Calculate total
        $total = 0;
        foreach ($order->detailPesanan as $detail) {
            $total += $detail->kuantitas * $detail->harga_saat_pesan;
        }

        return view('cashier.show', ['order' => $order, 'total' => $total]);
    }

    public function pay(Request $request, $id)
    {
        $order = \App\Models\Pesanan::findOrFail($id);

        // Calculate total again for security
        $total = 0;
        foreach ($order->detailPesanan as $detail) {
            $total += $detail->kuantitas * $detail->harga_saat_pesan;
        }

        \App\Models\Payment::create([
            'pesanan_id' => $order->id,
            'karyawan_id' => $request->user()->karyawan->id,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_bayar' => $total,
            'waktu_bayar' => now()
        ]);

        $order->status = 'paid';
        $order->save();

        return redirect()->route('cashier.index')->with('success', 'Payment successful for Order #' . $order->id);
    }
}
