@extends('layouts.app')

@section('title', 'Biaya Pengeluaran Cabang')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Biaya Pengeluaran</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Tambah Pengeluaran</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(auth()->user()->isSuperAdmin())
                    <div class="form-group">
                        <label>Cabang <span class="text-danger">*</span></label>
                        <select name="id_cabang" class="form-control" required>
                            @foreach($cabangs as $cb)
                                <option value="{{ $cb->id }}">{{ $cb->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="form-group">
                        <label>Total Pengeluaran (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="total_pengeluaran" class="form-control" required min="1" placeholder="Contoh: 50000">
                    </div>

                    <div class="form-group">
                        <label>Catatan / Keperluan <span class="text-danger">*</span></label>
                        <textarea name="catatan" class="form-control" rows="3" required placeholder="Beli plastik kresek, bayar listrik, dll."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Kode Pesanan (Jika Terkait Pengadaan)</label>
                        <input type="text" name="kode_pesanan" class="form-control" placeholder="PSN001234">
                    </div>

                    <div class="form-group">
                        <label>Upload Bukti / Nota (Opsional)</label>
                        <input type="file" name="bukti" class="form-control" accept="image/*">
                        <small class="text-muted">Maksimal 5MB (jpg, png, jpeg)</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i> Simpan Pengeluaran</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Riwayat Biaya Pengeluaran</h4>
                <div class="card-header-action">
                    <a href="{{ route('export.pengeluaran') }}" class="btn btn-success"><i class="fas fa-file-excel mr-1"></i> Export Excel</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Cabang</th>
                                <th>Keperluan</th>
                                <th>Total Biaya</th>
                                <th>Bukti</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengeluarans as $index => $p)
                            <tr>
                                <td>{{ $pengeluarans->firstItem() + $index }}</td>
                                <td>{{ $p->tanggal_ind }}</td>
                                <td>{{ $p->cabang->nama_cabang ?? 'Cabang ' . $p->id_cabang }}</td>
                                <td>
                                    {{ $p->catatan }}
                                    @if($p->kode_pesanan)
                                        <br><small class="text-muted">PO: {{ $p->kode_pesanan }}</small>
                                    @endif
                                </td>
                                <td class="font-weight-bold text-danger">Rp {{ rupiah($p->total_pengeluaran) }}</td>
                                <td>
                                    @if($p->bukti_pengeluaran && $p->bukti_pengeluaran !== 'default.png')
                                        <a href="{{ asset('assets/images/bukti_pengeluaran/' . $p->bukti_pengeluaran) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-image"></i> Lihat
                                        </a>
                                    @else
                                        <span class="badge badge-light">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->status_bukti == 1)
                                        <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Disetujui</span>
                                    @elseif($p->status_bukti == 2)
                                        <span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i> Ditolak</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @if(auth()->user()->isSuperAdmin() && $p->status_bukti == 0)
                                        <form action="{{ route('pengeluaran.approve', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Setujui"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('pengeluaran.reject', $p->id) }}" method="POST" class="d-inline ml-1">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Tolak"><i class="fas fa-times"></i></button>
                                        </form>
                                        @endif
                                        <form action="{{ route('pengeluaran.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus data pengeluaran ini?')" class="d-inline ml-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada catatan pengeluaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pengeluarans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
