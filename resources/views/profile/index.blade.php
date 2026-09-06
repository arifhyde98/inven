@extends('layouts.app')

@section('title', 'Profil Saya')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Profil Saya</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card card-primary text-center">
            <div class="card-body">
                <img src="{{ asset('assets/images/profiles/' . ($user->foto_profile ?? 'default.png')) }}" 
                     alt="{{ $user->nama }}" 
                     class="rounded-circle img-thumbnail mb-3" 
                     style="width: 120px; height: 120px; object-fit: cover;">
                <h4>{{ $user->nama }}</h4>
                <p class="text-muted">@ {{ $user->username }}</p>
                <span class="badge badge-primary">{{ $user->isSuperAdmin() ? 'Super Admin' : 'Admin Cabang' }}</span>
                <span class="badge badge-success">{{ $user->isSuperAdmin() ? 'Pusat' : ($user->cabang->nama_cabang ?? 'Cabang ' . $user->penempatan_cabang) }}</span>
            </div>
        </div>

        <div class="card card-warning">
            <div class="card-header">
                <h4>Ganti Password</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="3">
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required minlength="3">
                    </div>

                    <button type="submit" class="btn btn-warning btn-block"><i class="fas fa-key mr-1"></i> Perbarui Password</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h4>Edit Biodata Diri</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="l" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'l' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="p" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'p' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ganti Foto Profil</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Profil</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
