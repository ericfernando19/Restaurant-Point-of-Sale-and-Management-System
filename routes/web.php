<?php

use App\Http\Controllers\Kasir\PembayaranController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboard;
use App\Http\Controllers\Kasir\KasirTransaksiController;
use App\Http\Controllers\Koki\DashboardController as KokiDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===============================
//   DEFAULT HOME REDIRECT
// ===============================
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return match (Auth::user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'kasir' => redirect()->route('kasir.dashboard'),
        'koki' => redirect()->route('koki.dashboard'),
        default => abort(403, 'Role tidak dikenal.'),
    };
})->name('dashboard');



// ===============================
//   ADMIN ROUTES
// ===============================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::resource('menus', MenuController::class);

        Route::resource('karyawan', KaryawanController::class)
            ->except(['create', 'edit', 'show']);
        Route::get('laporan', [AdminDashboard::class, 'laporan'])->name('laporan');
        Route::get('laporan/cetak', [AdminDashboard::class, 'cetakLaporan'])->name('laporan.cetak');
    });



// ===============================
//   KASIR ROUTES
// ===============================
Route::middleware(['auth', 'role:kasir'])
    ->prefix('kasir')
    ->name('kasir.')
    ->group(function () {

        // Dashboard kasir
        Route::get('/dashboard', [KasirDashboard::class, 'dashboard'])->name('dashboard');

        // Transaksi Kasir
        Route::get('/transaksi', [KasirTransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi/simpan', [KasirTransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/riwayat', [KasirTransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
        Route::get('/transaksi/struk/{id}', [KasirTransaksiController::class, 'printPdf'])->name('transaksi.struk');
        Route::get(
            '/transaksi/struk-ajax/{id}',
            [KasirTransaksiController::class, 'strukAjax']
        )->name('transaksi.strukajax');


        // ===============================
        //   PEMBAYARAN (PREFIX BARU)
        // ===============================
        Route::prefix('pembayaran')
            ->name('pembayaran.')
            ->group(function () {

            Route::get('/', [PembayaranController::class, 'index'])->name('index');
            Route::get('/{id}', [PembayaranController::class, 'show'])->name('show');

            // AJAX process pembayaran
            Route::post('/process/{id}', [PembayaranController::class, 'process'])->name('process');

            // Cetak Struk
            Route::get('/struk/{id}', [PembayaranController::class, 'strukpdf'])->name('strukpdf');
        });
    });



// ===============================
//   KOKI ROUTES
// ===============================
Route::middleware(['auth', 'role:koki'])
    ->prefix('koki')
    ->name('koki.')
    ->group(function () {
        Route::get('/dashboard', [KokiDashboard::class, 'index'])->name('dashboard');

        // Pesanan masuk
        Route::get('/pesanan', [KokiDashboard::class, 'pesananMasuk'])->name('pesanan');

        // Detail
        Route::get('/pesanan/{id}', [KokiDashboard::class, 'detail'])->name('pesanan.detail');

        // Update status
        Route::post('/pesanan/{id}/status', [KokiDashboard::class, 'updateStatus'])->name('pesanan.status');

        // Riwayat selesai
        Route::get('/riwayat', [KokiDashboard::class, 'riwayat'])->name('riwayat');
    });



// ===============================
//   AUTH ROUTES
// ===============================
require __DIR__ . '/auth.php';
