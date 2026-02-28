<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class KitchenController extends Controller
{
    public function index()
    {
        $orders = Pesanan::with(['meja', 'detailPesanan.menu'])
            ->whereIn('status', ['open', 'preparing'])
            ->orderBy('waktu_pesan', 'asc')
            ->get();

        return view('kitchen.index', ['orders' => $orders]);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Pesanan::findOrFail($id);

        // Validate transition
        if ($order->status == 'open') {
            $order->status = 'preparing';
        } elseif ($order->status == 'preparing') {
            $order->status = 'ready';
        }

        $order->save();

        return back()->with('success', 'Order status updated to ' . $order->status);
    }
}
