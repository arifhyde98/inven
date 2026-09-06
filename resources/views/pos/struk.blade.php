@extends('layouts.print')

@section('title', 'Struk Penjualan #' . $penjualan->id_pembelian)

@section('content')
<div class="card border p-4 mx-auto" style="max-width: 650px;">
    <div class="text-center mb-4">
        <h3 class="font-weight-bold mb-1">{{ $pengaturan->nama_perusahaan ?? 'Joona Inventory' }}</h3>
        <p class="mb-1 text-muted">{{ $penjualan->cabang->nama_cabang ?? '' }} - {{ $penjualan->cabang->alamat ?? '' }}</p>
        <hr>
        <h5 class="font-weight-bold text-uppercase">STRUK PENJUALAN</h5>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <span class="text-muted small">No. Transaksi:</span><br>
            <strong>{{ $penjualan->id_pembelian }}</strong><br>
            <span class="text-muted small">Waktu:</span><br>
            <span>{{ $penjualan->tanggal }}</span>
        </div>
        <div class="col-6 text-right">
            <span class="text-muted small">Metode Pembayaran:</span><br>
            <span class="badge badge-{{ $penjualan->metode_bayar === 'tunai' ? 'success' : 'warning' }}">
                {{ strtoupper($penjualan->metode_bayar) }}
            </span><br>
            @if($penjualan->customer)
                <span class="text-muted small">Pelanggan:</span><br>
                <strong>{{ $penjualan->customer->nama_user }}</strong>
            @endif
        </div>
    </div>

    <table class="table table-bordered table-sm mb-4">
        <thead class="bg-light">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th class="text-right">Harga</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->items as $idx => $item)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td class="text-right">Rp {{ rupiah($item->harga) }}</td>
                <td class="text-center">{{ $item->jumlah }} {{ $item->satuan }}</td>
                <td class="text-right">Rp {{ rupiah($item->harga_total) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="font-weight-bold">
                <td colspan="4" class="text-right">TOTAL PEMBAYARAN:</td>
                <td class="text-right">Rp {{ rupiah($penjualan->total_pembayaran) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">UANG DITERIMA:</td>
                <td class="text-right">Rp {{ rupiah($penjualan->uang) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">KEMBALIAN:</td>
                <td class="text-right">Rp {{ rupiah($penjualan->kembalian) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="text-center text-muted small mt-3">
        <p class="mb-0">Terima kasih telah berbelanja di {{ $pengaturan->nama_perusahaan ?? 'toko kami' }}!</p>
        <p class="mb-0">{{ $pengaturan->footer ?? '' }}</p>
    </div>
</div>
@endsection
