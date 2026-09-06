@extends('layouts.app')

@section('title', 'Cetak Barcode Barang')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('barang.index') }}">Master Barang</a></div>
<div class="breadcrumb-item active">Cetak Barcode</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Pilih Barang untuk Cetak Barcode</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('cetak.barcode_sheet') }}" method="GET" target="_blank">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pilih Barang</label>
                        <select name="id" class="form-control select2" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }} ({{ $b->barcode }}) - Rp {{ rupiah($b->harga_jual) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jumlah Label Barcode</label>
                        <input type="number" name="qty" class="form-control" value="12" min="1" max="100">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-print mr-1"></i> Preview & Cetak</button>
                    </div>
                </div>
            </div>
        </form>

        <hr>

        <h5 class="mb-3">Daftar Barcode Seluruh Barang</h5>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $b)
                    <tr>
                        <td><code>{{ $b->barcode }}</code></td>
                        <td>{{ $b->nama_barang }}</td>
                        <td>{{ $b->kategori }}</td>
                        <td>Rp {{ rupiah($b->harga_jual) }}</td>
                        <td>
                            <a href="{{ route('cetak.barcode_sheet', ['id' => $b->id, 'qty' => 12]) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-print mr-1"></i> Cetak Label
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
