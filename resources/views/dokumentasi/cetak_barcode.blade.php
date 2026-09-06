@extends('layouts.app')

@section('title', 'Dokumentasi - Cetak Barcode')

@section('content')
<div class="section-header">
    <h1>Panduan Pencetakan Barcode Produk</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('dokumentasi.show', 'index') }}">Dokumentasi</a></div>
        <div class="breadcrumb-item">Cetak Barcode</div>
    </div>
</div>

<div class="section-body">
    @include('dokumentasi.nav')

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h4 class="text-primary"><i class="fas fa-barcode mr-2"></i>Pembuatan & Pencetakan Label Barcode Produk</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-12 mb-4">
                    <h5 class="font-weight-bold">Format Standar Barcode:</h5>
                    <p class="text-muted">
                        Aplikasi mendukung standar barcode universal internasional seperti <strong>Code128</strong> dan <strong>EAN-13</strong>. Setiap produk dianjurkan memiliki kode unik 12 hingga 13 digit numerik atau alfanumerik.
                    </p>
                    
                    <h6 class="font-weight-bold mt-4">Cara Mencetak Barcode Satuan:</h6>
                    <ol class="pl-3">
                        <li>Buka menu <strong>Data Barang</strong>.</li>
                        <li>Pilih produk yang diinginkan lalu klik tombol ikon barcode <i class="fas fa-barcode text-dark"></i>.</li>
                        <li>Dialog cetak barcode per-item akan terbuka. Masukkan jumlah label yang ingin dicetak lalu tekan <kbd>Print</kbd>.</li>
                    </ol>

                    <h6 class="font-weight-bold mt-4">Cara Mencetak Lembar Massal (Sheet):</h6>
                    <ol class="pl-3">
                        <li>Buka menu <strong>Laporan Stok</strong> atau <strong>Data Barang</strong>.</li>
                        <li>Klik tombol <strong>Cetak Barcode Sheet</strong>.</li>
                        <li>Sistem otomatis menyusun kisi barcode (grid 3 kolom) siap cetak di kertas stiker label HVS.</li>
                    </ol>
                </div>
                <div class="col-lg-6 col-12 text-center">
                    <img src="{{ asset('assets/dok/barcode.png') }}" class="img-fluid rounded border shadow-sm mb-3" alt="Cetak Barcode">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
