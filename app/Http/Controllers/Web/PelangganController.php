<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\OperationalDay;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Tampil menu untuk pelanggan (QR)
     */
    public function showMenu($meja_id)
    {
        // Cek meja ada
        $meja = Meja::findOrFail($meja_id);

        // Ambil kategori menu
        $kategoris = KategoriMenu::with('menu')->whereHas('menu', function ($q) {
            $q->where('aktif', true);
        })->get();

        // Ambil semua menu aktif
        $menus = Menu::where('aktif', true)->get();

        // Cek operational day hari ini
        $today = now()->toDateString();
        $isClosed = !OperationalDay::whereDate('tanggal', $today)
            ->where('status', 'open')
            ->exists();

        // Cek apakah ada pesanan open untuk meja ini hari ini
        $today = now()->toDateString();
        $pesanan = Pesanan::where('meja_id', $meja_id)
            ->whereIn('status', ['open', 'preparing', 'ready', 'delivered'])
            ->whereDate('created_at', $today)
            ->first();

        // Jika ada pesanan, ambil detail
        $cartItems = [];
        $totalHarga = 0;
        if ($pesanan) {
            $details = DetailPesanan::where('pesanan_id', $pesanan->id)->with('menu')->get();
            foreach ($details as $detail) {
                $cartItems[] = [
                    'id' => $detail->menu_id,
                    'nama' => $detail->menu->nama_menu,
                    'harga' => $detail->menu->harga,
                    'kuantitas' => $detail->kuantitas,
                    'subtotal' => $detail->menu->harga * $detail->kuantitas,
                ];
                $totalHarga += $detail->menu->harga * $detail->kuantitas;
            }
        }

        return view('pelanggan.menu', [
            'meja_id' => $meja_id,
            'meja' => $meja,
            'kategoris' => $kategoris,
            'menus' => $menus,
            'cartItems' => $cartItems,
            'totalHarga' => $totalHarga,
            'pesanan_id' => $pesanan->id ?? null,
            'isClosed' => $isClosed,
        ]);
    }

    /**
     * Tambah menu ke pesanan
     */
    public function pesan(Request $request, $meja_id)
    {
        $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'kuantitas' => 'required|integer|min:1',
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $meja = Meja::findOrFail($meja_id);

        // Cek operational day hari ini
        $today = now()->toDateString();
        $operationalDay = OperationalDay::whereDate('tanggal', $today)
            ->where('status', 'open')
            ->first();

        if (!$operationalDay) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Restoran sedang tutup.'
                ], 403);
            }
            return back()->with('error', 'Restoran sedang tutup.');
        }

        // Cek atau buat pesanan untuk meja hari ini
        $pesanan = Pesanan::where('meja_id', $meja_id)
            ->where('operational_day_id', $operationalDay->id)
            ->whereIn('status', ['open', 'preparing', 'ready', 'delivered'])
            ->first();

        if (!$pesanan) {
            $pesanan = Pesanan::create([
                'meja_id' => $meja_id,
                'operational_day_id' => $operationalDay->id,
                'status' => 'open',
                'created_at' => now(),
            ]);

            // Update meja status jadi occupied
            $meja->update(['status' => 'occupied']);
        }

        // Cek detail pesanan sudah ada untuk menu ini
        $detail = DetailPesanan::where('pesanan_id', $pesanan->id)
            ->where('menu_id', $request->menu_id)
            ->first();

        if ($detail) {
            // Kuantitas +1
            $detail->update(['kuantitas' => $detail->kuantitas + $request->kuantitas]);
        } else {
            // Buat detail pesanan baru
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $request->menu_id,
                'kuantitas' => $request->kuantitas,
                'harga_saat_pesan' => $menu->harga,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu ditambahkan ke pesanan.'
            ]);
        }

        return back()->with('success', 'Menu ditambahkan ke pesanan.');
    }
}
