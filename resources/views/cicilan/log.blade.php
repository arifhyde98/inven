@extends('layouts.app')

@section('title', 'Log Pembayaran Cicilan')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('cicilan.index') }}">Data Cicilan</a></div>
<div class="breadcrumb-item active">Log Pembayaran</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Semua Log Transaksi Pembayaran Cicilan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID Cicilan</th>
                        <th>Pelanggan</th>
                        <th>Cabang</th>
                        <th>Waktu Bayar</th>
                        <th>Jumlah Bayar</th>
                        <th>Sisa Akhir</th>
                        <th>Kembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $index => $l)
                    <tr>
                        <td>{{ $logs->firstItem() + $index }}</td>
                        <td><code>{{ $l->id_cicilan }}</code></td>
                        <td><strong>{{ $l->customer->nama_user ?? ($l->penjualan->customer->nama_user ?? $l->id_user) }}</strong></td>
                        <td>{{ $l->cabang->nama_cabang ?? 'Cabang ' . $l->id_cabang }}</td>
                        <td>{{ $l->tanggal }}</td>
                        <td class="font-weight-bold text-success">Rp {{ rupiah($l->uang) }}</td>
                        <td class="font-weight-bold text-danger">Rp {{ rupiah($l->sisa_cicilan_akhir) }}</td>
                        <td>Rp {{ rupiah($l->kembalian) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat pembayaran cicilan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
