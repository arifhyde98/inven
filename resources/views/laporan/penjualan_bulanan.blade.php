@extends('layouts.app')

@section('title', 'Laporan Penjualan Bulanan')

@section('content')
<div class="section-header">
    <h1>Laporan Penjualan Bulanan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Laporan</a></div>
        <div class="breadcrumb-item">Penjualan Bulanan</div>
    </div>
</div>

<div class="section-body">
    <!-- Filter Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.penjualan_bulanan') }}" class="form-row align-items-end">
                @if($user->isSuperAdmin())
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">Cabang</label>
                    <select name="cabang_id" class="form-control selectric">
                        <option value="">Semua Cabang</option>
                        @foreach($cabangs as $cab)
                            <option value="{{ $cab->id }}" {{ (string)$cabangId === (string)$cab->id ? 'selected' : '' }}>
                                {{ $cab->nama_cabang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-3 mb-3">
                    <label class="font-weight-bold">Bulan & Tahun</label>
                    <input type="month" name="bulan" class="form-control" value="{{ request('bulan', now()->format('Y-m')) }}">
                </div>
                <div class="col-md-5 mb-3 d-flex">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('laporan.penjualan_bulanan') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                    <a href="{{ route('export.penjualan', ['cabang_id' => $cabangId, 'bulan' => request('bulan', now()->format('Y-m'))]) }}" target="_blank" class="btn btn-success mr-2">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('cetak.history_penjualan', ['cabang_id' => $cabangId]) }}" target="_blank" class="btn btn-info">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Widgets -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Transaksi Penjualan (Bulan Ini)</h4>
                    </div>
                    <div class="card-body">
                        {{ rupiah($totalPenjualan) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-success bg-success">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Estimasi Laba / Profit (Bulan Ini)</h4>
                    </div>
                    <div class="card-body">
                        {{ rupiah($totalProfit) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="text-dark mb-0"><i class="fas fa-calendar-alt text-primary mr-2"></i>Data Transaksi Periode {{ $bulan }}</h4>
            <span class="badge badge-primary">{{ $laporan->count() }} Transaksi</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="table-1">
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>No. Nota</th>
                            <th>Tanggal</th>
                            <th>Cabang</th>
                            <th>Kasir</th>
                            <th>Customer</th>
                            <th>Metode</th>
                            <th>Total Belanja</th>
                            <th>Profit</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge badge-light font-weight-bold">#{{ $row->id_pembelian }}</span></td>
                            <td>{{ $row->tanggal_ind }} <small class="text-muted">{{ $row->jam_ind }}</small></td>
                            <td><span class="badge badge-info">{{ $row->cabang ? $row->cabang->nama_cabang : 'Utama' }}</span></td>
                            <td>{{ $row->kasir ?? '-' }}</td>
                            <td>{{ $row->nama_pembeli ?? 'Umum' }}</td>
                            <td>
                                @if($row->status_pembayaran == 2)
                                    <span class="badge badge-warning">Cicilan</span>
                                @else
                                    <span class="badge badge-success">Cash</span>
                                @endif
                            </td>
                            <td class="font-weight-bold">{{ rupiah($row->total_pembayaran) }}</td>
                            <td class="text-success font-weight-bold">{{ rupiah($row->pendapatan) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal{{ $row->id }}" title="Detail Belanja">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('pos.struk', $row->id_pembelian) }}" target="_blank" class="btn btn-sm btn-secondary" title="Cetak Struk">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-bold">Rincian Nota #{{ $row->id_pembelian }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Tanggal:</strong> {{ $row->tanggal_ind }} {{ $row->jam_ind }}</p>
                                                <p class="mb-1"><strong>Cabang:</strong> {{ $row->cabang ? $row->cabang->nama_cabang : '-' }}</p>
                                                <p class="mb-1"><strong>Kasir:</strong> {{ $row->kasir }}</p>
                                            </div>
                                            <div class="col-md-6 text-md-right">
                                                <p class="mb-1"><strong>Pelanggan:</strong> {{ $row->nama_pembeli ?? 'Umum' }}</p>
                                                <p class="mb-1"><strong>Total Bayar:</strong> {{ rupiah($row->total_pembayaran) }}</p>
                                                <p class="mb-1"><strong>Diskon:</strong> {{ $row->diskon ?? 0 }}%</p>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Barang</th>
                                                        <th>Harga Satuan</th>
                                                        <th class="text-center">Jumlah</th>
                                                        <th class="text-right">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($row->items)
                                                        @foreach($row->items as $it)
                                                        <tr>
                                                            <td>{{ $it->nama }}</td>
                                                            <td>{{ rupiah($it->harga) }}</td>
                                                            <td class="text-center">{{ $it->jumlah }} {{ $it->satuan }}</td>
                                                            <td class="text-right">{{ rupiah($it->harga_total) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3" class="text-right">Total Transaksi</th>
                                                        <th class="text-right font-weight-bold text-primary">{{ rupiah($row->total_pembayaran) }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">Belum ada transaksi pada periode {{ $bulan }}.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
