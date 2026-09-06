@extends('layouts.print')

@section('title', 'Laporan Pengeluaran')

@section('content')
<div class="container my-4">
    <div class="card border p-4 shadow-none">
        <div class="text-center mb-4 border-bottom pb-3">
            <h4 class="text-uppercase font-weight-bold mb-1">Laporan Riwayat Pengeluaran</h4>
            <h5 class="text-uppercase text-primary mb-1">{{ $cabang ? $cabang->nama_cabang : 'Semua Cabang' }}</h5>
            <p class="mb-0 text-muted">{{ $pengaturan->nama_perusahaan ?? 'Joona InventoryX' }} | {{ $cabang ? $cabang->alamat : $pengaturan->alamat_perusahaan }}</p>
        </div>

        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th width="40" class="text-center">No</th>
                    <th>Kode Pesanan / Referensi</th>
                    <th>Tanggal</th>
                    <th>Cabang</th>
                    <th class="text-right">Total Biaya / Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPengeluaran = 0; @endphp
                @foreach($pengeluarans as $idx => $p)
                @php $totalPengeluaran += $p->total_pengeluaran; @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>{{ $p->kode_pesanan }}</td>
                    <td>{{ $p->tanggal_ind }}</td>
                    <td>{{ $p->cabang ? $p->cabang->nama_cabang : 'Pusat' }}</td>
                    <td class="text-right font-weight-bold text-danger">{{ rupiah($p->total_pengeluaran) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-light">
                    <td colspan="4" class="text-right">TOTAL PENGELUARAN</td>
                    <td class="text-right text-danger">{{ rupiah($totalPengeluaran) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5 pt-4">
            <div class="col-6"></div>
            <div class="col-6 text-right pr-5">
                <p class="mb-5">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}<br>Bagian Keuangan,</p>
                <p class="font-weight-bold mb-0">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
            </div>
        </div>
    </div>
</div>
@endsection
