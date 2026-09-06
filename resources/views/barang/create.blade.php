@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('barang.index') }}">Master Barang</a></div>
<div class="breadcrumb-item active">Tambah Barang</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>Form Tambah Barang Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang') }}" required placeholder="Contoh: Indomie Goreng">
                    </div>

                    <div class="form-group">
                        <label>Barcode (Kosongkan jika ingin digenerate otomatis)</label>
                        <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}" placeholder="899522750027">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-control selectric" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->nama_kategori }}" {{ old('kategori') == $k->nama_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Satuan <span class="text-danger">*</span></label>
                                <select name="satuan" class="form-control selectric" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    @foreach($satuans as $s)
                                        <option value="{{ $s->nama_satuan }}" {{ old('satuan') == $s->nama_satuan ? 'selected' : '' }}>{{ $s->nama_satuan }} ({{ $s->nama_asli }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Beli (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga_beli" id="harga_beli" class="form-control" value="{{ old('harga_beli', 0) }}" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Jual (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga_jual" id="harga_jual" class="form-control" value="{{ old('harga_jual', 0) }}" required min="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stok Awal <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Kadaluarsa (Expired)</label>
                                <input type="date" name="exp_date" class="form-control" value="{{ old('exp_date') }}">
                            </div>
                        </div>
                    </div>

                    @if($user->isSuperAdmin())
                    <div class="form-group">
                        <label>Penempatan Cabang <span class="text-danger">*</span></label>
                        <select name="id_cabang" class="form-control" required>
                            @foreach($cabangs as $cb)
                                <option value="{{ $cb->id }}" {{ old('id_cabang') == $cb->id ? 'selected' : '' }}>{{ $cb->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="form-group">
                        <label>Supplier</label>
                        <select name="id_suplier" class="form-control">
                            <option value="">-- Tidak ada supplier --</option>
                            @foreach($supliers as $sp)
                                <option value="{{ $sp->id }}" {{ old('id_suplier') == $sp->id ? 'selected' : '' }}>{{ $sp->nama_suplier }} ({{ $sp->id_suplier }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Foto Produk (Opsional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Maksimal 5MB, format: jpg, jpeg, png, gif</small>
                    </div>

                    <div class="form-group">
                        <label>Keterangan Tambahan</label>
                        <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-whitesmoke text-right">
                <a href="{{ route('barang.index') }}" class="btn btn-secondary mr-1">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Barang</button>
            </div>
        </form>
    </div>
</div>
@endsection
