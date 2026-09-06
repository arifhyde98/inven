<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>

        <div class="section-body">
            <?php
            $total_transaksi = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $user['penempatan_cabang'], 'tanggal_ind' => date('d-m-Y')])->num_rows();
            $this->db->select_sum('total_pembayaran');
            $total_penjualan = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $user['penempatan_cabang'], 'tanggal_ind' => date('d-m-Y')])->row_array();
            $this->db->select_sum('pendapatan');
            $total_pendapatan = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $user['penempatan_cabang'], 'tanggal_ind' => date('d-m-Y')])->row_array();
            $tot_admin = $this->db->get_where('user', ['penempatan_cabang' => $user['penempatan_cabang'], 'role_id' => 2])->num_rows();
            ?>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-4">Laporan Penjualan Hari Ini - <?= date('d F Y') ?></h5>
                </div>
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
                                $bersih =  $total_pendapatan['pendapatan'];
                                ?>
                                Rp. <?= rupiah($bersih) ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php
                                    date_default_timezone_set('Asia/Jakarta');
                                    $wdate = date('d-m-Y', strtotime('monday this week'));
                                    $wdate_to = $wdate;
                                    $wdate_to = strtotime("+6 days", strtotime($wdate_to)); //-7 days for last week. -30 for last week
                                    $wdate_to = date("d-m-Y", $wdate_to);

                                    ?>
                                    <h4>
                                        Statistik Penjualan <?= $cabang['nama_cabang'] ?> <a href="<?= base_url('admin/statistik_penjualan/' . $user['penempatan_cabang']) ?>" title="Statistik Penjualan, Pendapatan, Pengeluaran" class="btn btn-success"><i class="fas fa-eye"></i> Statistik Lengkap</a>

                                        <p class="text-small font-weight-normal mb-0">Dari Tanggal : <?= $wdate ?> - <?= $wdate_to ?></p>
                                    </h4>

                                </div>
                                <div class="card-body">
                                    <canvas id="graphCanvas1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="jumbotron">
                        <h5>Nama Cabang : <?= $cb['nama_cabang'] ?></h5>
                        <p>Alamat Cabang : <b><?= $cb['alamat'] ?></b></p>
                        <hr class="my-4">
                        <p>Anda telah login sebagai <b><?= $user['nama'] ?></b></p>
                        <a class="btn btn-primary btn-lg" onclick="return confirm('Apakah anda yakin ?')" href="<?= base_url('admin/logout') ?>" role="button"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
            <div class="row">
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
                                    $qNya = "SELECT nama, sum(jumlah) as j  FROM semua_data_keranjang WHERE id_cabang = '$user[penempatan_cabang]' GROUP BY nama ORDER BY j DESC LIMIT 10";
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
                            Stok Hampir Habis ( < 8 )
                        </div>
                        <div class="card-body" style="height: 300px;overflow:scroll;">
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
                                    $qBarang = "SELECT * FROM barang WHERE id_cabang = '$user[penempatan_cabang]' AND stok < '8'  AND stok != '0' ORDER BY stok ASC";
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
                                                <a href="<?= base_url('admin/stok_barang') ?>" class="btn btn-sm btn-primary" title="Tambah stok"><i class="fas fa-plus"></i></a>
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
                                    $qBarang = "SELECT * FROM barang WHERE id_cabang = '$user[penempatan_cabang]' AND exp_date != ' ' ORDER BY exp_date ASC";
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
    </section>
</div>