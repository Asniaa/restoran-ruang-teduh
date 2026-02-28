<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Karyawan;
use App\Models\Pesanan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function getStatistik()
    {
        try {
            $today = now()->toDateString();
            $totalMenu = Menu::count();
            $totalKaryawan = Karyawan::count();
            $totalMeja = Meja::count();
            
            // Pesanan aktif (belum paid/cancelled)
            $pesananAktif = Pesanan::whereNotIn('status', ['paid', 'cancelled'])->count();
            
            // Meja terisi (status occupied)
            $mejaTerisi = Meja::where('status', 'occupied')->count();
            
            // Total penjualan diambil dari tabel payment agar konsisten dengan data transaksi real
            // Jika ingin total semua penjualan (bukan hanya hari ini), jangan filter by tanggal
            $totalPendapatanHari = (int) (Payment::sum('total_bayar') ?? 0);

            Log::info('Admin statistik loaded', [
                'date' => $today,
                'total_menu' => $totalMenu,
                'total_karyawan' => $totalKaryawan,
                'total_meja' => $totalMeja,
                'pesanan_aktif' => $pesananAktif,
                'meja_terisi' => $mejaTerisi,
                'total_pendapatan_hari_ini' => $totalPendapatanHari,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'total_menu' => $totalMenu,
                    'total_karyawan' => $totalKaryawan,
                    'total_meja' => $totalMeja,
                    'total_pendapatan_hari_ini' => $totalPendapatanHari,
                    'pesanan_aktif' => $pesananAktif,
                    'meja_terisi' => $mejaTerisi,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load admin statistik', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all menus
     */
    public function getMenu()
    {
        try {
            $menus = Menu::all()->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'nama' => $menu->nama_menu,
                    'deskripsi' => $menu->deskripsi,
                    'harga' => (int) $menu->harga,
                    'kategori_id' => $menu->kategori_id,
                    'gambar' => $menu->foto,
                    'status' => $menu->aktif ? 'tersedia' : 'habis',
                    'created_at' => $menu->created_at,
                    'updated_at' => $menu->updated_at,
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $menus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all menu categories
     */
    public function getKategori()
    {
        try {
            $kategoris = KategoriMenu::all()->map(function ($kategori) {
                return [
                    'id' => $kategori->id,
                    'nama' => $kategori->nama_kategori,
                    'deskripsi' => $kategori->deskripsi ?? null,
                    'created_at' => $kategori->created_at,
                    'updated_at' => $kategori->updated_at,
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $kategoris
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all tables
     */
    public function getMeja()
    {
        try {
            $mejas = Meja::all();
            
            return response()->json([
                'success' => true,
                'data' => $mejas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all staff/employees
     */
    public function getKaryawan()
    {
        try {
            $karyawans = User::where('role', '!=', 'pelanggan')
                ->select('id', 'name', 'email', 'role', 'created_at', 'updated_at')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $karyawans
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}

