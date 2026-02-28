<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class DapurController extends Controller
{
    /**
     * Dashboard dapur dengan pesanan per status
     */
    public function index()
    {
        $today = now()->toDateString();

        // Pesanan BARU (status=open)
        $pesananBaru = Pesanan::where('status', 'open')
            ->whereDate('created_at', $today)
            ->with(['meja', 'detailPesanan.menu'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Pesanan SEDANG DIMASAK (status=preparing)
        $pesananSedangMasak = Pesanan::where('status', 'preparing')
            ->whereDate('created_at', $today)
            ->with(['meja', 'detailPesanan.menu'])
            ->orderBy('updated_at', 'asc')
            ->get();

        // Pesanan SIAP DIANTAR (status=ready)
        $pesananSiapDiantar = Pesanan::where('status', 'ready')
            ->whereDate('created_at', $today)
            ->with(['meja', 'detailPesanan.menu'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('dapur.index', [
            'pesananBaru' => $pesananBaru,
            'pesananSedangMasak' => $pesananSedangMasak,
            'pesananSiapDiantar' => $pesananSiapDiantar,
            'countBaru' => $pesananBaru->count(),
            'countSedangMasak' => $pesananSedangMasak->count(),
            'countSiapDiantar' => $pesananSiapDiantar->count(),
        ]);
    }

    /**
     * Mulai memasak (ubah status open -> preparing)
     */
    public function mulaiMasak($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status !== 'open') {
            return back()->with('error', 'Pesanan tidak dalam status yang tepat.');
        }

        $pesanan->update(['status' => 'preparing']);

        return back()->with('success', 'Mulai memasak pesanan meja ' . $pesanan->meja->nomor_meja);
    }

    /**
     * Tandai selesai (ubah status preparing -> ready)
     */
    public function tandaiSelesai($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status !== 'preparing') {
            return back()->with('error', 'Pesanan tidak dalam status yang tepat.');
        }

        $pesanan->update(['status' => 'ready']);

        return back()->with('success', 'Pesanan meja ' . $pesanan->meja->nomor_meja . ' siap diantar.');
    }
}
