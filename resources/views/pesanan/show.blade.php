@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $pesanan->kode)

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('pesanan.index') }}">Pesanan Barang</a></div>
<div class="breadcrumb-item active">Detail</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Informasi Pesanan: {{ $pesanan->nama }} (<code>{{ $pesanan->kode }}</code>)</h4>
        <div class="card-header-action">
            <a href="{{ route('cetak.bukti_pesanan', $pesanan->kode) }}" target="_blank" class="btn btn-info mr-1">
                <i class="fas fa-print mr-1"></i> Cetak Bukti PO
            </a>
            @if($pesanan->status == 0)
            <form action="{{ route('pesanan.receive', $pesanan->kode) }}" method="POST" onsubmit="return confirm('Konfirmasi terima barang? Stok akan ditambahkan ke inventaris.')" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success"><i class="fas fa-download mr-1"></i> Terima Barang Sekarang</button>
            </form>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <span class="text-muted small">Cabang Tujuan:</span><br>
                <strong>{{ $pesanan->cabang->nama_cabang ?? 'Cabang ' . $pesanan->tempat }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted small">Supplier:</span><br>
                <strong>{{ $pesanan->suplierRelasi->nama_suplier ?? ($pesanan->suplier ?: '-') }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted small">Tanggal Pesan:</span><br>
                <strong>{{ $pesanan->tanggal_pesan }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted small">Status:</span><br>
                @if($pesanan->status == 1)
                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima pada {{ $pesanan->tanggal_terima }}</span>
                @else
                    <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu Penerimaan</span>
                @endif
            </div>
        </div>

        <h5 class="mb-3">Rincian Barang yang Dipesan</h5>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead class="bg-light">
                    <tr>
                        <th width="40">#</th>
                        <th>Nama Barang</th>
                        <th class="text-right">Harga Beli</th>
                        <th class="text-center">Jumlah Pesan</th>
                        <th class="text-center">Jumlah Diterima</th>
                        <th class="text-right">Total Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pesanan->jenis_pesanan == 1)
                        @foreach($pesanan->items as $idx => $item)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td><strong>{{ $item->nama }}</strong></td>
                            <td class="text-right">Rp {{ rupiah($item->harga_beli) }}</td>
                            <td class="text-center">{{ $item->stok_pesan }}</td>
                            <td class="text-center font-weight-bold {{ $item->status == 1 ? 'text-success' : 'text-muted' }}">
                                {{ $item->stok_terima }}
                            </td>
                            <td class="text-right font-weight-bold">Rp {{ rupiah($item->total_beli) }}</td>
                        </tr>
                        @endforeach
                    @else
                        @foreach($pesanan->itemsManual as $idx => $item)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td><strong>{{ $item->nama_barang }}</strong> ({{ $item->kategori }})</td>
                            <td class="text-right">Rp {{ rupiah($item->harga_beli) }}</td>
                            <td class="text-center">{{ $item->jumlah }} {{ $item->satuan }}</td>
                            <td class="text-center font-weight-bold text-muted">-</td>
                            <td class="text-right font-weight-bold">Rp {{ rupiah($item->harga_total) }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
