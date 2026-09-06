@extends('layouts.print')

@section('title', 'Bukti Pesanan ' . $pesanan->kode)

@section('content')
<div class="container my-4">
    <div class="card border p-4 shadow-none">
        <div class="text-center mb-4 border-bottom pb-3">
            <h4 class="text-uppercase font-weight-bold mb-1">Nota Pembelian & Pemesanan Barang</h4>
            <h5 class="text-uppercase text-primary mb-1">{{ $pengaturan->nama_perusahaan ?? 'Joona InventoryX' }}</h5>
            <p class="mb-0 text-muted">{{ $pengaturan->alamat_perusahaan ?? '' }} | Telp: {{ $pengaturan->nomor_telepon ?? '-' }}</p>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="130" class="font-weight-bold">Kode Pesanan</td>
                        <td>: <span class="badge badge-light font-weight-bold">{{ $pesanan->kode }}</span></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Nama Pesanan</td>
                        <td>: {{ $pesanan->nama }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Supplier</td>
                        <td>: {{ $pesanan->suplierRelasi ? $pesanan->suplierRelasi->nama_suplier : ($pesanan->suplier ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Tujuan Cabang</td>
                        <td>: {{ $pesanan->cabang ? $pesanan->cabang->nama_cabang : 'Pusat' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6 text-right">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="font-weight-bold">Tgl. Pesan</td>
                        <td>: {{ $pesanan->tanggal_pesan }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Tgl. Terima</td>
                        <td>: {{ $pesanan->tanggal_terima ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Status</td>
                        <td>: 
                            @if($pesanan->status == 1)
                                <span class="badge badge-success">Diterima Lengkap</span>
                            @else
                                <span class="badge badge-warning">Dalam Proses</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th width="40" class="text-center">No</th>
                    <th>Nama Barang</th>
                    <th class="text-center">Dipesan</th>
                    <th class="text-center">Diterima</th>
                    <th class="text-right">Harga Beli</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $totalBeli = 0; @endphp
                @if($pesanan->jenis_pesanan == 1)
                    @foreach($pesanan->items as $idx => $item)
                    @php $totalBeli += $item->total_beli; @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td class="text-center">{{ $item->stok_pesan }}</td>
                        <td class="text-center">{{ $item->stok_terima ?? 0 }}</td>
                        <td class="text-right">{{ rupiah($item->harga_beli) }}</td>
                        <td class="text-right">{{ rupiah($item->total_beli) }}</td>
                    </tr>
                    @endforeach
                @else
                    @foreach($pesanan->itemsManual as $idx => $m)
                    @php $totalBeli += $m->harga_total; @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td>{{ $m->nama_barang }}</td>
                        <td class="text-center">{{ $m->jumlah }} {{ $m->satuan }}</td>
                        <td class="text-center">{{ $m->jumlah }} {{ $m->satuan }}</td>
                        <td class="text-right">{{ rupiah($m->harga_beli) }}</td>
                        <td class="text-right">{{ rupiah($m->harga_total) }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-light">
                    <td colspan="5" class="text-right">TOTAL PENGELUARAN</td>
                    <td class="text-right text-primary">{{ rupiah($totalBeli) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5 pt-4">
            <div class="col-4 text-center">
                <p class="mb-5">Pengirim / Supplier</p>
                <p class="font-weight-bold mb-0">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
            </div>
            <div class="col-4 text-center">
                <p class="mb-5">Penerima Barang</p>
                <p class="font-weight-bold mb-0">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
            </div>
            <div class="col-4 text-center">
                <p class="mb-5">Penanggung Jawab / Admin</p>
                <p class="font-weight-bold mb-0">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
            </div>
        </div>
    </div>
</div>
@endsection
