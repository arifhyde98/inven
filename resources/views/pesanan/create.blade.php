@extends('layouts.app')

@section('title', $jenis == 1 ? 'Pesan Stok Barang' : 'Pengadaan Barang Baru')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('pesanan.index') }}">Pesanan Barang</a></div>
<div class="breadcrumb-item active">Buat Pesanan</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>{{ $jenis == 1 ? 'Pesan Stok Ulang Barang (Restock)' : 'Pengadaan Barang Baru Manual' }}</h4>
        <div class="card-header-action">
            <span class="badge badge-light">Kode: <strong>{{ $kodePesanan }}</strong></span>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('pesanan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kode" value="{{ $kodePesanan }}">
            <input type="hidden" name="jenis_pesanan" value="{{ $jenis }}">

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama Pesanan <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" required placeholder="Contoh: Pesanan Restock Awal Bulan">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pilih Supplier</label>
                        <select name="suplier" class="form-control">
                            <option value="-">-- Pilih Supplier --</option>
                            @foreach($supliers as $sp)
                                <option value="{{ $sp->id_suplier }}">{{ $sp->nama_suplier }} ({{ $sp->id_suplier }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if($user->isSuperAdmin())
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cabang Tujuan <span class="text-danger">*</span></label>
                        <select name="tempat" class="form-control" onchange="window.location.href='{{ route('pesanan.create', ['jenis' => $jenis]) }}?cabang_id=' + this.value">
                            @foreach($cabangs as $cb)
                                <option value="{{ $cb->id }}" {{ $cabangId == $cb->id ? 'selected' : '' }}>{{ $cb->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @else
                    <input type="hidden" name="tempat" value="{{ $user->penempatan_cabang }}">
                @endif
            </div>

            @if($jenis == 1)
            <!-- Restock Existing Items -->
            <h5 class="mb-3">Daftar Barang yang Dipesan</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="bg-light">
                        <tr>
                            <th width="40">Pilih</th>
                            <th>Nama Barang</th>
                            <th>Stok Saat Ini</th>
                            <th width="150">Harga Beli</th>
                            <th width="120">Jumlah Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $b)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="barang_id[]" value="{{ $b->id }}" class="item-checkbox" id="chk-{{ $b->id }}">
                            </td>
                            <td>
                                <label for="chk-{{ $b->id }}" class="mb-0 font-weight-600 d-block" style="cursor: pointer;">
                                    {{ $b->nama_barang }} (<code>{{ $b->barcode }}</code>)
                                </label>
                            </td>
                            <td>{{ $b->stok }} {{ $b->satuan }}</td>
                            <td>Rp {{ rupiah($b->harga_beli) }}</td>
                            <td>
                                <input type="number" name="stok_pesan[]" class="form-control form-control-sm text-center" min="1" value="10">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">Belum ada barang di cabang ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @else
            <!-- Manual New Purchase Items -->
            <h5 class="mb-3">Item Pengadaan Baru</h5>
            <div id="manual-items-container">
                <div class="card border mb-3 p-3 manual-item-row">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label>Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="manual_nama[]" class="form-control" required placeholder="Nama produk baru">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-2">
                                <label>Kategori</label>
                                <select name="manual_kategori[]" class="form-control">
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->nama_kategori }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-2">
                                <label>Satuan</label>
                                <select name="manual_satuan[]" class="form-control">
                                    @foreach($satuans as $s)
                                        <option value="{{ $s->nama_satuan }}">{{ $s->nama_satuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-2">
                                <label>Harga Beli (Rp)</label>
                                <input type="number" name="manual_harga_beli[]" class="form-control" min="0" required value="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-2">
                                <label>Jumlah</label>
                                <input type="number" name="manual_jumlah[]" class="form-control" min="1" required value="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="btn-add-manual-row" class="btn btn-outline-primary btn-sm mb-3">
                <i class="fas fa-plus mr-1"></i> Tambah Baris Barang
            </button>
            @endif

            <div class="card-footer bg-whitesmoke text-right mt-3">
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary mr-1">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"></i> Kirim Pesanan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#btn-add-manual-row').on('click', function() {
        var clone = $('.manual-item-row:first').clone();
        clone.find('input').val('');
        clone.find('input[type="number"]').val(1);
        $('#manual-items-container').append(clone);
    });
</script>
@endpush
