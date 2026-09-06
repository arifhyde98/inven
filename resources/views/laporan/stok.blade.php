@extends('layouts.app')

@section('title', 'Laporan Stok Barang')

@section('content')
<div class="section-header">
    <h1>Laporan Stok Barang</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Laporan</a></div>
        <div class="breadcrumb-item">Stok Barang</div>
    </div>
</div>

<div class="section-body">
    <!-- Filter Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.stok') }}" class="form-row align-items-end">
                @if($user->isSuperAdmin())
                <div class="col-md-5 mb-3">
                    <label class="font-weight-bold">Filter Cabang</label>
                    <select name="cabang_id" class="form-control selectric">
                        <option value="">Semua Cabang</option>
                        @foreach($cabangs as $cab)
                            <option value="{{ $cab->id }}" {{ (string)$cabangId === (string)$cab->id ? 'selected' : '' }}>
                                {{ $cab->nama_cabang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-7 mb-3 d-flex">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('laporan.stok') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                    <a href="{{ route('export.stok', ['cabang_id' => $cabangId]) }}" target="_blank" class="btn btn-success mr-2">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('cetak.barcode_sheet', ['cabang_id' => $cabangId]) }}" target="_blank" class="btn btn-warning mr-2">
                        <i class="fas fa-barcode"></i> Cetak Barcode Sheet
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Widgets -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Item Barang</h4>
                    </div>
                    <div class="card-body">
                        {{ $barangs->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Unit Stok</h4>
                    </div>
                    <div class="card-body">
                        {{ number_format($totalStok) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Nilai Aset Modal</h4>
                    </div>
                    <div class="card-body">
                        {{ rupiah($totalAsetBeli) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Estimasi Nilai Jual</h4>
                    </div>
                    <div class="card-body">
                        {{ rupiah($totalAsetJual) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="text-dark mb-0"><i class="fas fa-warehouse text-primary mr-2"></i>Rincian Stok Barang</h4>
            <span class="badge badge-primary">{{ $barangs->count() }} Produk Terdaftar</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="table-1">
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>Kode Barcode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Cabang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Sisa Stok</th>
                            <th>Status Stok</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $index => $b)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><code>{{ $b->kode_barang }}</code></td>
                            <td>
                                <strong>{{ $b->nama_barang }}</strong>
                                @if($b->exp_date && $b->exp_date != '0')
                                    <br><small class="text-muted"><i class="fas fa-calendar-times text-danger"></i> Exp: {{ $b->exp_date }}</small>
                                @endif
                            </td>
                            <td>{{ $b->kategoriRelasi ? $b->kategoriRelasi->kategori : ($b->kategori ?? '-') }}</td>
                            <td><span class="badge badge-light">{{ $b->cabang ? $b->cabang->nama_cabang : 'Utama' }}</span></td>
                            <td>{{ rupiah($b->harga_beli) }}</td>
                            <td class="text-success font-weight-bold">{{ rupiah($b->harga_jual) }}</td>
                            <td>
                                <span class="badge {{ $b->stok <= 5 ? 'badge-danger' : 'badge-success' }} font-weight-bold" style="font-size: 0.95rem;">
                                    {{ $b->stok }} {{ $b->satuan }}
                                </span>
                            </td>
                            <td>
                                @if($b->stok <= 0)
                                    <span class="badge badge-danger">Habis</span>
                                @elseif($b->stok <= 5)
                                    <span class="badge badge-warning">Menipis</span>
                                @else
                                    <span class="badge badge-success">Aman</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('barang.log_in_out') }}" class="btn btn-sm btn-info" title="Log Masuk / Keluar">
                                    <i class="fas fa-history"></i>
                                </a>
                                <a href="{{ route('barang.barcode') }}" target="_blank" class="btn btn-sm btn-dark" title="Cetak Barcode">
                                    <i class="fas fa-barcode"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">Tidak ada data stok barang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
