<div class="card mb-4 shadow-sm border-0">
    <div class="card-body p-2">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link {{ $page == 'index' ? 'active' : '' }}" href="{{ route('dokumentasi.show', 'index') }}">
                    <i class="fas fa-book mr-1"></i> Instalasi & Sistem
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $page == 'penjelasan' ? 'active' : '' }}" href="{{ route('dokumentasi.show', 'penjelasan') }}">
                    <i class="fas fa-user-shield mr-1"></i> Hak Akses Role
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $page == 'pemesanan' ? 'active' : '' }}" href="{{ route('dokumentasi.show', 'pemesanan') }}">
                    <i class="fas fa-truck-loading mr-1"></i> Pemesanan Barang
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $page == 'jual_barang' ? 'active' : '' }}" href="{{ route('dokumentasi.show', 'jual_barang') }}">
                    <i class="fas fa-cash-register mr-1"></i> Penjualan (POS)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $page == 'cetak_barcode' ? 'active' : '' }}" href="{{ route('dokumentasi.show', 'cetak_barcode') }}">
                    <i class="fas fa-barcode mr-1"></i> Cetak Barcode
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $page == 'stok_opname' ? 'active' : '' }}" href="{{ route('dokumentasi.show', 'stok_opname') }}">
                    <i class="fas fa-clipboard-check mr-1"></i> Stok Opname
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $page == 'data_cicilan' ? 'active' : '' }}" href="{{ route('dokumentasi.show', 'data_cicilan') }}">
                    <i class="fas fa-file-invoice-dollar mr-1"></i> Data Cicilan
                </a>
            </li>
        </ul>
    </div>
</div>
