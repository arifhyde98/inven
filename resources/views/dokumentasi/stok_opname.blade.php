@extends('layouts.app')

@section('title', 'Dokumentasi - Stok Opname')

@section('content')
<div class="section-header">
    <h1>Panduan Stok Opname & Audit Inventori</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('dokumentasi.show', 'index') }}">Dokumentasi</a></div>
        <div class="breadcrumb-item">Stok Opname</div>
    </div>
</div>

<div class="section-body">
    @include('dokumentasi.nav')

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h4 class="text-primary"><i class="fas fa-boxes mr-2"></i>Audit Stok Fisik vs Data Sistem (Reconciliation)</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-12 mb-4">
                    <h5 class="font-weight-bold">Tujuan Stok Opname:</h5>
                    <p class="text-muted">
                        Stok opname bertujuan memvalidasi kebenaran fisik stok barang di rak atau gudang toko terhadap data saldo yang tersimpan di sistem. Melalui audit ini, kehilangan barang, kerusakan, atau salah catat dapat terdeteksi dini.
                    </p>

                    <h6 class="font-weight-bold mt-4">Tahapan Pelaksanaan:</h6>
                    <ol class="pl-3">
                        <li class="mb-2"><strong>Buat Jadwal Opname:</strong> Buka menu <em>Stok Opname</em> &rarr; <em>Buat Opname Baru</em>. Pilih tanggal dan cabang yang akan diaudit.</li>
                        <li class="mb-2"><strong>Perhitungan Fisik (Stock Count):</strong> Petugas gudang menghitung unit riil di rak penyimpanan.</li>
                        <li class="mb-2"><strong>Input Stok Fisik:</strong> Klik tombol <em>Proses Audit</em> pada opname yang aktif. Masukkan angka stok fisik di kolom yang tersedia.</li>
                        <li class="mb-2"><strong>Analisis Selisih:</strong> Sistem secara instan menghitung deviasi (Surplus / Minus). Berikan keterangan jika terdapat barang rusak atau kadaluarsa.</li>
                        <li class="mb-2"><strong>Finalisasi & Rekonsiliasi:</strong> Klik <em>Selesaikan & Sesuaikan Stok</em>. Saldo barang akan langsung diperbarui ke stok fisik riil, dan selisih tercatat di log audit.</li>
                    </ol>
                </div>
                <div class="col-lg-6 col-12 text-center">
                    <img src="{{ asset('assets/dok/prosesstokopname.png') }}" class="img-fluid rounded border shadow-sm mb-3" alt="Proses Stok Opname">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
