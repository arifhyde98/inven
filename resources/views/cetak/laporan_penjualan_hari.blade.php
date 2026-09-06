@extends('layouts.print')

@section('title', 'Laporan Penjualan Harian - ' . $tanggal)

@section('content')
<div class="container my-4">
    <div class="card border p-4 shadow-none">
        <div class="text-center mb-4 border-bottom pb-3">
            <h4 class="text-uppercase font-weight-bold mb-1">Laporan Penjualan Harian</h4>
            <h5 class="text-uppercase text-primary mb-1">{{ $cabang ? $cabang->nama_cabang : 'Semua Cabang' }}</h5>
            <p class="mb-0 text-muted">Tanggal: <strong>{{ $tanggal }}</strong> | {{ $pengaturan->nama_perusahaan ?? 'Joona InventoryX' }}</p>
        </div>

        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th width="40" class="text-center">No</th>
                    <th>ID Penjualan</th>
                    <th>Jam</th>
                    <th>Kasir</th>
                    <th>Customer</th>
                    <th class="text-center">Jml Item</th>
                    <th class="text-right">Total Transaksi</th>
                    <th class="text-right">Laba/Profit</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPenjualan = 0; $totalProfit = 0; @endphp
                @foreach($penjualans as $idx => $p)
                @php 
                    $totalPenjualan += $p->total_pembayaran; 
                    $totalProfit += $p->pendapatan;
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>#{{ $p->id_pembelian }}</td>
                    <td>{{ $p->jam_ind }}</td>
                    <td>{{ $p->kasir ?? '-' }}</td>
                    <td>{{ $p->nama_pembeli ?? 'Umum' }}</td>
                    <td class="text-center">{{ $p->items ? $p->items->count() : 0 }}</td>
                    <td class="text-right font-weight-bold">{{ rupiah($p->total_pembayaran) }}</td>
                    <td class="text-right text-success">{{ rupiah($p->pendapatan) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-light">
                    <td colspan="6" class="text-right">TOTAL HARI INI</td>
                    <td class="text-right text-primary">{{ rupiah($totalPenjualan) }}</td>
                    <td class="text-right text-success">{{ rupiah($totalProfit) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5 pt-4">
            <div class="col-6"></div>
            <div class="col-6 text-right pr-5">
                <p class="mb-5">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}<br>Kasir / Penanggung Jawab,</p>
                <p class="font-weight-bold mb-0">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
            </div>
        </div>
    </div>
</div>
@endsection
