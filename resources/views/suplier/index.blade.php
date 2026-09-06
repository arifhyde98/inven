@extends('layouts.app')

@section('title', 'Data Supplier')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Supplier</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Tambah Supplier Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('suplier.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Kode Supplier <span class="text-danger">*</span></label>
                        <input type="text" name="id_suplier" class="form-control" value="{{ $kodeBaru }}" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" name="nama_suplier" class="form-control" required placeholder="Contoh: PT. Sumber Makmur">
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="telp" class="form-control" placeholder="08123456789">
                    </div>

                    <div class="form-group">
                        <label>Alamat Supplier</label>
                        <textarea name="alamat_suplier" class="form-control" rows="3" placeholder="Alamat supplier..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i> Simpan Supplier</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Mitra Supplier</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Supplier</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supliers as $index => $sp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><code>{{ $sp->id_suplier }}</code></td>
                                <td><strong>{{ $sp->nama_suplier }}</strong></td>
                                <td>{{ $sp->telp ?: '-' }}</td>
                                <td>{{ $sp->alamat_suplier ?: '-' }}</td>
                                <td><span class="badge badge-light">{{ $sp->barangs_count }} Barang</span></td>
                                <td>
                                    <form action="{{ route('suplier.destroy', $sp->id) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada supplier terdaftar.</td>
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
