@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
<div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Penjualan Hari Ini</h4>
                </div>
                <div class="card-body">
                    Rp {{ rupiah($stats['penjualan_hari_ini']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Keuntungan Bulan Ini</h4>
                </div>
                <div class="card-body">
                    Rp {{ rupiah($stats['pendapatan_bulan_ini']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Produk</h4>
                </div>
                <div class="card-body">
                    {{ $stats['total_barang'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Stok Menipis (≤5)</h4>
                </div>
                <div class="card-body">
                    {{ $stats['stok_menipis'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Grafik Penjualan Mingguan</h4>
            </div>
            <div class="card-body">
                <canvas id="weeklySalesChart" height="150"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Ringkasan Keuangan</h4>
            </div>
            <div class="card-body">
                <ul class="list-unstyled list-unstyled-border">
                    <li class="media">
                        <div class="media-body">
                            <div class="float-right text-primary font-weight-600">Rp {{ rupiah($stats['penjualan_bulan_ini']) }}</div>
                            <div class="media-title">Total Penjualan</div>
                            <span class="text-small text-muted">Akumulasi bulan ini</span>
                        </div>
                    </li>
                    <li class="media">
                        <div class="media-body">
                            <div class="float-right text-success font-weight-600">Rp {{ rupiah($stats['pendapatan_bulan_ini']) }}</div>
                            <div class="media-title">Gross Profit</div>
                            <span class="text-small text-muted">Laba kotor penjualan</span>
                        </div>
                    </li>
                    <li class="media">
                        <div class="media-body">
                            <div class="float-right text-danger font-weight-600">Rp {{ rupiah($stats['pengeluaran_bulan_ini']) }}</div>
                            <div class="media-title">Pengeluaran</div>
                            <span class="text-small text-muted">Biaya operasional cabang</span>
                        </div>
                    </li>
                    <li class="media">
                        <div class="media-body">
                            <div class="float-right text-info font-weight-bold" style="font-size: 1.1rem;">Rp {{ rupiah($stats['laba_bersih_bulan_ini']) }}</div>
                            <div class="media-title font-weight-bold">Laba Bersih</div>
                            <span class="text-small text-muted">Net Profit setelah biaya</span>
                        </div>
                    </li>
                </ul>
                <div class="text-center pt-1 pb-1">
                    <a href="{{ route('pos.index') }}" class="btn btn-primary btn-lg btn-round btn-icon icon-left">
                        <i class="fas fa-cash-register"></i> Buka Kasir POS
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>10 Transaksi Penjualan Terakhir</h4>
                <div class="card-header-action">
                    <a href="{{ route('laporan.penjualan_harian') }}" class="btn btn-primary">Lihat Semua Laporan</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Pembelian</th>
                                <th>Cabang</th>
                                <th>Waktu</th>
                                <th>Metode</th>
                                <th>Total Bayar</th>
                                <th>Keuntungan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $index => $sale)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge badge-light font-weight-bold">{{ $sale->id_pembelian }}</span></td>
                                <td>{{ $sale->cabang->nama_cabang ?? 'Cabang ' . $sale->id_cabang }}</td>
                                <td>{{ $sale->tanggal }}</td>
                                <td>
                                    <span class="badge badge-{{ $sale->metode_bayar === 'tunai' ? 'success' : 'warning' }}">
                                        {{ ucfirst($sale->metode_bayar) }}
                                    </span>
                                </td>
                                <td>Rp {{ rupiah($sale->total_pembayaran) }}</td>
                                <td class="text-success font-weight-600">+Rp {{ rupiah($sale->pendapatan) }}</td>
                                <td>
                                    <a href="{{ route('pos.struk', $sale->id_pembelian) }}" target="_blank" class="btn btn-sm btn-info" title="Cetak Struk">
                                        <i class="fas fa-print"></i> Struk
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada transaksi penjualan terbaru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/modules/chart.min.js') }}"></script>
<script>
    var ctx = document.getElementById("weeklySalesChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($stats['chart_labels']) !!},
            datasets: [{
                label: 'Penjualan (Rp)',
                data: {!! json_encode($stats['chart_sales']) !!},
                borderWidth: 2,
                backgroundColor: 'rgba(103, 119, 239, 0.2)',
                borderColor: '#6777ef',
                pointBackgroundColor: '#6777ef',
                pointRadius: 4
            }, {
                label: 'Keuntungan (Rp)',
                data: {!! json_encode($stats['chart_income']) !!},
                borderWidth: 2,
                backgroundColor: 'rgba(71, 195, 99, 0.2)',
                borderColor: '#47c363',
                pointBackgroundColor: '#47c363',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }]
            }
        }
    });
</script>
@endpush
