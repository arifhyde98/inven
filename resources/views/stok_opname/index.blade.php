@extends('layouts.app')

@section('title', 'Stok Opname')

@section('breadcrumb')
<div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
<div class="breadcrumb-item active">Stok Opname</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Riwayat Sesi Audit Stok Opname</h4>
        <div class="card-header-action">
            <a href="{{ route('stok-opname.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Mulai Stok Opname Baru</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Opname</th>
                        <th>Nama Sesi</th>
                        <th>Cabang</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opnames as $index => $op)
                    <tr>
                        <td>{{ $opnames->firstItem() + $index }}</td>
                        <td><code>{{ $op->kode }}</code></td>
                        <td><strong>{{ $op->nama }}</strong></td>
                        <td>{{ $op->cabang->nama_cabang ?? 'Cabang ' . $op->tempat }}</td>
                        <td>{{ $op->tanggal }}</td>
                        <td>
                            @if($op->disabled == 1)
                                <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Selesai / Terkunci</span>
                            @else
                                <span class="badge badge-warning"><i class="fas fa-edit mr-1"></i> Proses Audit</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('stok-opname.process', $op->kode) }}" class="btn btn-sm btn-info" title="Buka Sesi Opname">
                                <i class="fas fa-tasks mr-1"></i> {{ $op->disabled == 1 ? 'Lihat Hasil' : 'Input Fisik' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada sesi stok opname.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $opnames->links() }}
        </div>
    </div>
</div>
@endsection
