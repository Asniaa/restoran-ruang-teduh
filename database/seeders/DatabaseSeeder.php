<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Karyawan;
use App\Models\OperationalDay;
use App\Models\StokMenuHarian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            KategoriMenu::firstOrCreate(['nama_kategori' => 'Makanan Pokok']),
            KategoriMenu::firstOrCreate(['nama_kategori' => 'Minuman']),
            KategoriMenu::firstOrCreate(['nama_kategori' => 'Dessert']),
            KategoriMenu::firstOrCreate(['nama_kategori' => 'Appetizer']),
        ];

        // Create menus
        $menus = [
            ['nama_menu' => 'Nasi Goreng', 'kategori_id' => 1, 'harga' => 35000],
            ['nama_menu' => 'Mie Goreng', 'kategori_id' => 1, 'harga' => 30000],
            ['nama_menu' => 'Ayam Bakar', 'kategori_id' => 1, 'harga' => 45000],
            ['nama_menu' => 'Ikan Bakar', 'kategori_id' => 1, 'harga' => 50000],
            ['nama_menu' => 'Es Teh', 'kategori_id' => 2, 'harga' => 10000],
            ['nama_menu' => 'Es Kopi', 'kategori_id' => 2, 'harga' => 12000],
            ['nama_menu' => 'Jus Jeruk', 'kategori_id' => 2, 'harga' => 15000],
            ['nama_menu' => 'Tiramisu', 'kategori_id' => 3, 'harga' => 20000],
            ['nama_menu' => 'Brownies', 'kategori_id' => 3, 'harga' => 18000],
            ['nama_menu' => 'Lumpia Goreng', 'kategori_id' => 4, 'harga' => 12000],
            ['nama_menu' => 'Satay', 'kategori_id' => 4, 'harga' => 25000],
        ];

        foreach ($menus as $menu) {
            Menu::firstOrCreate(
                ['nama_menu' => $menu['nama_menu']],
                ['kategori_id' => $menu['kategori_id'], 'harga' => $menu['harga'], 'aktif' => true]
            );
        }

        // Create tables
        for ($i = 1; $i <= 10; $i++) {
            Meja::firstOrCreate(
                ['nomor_meja' => $i],
                ['status' => 'available']
            );
        }

        // Create staff
        $karyawanData = [
            [
                'nama' => 'Budi Santoso',
                'role' => 'dapur',
                'email' => 'dapur@resto.com',
                'password' => 'password123'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'role' => 'kasir',
                'email' => 'kasir@resto.com',
                'password' => 'password123'
            ],
            [
                'nama' => 'Ahmad Riyanto',
                'role' => 'pelayan',
                'email' => 'pelayan@resto.com',
                'password' => 'password123'
            ],
            [
                'nama' => 'Admin Resto',
                'role' => 'admin',
                'email' => 'admin@resto.com',
                'password' => 'password123'
            ],
        ];

        foreach ($karyawanData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['nama'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                    'aktif' => true,
                ]
            );

            Karyawan::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => $data['nama'],
                    'aktif' => true,
                ]
            );
        }

        // Create operational day today
        $operationalDay = OperationalDay::firstOrCreate(
            ['tanggal' => date('Y-m-d')],
            ['status' => 'open']
        );

        // Create stok menu harian
        $allMenus = Menu::all();
        foreach ($allMenus as $menu) {
            StokMenuHarian::firstOrCreate(
                ['menu_id' => $menu->id, 'operational_day_id' => $operationalDay->id],
                ['stok' => 50]
            );
        }
    }
}
