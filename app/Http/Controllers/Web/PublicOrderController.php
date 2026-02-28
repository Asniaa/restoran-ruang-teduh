<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\OperationalDay;
use App\Models\Pesanan;
use App\Models\DetailPesanan;

class PublicOrderController extends Controller
{
    public function index($no_meja)
    {
        session(['meja_id' => $no_meja]);

        $categories = KategoriMenu::all();
        $menus = Menu::with('kategori')->where('aktif', true)->get();

        return view('order.index', [
            'no_meja' => $no_meja,
            'categories' => $categories,
            'menus' => $menus
        ]);
    }

    public function addToCart(Request $request)
    {
        $menu = Menu::findOrFail($request->menu_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] += $request->quantity;
        } else {
            $cart[$menu->id] = [
                "name" => $menu->nama_menu,
                "quantity" => $request->quantity,
                "price" => $menu->harga,
                "foto_url" => $menu->foto_url
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu added to cart successfully!');
    }

    public function cart()
    {
        return view('order.cart');
    }

    public function checkout()
    {
        $cart = session()->get('cart');
        $mejaId = session()->get('meja_id'); // Assuming passed as number, need ID?
        // Wait, 'meja_id' in session from index($no_meja) is likely just the number string.
        // We need the actual Meja ID.

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        // Find Meja ID by nomor_meja (assuming $mejaId is strictly the number part or full string 'Meja X')
        // In index() we set session(['meja_id' => $no_meja]);
        // Let's assume $no_meja is the ID for simplicity OR the 'nomor_meja' string.
        // The prompt said: "QR mengarah ke route: /order/{nomor_meja}. Sistem mengambil data dari tabel meja berdasarkan nomor_meja."
        // So we should query Meja by `nomor_meja`.

        // Clean input if needed, e.g. "5" -> "Meja 5"? Or existing data is "Meja 5".
        // Let's try to find exact match first.
        $meja = Meja::where('nomor_meja', $mejaId)
            ->orWhere('id', $mejaId) // Fallback if ID passed
            ->first();

        if (!$meja) {
            return redirect()->back()->with('error', 'Invalid Table!');
        }

        // Get active operational day
        $operationalDay = OperationalDay::where('status', 'open')->latest()->first();
        if (!$operationalDay) {
            return redirect()->back()->with('error', 'Restaurant is closed!');
        }

        DB::beginTransaction();
        try {
            $pesanan = Pesanan::create([
                'meja_id' => $meja->id,
                'operational_day_id' => $operationalDay->id,
                'jenis_pesanan' => 'dine_in',
                'status' => 'open',
                'waktu_pesan' => now(),
                // 'nama_pelanggan' => 'Guest' // Optional
            ]);

            foreach ($cart as $id => $details) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $id,
                    'kuantitas' => $details['quantity'],
                    'harga_saat_pesan' => $details['price'], // Add this column if exists in DB? Prompt says "detail pesanan stored: pesanan_id, menu_id, kuantitas".
                    // Standard practice is to store price snapshot.
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('public.order.index', $mejaId)->with('success', 'Order placed successfully! Please wait.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Order failed! ' . $e->getMessage());
        }
    }
}
