<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') &mdash; {{ \App\Models\PengaturanUmum::first()->title ?? 'JInventory' }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/profiles/' . (\App\Models\PengaturanUmum::first()->favicon ?? 'default.png')) }}" type="image/x-icon">

    @stack('styles')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    </ul>
                    <div class="text-white font-weight-600 d-none d-md-inline-block">
                        <i class="fas fa-store-alt mr-1"></i>
                        {{ auth()->user()->isSuperAdmin() ? 'Kantor Pusat / Semua Cabang' : (auth()->user()->cabang->nama_cabang ?? 'Cabang') }}
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{ asset('assets/images/profiles/' . (auth()->user()->foto_profile ?? 'default.png')) }}" class="rounded-circle mr-1" style="width: 30px; height: 30px; object-fit: cover;">
                        <div class="d-sm-none d-lg-inline-block">Halo, {{ auth()->user()->nama ?? auth()->user()->username }}</div></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">{{ auth()->user()->isSuperAdmin() ? 'Super Admin' : 'Admin Cabang' }}</div>
                            <a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profil Saya
                            </a>
                            @if(auth()->user()->isSuperAdmin())
                            <a href="{{ route('pengaturan.index') }}" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Pengaturan
                            </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item has-icon text-danger border-0 bg-transparent" style="cursor: pointer;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route('dashboard') }}">{{ \App\Models\PengaturanUmum::first()->title ?? 'JInventory' }}</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ route('dashboard') }}">JX</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard & Transaksi</li>
                        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="{{ request()->routeIs('pos.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('pos.index') }}"><i class="fas fa-cash-register"></i> <span>Kasir / POS</span></a>
                        </li>
                        <li class="{{ request()->routeIs('cicilan.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('cicilan.index') }}"><i class="fas fa-file-invoice-dollar"></i> <span>Data Cicilan / Piutang</span></a>
                        </li>

                        <li class="menu-header">Inventaris & Stok</li>
                        <li class="dropdown {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-boxes"></i> <span>Master Barang</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ request()->routeIs('barang.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('barang.index') }}">Daftar Barang</a></li>
                                <li class="{{ request()->routeIs('barang.create') ? 'active' : '' }}"><a class="nav-link" href="{{ route('barang.create') }}">Tambah Barang</a></li>
                                <li class="{{ request()->routeIs('barang.barcode') ? 'active' : '' }}"><a class="nav-link" href="{{ route('barang.barcode') }}">Cetak Barcode</a></li>
                                <li class="{{ request()->routeIs('barang.log_in_out') ? 'active' : '' }}"><a class="nav-link" href="{{ route('barang.log_in_out') }}">Log Stok In / Out</a></li>
                            </ul>
                        </li>
                        <li class="{{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('pesanan.index') }}"><i class="fas fa-truck-loading"></i> <span>Pesanan / Pembelian</span></a>
                        </li>
                        <li class="{{ request()->routeIs('stok-opname.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('stok-opname.index') }}"><i class="fas fa-clipboard-check"></i> <span>Stok Opname</span></a>
                        </li>
                        <li class="{{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('pengeluaran.index') }}"><i class="fas fa-money-bill-wave"></i> <span>Biaya Pengeluaran</span></a>
                        </li>

                        <li class="menu-header">Laporan & Pelanggan</li>
                        <li class="dropdown {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-chart-line"></i> <span>Laporan</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ request()->routeIs('laporan.penjualan_harian') ? 'active' : '' }}"><a class="nav-link" href="{{ route('laporan.penjualan_harian') }}">Penjualan Harian</a></li>
                                <li class="{{ request()->routeIs('laporan.penjualan_bulanan') ? 'active' : '' }}"><a class="nav-link" href="{{ route('laporan.penjualan_bulanan') }}">Penjualan Bulanan</a></li>
                                <li class="{{ request()->routeIs('laporan.stok') ? 'active' : '' }}"><a class="nav-link" href="{{ route('laporan.stok') }}">Laporan Stok</a></li>
                            </ul>
                        </li>
                        <li class="{{ request()->routeIs('customer.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('customer.index') }}"><i class="fas fa-address-book"></i> <span>Pelanggan Tetap</span></a>
                        </li>

                        @if(auth()->user()->isSuperAdmin())
                        <li class="menu-header">Super Admin Area</li>
                        <li class="{{ request()->routeIs('cabang.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('cabang.index') }}"><i class="fas fa-store"></i> <span>Data Cabang</span></a>
                        </li>
                        <li class="{{ request()->routeIs('suplier.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('suplier.index') }}"><i class="fas fa-truck"></i> <span>Supplier</span></a>
                        </li>
                        <li class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kategori.index') }}"><i class="fas fa-tags"></i> <span>Kategori Barang</span></a>
                        </li>
                        <li class="{{ request()->routeIs('satuan.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('satuan.index') }}"><i class="fas fa-balance-scale"></i> <span>Satuan Barang</span></a>
                        </li>
                        <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-users-cog"></i> <span>Kelola Admin Cabang</span></a>
                        </li>
                        <li class="{{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('pengaturan.index') }}"><i class="fas fa-cogs"></i> <span>Pengaturan Toko</span></a>
                        </li>
                        @endif

                        <li class="menu-header">Bantuan</li>
                        <li class="{{ request()->routeIs('dokumentasi') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dokumentasi') }}"><i class="fas fa-book"></i> <span>Dokumentasi Sistem</span></a>
                        </li>
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>@yield('title', 'Dashboard')</h1>
                        <div class="section-header-breadcrumb">
                            @yield('breadcrumb')
                        </div>
                    </div>

                    <div class="section-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    <ul class="mb-0 pl-3">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    {{ \App\Models\PengaturanUmum::first()->footer ?? 'Copyright &copy; 2026 Joona InventoryX' }}
                </div>
                <div class="footer-right">
                    Laravel Edition v12.69
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraries -->
    <script src="{{ asset('assets/modules/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if(session('success'))
            iziToast.success({
                title: 'Berhasil',
                message: "{{ session('success') }}",
                position: 'topRight'
            });
        @endif

        @if(session('error'))
            iziToast.error({
                title: 'Gagal',
                message: "{{ session('error') }}",
                position: 'topRight'
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
