<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\PelangganController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\DapurController;
use App\Http\Controllers\Web\PelayanController;
use App\Http\Controllers\Web\KasirController;

// Redirect root
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// PUBLIC Routes - Pelanggan (tanpa login)
Route::prefix('/meja/{meja_id}')->name('pelanggan.')->group(function () {
    Route::get('/menu', [PelangganController::class, 'showMenu'])->name('menu');
    Route::post('/pesan', [PelangganController::class, 'pesan'])->name('pesan');
});

// PROTECTED Routes - Hanya staff yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('/admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Menu Management
        Route::get('/menu', [AdminController::class, 'indexMenu'])->name('menu.index');
        Route::post('/menu/create', [AdminController::class, 'storeMenu'])->name('menu.store');
        Route::post('/menu/{id}/update', [AdminController::class, 'updateMenu'])->name('menu.update');
        Route::delete('/menu/{id}', [AdminController::class, 'deleteMenu'])->name('menu.delete');

        // Category Management
        Route::get('/kategori', [AdminController::class, 'indexKategori'])->name('kategori.index');
        Route::post('/kategori/create', [AdminController::class, 'storeKategori'])->name('kategori.store');
        Route::post('/kategori/{id}/update', [AdminController::class, 'updateKategori'])->name('kategori.update');
        Route::delete('/kategori/{id}', [AdminController::class, 'deleteKategori'])->name('kategori.delete');

        // Table Management
        Route::get('/meja', [AdminController::class, 'indexMeja'])->name('meja.index');
        Route::post('/meja/generate-qr/{id}', [AdminController::class, 'generateQR'])->name('meja.generateQR');
        Route::get('/meja/download-qr/{id}', [AdminController::class, 'downloadQR'])->name('meja.downloadQR');

        // Karyawan Management
        Route::get('/karyawan', [AdminController::class, 'indexKaryawan'])->name('karyawan.index');
        Route::post('/karyawan', [AdminController::class, 'storeKaryawan'])->name('karyawan.store');
        Route::get('/karyawan/{id}/edit-api', [AdminController::class, 'editKaryawanApi'])->name('karyawan.editApi');
        Route::put('/karyawan/{id}', [AdminController::class, 'updateKaryawan'])->name('karyawan.update');
        Route::delete('/karyawan/{id}', [AdminController::class, 'deleteKaryawan'])->name('karyawan.delete');

        // Menu edit API
        Route::get('/menu/{id}/edit-api', [AdminController::class, 'editMenuApi'])->name('menu.editApi');
        Route::put('/menu/{id}', [AdminController::class, 'updateMenu'])->name('menu.update');

        // Kategori edit API
        Route::get('/kategori/{id}/edit-api', [AdminController::class, 'editKategoriApi'])->name('kategori.editApi');
        Route::put('/kategori/{id}', [AdminController::class, 'updateKategori'])->name('kategori.update');

        // Meja edit API
        Route::get('/meja/{id}/edit-api', [AdminController::class, 'editMejaApi'])->name('meja.editApi');
        Route::post('/meja', [AdminController::class, 'storeMeja'])->name('meja.store');
        Route::put('/meja/{id}', [AdminController::class, 'updateMeja'])->name('meja.update');
        Route::delete('/meja/{id}', [AdminController::class, 'deleteMeja'])->name('meja.delete');

        // Pesanan Management
        Route::get('/pesanan', [AdminController::class, 'indexPesanan'])->name('pesanan.index');

        // Laporan Penjualan
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan.index');

        // Operational Days
        Route::get('/operational-days', [AdminController::class, 'indexOperationalDays'])->name('operational-days.index');
        Route::post('/operational-days/open', [AdminController::class, 'openOperationalDay'])->name('operational-days.open');
        Route::post('/operational-days/close', [AdminController::class, 'closeOperationalDay'])->name('operational-days.close');
    });

    // Dapur Routes
    Route::middleware(['role:dapur'])->prefix('/dapur')->name('dapur.')->group(function () {
        Route::get('/', [DapurController::class, 'index'])->name('index');
        Route::post('/mulai-masak/{id}', [DapurController::class, 'mulaiMasak'])->name('mulaiMasak');
        Route::post('/tandai-selesai/{id}', [DapurController::class, 'tandaiSelesai'])->name('tandaiSelesai');
    });

    // Pelayan Routes
    Route::middleware(['role:pelayan'])->prefix('/pelayan')->name('pelayan.')->group(function () {
        Route::get('/', [PelayanController::class, 'index'])->name('index');
        Route::post('/sudah-diantar/{id}', [PelayanController::class, 'sudahDiantar'])->name('sudahDiantar');
    });

    // Kasir Routes
    Route::middleware(['role:kasir'])->prefix('/kasir')->name('kasir.')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('index');
        Route::get('/pesanan/{id}', [KasirController::class, 'showPesanan'])->name('showPesanan');
        Route::post('/proses-pembayaran/{id}', [KasirController::class, 'prosesPembayaran'])->name('prosesPembayaran');
    });
});

