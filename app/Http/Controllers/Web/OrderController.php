<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Meja;
use App\Models\Karyawan;
use App\Models\Payment;
use App\Models\OperationalDay;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')->orderBy('nama_menu')->get();
        $categories = KategoriMenu::orderBy('nama_kategori')->get();
        return view('order_index', ['menus' => $menus, 'categories' => $categories]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'qty' => 'required|integer|min:1',
        ]);
        $cart = session()->get('cart', []);
        $menuId = (string) $validated['menu_id'];
        $qty = (int) $validated['qty'];
        $cart[$menuId] = ($cart[$menuId] ?? 0) + $qty;
        session()->put('cart', $cart);
        return redirect()->route('order.cart');
    }

    public function remove($menuId)
    {
        $cart = session()->get('cart', []);
        unset($cart[(string) $menuId]);
        session()->put('cart', $cart);
        return redirect()->route('order.cart');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;
        if (!empty($cart)) {
            $menus = Menu::whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $id => $qty) {
                $m = $menus[$id] ?? null;
                if ($m) {
                    $line = [
                        'id' => $m->id,
                        'nama_menu' => $m->nama_menu,
                        'harga' => $m->harga,
                        'qty' => $qty,
                        'subtotal' => $m->harga * $qty,
                    ];
                    $items[] = $line;
                    $total += $line['subtotal'];
                }
            }
        }
        return view('cart', ['items' => $items, 'total' => $total]);
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('order.index');
        }
        $tables = Meja::orderBy('nomor_meja')->get();
        $staff = Karyawan::where('aktif', true)->orderBy('nama')->get();
        $day = OperationalDay::orderByDesc('tanggal')->first();
        if (!$day) {
            $day = OperationalDay::create([
                'tanggal' => now()->toDateString(),
                'status' => 'open',
            ]);
        }
        return view('checkout', ['tables' => $tables, 'staff' => $staff, 'operational_day_id' => $day->id]);
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'operational_day_id' => 'required|exists:operational_days,id',
            'meja_id' => 'required|exists:meja,id',
            'jenis_pesanan' => 'required|in:dine_in,take_away',
            'ditangani_oleh' => 'required|exists:karyawan,id',
            'metode_pembayaran' => 'required|in:cash,qris',
        ]);
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('order.index');
        }
        return DB::transaction(function () use ($validated, $cart) {
            $pesanan = Pesanan::create([
                'operational_day_id' => $validated['operational_day_id'],
                'meja_id' => $validated['meja_id'],
                'jenis_pesanan' => $validated['jenis_pesanan'],
                'status' => 'open',
                'ditangani_oleh' => $validated['ditangani_oleh'],
                'waktu_pesan' => now(),
            ]);
            $menus = Menu::whereIn('id', array_keys($cart))->get()->keyBy('id');
            $total = 0;
            foreach ($cart as $id => $qty) {
                $m = $menus[$id] ?? null;
                if ($m) {
                    DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'menu_id' => $m->id,
                        'kuantitas' => $qty,
                        'harga_saat_pesan' => $m->harga,
                    ]);
                    $total += $m->harga * $qty;
                }
            }
            Payment::create([
                'pesanan_id' => $pesanan->id,
                'karyawan_id' => $validated['ditangani_oleh'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'total_bayar' => $total,
                'waktu_bayar' => now(),
            ]);
            $pesanan->update(['status' => 'paid']);
            session()->forget('cart');
            session()->put('last_pesanan_id', $pesanan->id);
            return redirect()->route('order.success');
        });
    }

    public function success()
    {
        return view('order_success');
    }

    public function receipt($id)
    {
        $order = Pesanan::with(['detail.menu', 'payment', 'meja', 'karyawan'])->findOrFail($id);
        $items = [];
        $total = 0;
        foreach ($order->detail as $d) {
            $qty = $d->kuantitas ?? ($d->qty ?? 0);
            $price = $d->harga_saat_pesan ?? ($d->harga_satuan ?? 0);
            $line = [
                'menu' => $d->menu?->nama_menu ?? 'Menu',
                'qty' => $qty,
                'price' => $price,
                'subtotal' => $qty * $price
            ];
            $items[] = $line;
            $total += $line['subtotal'];
        }
        return view('receipt', ['order' => $order, 'items' => $items, 'total' => $total]);
    }
}
