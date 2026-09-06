@extends('layouts.app')

@section('title', 'Pesanan / Pembelian Barang')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Pesanan Barang</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Data Pesanan & Pengadaan Barang</h4>
        <div class="card-header-action">
            <div class="btn-group">
                <a href="{{ route('pesanan.create', ['jenis' => 1]) }}" class="btn btn-primary"><i class="fas fa-boxes mr-1"></i> Pesan Stok Barang</a>
                <a href="{{ route('pesanan.create', ['jenis' => 2]) }}" class="btn btn-outline-primary"><i class="fas fa-cart-plus mr-1"></i> Pengadaan Barang Baru</a>
            </div>
            <a href="{{ route('export.pesanan') }}" class="btn btn-success ml-1"><i class="fas fa-file-excel mr-1"></i> Export</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Pesanan</th>
                        <th>Nama Pesanan</th>
                        <th>Cabang</th>
                        <th>Supplier</th>
                        <th>Jenis</th>
                        <th>Tanggal Pesan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $index => $p)
                    <tr>
                        <td>{{ $pesanans->firstItem() + $index }}</td>
                        <td><code>{{ $p->kode }}</code></td>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td>{{ $p->cabang->nama_cabang ?? 'Cabang ' . $p->tempat }}</td>
                        <td>{{ $p->suplierRelasi->nama_suplier ?? ($p->suplier ?: '-') }}</td>
                        <td>
                            <span class="badge badge-{{ $p->jenis_pesanan == 1 ? 'info' : 'secondary' }}">
                                {{ $p->jenis_pesanan == 1 ? 'Pesanan Stok' : 'Barang Baru' }}
                            </span>
                        </td>
                        <td>{{ $p->tanggal_pesan }}</td>
                        <td>
                            @if($p->status == 1)
                                <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima</span>
                                <br><small class="text-muted">{{ $p->tanggal_terima }}</small>
                            @else
                                <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('pesanan.show', $p->kode) }}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('cetak.bukti_pesanan', $p->kode) }}" target="_blank" class="btn btn-sm btn-light" title="Cetak PO"><i class="fas fa-print"></i></a>
                                
                                @if($p->status == 0)
                                <form action="{{ route('pesanan.receive', $p->kode) }}" method="POST" onsubmit="return confirm('Konfirmasi terima pesanan ini? Stok barang akan bertambah secara otomatis.')" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" title="Terima Barang"><i class="fas fa-download"></i></button>
                                </form>
                                <form action="{{ route('pesanan.destroy', $p->kode) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Batalkan"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">Belum ada riwayat pesanan barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $pesanans->links() }}
        </div>
    </div>
</div>
@endsection
