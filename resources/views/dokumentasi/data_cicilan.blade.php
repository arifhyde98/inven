@extends('layouts.app')

@section('title', 'Dokumentasi - Data Cicilan & Piutang')

@section('content')
<div class="section-header">
    <h1>Panduan Manajemen Cicilan & Piutang Pelanggan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('dokumentasi.show', 'index') }}">Dokumentasi</a></div>
        <div class="breadcrumb-item">Data Cicilan</div>
    </div>
</div>

<div class="section-body">
    @include('dokumentasi.nav')

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h4 class="text-primary"><i class="fas fa-hand-holding-usd mr-2"></i>Pencatatan & Pelunasan Cicilan Pelanggan</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-12 mb-4">
                    <h5 class="font-weight-bold">Alur Pembayaran Angsuran:</h5>
                    <ol class="pl-3">
                        <li class="mb-2">Saat pelanggan datang untuk membayar angsuran atau pelunasan, buka menu <strong>Data Cicilan</strong>.</li>
                        <li class="mb-2">Gunakan kotak pencarian untuk mencari berdasarkan <strong>Kode Cicilan</strong> atau <strong>Nama Pelanggan</strong>.</li>
                        <li class="mb-2">Klik tombol <strong>Bayar Cicilan</strong> pada data yang bersangkutan.</li>
                        <li class="mb-2">Masukkan jumlah uang yang dibayarkan dan pilih metode pembayaran.</li>
                        <li class="mb-2">Sistem secara otomatis:
                            <ul class="pl-3 mt-1">
                                <li>Mengurangi sisa piutang pelanggan.</li>
                                <li>Mencatat history pembayaran lengkap dengan timestamp dan kasir penerima.</li>
                                <li>Memperbarui status menjadi <em>LUNAS</em> jika saldo piutang mencapai nol.</li>
                            </ul>
                        </li>
                        <li class="mb-2">Cetak <strong>Kuitansi / Struk Pembayaran Cicilan</strong> resmi untuk diserahkan ke pelanggan sebagai bukti sah.</li>
                    </ol>
                </div>
                <div class="col-lg-6 col-12 text-center">
                    <img src="{{ asset('assets/dok/bayarcicilan.png') }}" class="img-fluid rounded border shadow-sm mb-3" alt="Bayar Cicilan">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
