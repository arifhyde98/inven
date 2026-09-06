@extends('layouts.app')

@section('title', 'Dokumentasi - Pemesanan Barang')

@section('content')
<div class="section-header">
    <h1>Alur & Panduan Pemesanan Barang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('dokumentasi.show', 'index') }}">Dokumentasi</a></div>
        <div class="breadcrumb-item">Pemesanan</div>
    </div>
</div>

<div class="section-body">
    @include('dokumentasi.nav')

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <ul class="nav nav-tabs card-header-tabs" id="orderTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold" id="diff-tab" data-toggle="tab" href="#diff" role="tab">1. Konsep Pemesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" id="newitem-tab" data-toggle="tab" href="#newitem" role="tab">2. Pesan Barang Baru</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" id="stockitem-tab" data-toggle="tab" href="#stockitem" role="tab">3. Pesan Stok Eksisting</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" id="receiving-tab" data-toggle="tab" href="#receiving" role="tab">4. Penerimaan & Stok Masuk</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="orderTabContent">
                <div class="tab-pane fade show active" id="diff" role="tabpanel">
                    <div class="alert alert-light border">
                        <h5 class="text-primary font-weight-bold"><i class="fas fa-info-circle mr-2"></i>Perbedaan Pesan Barang vs Pesan Stok</h5>
                        <p class="mb-2"><strong>Pesan Barang Baru:</strong> Digunakan untuk mengajukan pembelian barang jenis baru yang belum pernah terdaftar di master data barang cabang Anda.</p>
                        <p class="mb-0"><strong>Pesan Stok Barang:</strong> Digunakan untuk mengisi kembali (restock) stok barang yang sudah ada di inventori cabang dengan harga beli yang sudah ditetapkan.</p>
                    </div>
                </div>

                <div class="tab-pane fade" id="newitem" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold">Langkah Pemesanan Barang Baru:</h6>
                            <ol class="pl-3">
                                <li>Buka menu <strong>Pemesanan Barang</strong> lalu klik <em>Tambah Pesanan</em>.</li>
                                <li>Pilih tipe <em>Pesanan Barang Baru (Manual)</em>.</li>
                                <li>Masukkan Nama Barang, Kategori, Satuan beli, Harga beli satuan, dan Jumlah pesan.</li>
                                <li>Klik <strong>Simpan ke Draft</strong>. Anda dapat menambahkan beberapa barang dalam satu surat pesanan.</li>
                                <li>Lengkapi Nama Pesanan, Supplier, dan Cabang Tujuan, kemudian klik <strong>Checkout / Ajukan Pesanan</strong>.</li>
                            </ol>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('assets/dok/datapesanan.png') }}" class="img-fluid rounded border shadow-sm" alt="Data Pesanan">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="stockitem" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold">Langkah Pesan Stok Barang:</h6>
                            <ol class="pl-3">
                                <li>Buka menu <strong>Pesan Stok Barang</strong>.</li>
                                <li>Pilih barang yang stoknya menipis dari katalog barang yang tersedia.</li>
                                <li>Masukkan jumlah unit yang akan dipesan kembali ke suplier.</li>
                                <li>Konfirmasi pengajuan purchase order (PO). Biaya total akan otomatis dihitung berdasarkan harga beli terdaftar.</li>
                            </ol>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('assets/dok/stokbarang.png') }}" class="img-fluid rounded border shadow-sm" alt="Stok Barang">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="receiving" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold">Penerimaan & Masuk ke Gudang:</h6>
                            <ol class="pl-3">
                                <li>Saat kurir/suplier mengantarkan barang, buka menu <strong>Penerimaan Barang</strong>.</li>
                                <li>Cari nomor PO / Kode Pesanan yang sesuai.</li>
                                <li>Periksa kuantitas fisik yang diterima dan masukkan jumlah fisik ke form <em>Stok Diterima</em>.</li>
                                <li>Klik <strong>Terima Pesanan</strong>. Sistem secara otomatis:
                                    <ul class="pl-3 mt-1">
                                        <li>Menambah stok aktif barang di cabang penerima.</li>
                                        <li>Mencatat log riwayat barang masuk (Stok In).</li>
                                        <li>Membukukan riwayat pengeluaran operasional.</li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('assets/dok/terimastok.png') }}" class="img-fluid rounded border shadow-sm" alt="Terima Stok">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
