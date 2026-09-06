@extends('layouts.print')

@section('title', 'Struk Thermal #' . $penjualan->id_pembelian)

@section('content')
<div class="thermal-receipt border p-2">
    <div class="text-center">
        <h6 class="font-weight-bold mb-0">{{ $pengaturan->nama_perusahaan ?? 'Joona Inventory' }}</h6>
        <div class="small">{{ $penjualan->cabang->nama_cabang ?? '' }}</div>
        <div class="small text-muted">{{ $penjualan->cabang->alamat ?? '' }}</div>
        <div class="small">{{ $penjualan->tanggal }}</div>
        <div>--------------------------------</div>
    </div>

    <div class="small mb-1">
        <div>No: {{ $penjualan->id_pembelian }}</div>
        @if($penjualan->customer)
        <div>Cust: {{ $penjualan->customer->nama_user }}</div>
        @endif
        <div>--------------------------------</div>
    </div>

    <table class="table-condensed w-100 small">
        <tbody>
            @foreach($penjualan->items as $item)
            <tr>
                <td colspan="2">{{ $item->nama }}</td>
            </tr>
            <tr>
                <td>{{ $item->jumlah }} x {{ rupiah($item->harga) }}</td>
                <td class="text-right">{{ rupiah($item->harga_total) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="small">
        <div>--------------------------------</div>
        <div class="d-flex justify-content-between font-weight-bold">
            <span>TOTAL:</span>
            <span>Rp {{ rupiah($penjualan->total_pembayaran) }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>BAYAR ({{ strtoupper($penjualan->metode_bayar) }}):</span>
            <span>Rp {{ rupiah($penjualan->uang) }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>KEMBALIAN:</span>
            <span>Rp {{ rupiah($penjualan->kembalian) }}</span>
        </div>
        <div>--------------------------------</div>
        <div class="text-center mt-2">
            Terima Kasih Atas Kunjungan Anda!
        </div>
    </div>
</div>
@endsection
