@extends('layouts.app')

@section('title', 'Dokumentasi - Hak Akses & Role')

@section('content')
<div class="section-header">
    <h1>Matriks Hak Akses & Penjelasan Role</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('dokumentasi.show', 'index') }}">Dokumentasi</a></div>
        <div class="breadcrumb-item">Hak Akses Role</div>
    </div>
</div>

<div class="section-body">
    @include('dokumentasi.nav')

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h4 class="text-primary"><i class="fas fa-shield-alt mr-2"></i>Matriks Wewenang & Hak Akses Pengguna</h4>
        </div>
        <div class="card-body">
            <p class="text-muted">
                Aplikasi membagi otorisasi pengguna menjadi dua level utama: <strong>Super Admin (Level 1)</strong> yang memiliki kendali multi-cabang menyeluruh, dan <strong>Admin Cabang (Level 2)</strong> yang terisolasi khusus pada cabang tempat ia ditugaskan.
            </p>

            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            <th width="260" rowspan="2" class="align-middle text-left">Fitur / Modul</th>
                            <th colspan="3" class="bg-primary text-white">Super Admin (Pusat)</th>
                            <th colspan="3" class="bg-dark text-white">Admin Cabang</th>
                        </tr>
                        <tr>
                            <th width="75">Create</th>
                            <th width="75">Update</th>
                            <th width="75">Delete</th>
                            <th width="75">Create</th>
                            <th width="75">Update</th>
                            <th width="75">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="text-left">
                        <tr>
                            <td><strong>Pemesanan Barang Baru</strong></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                        </tr>
                        <tr>
                            <td><strong>Pesan Stok Barang Eksisting</strong></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                        </tr>
                        <tr>
                            <td><strong>Terima & Validasi Pesanan Masuk</strong></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                        </tr>
                        <tr>
                            <td><strong>Kasir / Transaksi POS (Jual Barang)</strong></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                        </tr>
                        <tr>
                            <td><strong>Pelanggan & Cicilan (Piutang)</strong></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                        </tr>
                        <tr>
                            <td><strong>Master Data Barang</strong></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                        </tr>
                        <tr>
                            <td><strong>Stok Opname Cabang</strong></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                        </tr>
                        <tr>
                            <td><strong>Manajemen Pengguna (Admin)</strong></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-danger"><i class="fas fa-times"></i></span></td>
                            <td class="text-center"><span class="badge badge-danger"><i class="fas fa-times"></i></span></td>
                            <td class="text-center"><span class="badge badge-danger"><i class="fas fa-times"></i></span></td>
                        </tr>
                        <tr>
                            <td><strong>Master Cabang, Suplier, Kategori, Satuan</strong></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-danger"><i class="fas fa-times"></i></span></td>
                            <td class="text-center"><span class="badge badge-danger"><i class="fas fa-times"></i></span></td>
                            <td class="text-center"><span class="badge badge-danger"><i class="fas fa-times"></i></span></td>
                        </tr>
                        <tr>
                            <td><strong>Pengaturan Sistem & Profil</strong></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                            <td class="text-center"><span class="badge badge-success"><i class="fas fa-check"></i></span></td>
                            <td class="text-center"><span class="badge badge-secondary"><i class="fas fa-minus"></i></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
