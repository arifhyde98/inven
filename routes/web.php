<?php

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\CicilanController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\SuplierController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated & Active Routes
Route::middleware(['auth', 'active'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // POS / Cashier
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('index');
        Route::post('/scan', [PosController::class, 'scanBarcode'])->name('scan');
        Route::post('/cart', [PosController::class, 'addToCart'])->name('cart.add');
        Route::put('/cart/{id}', [PosController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/{id}', [PosController::class, 'deleteCart'])->name('cart.delete');
        Route::delete('/cart-clear', [PosController::class, 'clearCart'])->name('cart.clear');
        Route::get('/cart-table', [PosController::class, 'getCartTable'])->name('cart.table');
        Route::post('/checkout', [PosController::class, 'checkout'])->name('checkout');
        Route::get('/struk/{idPembelian}', [PosController::class, 'struk'])->name('struk');
        Route::get('/struk-thermal/{idPembelian}', [PosController::class, 'strukThermal'])->name('struk.thermal');
    });

    // Master Barang & Stok
    Route::get('/barang/barcode', [BarangController::class, 'barcode'])->name('barang.barcode');
    Route::get('/barang/log-in-out', [BarangController::class, 'logInOut'])->name('barang.log_in_out');
    Route::resource('barang', BarangController::class);

    // Purchase Orders (PO) / Restock
    Route::post('/pesanan/{kode}/receive', [PesananController::class, 'receive'])->name('pesanan.receive');
    Route::resource('pesanan', PesananController::class)->parameters(['pesanan' => 'kode']);

    // Stock Opname
    Route::get('/stok-opname/{kode}/process', [StokOpnameController::class, 'showProcess'])->name('stok-opname.process');
    Route::post('/stok-opname/{kode}/process', [StokOpnameController::class, 'process'])->name('stok-opname.process.post');
    Route::resource('stok-opname', StokOpnameController::class)->parameters(['stok-opname' => 'kode']);

    // Cicilan / Piutang
    Route::get('/cicilan/log', [CicilanController::class, 'log'])->name('cicilan.log');
    Route::get('/cicilan/{idCicilan}/struk', [CicilanController::class, 'struk'])->name('cicilan.struk');
    Route::post('/cicilan/{idCicilan}/pay', [CicilanController::class, 'pay'])->name('cicilan.pay');
    Route::resource('cicilan', CicilanController::class)->only(['index', 'show'])->parameters(['cicilan' => 'idCicilan']);

    // Pengeluaran Operasional
    Route::post('/pengeluaran/{id}/approve', [PengeluaranController::class, 'approve'])->name('pengeluaran.approve');
    Route::post('/pengeluaran/{id}/reject', [PengeluaranController::class, 'reject'])->name('pengeluaran.reject');
    Route::resource('pengeluaran', PengeluaranController::class)->only(['index', 'store', 'destroy']);

    // Pelanggan Langganan
    Route::resource('customer', CustomerController::class);

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/penjualan-harian', [LaporanController::class, 'penjualanHarian'])->name('penjualan_harian');
        Route::get('/penjualan-bulanan', [LaporanController::class, 'penjualanBulanan'])->name('penjualan_bulanan');
        Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
    });

    // Export Excel
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/pesanan', [ExportController::class, 'pesanan'])->name('pesanan');
        Route::get('/penjualan', [ExportController::class, 'penjualan'])->name('penjualan');
        Route::get('/stok', [ExportController::class, 'stok'])->name('stok');
        Route::get('/pengeluaran', [ExportController::class, 'pengeluaran'])->name('pengeluaran');
    });

    // Cetak Print
    Route::prefix('cetak')->name('cetak.')->group(function () {
        Route::get('/bukti-pesanan/{kode}', [CetakController::class, 'buktiPesanan'])->name('bukti_pesanan');
        Route::get('/history-penjualan', [CetakController::class, 'historyPenjualan'])->name('history_penjualan');
        Route::get('/laporan-penjualan-hari', [CetakController::class, 'laporanPenjualanHari'])->name('laporan_penjualan_hari');
        Route::get('/laporan-pengeluaran', [CetakController::class, 'laporanPengeluaran'])->name('laporan_pengeluaran');
        Route::get('/barcode-sheet', [CetakController::class, 'barcodeSheet'])->name('barcode_sheet');
    });

    // Profile & Password
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Dokumentasi
    Route::get('/dokumentasi/{page?}', [DokumentasiController::class, 'show'])->name('dokumentasi');

    // Superadmin Only Routes
    Route::middleware('role:1')->group(function () {
        Route::resource('cabang', CabangController::class);
        Route::resource('suplier', SuplierController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('satuan', SatuanController::class);
        Route::post('/users/{user}/toggle-status', [AdminManagementController::class, 'toggleStatus'])->name('users.toggle_status');
        Route::resource('users', AdminManagementController::class);
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });
});
