@extends('layouts.app')

@section('title', 'Pengaturan Toko')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Pengaturan</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>Pengaturan Profil Toko & Nota Struk</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Perusahaan / Toko <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan', $pengaturan->nama_perusahaan) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Pemilik</label>
                        <input type="text" name="pemilik" class="form-control" value="{{ old('pemilik', $pengaturan->pemilik) }}">
                    </div>

                    <div class="form-group">
                        <label>Alamat Perusahaan / Toko</label>
                        <textarea name="alamat_perusahaan" class="form-control" rows="3">{{ old('alamat_perusahaan', $pengaturan->alamat_perusahaan) }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Judul Aplikasi (Title)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $pengaturan->title) }}">
                    </div>

                    <div class="form-group">
                        <label>Teks Footer Aplikasi</label>
                        <input type="text" name="footer" class="form-control" value="{{ old('footer', $pengaturan->footer) }}">
                    </div>

                    <div class="form-group">
                        <label>Logo / Favicon Toko</label>
                        <input type="file" name="favicon" class="form-control" accept="image/*">
                        @if($pengaturan->favicon)
                            <div class="mt-2">
                                <img src="{{ asset('assets/images/profiles/' . $pengaturan->favicon) }}" alt="Logo" class="rounded" style="max-height: 60px;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-footer bg-whitesmoke text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection
