<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= base_url('admin') ?>">Dokumentasi<sup></sup></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url('admin') ?>">JC</a>
        </div>
        <ul class="sidebar-menu">

            <li class="<?= $title == "Dokumentasi" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('dokumentasi') ?>"><i class="fas fa-book"></i><span>Dokumentasi</span></a></li>
            <li class="<?= $title == "Penjelasan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('dokumentasi/penjelasan') ?>"><i class="fas fa-comment"></i><span>Penjelasan</span></a></li>
            <li class="<?= $title == "Pemesanan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('dokumentasi/pemesanan') ?>"><i class="fas fa-money-bill"></i><span>Pemesanan</span></a></li>
            <li class="<?= $title == "Jual Barang" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('dokumentasi/jual_barang') ?>"><i class="fas fa-store-alt"></i><span>Jual Barang</span></a></li>
            <li class="<?= $title == "Cetak Barcode" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('dokumentasi/cetak_barcode') ?>"><i class="fas fa-barcode"></i><span>Cetak Barcode</span></a></li>
            <li class="<?= $title == "Stok Opname" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('dokumentasi/stok_opname') ?>"><i class="fas fa-box"></i><span>Stok Opname</span></a></li>
            <li class="<?= $title == "Data Cicilan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('dokumentasi/data_cicilan') ?>"><i class="fas fa-book"></i><span>Data Cicilan</span></a></li>
            <li class="<?= $title == "" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('goadmin') ?>"><i class="fas fa-arrow-left"></i><span>Kembali</span></a></li>

        </ul>
    </aside>
</div>