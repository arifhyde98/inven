@extends('layouts.app')

@section('title', 'Laporan Penjualan Harian')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="#">Laporan</a></div>
<div class="breadcrumb-item active">Penjualan Harian</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Laporan Penjualan Per Hari</h4>
        <div class="card-header-action">
            <a href="{{ route('cetak.laporan_penjualan_hari', ['tanggal' => $tanggal, 'cabang_id' => $cabangId]) }}" target="_blank" class="btn btn-info">
                <i class="fas fa-print mr-1"></i> Cetak Laporan
            </a>
            <a href="{{ route('export.penjualan', ['cabang_id' => $cabangId]) }}" class="btn btn-success ml-1">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.penjualan_harian') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label>Pilih Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') ? date('Y-m-d', strtotime(request('tanggal'))) : date('Y-m-d') }}" onchange="this.form.submit()">
                </div>
                @if(auth()->user()->isSuperAdmin())
                <div class="col-md-4 mb-2">
                    <label>Pilih Cabang</label>
                    <select name="cabang_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Cabang --</option>
                        @foreach($cabangs as $cb)
                            <option value="{{ $cb->id }}" {{ $cabangId == $cb->id ? 'selected' : '' }}>{{ $cb->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </form>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <span class="text-muted">Total Omset Penjualan:</span>
                    <h3 class="text-primary font-weight-bold mb-0">Rp {{ rupiah($totalPenjualan) }}</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded">
                    <span class="text-muted">Total Keuntungan / Profit:</span>
                    <h3 class="text-success font-weight-bold mb-0">+Rp {{ rupiah($totalProfit) }}</h3>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-md">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Transaksi</th>
                        <th>Cabang</th>
                        <th>Waktu</th>
                        <th>Total Bayar</th>
                        <th>Metode</th>
                        <th>Keuntungan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><code>{{ $row->id_pembelian }}</code></td>
                        <td>{{ $row->cabang->nama_cabang ?? 'Cabang ' . $row->id_cabang }}</td>
                        <td>{{ $row->tanggal }}</td>
                        <td class="font-weight-bold">Rp {{ rupiah($row->total_pembayaran) }}</td>
                        <td>
                            <span class="badge badge-{{ $row->metode_bayar === 'tunai' ? 'success' : 'warning' }}">
                                {{ ucfirst($row->metode_bayar) }}
                            </span>
                        </td>
                        <td class="text-success font-weight-bold">+Rp {{ rupiah($row->pendapatan) }}</td>
                        <td>
                            <a href="{{ route('pos.struk', $row->id_pembelian) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-print mr-1"></i> Struk
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Tidak ada transaksi penjualan pada tanggal ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
