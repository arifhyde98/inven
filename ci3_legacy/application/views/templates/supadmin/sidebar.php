<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= base_url('superadmin') ?>">JInventory</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url('superadmin') ?>">JC</a>
        </div>
        <ul class="sidebar-menu">

            <li class="menu-header">Main Menu</li>
            <li class="<?= $title == "Dashboard" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin') ?>"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>

            <?php if (isset($main_title)) : ?>
                <li class="dropdown <?= $main_title == "Pemesanan" ? 'active' : '' ?>">
                <?php else : ?>
                <li class="dropdown">
                <?php endif; ?>
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-money-bill"></i> <span>Pemesanan</span></a>
                <ul class="dropdown-menu">
                    <li class="<?= $title == "Pesan Barang" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/pesan_barang') ?>">Pesan Barang</a></li>
                    <li class="<?= $title == "Pesan Stok Barang" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/pesan_stok_barang') ?>">Pesan Stok Barang</a></li>
                    <li class="<?= $title == "Data Pesanan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/data_pesanan') ?>">Data Pesanan</a></li>
                    <li class="<?= $title == "Data Pengeluaran" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/data_pengeluaran') ?>">Data Pengeluaran</a></li>
                </ul>
                </li>
                <li class="<?= $title == "Jual Barang" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/jual_barang') ?>"><i class="fas fa-store-alt"></i><span>Jual Barang</span></a></li>
                <li class="<?= $title == "Cetak Barcode" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/cetak_barcode') ?>"><i class="fas fa-barcode"></i><span>Cetak Barcode</span></a></li>

                <?php if (isset($main_title)) : ?>
                    <li class="dropdown <?= $main_title == "Barang" ? 'active' : '' ?>">
                    <?php else : ?>
                    <li class="dropdown">
                    <?php endif; ?>
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i> <span>Barang</span></a>
                    <ul class="dropdown-menu">
                        <li class="<?= $title == "Data Barang" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/barang') ?>"><span>Data Barang</span></a></li>
                        <li class="<?= $title == "Stok Barang" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/stok_barang') ?>"><span>Stok Barang</span></a></li>
                        <li class="<?= $title == "Log In Out" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/log_in_out') ?>"><span>Log In / Out</span></a></li>
                        <li class="<?= $title == "Stok Opname" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/stok_opname') ?>"><span>Stok Opname</span></a></li>
                        <li class="<?= $title == "Kategori Barang" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/kategori_barang') ?>"><span>Kategori Barang</span></a></li>
                        <li class="<?= $title == "Satuan Barang" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/satuan_barang') ?>"><span>Satuan Barang</span></a></li>
                    </ul>
                    </li>
                    <li class="<?= $title == "Suplier" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/suplier') ?>"><i class="fas fa-user-friends"></i><span>Suplier</span></a></li>
                    <li class="<?= $title == "Data Admin" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/admin') ?>"><i class="fas fa-user"></i><span>Data Admin</span></a></li>
                    <li class="<?= $title == "Data User" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/data_user') ?>"><i class="fas fa-user-friends"></i><span>Data User</span></a></li>
                    <li class="<?= $title == "Data Cabang" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/data_cabang') ?>"><i class="fas fa-home"></i><span>Data Cabang</span></a></li>

                    <?php if (isset($main_title)) : ?>
                        <li class="dropdown <?= $main_title == "Cicilan" ? 'active' : '' ?>">
                        <?php else : ?>
                        <li class="dropdown">
                        <?php endif; ?>
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-journal-whills"></i> <span>Cicilan</span></a>
                        <ul class="dropdown-menu">
                            <li class="<?= $title == "Data Cicilan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/data_cicilan') ?>">Data Cicilan</a></li>
                            <li class="<?= $title == "Log Cicilan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/log_cicilan') ?>">Log Cicilan</a></li>

                        </ul>
                        </li>
                        <?php if (isset($main_title)) : ?>
                            <li class="dropdown <?= $main_title == "Laporan" ? 'active' : '' ?>">
                            <?php else : ?>
                            <li class="dropdown">
                            <?php endif; ?>
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-chart-line"></i> <span>Laporan</span></a>
                            <ul class="dropdown-menu">
                                <li class="<?= $title == "History Penjualan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/history_penjualan') ?>">History Penjualan</a></li>
                                <li class="<?= $title == "Laporan Penjualan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/laporan_penjualan') ?>">Laporan Penjualan Hari</a></li>
                                <li class="<?= $title == "Laporan Penjualan Bulan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/laporan_penjualan_bulan') ?>">Laporan Penjualan Bulan</a></li>
                                <li class="<?= $title == "History Pengeluaran" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/history_pengeluaran') ?>">History Pengeluaran</a></li>
                                <li class="<?= $title == "Laporan Pengeluaran" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/laporan_pengeluaran') ?>">Laporan Pengeluaran Hari</a></li>
                                <li class="<?= $title == "Laporan Pengeluaran Bulan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/laporan_pengeluaran_bulan') ?>">Laporan Pengeluaran Bulan</a></li>
                                <li class="<?= $title == "Laporan Stok" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/laporan_stok') ?>">Laporan Stok</a></li>
                            </ul>
                            </li>

                            <li class="menu-header">Lainnya</li>
                            <?php if ($user['role_id'] == 1) : ?>
                                <li class="<?= $title == "Pengaturan" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/pengaturan_umum') ?>"><i class="fas fa-cog"></i><span>Pengaturan</span></a></li>
                            <?php endif; ?>
                            <li class="<?= $title == "Profile" ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('superadmin/profile') ?>"><i class="fas fa-user"></i><span>Profile</span></a></li>
                            <li><a class="nav-link" target="_blank" href="<?= base_url('dokumentasi') ?>"><i class="fas fa-file"></i><span>Dokumentasi</span></a></li>
                            <li><a class="nav-link btn-logout" href="<?= base_url('superadmin/logout') ?>"><i class="fas fa-sign-out-alt"></i><span>Keluar</span></a></li>

        </ul>
    </aside>
</div>