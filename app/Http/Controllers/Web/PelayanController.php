<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PelayanController extends Controller
{
    /**
     * Dashboard pelayan dengan pesanan per status
     */
    public function index()
    {
        $today = now()->toDateString();

        // Pesanan PERLU DIANTAR (status=ready)
        $pesananPerluDiantar = Pesanan::where('status', 'ready')
            ->whereDate('created_at', $today)
            ->with(['meja', 'detailPesanan.menu'])
            ->orderBy('updated_at', 'asc')
            ->get();

        // Pesanan SUDAH DIANTAR (status=delivered)
        $pesananSudahDiantar = Pesanan::where('status', 'delivered')
            ->whereDate('created_at', $today)
            ->with(['meja', 'detailPesanan.menu'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('pelayan.index', [
            'pesananPerluDiantar' => $pesananPerluDiantar,
            'pesananSudahDiantar' => $pesananSudahDiantar,
            'countPerluDiantar' => $pesananPerluDiantar->count(),
            'countSudahDiantar' => $pesananSudahDiantar->count(),
        ]);
    }

    /**
     * Tandai sudah diantar (ubah status ready -> delivered)
     */
    public function sudahDiantar($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status !== 'ready') {
            return back()->with('error', 'Pesanan tidak dalam status yang tepat.');
        }

        $pesanan->update(['status' => 'delivered']);

        return back()->with('success', 'Pesanan meja ' . $pesanan->meja->nomor_meja . ' sudah diantar.');
    }
}
