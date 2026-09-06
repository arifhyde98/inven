@extends('layouts.print')

@section('title', 'Struk Cicilan #' . $penjualan->id_pembayaran_cicilan)

@section('content')
<div class="card border p-4 mx-auto" style="max-width: 650px;">
    <div class="text-center mb-4">
        <h3 class="font-weight-bold mb-1">{{ $pengaturan->nama_perusahaan ?? 'Joona Inventory' }}</h3>
        <p class="mb-1 text-muted">{{ $penjualan->cabang->nama_cabang ?? '' }} - {{ $penjualan->cabang->alamat ?? '' }}</p>
        <hr>
        <h5 class="font-weight-bold text-uppercase">BUKTI PEMBAYARAN CICILAN / PIUTANG</h5>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <span class="text-muted small">ID Cicilan:</span><br>
            <strong>{{ $penjualan->id_pembayaran_cicilan }}</strong><br>
            <span class="text-muted small">No. Transaksi Asal:</span><br>
            <span>{{ $penjualan->id_pembelian }}</span>
        </div>
        <div class="col-6 text-right">
            <span class="text-muted small">Pelanggan:</span><br>
            <strong>{{ $penjualan->customer->nama_user ?? $penjualan->id_user }}</strong><br>
            <span class="text-muted small">Total Pembelian:</span><br>
            <strong>Rp {{ rupiah($penjualan->total_pembayaran) }}</strong>
        </div>
    </div>

    <h6 class="font-weight-bold">Histori Angsuran:</h6>
    <table class="table table-bordered table-sm mb-4">
        <thead class="bg-light">
            <tr>
                <th>No</th>
                <th>Tanggal Pembayaran</th>
                <th class="text-right">Sisa Sebelum</th>
                <th class="text-right">Jumlah Dibayar</th>
                <th class="text-right">Sisa Hutang Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $idx => $p)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $p->tanggal }}</td>
                <td class="text-right">Rp {{ rupiah($p->sisa_cicilan) }}</td>
                <td class="text-right font-weight-bold text-success">Rp {{ rupiah($p->uang) }}</td>
                <td class="text-right font-weight-bold">Rp {{ rupiah($p->sisa_cicilan_akhir) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center text-muted small mt-3">
        <p class="mb-0">Simpan bukti pembayaran ini sebagai bukti pelunasan yang sah.</p>
        <p class="mb-0">{{ $pengaturan->footer ?? '' }}</p>
    </div>
</div>
@endsection
