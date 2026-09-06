@extends('layouts.app')

@section('title', 'Detail Cicilan #' . $idCicilan)

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="{{ route('cicilan.index') }}">Data Cicilan</a></div>
<div class="breadcrumb-item active">Detail & Bayar</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Informasi Transaksi</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <tr>
                        <th>ID Cicilan</th>
                        <td><code>{{ $idCicilan }}</code></td>
                    </tr>
                    <tr>
                        <th>No. Pembelian</th>
                        <td>{{ $penjualan->id_pembelian }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <td><strong>{{ $penjualan->customer->nama_user ?? $penjualan->id_user }}</strong></td>
                    </tr>
                    <tr>
                        <th>Cabang</th>
                        <td>{{ $penjualan->cabang->nama_cabang ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Total Tagihan</th>
                        <td>Rp {{ rupiah($penjualan->total_pembayaran) }}</td>
                    </tr>
                    <tr>
                        <th>Sisa Piutang</th>
                        <td class="font-weight-bold text-{{ $sisaHutang > 0 ? 'danger' : 'success' }}" style="font-size: 1.2rem;">
                            Rp {{ rupiah($sisaHutang) }}
                            @if($sisaHutang == 0)
                                <span class="badge badge-success ml-1">LUNAS</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer bg-whitesmoke text-right">
                <a href="{{ route('cicilan.struk', $idCicilan) }}" target="_blank" class="btn btn-info btn-sm">
                    <i class="fas fa-print mr-1"></i> Cetak Struk Cicilan
                </a>
            </div>
        </div>

        @if($sisaHutang > 0)
        <div class="card card-success">
            <div class="card-header">
                <h4>Bayar Angsuran / Cicilan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cicilan.pay', $idCicilan) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Jumlah Pembayaran (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="uang" class="form-control form-control-lg" placeholder="Masukkan jumlah uang bayar" min="1" required autofocus>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg btn-block" onclick="return confirm('Konfirmasi pembayaran cicilan?')">
                        <i class="fas fa-check mr-1"></i> Simpan Pembayaran
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h4>Riwayat Pembayaran Angsuran</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Waktu</th>
                                <th>Sisa Awal</th>
                                <th>Bayar</th>
                                <th>Sisa Akhir</th>
                                <th>Kembalian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $idx => $p)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $p->tanggal }}</td>
                                <td>Rp {{ rupiah($p->sisa_cicilan) }}</td>
                                <td class="font-weight-bold text-success">+Rp {{ rupiah($p->uang) }}</td>
                                <td class="font-weight-bold text-danger">Rp {{ rupiah($p->sisa_cicilan_akhir) }}</td>
                                <td>Rp {{ rupiah($p->kembalian) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted">Belum ada pembayaran angsuran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Daftar Barang yang Dibeli</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th class="text-right">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan->items as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td class="text-right">Rp {{ rupiah($item->harga) }}</td>
                            <td class="text-center">{{ $item->jumlah }} {{ $item->satuan }}</td>
                            <td class="text-right">Rp {{ rupiah($item->harga_total) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
