<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Payment;
use App\Models\OperationalDay;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Dashboard admin dengan statistik
     */
    public function index()
    {
        $today = now()->toDateString();

        // Total Penjualan
        $totalPenjualan = Payment::sum('total_bayar');

        // Pesanan Aktif
        // Some parts of the app use different status names (paid/dibayar, pending, proses, selesai).
        // Treat an order as "active" when its status is NOT a final/paid/cancelled state.
        $finalStatuses = ['paid', 'dibayar', 'selesai', 'completed', 'cancelled'];

        $pesananAktif = Pesanan::whereDate('created_at', $today)
            ->whereNotIn('status', $finalStatuses)
            ->count();

        // Meja Terisi
        // Hybrid approach: count tables marked 'occupied' OR tables that have a non-final
        // order in the recent window (last 2 hours). This is robust if some flows update
        // Meja.status and others rely on orders only.
        $since = now()->subHours(2);

        // IDs of tables marked occupied
        $occupiedByFlag = Meja::where('status', 'occupied')->pluck('id')->toArray();

        // IDs of tables with recent non-final orders
        $occupiedByOrders = Pesanan::where('created_at', '>=', $since)
            ->whereNotIn('status', $finalStatuses)
            ->whereNotNull('meja_id')
            ->pluck('meja_id')
            ->unique()
            ->filter()
            ->toArray();

        // Union and count distinct
        $union = array_unique(array_merge($occupiedByFlag, $occupiedByOrders));
        $mejaHuni = count($union);

        // Total Menu Aktif
        $totalMenuAktif = Menu::where('aktif', true)->count();

        // Operational Days Data
        $operationalDays = OperationalDay::orderBy('tanggal', 'DESC')->paginate(5);
        $todayRecord = OperationalDay::whereDate('tanggal', $today)->first();

        return view('admin.index', [
            'totalPenjualan' => $totalPenjualan,
            'pesananAktif' => $pesananAktif,
            'mejaHuni' => $mejaHuni,
            'totalMenuAktif' => $totalMenuAktif,
            'operationalDays' => $operationalDays,
            'todayRecord' => $todayRecord
        ]);
    }

    /**
     * Index menu dengan search
     */
    public function indexMenu(Request $request)
    {
        $query = Menu::with('kategori');

        if ($search = $request->search) {
            $query->where('nama_menu', 'like', "%$search%");
        }

        $menus = $query->paginate(15);

        return view('admin.menu', ['menus' => $menus]);
    }

    /**
     * Store menu baru
     */
    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_menu,id',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_url' => 'nullable|url',
            'aktif' => 'boolean',
        ]);

        // Handle file upload atau URL
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('menus', $filename, 'public');
            $validated['foto'] = $path;
        } elseif ($request->filled('foto_url')) {
            $validated['foto'] = $request->input('foto_url');
        }

        Menu::create($validated);

        return back()->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Update menu
     */
    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_menu,id',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_url' => 'nullable|url',
            'aktif' => 'boolean',
        ]);

        // Handle file upload atau URL
        if ($request->hasFile('foto')) {
            // Delete old foto if it's a local file
            if ($menu->foto && !filter_var($menu->foto, FILTER_VALIDATE_URL) && \Storage::disk('public')->exists($menu->foto)) {
                \Storage::disk('public')->delete($menu->foto);
            }
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('menus', $filename, 'public');
            $validated['foto'] = $path;
        } elseif ($request->filled('foto_url')) {
            // Delete old local file if exists
            if ($menu->foto && !filter_var($menu->foto, FILTER_VALIDATE_URL) && \Storage::disk('public')->exists($menu->foto)) {
                \Storage::disk('public')->delete($menu->foto);
            }
            $validated['foto'] = $request->input('foto_url');
        }

        $menu->update($validated);

        return back()->with('success', 'Menu berhasil diupdate.');
    }

    /**
     * Delete menu
     */
    public function deleteMenu($id)
    {
        Menu::findOrFail($id)->delete();

        return back()->with('success', 'Menu berhasil dihapus.');
    }

    /**
     * Index kategori menu
     */
    public function indexKategori()
    {
        $kategoris = KategoriMenu::withCount('menu')->paginate(15);

        return view('admin.kategori', ['kategoris' => $kategoris]);
    }

    /**
     * Store kategori baru
     */
    public function storeKategori(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|unique:kategori_menu',
        ]);

        KategoriMenu::create($validated);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Update kategori
     */
    public function updateKategori(Request $request, $id)
    {
        $kategori = KategoriMenu::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => "required|string|unique:kategori_menu,nama_kategori,$id",
        ]);

        $kategori->update($validated);

        return back()->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * Delete kategori
     */
    public function deleteKategori($id)
    {
        KategoriMenu::findOrFail($id)->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Index meja dengan QR code
     */
    public function indexMeja()
    {
        $mejas = Meja::all();

        return view('admin.meja', ['mejas' => $mejas]);
    }

    /**
     * Generate QR code untuk meja
     */
    public function generateQR($id)
    {
        $meja = Meja::findOrFail($id);

        // QR berisi URL: /meja/{id}/menu
        $url = route('pelanggan.menu', ['meja_id' => $meja->id]);

        // Generate QR URL menggunakan API pihak ketiga (qrserver.com)
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);

        $meja->update(['qr_code' => $qrUrl]);

        return response()->json(['message' => 'QR Code berhasil di-generate untuk Meja ' . $meja->nomor_meja]);
    }

    /**
     * Download QR code meja
     */
    public function downloadQR($id)
    {
        $meja = Meja::findOrFail($id);

        $url = route('pelanggan.menu', ['meja_id' => $meja->id]);
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);

        // Redirect ke QR URL
        return redirect($qrUrl);
    }

    /**
     * Index karyawan
     */
    public function indexKaryawan()
    {
        $karyawans = Karyawan::with('user')->paginate(15);
        return view('admin.karyawan', ['karyawans' => $karyawans]);
    }

    /**
     * Index pesanan
     */
    public function indexPesanan()
    {
        $pesanans = Pesanan::with('meja', 'user')->paginate(15);
        return view('admin.pesanan', ['pesanans' => $pesanans]);
    }

    /**
     * Dashboard Laporan Admin
     */
    public function laporan(Request $request)
    {
        $today = now()->toDateString();
        $selectedYear = $request->get('year', date('Y'));

        // 1. Menu Terlaris (Top 5)
        $topMenus = DB::table('detail_pesanan as dp')
            ->join('menu as m', 'dp.menu_id', '=', 'm.id')
            ->join('kategori_menu as k', 'm.kategori_id', '=', 'k.id')
            ->select(
                'm.nama_menu',
                'k.nama_kategori',
                DB::raw('SUM(dp.kuantitas) as total_dipesan'),
                DB::raw('SUM(dp.kuantitas * dp.harga_saat_pesan) as total_pendapatan')
            )
            ->groupBy('m.id', 'm.nama_menu', 'k.nama_kategori')
            ->orderBy('total_dipesan', 'DESC')
            ->limit(5)
            ->get();

        // 2. Total Pendapatan Per Bulan
        $monthlyRevenue = DB::table('payment')
            ->select(
                DB::raw('MONTH(waktu_bayar) as bulan'),
                DB::raw('YEAR(waktu_bayar) as tahun'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->whereYear('waktu_bayar', $selectedYear)
            ->groupBy(DB::raw('YEAR(waktu_bayar)'), DB::raw('MONTH(waktu_bayar)'))
            ->orderBy('tahun', 'DESC')
            ->orderBy('bulan', 'DESC')
            ->get();

        // 3. Pendapatan Per Kategori
        $categoryRevenue = DB::table('detail_pesanan as dp')
            ->join('menu as m', 'dp.menu_id', '=', 'm.id')
            ->join('kategori_menu as k', 'm.kategori_id', '=', 'k.id')
            ->select(
                'k.nama_kategori',
                DB::raw('SUM(dp.kuantitas) as total_item'),
                DB::raw('SUM(dp.kuantitas * dp.harga_saat_pesan) as total_pendapatan')
            )
            ->groupBy('k.id', 'k.nama_kategori')
            ->orderBy('total_pendapatan', 'DESC')
            ->get();

        // 4. Ringkasan Hari Ini
        $todaySummary = [
            'total_pendapatan' => Payment::whereDate('waktu_bayar', $today)->sum('total_bayar'),
            'total_pesanan' => Pesanan::whereDate('created_at', $today)->count(),
            'total_item' => DetailPesanan::whereHas('pesanan', function ($q) use ($today) {
                $q->whereDate('created_at', $today);
            })->sum('kuantitas'),
        ];

        // Available years for filter
        $availableYears = Payment::selectRaw('YEAR(waktu_bayar) as year')
            ->distinct()
            ->orderBy('year', 'DESC')
            ->pluck('year');

        return view('admin.laporan', [
            'topMenus' => $topMenus,
            'monthlyRevenue' => $monthlyRevenue,
            'categoryRevenue' => $categoryRevenue,
            'todaySummary' => $todaySummary,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears
        ]);
    }

    /**
     * Index operational days
     */
    public function indexOperationalDays()
    {
        $operationalDays = OperationalDay::orderBy('tanggal', 'DESC')->paginate(15);

        $today = now()->toDateString();
        $todayRecord = OperationalDay::whereDate('tanggal', $today)->first();

        return view('admin.operational-days', [
            'operationalDays' => $operationalDays,
            'todayRecord' => $todayRecord
        ]);
    }

    /**
     * Edit Menu API
     */
    public function editMenuApi($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    /**
     * Edit Kategori API
     */
    public function editKategoriApi($id)
    {
        $kategori = KategoriMenu::findOrFail($id);
        return response()->json($kategori);
    }

    /**
     * Edit Meja API
     */
    public function editMejaApi($id)
    {
        $meja = Meja::findOrFail($id);
        return response()->json($meja);
    }

    /**
     * Store Meja Baru
     */
    public function storeMeja(Request $request)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|unique:meja',
            'status' => 'required|in:available,occupied',
        ]);

        Meja::create($validated);
        return back()->with('success', 'Meja berhasil ditambahkan.');
    }

    /**
     * Update Meja
     */
    public function updateMeja(Request $request, $id)
    {
        $meja = Meja::findOrFail($id);

        $validated = $request->validate([
            'nomor_meja' => "required|unique:meja,nomor_meja,$id",
            'status' => 'required|in:available,occupied',
        ]);

        $meja->update($validated);
        return back()->with('success', 'Meja berhasil diupdate.');
    }

    /**
     * Delete Meja
     */
    public function deleteMeja($id)
    {
        Meja::findOrFail($id)->delete();
        return back()->with('success', 'Meja berhasil dihapus.');
    }

    /**
     * Store Karyawan Baru
     */
    public function storeKaryawan(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,dapur,pelayan,kasir',
            'password' => 'required|min:6',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'aktif' => true,
            'password' => $validated['password'],
        ]);

        // Create karyawan
        Karyawan::create([
            'user_id' => $user->id,
            'nama' => $validated['nama'],
            'aktif' => true,
        ]);

        return back()->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Edit Karyawan API
     */
    public function editKaryawanApi($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return response()->json([
            'id' => $karyawan->id,
            'user_id' => $karyawan->user_id,
            'nama' => $karyawan->nama,
            'email' => $karyawan->user->email ?? '',
            'role' => $karyawan->user->role ?? '',
            'aktif' => $karyawan->aktif,
        ]);
    }

    /**
     * Update Karyawan
     */
    public function updateKaryawan(Request $request, $id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);

        $rules = [
            'nama' => 'required|string|max:100',
            'email' => "required|email|unique:users,email,{$karyawan->user_id}",
            'role' => 'required|in:admin,dapur,pelayan,kasir',
            'aktif' => 'boolean',
        ];

        // Password hanya required jika ada input
        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $validated = $request->validate($rules);

        // Update user
        $userData = [
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'aktif' => $request->boolean('aktif'),
        ];

        if ($request->filled('password')) {
            $userData['password'] = $validated['password'];
        }

        $karyawan->user->update($userData);

        // Update karyawan
        $karyawan->update([
            'nama' => $validated['nama'],
            'aktif' => $request->boolean('aktif'),
        ]);

        return back()->with('success', 'Karyawan berhasil diupdate.');
    }

    /**
     * Delete Karyawan
     */
    public function deleteKaryawan($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        // Delete user juga
        if ($karyawan->user_id) {
            User::find($karyawan->user_id)->delete();
        }

        $karyawan->delete();
        return back()->with('success', 'Karyawan berhasil dihapus.');
    }

    /**
     * Buka restoran hari ini
     */
    public function openOperationalDay(Request $request)
    {
        $today = now()->toDateString();

        // Cek jika sudah ada
        $exists = OperationalDay::whereDate('tanggal', $today)->first();

        if ($exists) {
            if ($exists->status === 'open') {
                return back()->with('error', 'Restoran sudah dibuka untuk hari ini.');
            }

            // Jika statusnya closed, buka kembali
            $exists->update(['status' => 'open']);
            return back()->with('success', 'Restoran berhasil dibuka KEMBALI. Pelanggan sekarang bisa memesan lagi.');
        }

        OperationalDay::create([
            'tanggal' => $today,
            'status' => 'open'
        ]);

        return back()->with('success', 'Restoran berhasil dibuka untuk hari ini. Pelanggan sekarang bisa memesan.');
    }

    /**
     * Tutup restoran hari ini
     */
    public function closeOperationalDay(Request $request)
    {
        $today = now()->toDateString();

        $day = OperationalDay::whereDate('tanggal', $today)->first();

        if (!$day) {
            return back()->with('error', 'Data operasional hari ini tidak ditemukan.');
        }

        if ($day->status === 'closed') {
            return back()->with('error', 'Restoran sudah ditutup untuk hari ini.');
        }

        $day->update(['status' => 'closed']);

        return back()->with('success', 'Restoran berhasil ditutup. Pelanggan tidak bisa lagi memesan.');
    }
}
