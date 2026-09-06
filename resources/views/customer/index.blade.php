@extends('layouts.app')

@section('title', 'Pelanggan Tetap')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Pelanggan Tetap</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Tambah Pelanggan Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('customer.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_user" class="form-control" required placeholder="Contoh: Pak Deni">
                    </div>

                    <div class="form-group">
                        <label>No. Telepon / WhatsApp</label>
                        <input type="text" name="tlp_user" class="form-control" placeholder="08123456789">
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat pelanggan..."></textarea>
                    </div>

                    @if(auth()->user()->isSuperAdmin())
                    <div class="form-group">
                        <label>Cabang <span class="text-danger">*</span></label>
                        <select name="penempatan" class="form-control" required>
                            @foreach($cabangs as $cb)
                                <option value="{{ $cb->id }}">{{ $cb->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i> Simpan Pelanggan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Pelanggan Tetap</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID User</th>
                                <th>Nama Pelanggan</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Cabang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $index => $c)
                            <tr>
                                <td>{{ $customers->firstItem() + $index }}</td>
                                <td><code>{{ $c->id_user }}</code></td>
                                <td><strong>{{ $c->nama_user }}</strong></td>
                                <td>{{ $c->tlp_user ?: '-' }}</td>
                                <td>{{ $c->alamat ?: '-' }}</td>
                                <td>{{ $c->cabang->nama_cabang ?? 'Cabang ' . $c->penempatan }}</td>
                                <td>
                                    <form action="{{ route('customer.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data pelanggan tetap.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
