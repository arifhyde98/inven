@extends('layouts.print')

@section('title', 'Laporan Riwayat Penjualan')

@section('content')
<div class="container my-4">
    <div class="card border p-4 shadow-none">
        <div class="text-center mb-4 border-bottom pb-3">
            <h4 class="text-uppercase font-weight-bold mb-1">Laporan Riwayat Penjualan Barang</h4>
            <h5 class="text-uppercase text-primary mb-1">{{ $cabang ? $cabang->nama_cabang : 'Semua Cabang' }}</h5>
            <p class="mb-0 text-muted">{{ $pengaturan->nama_perusahaan ?? 'Joona InventoryX' }} | {{ $cabang ? $cabang->alamat : $pengaturan->alamat_perusahaan }}</p>
        </div>

        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th width="40" class="text-center">No</th>
                    <th>ID Penjualan</th>
                    <th>Tanggal & Jam</th>
                    <th>Cabang</th>
                    <th>Customer</th>
                    <th class="text-center">Total Item</th>
                    <th class="text-right">Total Pembayaran</th>
                    <th>Metode</th>
                </tr>
            </thead>
            <tbody>
                @php $totalSemua = 0; @endphp
                @foreach($penjualans as $idx => $p)
                @php $totalSemua += $p->total_pembayaran; @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>#{{ $p->id_pembelian }}</td>
                    <td>{{ $p->tanggal_ind }} {{ $p->jam_ind }}</td>
                    <td>{{ $p->cabang ? $p->cabang->nama_cabang : 'Utama' }}</td>
                    <td>{{ $p->nama_pembeli ?? 'Umum' }}</td>
                    <td class="text-center">{{ $p->items ? $p->items->count() : 0 }}</td>
                    <td class="text-right">{{ rupiah($p->total_pembayaran) }}</td>
                    <td>
                        {{ $p->metode_bayar ?? 'Tunai' }}
                        @if($p->status_pembayaran == 2)
                            <small class="text-warning font-weight-bold">({{ $p->status_utang == 0 ? 'Lunas' : 'Cicilan' }})</small>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-light">
                    <td colspan="6" class="text-right">TOTAL KESELURUHAN PENJUALAN</td>
                    <td class="text-right text-primary">{{ rupiah($totalSemua) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5 pt-4">
            <div class="col-6"></div>
            <div class="col-6 text-right pr-5">
                <p class="mb-5">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}<br>Penanggung Jawab,</p>
                <p class="font-weight-bold mb-0">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
            </div>
        </div>
    </div>
</div>
@endsection
