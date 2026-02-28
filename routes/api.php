<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\KategoriMenuController;
use App\Http\Controllers\API\MejaController;
use App\Http\Controllers\API\KaryawanController;
use App\Http\Controllers\API\PesananController;
use App\Http\Controllers\API\DetailPesananController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\StokMenuHarianController;
use App\Http\Controllers\API\OperationalDayController;

// Route Login
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route Admin Dashboard
        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/statistik', [AdminController::class, 'getStatistik'])->name('statistik');
        Route::get('/menu', [AdminController::class, 'getMenu'])->name('menu');
        Route::get('/kategori', [AdminController::class, 'getKategori'])->name('kategori');
        Route::get('/meja', [AdminController::class, 'getMeja'])->name('meja');
        Route::get('/karyawan', [AdminController::class, 'getKaryawan'])->name('karyawan');
        
        // Operational Days CRUD
        Route::get('/operational-days', [OperationalDayController::class, 'index'])->name('operational-days.index');
        Route::post('/operational-days', [OperationalDayController::class, 'store'])->name('operational-days.store');
        Route::get('/operational-days/{id}', [OperationalDayController::class, 'show'])->name('operational-days.show');
        Route::put('/operational-days/{id}', [OperationalDayController::class, 'update'])->name('operational-days.update');
        Route::delete('/operational-days/{id}', [OperationalDayController::class, 'destroy'])->name('operational-days.destroy');
    });

    // Route Role-Based (Dapur, Pelayan, Kasir)
    Route::prefix('dapur')->name('dapur.')->group(function () {
        Route::get('/pesanan', [RoleController::class, 'getDapurPesanan'])->name('pesanan');
    });

    Route::prefix('pelayan')->name('pelayan.')->group(function () {
        Route::get('/pesanan', [RoleController::class, 'getPelayanPesanan'])->name('pesanan');
    });

    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/pesanan', [RoleController::class, 'getKasirPesanan'])->name('pesanan');
        Route::get('/riwayat', [RoleController::class, 'getKasirRiwayat'])->name('riwayat');
    });

    // Route CRUD Menu
    Route::apiResource('menus', MenuController::class);
    Route::get('/menu', [MenuController::class, 'index']); // Alias for menus (singular)

    // Route CRUD Kategori Menu
    Route::apiResource('kategori-menu', KategoriMenuController::class);

    // Route CRUD Meja
    Route::apiResource('meja', MejaController::class);

    // Route CRUD Karyawan
    Route::apiResource('karyawan', KaryawanController::class);

    // Route CRUD Pesanan
    Route::apiResource('pesanan', PesananController::class);

    // Route CRUD Detail Pesanan
    Route::apiResource('detail-pesanan', DetailPesananController::class);

    // Route CRUD Payment
    Route::apiResource('payment', PaymentController::class);

    // Route CRUD Stok Menu Harian
    Route::apiResource('stok-menu-harian', StokMenuHarianController::class);

    // Route CRUD Operational Days
    Route::apiResource('operational-days', OperationalDayController::class);
});
