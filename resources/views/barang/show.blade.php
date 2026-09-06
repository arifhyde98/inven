@extends('layouts.app')

@section('title', 'Detail Barang: ' . $barang->nama_barang)

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('barang.index') }}">Master Barang</a></div>
<div class="breadcrumb-item active">Detail</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary text-center">
            <div class="card-body">
                <img src="{{ asset('assets/images/barang/' . ($barang->gambar ?? 'default.png')) }}" 
                     alt="{{ $barang->nama_barang }}" 
                     class="img-fluid rounded mb-3" 
                     style="max-height: 250px; object-fit: contain;"
                     onerror="this.src='{{ asset('assets/images/profiles/default.png') }}'">
                <h4>{{ $barang->nama_barang }}</h4>
                <p class="text-muted mb-2"><code>{{ $barang->barcode }}</code></p>
                <span class="badge badge-primary">{{ $barang->kategori }}</span>
                <span class="badge badge-success">{{ $barang->cabang->nama_cabang ?? 'Cabang ' . $barang->id_cabang }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Informasi Rinci Produk</h4>
                <div class="card-header-action">
                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning"><i class="fas fa-edit mr-1"></i> Edit</a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <tr>
                        <th width="200">Harga Beli</th>
                        <td>Rp {{ rupiah($barang->harga_beli) }}</td>
                    </tr>
                    <tr>
                        <th>Harga Jual</th>
                        <td class="font-weight-bold text-primary">Rp {{ rupiah($barang->harga_jual) }}</td>
                    </tr>
                    <tr>
                        <th>Profit per Satuan</th>
                        <td class="text-success font-weight-bold">Rp {{ rupiah($barang->profit) }}</td>
                    </tr>
                    <tr>
                        <th>Stok Tersedia</th>
                        <td>
                            <span class="badge badge-{{ $barang->stok > 5 ? 'success' : ($barang->stok > 0 ? 'warning' : 'danger') }}">
                                {{ $barang->stok }} {{ $barang->satuan }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <td>{{ $barang->suplier->nama_suplier ?? '-' }} ({{ $barang->suplier->telp ?? '-' }})</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kadaluarsa</th>
                        <td>{{ $barang->exp_date ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $barang->keterangan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Riwayat Pergerakan Stok (10 Terakhir)</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barang->stokLogs()->orderBy('id', 'desc')->limit(10)->get() as $log)
                            <tr>
                                <td>{{ $log->tanggal ?: date('d-m-Y H:i', $log->tgl) }}</td>
                                <td>
                                    <span class="badge badge-{{ $log->status == 1 ? 'success' : 'danger' }}">
                                        {{ $log->status == 1 ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td>{{ $log->jumlah }}</td>
                                <td>{{ $log->keterangan }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Belum ada catatan log stok.</td>
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
