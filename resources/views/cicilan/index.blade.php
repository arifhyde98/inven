@extends('layouts.app')

@section('title', 'Data Cicilan / Piutang Pelanggan')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Data Cicilan</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Monitoring Piutang & Cicilan Penjualan</h4>
        <div class="card-header-action">
            <a href="{{ route('cicilan.log') }}" class="btn btn-outline-primary"><i class="fas fa-history mr-1"></i> Log Pembayaran Cicilan</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID Cicilan</th>
                        <th>No. Penjualan</th>
                        <th>Pelanggan</th>
                        <th>Cabang</th>
                        <th>Total Transaksi</th>
                        <th>Status Piutang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cicilans as $index => $c)
                    @php
                        $lastPayment = $c->cicilans->sortByDesc('id')->first();
                        $sisa = $lastPayment ? $lastPayment->sisa_cicilan_akhir : $c->total_pembayaran;
                    @endphp
                    <tr>
                        <td>{{ $cicilans->firstItem() + $index }}</td>
                        <td><code>{{ $c->id_pembayaran_cicilan }}</code></td>
                        <td><small>{{ $c->id_pembelian }}</small></td>
                        <td><strong>{{ $c->customer->nama_user ?? $c->id_user }}</strong></td>
                        <td>{{ $c->cabang->nama_cabang ?? 'Cabang ' . $c->id_cabang }}</td>
                        <td>Rp {{ rupiah($c->total_pembayaran) }}</td>
                        <td>
                            @if($c->status_utang == 0 || $sisa == 0)
                                <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> LUNAS</span>
                            @else
                                <span class="badge badge-warning">
                                    <i class="fas fa-exclamation-circle mr-1"></i> Sisa: Rp {{ rupiah($sisa) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('cicilan.show', $c->id_pembayaran_cicilan) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-money-bill-wave mr-1"></i> {{ $sisa > 0 ? 'Bayar / Detail' : 'Detail Riwayat' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada transaksi cicilan/piutang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $cicilans->links() }}
        </div>
    </div>
</div>
@endsection
