@extends('layouts.app')

@section('title', 'Buat Sesi Stok Opname')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('stok-opname.index') }}">Stok Opname</a></div>
<div class="breadcrumb-item active">Mulai Sesi</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>Buat Sesi Audit Stok Opname Baru</h4>
        <div class="card-header-action">
            <span class="badge badge-light">Kode: <strong>{{ $kode }}</strong></span>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('stok-opname.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kode" value="{{ $kode }}">

            <div class="form-group">
                <label>Nama Sesi Opname <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" required placeholder="Contoh: Stok Opname Akhir Bulan Januari">
            </div>

            @if($user->isSuperAdmin())
            <div class="form-group">
                <label>Pilih Cabang yang Diaudit <span class="text-danger">*</span></label>
                <select name="tempat" class="form-control" required>
                    @foreach($cabangs as $cb)
                        <option value="{{ $cb->id }}">{{ $cb->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            @else
                <input type="hidden" name="tempat" value="{{ $user->penempatan_cabang }}">
            @endif

            <div class="form-group">
                <label>Catatan / Keterangan</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan opsional mengenai tim auditor atau alasan opname"></textarea>
            </div>

            <div class="card-footer bg-whitesmoke text-right">
                <a href="{{ route('stok-opname.index') }}" class="btn btn-secondary mr-1">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-play mr-1"></i> Mulai Input Fisik</button>
            </div>
        </form>
    </div>
</div>
@endsection
