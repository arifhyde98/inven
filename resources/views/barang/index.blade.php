@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Master Barang</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Master Data Barang</h4>
        <div class="card-header-action">
            <a href="{{ route('barang.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Tambah Barang</a>
            <a href="{{ route('export.stok') }}" class="btn btn-success"><i class="fas fa-file-excel mr-1"></i> Export Excel</a>
        </div>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('barang.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama barang / barcode..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <select name="kategori" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->nama_kategori }}" {{ request('kategori') == $k->nama_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                @if(auth()->user()->isSuperAdmin())
                <div class="col-md-3 mb-2">
                    <select name="cabang_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Cabang --</option>
                        @foreach($cabangs as $cb)
                            <option value="{{ $cb->id }}" {{ request('cabang_id') == $cb->id ? 'selected' : '' }}>{{ $cb->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search mr-1"></i> Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-md">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Barcode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Cabang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $index => $b)
                    <tr>
                        <td>{{ $barangs->firstItem() + $index }}</td>
                        <td>
                            <img src="{{ asset('assets/images/barang/' . ($b->gambar ?? 'default.png')) }}" 
                                 alt="{{ $b->nama_barang }}" 
                                 class="rounded" 
                                 style="width: 45px; height: 45px; object-fit: cover;"
                                 onerror="this.src='{{ asset('assets/images/profiles/default.png') }}'">
                        </td>
                        <td><code>{{ $b->barcode }}</code></td>
                        <td><strong>{{ $b->nama_barang }}</strong></td>
                        <td><span class="badge badge-light">{{ $b->kategori }}</span></td>
                        <td>Rp {{ rupiah($b->harga_beli) }}</td>
                        <td class="font-weight-bold text-primary">Rp {{ rupiah($b->harga_jual) }}</td>
                        <td>
                            <span class="badge badge-{{ $b->stok > 5 ? 'success' : ($b->stok > 0 ? 'warning' : 'danger') }}">
                                {{ $b->stok }} {{ $b->satuan }}
                            </span>
                        </td>
                        <td>{{ $b->cabang->nama_cabang ?? 'Cabang ' . $b->id_cabang }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('barang.show', $b->id) }}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('barang.edit', $b->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('barang.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">Data barang tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $barangs->links() }}
        </div>
    </div>
</div>
@endsection
