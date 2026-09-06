@extends('layouts.print')

@section('title', 'Cetak Lembar Barcode')

@push('styles')
<style>
    .barcode-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
    .barcode-card {
        border: 1px dashed #bbb;
        padding: 12px;
        text-align: center;
        page-break-inside: avoid;
        background: #fff;
    }
    .barcode-card h6 {
        font-size: 11px;
        margin-top: 6px;
        margin-bottom: 2px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .barcode-card .price {
        font-size: 12px;
        font-weight: bold;
        color: #111;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row no-print mb-3">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Gunakan opsi <strong>Layout Portrait</strong> dan margin minimum pada dialog browser print untuk hasil terbaik pada kertas stiker / HVS.
            </div>
        </div>
    </div>

    <div class="barcode-grid">
        @foreach($barangs as $barang)
            @for($i = 0; $i < $jumlahPerItem; $i++)
            <div class="barcode-card">
                <img alt="Barcode {{ $barang->kode_barang }}" src="https://barcode.tec-it.com/barcode.ashx?data={{ $barang->kode_barang }}&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0" style="max-height: 48px; max-width: 100%;">
                <h6>{{ $barang->nama_barang }}</h6>
                <div class="price">{{ rupiah($barang->harga_jual) }}</div>
            </div>
            @endfor
        @endforeach
    </div>
</div>
@endsection
