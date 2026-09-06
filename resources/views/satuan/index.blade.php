@extends('layouts.app')

@section('title', 'Satuan Barang')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Satuan Barang</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Tambah Satuan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('satuan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Singkatan Satuan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_satuan" class="form-control" required placeholder="Contoh: pcs, btl, kds">
                    </div>
                    <div class="form-group">
                        <label>Nama Satuan Asli <span class="text-danger">*</span></label>
                        <input type="text" name="nama_asli" class="form-control" required placeholder="Contoh: Picis, Botol, Kardus">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i> Simpan Satuan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Satuan Barang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Singkatan</th>
                                <th>Nama Lengkap</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($satuans as $index => $s)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><code>{{ $s->nama_satuan }}</code></td>
                                <td><strong>{{ $s->nama_asli }}</strong></td>
                                <td>
                                    <form action="{{ route('satuan.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus satuan ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada satuan barang.</td>
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
