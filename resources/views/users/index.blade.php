@extends('layouts.app')

@section('title', 'Kelola Admin Cabang')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Admin Cabang</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Tambah Admin Cabang</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" required placeholder="Contoh: Budi Santoso">
                    </div>

                    <div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" required placeholder="budiadmin">
                    </div>

                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required placeholder="budi@gmail.com">
                    </div>

                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 3 karakter">
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="l">Laki-laki</option>
                            <option value="p">Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Penempatan Cabang <span class="text-danger">*</span></label>
                        <select name="penempatan_cabang" class="form-control" required>
                            @foreach($cabangs as $cb)
                                <option value="{{ $cb->id }}">{{ $cb->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Foto Profil (Opsional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-user-plus mr-1"></i> Buat Akun Admin</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Admin Cabang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama / Username</th>
                                <th>Email</th>
                                <th>Cabang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $u)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('assets/images/profiles/' . ($u->foto_profile ?? 'default.png')) }}" 
                                         alt="{{ $u->nama }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $u->nama }}</strong><br>
                                    <small class="text-muted">@ {{ $u->username }}</small>
                                </td>
                                <td>{{ $u->email }}</td>
                                <td><span class="badge badge-light">{{ $u->cabang->nama_cabang ?? 'Cabang ' . $u->penempatan_cabang }}</span></td>
                                <td>
                                    @if($u->status == 1)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Diblokir</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <form action="{{ route('users.toggle_status', $u->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-{{ $u->status == 1 ? 'warning' : 'success' }}" title="{{ $u->status == 1 ? 'Blokir' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $u->status == 1 ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus admin ini?')" class="d-inline ml-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada admin cabang terdaftar.</td>
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
