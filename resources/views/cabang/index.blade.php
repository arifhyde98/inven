@extends('layouts.app')

@section('title', 'Data Cabang')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Cabang</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Tambah Cabang Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cabang.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Cabang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_cabang" class="form-control" required placeholder="Contoh: Cabang Jakarta Selatan">
                    </div>

                    <div class="form-group">
                        <label>Alamat Cabang <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="3" required placeholder="Alamat lengkap cabang..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i> Simpan Cabang</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Seluruh Cabang Toko</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Cabang</th>
                                <th>Alamat</th>
                                <th>Jumlah Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cabangs as $index => $cb)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $cb->nama_cabang }}</strong></td>
                                <td>{{ $cb->alamat }}</td>
                                <td><span class="badge badge-info">{{ $cb->barangs_count }} Barang</span></td>
                                <td>
                                    <form action="{{ route('cabang.destroy', $cb->id) }}" method="POST" onsubmit="return confirm('Hapus cabang ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada cabang terdaftar.</td>
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
