<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-md-12">

                    <h5 class="mb-4">Laporan Penjualan Hari Ini - <?= date('d F Y') ?></h5>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <?php foreach ($cabang as $row) : ?>
                                <a class="nav-item nav-link <?= $row['id'] == 1 ? 'active' : '' ?>" id="nav-euy-<?= $row['id'] ?>" data-toggle="tab" href="#nav-<?= $row['id'] ?>" role="tab" aria-controls="nav-<?= $row['id'] ?>" aria-selected="<?= $row['id'] == 1 ? 'true' : '' ?>"><?= $row['nama_cabang'] ?></a>
                            <?php endforeach; ?>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <?php foreach ($cabang as $bar) : ?>
                            <?php
                            $total_barang = $this->db->query("SELECT count(id) as jum_barang FROM barang WHERE id_cabang = '$bar[id]'")->row_array();
                            $total_transaksi = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $bar['id'], 'tanggal_ind' => date('d-m-Y')])->num_rows();
                            $this->db->select_sum('total_pembayaran');
                            $total_penjualan = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $bar['id'], 'tanggal_ind' => date('d-m-Y')])->row_array();
                            $this->db->select_sum('pendapatan');
                            $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $bar['id'], 'tanggal_ind' => date('d-m-Y')])->row_array();
                            $tot_admin = $this->db->get_where('user', ['penempatan_cabang' => $bar['id'], 'role_id' => 2])->num_rows();
                            ?>
                            <div class="tab-pane fade <?= $bar['id'] == 1 ? 'show active' : '' ?>" id="nav-<?= $bar['id'] ?>" role="tabpanel" aria-labelledby="nav-euy-<?= $bar['id'] ?>">
                                <div class="row">

                                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-danger">
                                                <i class="fas fa-money-check"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Total Transaksi</h4>
                                                </div>
                                                <div class="card-body">
                                                    <?= $total_transaksi ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-primary">
                                                <i class="far fa-user"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Total Admin</h4>
                                                </div>
                                                <div class="card-body">
                                                    <?= $tot_admin ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-primary">
                                                <i class="fas fa-box"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Total Barang</h4>
                                                </div>
                                                <div class="card-body">
                                                    <?= $total_barang['jum_barang'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-primary">
                                                <i class="fas fa-money-bill"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Total Penjualan</h4>
                                                </div>
                                                <div class="card-body">
                                                    Rp. <?= rupiah($total_penjualan['total_pembayaran']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-warning">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Pendapatan</h4>
                                                </div>
                                                <div class="card-body">
                                                    <?php
                                                    $bersih = $total_pendapatan['pendapatan'];
                                                    ?>
                                                    Rp. <?= rupiah($bersih) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-warning">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Statistik</h4>
                                                </div>
                                                <div class="card-body">
                                                    <a href="<?= base_url('superadmin/statistik_penjualan/' . $bar['id']) ?>" title="Statistik Penjualan, Pendapatan, Pengeluaran" class="btn btn-success"><i class="fas fa-eye"></i> Lihat Statistik</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                Top 10 Barang Terlaris
                                            </div>
                                            <div class="card-body" style="height: 300px;overflow:scroll;">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Nama</th>
                                                            <th scope="col">Jumlah Terjual</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $qNya = "SELECT nama, sum(jumlah) as j  FROM semua_data_keranjang WHERE id_cabang = '$bar[id]' GROUP BY nama ORDER BY j DESC LIMIT 10";
                                                        $semua_data_keranjang = $this->db->query($qNya)->result_array();
                                                        ?>
                                                        <?php $no = 1;
                                                        foreach ($semua_data_keranjang as $rp) :

                                                        ?>
                                                            <tr>
                                                                <th><?= $no ?></th>
                                                                <td><?= $rp['nama'] ?></td>
                                                                <td><?= $rp['j'] ?></td>
                                                            </tr>
                                                        <?php $no++;
                                                        endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                Stok Hampir Habis ( < 5 ) </div> <div class="card-body" style="height: 300px;overflow:scroll;">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Nama</th>
                                                                <th scope="col">Jumlah Stok</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $qBarang = "SELECT * FROM barang WHERE id_cabang = '$bar[id]' AND stok < '5' ORDER BY stok ASC"; #AND stok != '0'
                                                            $dataBarang = $this->db->query($qBarang)->result_array();
                                                            ?>
                                                            <?php $no = 1;
                                                            foreach ($dataBarang as $dabar) :

                                                            ?>
                                                                <tr>
                                                                    <th><?= $no ?></th>
                                                                    <td><?= $dabar['nama_barang'] ?></td>
                                                                    <td><?= $dabar['stok'] ?></td>
                                                                    <td>
                                                                        <a href="<?= base_url('superadmin/stok_barang?idCabang=' . $bar['id']) ?>" class="btn btn-sm btn-primary" title="Tambah stok"><i class="fas fa-plus"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php $no++;
                                                            endforeach; ?>
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                Makanan & Minuman Hampir Kadaluarsa ( 2 Bulan Sebelum Kadaluarsa )
                                            </div>
                                            <div class="card-body" style="height: 300px;overflow:scroll;">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Nama</th>
                                                            <th scope="col">Tanggal Kadaluarsa</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $qBarang = "SELECT * FROM barang WHERE id_cabang = '$bar[id]' AND exp_date != ' ' ORDER BY exp_date ASC";
                                                        $dataBarang = $this->db->query($qBarang)->result_array();
                                                        ?>
                                                        <?php $no = 1;
                                                        foreach ($dataBarang as $dabar) :
                                                            $tt = $dabar['exp_date'];
                                                            $tgl = substr($tt, 0, 2);
                                                            $bln = substr($tt, 3, 2);
                                                            $thn = substr($tt, 6, 12);
                                                            $tgl_lengkap = $thn . "-" . $bln . "-" . $tgl;

                                                            $a = "SELECT DATE_ADD('$tgl_lengkap', INTERVAL -60 DAY) AS tomorow";
                                                            $a = $this->db->query($a)->row_array();
                                                            $rr =  $a['tomorow'];
                                                            $thn_baru = substr($rr, 0, 4);
                                                            $bln_baru = substr($rr, 4, 3);
                                                            $tgl_baru = substr($rr, 8, 9);
                                                            $tgl_lengkap_baru = $tgl_baru . "" . $bln_baru . "-" . $thn_baru;

                                                            $baru = "SELECT * FROM barang WHERE exp_date BETWEEN '$tgl_lengkap_baru' AND '$tgl_lengkap' AND id = '$dabar[id]'";
                                                            $baru = $this->db->query($baru)->result_array();
                                                        ?>
                                                            <?php foreach ($baru as $raw) : ?>
                                                                <tr>
                                                                    <td><?= $raw['nama_barang'] ?></td>
                                                                    <td><?= $raw['exp_date'] ?></td>

                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php $no++;
                                                        endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>

                </div>
                <div class="col-md-12 border-top mb-4"></div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jumlah Data Barang Berdasarkan Cabang</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="graphCanvas"></canvas>
                        </div>
                    </div>
                </div>



            </div>

        </div>
    </section>
</div>