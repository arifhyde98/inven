@extends('layouts.app')

@section('title', 'Dokumentasi Sistem')

@section('content')
<div class="section-header">
    <h1>Dokumentasi & Panduan Aplikasi</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Dokumentasi</div>
    </div>
</div>

<div class="section-body">
    @include('dokumentasi.nav')

    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h4 class="text-primary"><i class="fas fa-rocket mr-2"></i>Panduan Instalasi & Deployment Laravel</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Aplikasi <strong>Joona InventoryX</strong> kini telah dimigrasikan dari arsitektur CodeIgniter 3 ke framework modern <strong>Laravel 12</strong> dengan PHP 8.2+.</p>
                    
                    <h6 class="font-weight-bold mt-3">Langkah Instalasi di Lingkungan Baru:</h6>
                    <ol class="pl-3">
                        <li class="mb-2">Clone / salin source code aplikasi ke direktori web server Anda.</li>
                        <li class="mb-2">Salin file konfigurasi: <code>cp .env.example .env</code></li>
                        <li class="mb-2">Sesuaikan koneksi database di <code>.env</code> (MySQL / SQLite).</li>
                        <li class="mb-2">Jalankan composer install: <code>composer install --no-dev --optimize-autoloader</code></li>
                        <li class="mb-2">Generate Application Key: <code>php artisan key:generate</code></li>
                        <li class="mb-2">Jalankan migrasi dan seeder awal: <code>php artisan migrate --seed</code></li>
                        <li class="mb-2">Buat symbolic link storage: <code>php artisan storage:link</code></li>
                        <li class="mb-2">Aplikasi siap dijalankan dengan Nginx/Apache atau <code>php artisan serve</code>.</li>
                    </ol>

                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-1"></i> Akun default Super Admin: Username <code>sadmin</code>, Password <code>asd</code>.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h4 class="text-warning"><i class="fas fa-exclamation-triangle mr-2"></i>Catatan Operasional Penting</h4>
                </div>
                <div class="card-body">
                    <ol class="pl-3">
                        <li class="mb-2">
                            <strong>Barcode Produk:</strong> Setiap data barang baru yang dipesan dan belum memiliki kode barcode harus diperbarui pada halaman <em>Data Barang</em> atau dicetak stiker barcodenya.
                        </li>
                        <li class="mb-2">
                            <strong>Konversi Satuan Grosir ke Eceran:</strong> Jika barang masuk berupa kardus/dus/box dan akan dijual eceran (misal per botol / pcs / renceng), tentukan satuan terkecil pada saat mendaftarkan barang untuk akurasi kalkulasi HPP dan margin profit per unit.
                        </li>
                        <li class="mb-2">
                            <strong>Stok Masuk vs Biaya Pengeluaran:</strong> Penambahan stok melalui fitur <em>Pesan Stok</em> dan <em>Pesan Barang</em> otomatis membukukan riwayat pengeluaran kas operasional. Jika stok ditambah manual melalui fitur koreksi tanpa pesanan, pengeluaran kas tidak tercatat.
                        </li>
                        <li class="mb-2">
                            <strong>Stok Opname:</strong> Lakukan stock opname secara berkala (mingguan/bulanan) untuk mencocokkan stok fisik di gudang/rak dengan saldo stok sistem.
                        </li>
                    </ol>

                    <div class="card bg-light border-0 mt-3">
                        <div class="card-body p-3">
                            <h6 class="font-weight-bold text-dark mb-2"><i class="fas fa-info-circle mr-1"></i>Teknologi & Fitur Baru</h6>
                            <ul class="mb-0 pl-3">
                                <li><strong>Full Atomic Transaction:</strong> Checkout kasir dan stok opname aman dari race condition.</li>
                                <li><strong>Excel Spreadsheet Export:</strong> Menggunakan library resmi PHPSpreadsheet.</li>
                                <li><strong>Modern Responsive UI:</strong> Didukung Stisla Framework dan Bootstrap 4.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
