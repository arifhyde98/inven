@extends('layouts.app')

@section('title', 'Log Stok Barang (In / Out)')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('barang.index') }}">Master Barang</a></div>
<div class="breadcrumb-item active">Log Stok In / Out</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Riwayat Keluar Masuk Stok Barang</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Waktu</th>
                        <th>Barang</th>
                        <th>Cabang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $index => $log)
                    <tr>
                        <td>{{ $logs->firstItem() + $index }}</td>
                        <td>{{ $log->tanggal ?: date('d-m-Y H:i', $log->tgl) }}</td>
                        <td><strong>{{ $log->barang->nama_barang ?? '-' }}</strong></td>
                        <td>{{ $log->barang->cabang->nama_cabang ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $log->status == 1 ? 'success' : 'danger' }}">
                                <i class="fas fa-arrow-{{ $log->status == 1 ? 'down' : 'up' }} mr-1"></i>
                                {{ $log->status == 1 ? 'Stok Masuk' : 'Stok Keluar' }}
                            </span>
                        </td>
                        <td class="font-weight-bold">{{ $log->jumlah }} {{ $log->barang->satuan ?? 'pcs' }}</td>
                        <td>{{ $log->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat pergerakan stok.</td>
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
