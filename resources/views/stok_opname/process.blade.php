@extends('layouts.app')

@section('title', 'Proses Stok Opname ' . $opname->kode)

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('stok-opname.index') }}">Stok Opname</a></div>
<div class="breadcrumb-item active">Audit Fisik</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Input Hasil Perhitungan Fisik: {{ $opname->nama }} (<code>{{ $opname->kode }}</code>)</h4>
        <div class="card-header-action">
            <span class="badge badge-info">{{ $opname->cabang->nama_cabang ?? 'Cabang ' . $opname->tempat }}</span>
        </div>
    </div>
    <div class="card-body">
        @if($opname->disabled == 1)
        <div class="alert alert-success mb-3">
            <i class="fas fa-check-circle mr-1"></i> Sesi audit ini telah diselesaikan dan stok barang telah disesuaikan secara otomatis.
        </div>
        @else
        <div class="alert alert-info mb-3">
            Centang barang yang diaudit, masukkan <strong>Stok Fisik</strong> aktual di gudang/toko, lalu klik <strong>Simpan & Sesuaikan Stok</strong>.
        </div>
        @endif

        <form action="{{ route('stok-opname.process.post', $opname->kode) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="bg-light">
                        <tr>
                            <th width="40" class="text-center">Audit</th>
                            <th>Nama Barang</th>
                            <th>Barcode</th>
                            <th class="text-center">Stok Sistem</th>
                            <th width="140" class="text-center">Stok Fisik</th>
                            <th class="text-center">Selisih</th>
                            <th class="text-right">Nilai Selisih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $index => $b)
                        @php
                            $savedItem = $items->get($b->id);
                            $stokFisik = $savedItem ? $savedItem->stok_fisik : $b->stok;
                            $stokAplikasi = $savedItem ? $savedItem->stok_aplikasi : $b->stok;
                            $selisih = $stokFisik - $stokAplikasi;
                        @endphp
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="is_check[{{ $index }}]" value="{{ $b->id }}" 
                                       class="opname-chk" id="chk-{{ $b->id }}" 
                                       {{ ($savedItem || $opname->disabled == 0) ? 'checked' : '' }}
                                       {{ $opname->disabled == 1 ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <strong>{{ $b->nama_barang }}</strong>
                                <input type="hidden" name="stok_aplikasi[{{ $index }}]" value="{{ $b->stok }}">
                            </td>
                            <td><code>{{ $b->barcode }}</code></td>
                            <td class="text-center font-weight-600">{{ $b->stok }} {{ $b->satuan }}</td>
                            <td>
                                <input type="number" name="stok_fisik[{{ $index }}]" 
                                       class="form-control form-control-sm text-center fisik-input" 
                                       data-stok="{{ $b->stok }}" 
                                       data-harga="{{ $b->harga_jual }}"
                                       value="{{ $stokFisik }}"
                                       {{ $opname->disabled == 1 ? 'disabled' : '' }}>
                            </td>
                            <td class="text-center font-weight-bold diff-display {{ $selisih < 0 ? 'text-danger' : ($selisih > 0 ? 'text-success' : '') }}">
                                {{ $selisih }}
                            </td>
                            <td class="text-right font-weight-bold diff-price-display">
                                Rp {{ rupiah($selisih * $b->harga_jual) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada data barang di cabang ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($opname->disabled == 0)
            <div class="card-footer bg-whitesmoke text-right">
                <a href="{{ route('stok-opname.index') }}" class="btn btn-secondary mr-1">Kembali</a>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin data fisik sudah benar? Stok barang akan disinkronkan dengan stok fisik yang diinput.')">
                    <i class="fas fa-save mr-1"></i> Simpan & Sesuaikan Stok
                </button>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.fisik-input').on('keyup change', function() {
        var row = $(this).closest('tr');
        var stokApp = parseInt($(this).data('stok')) || 0;
        var harga = parseInt($(this).data('harga')) || 0;
        var fisik = parseInt($(this).val()) || 0;

        var selisih = fisik - stokApp;
        var nilai = selisih * harga;

        var diffCell = row.find('.diff-display');
        diffCell.text(selisih);
        if (selisih < 0) {
            diffCell.removeClass('text-success').addClass('text-danger');
        } else if (selisih > 0) {
            diffCell.removeClass('text-danger').addClass('text-success');
        } else {
            diffCell.removeClass('text-danger text-success');
        }

        row.find('.diff-price-display').text('Rp ' + nilai.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    });
</script>
@endpush
