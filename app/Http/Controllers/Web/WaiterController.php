<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class WaiterController extends Controller
{
    public function index()
    {
        $orders = Pesanan::with(['meja', 'detailPesanan.menu'])
            ->where('status', 'ready')
            ->orderBy('updated_at', 'asc')
            ->get();

        return view('waiter.index', ['orders' => $orders]);
    }

    public function markDelivered($id)
    {
        $order = Pesanan::findOrFail($id);

        if ($order->status == 'ready') {
            $order->status = 'delivered';
            $order->save();
            return back()->with('success', 'Order marked as delivered.');
        }

        return back()->with('error', 'Cannot mark as delivered. Current status: ' . $order->status);
    }
}
