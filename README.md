# Ruang Teduh - Restaurant Management System

**Ruang Teduh** adalah aplikasi manajemen restoran berbasis web yang dibangun dengan Laravel 12. Aplikasi ini dirancang untuk mengelola seluruh operasional restoran, mulai dari pemesanan mandiri oleh pelanggan melalui QR Code hingga laporan keuangan mendalam untuk Admin.

## Fitur Utama

### 1. Panel Admin (Owner)
- **Dashboard Real-time**: Pantau statistik harian seperti Total Penjualan, Pesanan Aktif, Meja Terisi, dan Menu Aktif.
- **Laporan Bisnis Canggih**:
   - Grafik Menu Terlaris (Top 5)
   - Tren Pendapatan Bulanan
   - Analisis Pendapatan per Kategori
   - Ringkasan Harian Otomatis
- **Manajemen Operasional (Buka/Tutup)**: Kontrol penuh atas jam operasional restoran. Pelanggan hanya bisa memesan saat status "Open".
- **Manajemen Menu & Stok**: Tambah menu dengan foto, atur harga, dan kategorisasi menu.
- **QR Code Generator Otomatis**: Generate QR Code unik untuk setiap meja menggunakan API (api.qrserver.com) yang bisa langsung diunduh dan dicetak.
- **Manajemen SDM**: Kelola akun dan akses untuk staff (Dapur, Pelayan, Kasir).

### 2. Panel Kasir (POS Sederhana)
- **Pembayaran Cepat**: Proses pembayaran pesanan dengan perhitungan kembalian otomatis.
- **Status Pesanan**: Update status pembayaran secara real-time yang terhubung ke dapur dan pelayan.

### 3. Panel Dapur (Kitchen Display System)
- **Antrean Pesanan**: Tampilan visual untuk koki melihat pesanan masuk.
- **Manajemen Status**: Ubah status masak ("Sedang Dimasak" -> "Siap Saji") untuk memberitahu pelayan.

### 4. Panel Pelayan (Waiter)
- **Pengantaran Pesanan**: Notifikasi pesanan siap saji dari dapur untuk segera diantar ke meja.
- **Monitoring Meja**: Lihat status meja yang aktif memesan.

### 5. Pelanggan (Self-Service)
- **Scan to Order**: Akses menu digital langsung dari scan QR Code di meja.
- **Keranjang Belanja**: Pilih menu, tentukan jumlah, dan kirim pesanan langsung ke dapur.

## Teknologi

- **Backend**: Laravel 12 (PHP 8.4)
- **Database**: MySQL / MariaDB
- **Frontend**: Blade Templates, Tailwind CSS (untuk Laporan), Vanilla CSS (UI Inti), JavaScript (AJAX/Fetch)
- **Icons**: SVG & Unicode Dashboard Icons

## Instalasi

1. **Clone repositori**:
   ```bash
   git clone https://github.com/username/resto_app.git
   cd resto_app/laravel
   ```

2. **Install Depedensi**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   Salin `.env.example` ke `.env` dan atur koneksi database:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Link Storage & Migrasi Database**:
   Aplikasi ini menyimpan foto menu di storage, jadi perlu disymlink agar bisa diakses:
   ```bash
   php artisan storage:link
   php artisan migrate --seed
   ```

5. **Build Assets Frontend**:
   ```bash
   npm run build
   ```

6. **Jalankan Aplikasi**:
   ```bash
   php artisan serve
   ```

## Kredensial Default (Seeder)
- **Admin**: `admin@mail.com` / `password123`
- **Kasir**: `kasir@mail.com` / `password123`
- **Dapur**: `dapur@mail.com` / `password123`
- **Pelayan**: `pelayan@mail.com` / `password123`

## Akses Pelanggan (Simulasi QR Code)
Untuk mensimulasikan scan QR Code pelanggan di meja nomor 1, akses URL berikut:
- **URL**: `http://127.0.0.1:8000/meja/1/menu`

*(Ganti angka `1` dengan nomor meja lain yang terdaftar di database)*

---
© 2026 Ruang Teduh - Developed for efficient restaurant operations.
