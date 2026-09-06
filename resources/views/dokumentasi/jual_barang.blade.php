@extends('layouts.app')

@section('title', 'Dokumentasi - Penjualan Kasir POS')

@section('content')
<div class="section-header">
    <h1>Panduan Kasir POS (Jual Barang)</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('dokumentasi.show', 'index') }}">Dokumentasi</a></div>
        <div class="breadcrumb-item">Kasir POS</div>
    </div>
</div>

<div class="section-body">
    @include('dokumentasi.nav')

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h4 class="text-primary"><i class="fas fa-cash-register mr-2"></i>Antarmuka Kasir Cepat & Barcode Scanning</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-12 mb-4">
                    <h5 class="font-weight-bold">1. Transaksi Tunai (Cash)</h5>
                    <ol class="pl-3">
                        <li class="mb-2">Arahkan scanner barcode ke label barang atau ketikkan kode barcode di input scanner lalu tekan <kbd>Enter</kbd>.</li>
                        <li class="mb-2">Anda juga dapat mengklik tombol <strong>Pilih Barang</strong> untuk mencari barang via pop-up katalog.</li>
                        <li class="mb-2">Ubah jumlah barang pada keranjang kasir jika pelanggan membeli lebih dari 1 item.</li>
                        <li class="mb-2">Pilih metode <strong>Tunai (Cash)</strong>. Masukkan nominal uang yang diterima dari pembeli di kolom <em>Uang Bayar</em>.</li>
                        <li class="mb-2">Sistem menghitung kembalian secara otomatis dan mencegah transaksi jika uang kurang.</li>
                        <li class="mb-2">Klik <strong>Bayar & Selesai Transaksi</strong>. Anda dapat mencetak struk thermal 58mm atau 80mm.</li>
                    </ol>
                    <div class="text-center mt-3">
                        <img src="{{ asset('assets/dok/jualbarang.png') }}" class="img-fluid rounded border shadow-sm" alt="Jual Barang Tunai">
                    </div>
                </div>

                <div class="col-lg-6 col-12 mb-4">
                    <h5 class="font-weight-bold">2. Transaksi Cicilan (Piutang)</h5>
                    <ol class="pl-3">
                        <li class="mb-2">Scan atau tambahkan produk belanjaan ke dalam keranjang.</li>
                        <li class="mb-2">Pada pilihan metode pembayaran, pilih <strong>Cicilan</strong>.</li>
                        <li class="mb-2">Pilih nama pelanggan terdaftar di dropdown <em>User Langganan / Penyicil</em> atau klik <strong>+ Tambah Customer</strong> jika pelanggan baru.</li>
                        <li class="mb-2">Tentukan jumlah DP (uang muka) jika ada, serta tanggal jatuh tempo pelunasan.</li>
                        <li class="mb-2">Klik <strong>Proses Cicilan</strong>. Transaksi akan tercatat di buku piutang dan struk cicilan resmi dapat dicetak.</li>
                    </ol>
                    <div class="text-center mt-3">
                        <img src="{{ asset('assets/dok/jualcicil.png') }}" class="img-fluid rounded border shadow-sm" alt="Jual Barang Cicilan">
                    </div>
                </div>
            </div>

            <div class="card bg-light border-0 mt-3">
                <div class="card-body">
                    <h6 class="font-weight-bold text-dark"><i class="fas fa-keyboard mr-1"></i>Dukungan Tombol Pintasan (Hotkeys):</h6>
                    <span class="badge badge-secondary p-2 mr-2"><kbd>F2</kbd> Fokus ke Scanner Barcode</span>
                    <span class="badge badge-secondary p-2 mr-2"><kbd>F4</kbd> Buka Katalog Barang</span>
                    <span class="badge badge-secondary p-2 mr-2"><kbd>F8</kbd> Fokus ke Input Uang Bayar</span>
                    <span class="badge badge-secondary p-2 mr-2"><kbd>F9</kbd> Tombol Bayar / Submit</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
