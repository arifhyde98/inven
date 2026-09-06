<?php
date_default_timezone_set('Asia/Jakarta');
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>
        <?= $this->session->flashdata('pesan') ?>
        <?php
        if (validation_errors()) :
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= validation_errors() ?>

            </div>
        <?php endif; ?>
        <div class="section-body">
            <div class="row">

                <div class="col-12">
                    <div class="card card-body bg-light">
                        <p>Filter berdasarkan hari</p>

                        <?php if (isset($_GET['idCabang'])) : ?>
                            <form method="get">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="hidden" name="idCabang" value="<?= $_GET['idCabang'] ?>">
                                        <input data-toggle="datepicker" value="<?= isset($_GET['awal']) ? $_GET['awal'] : '' ?>" name="awal" placeholder="Tanggal dari" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <input data-toggle="datepicker" name="akhir" value="<?= isset($_GET['akhir']) ? $_GET['akhir'] : '' ?>" placeholder="Tanggal ke" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary mt-1"><i class="fas fa-search"></i> Cari</button>
                                    </div>
                                </div>
                            </form>
                        <?php else : ?>
                            <form method="get">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input data-toggle="datepicker" value="<?= isset($_GET['awal']) ? $_GET['awal'] : '' ?>" name="awal" placeholder="Tanggal dari" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <input data-toggle="datepicker" name="akhir" value="<?= isset($_GET['akhir']) ? $_GET['akhir'] : '' ?>" placeholder="Tanggal ke" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary mt-1"><i class="fas fa-search"></i> Cari</button>
                                    </div>
                                </div>
                            </form>

                        <?php endif; ?>


                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <?php if ($user['role_id'] == 1) : ?>

                                    <?php
                                    if (isset($_GET['idCabang'])) {
                                        $tempat = $_GET['idCabang'];
                                        $p = $this->db->get_where('data_cabang', ['id' => $tempat])->row_array();
                                        echo "Laporan Penjualan " . $p['nama_cabang'];
                                    } else {
                                        echo "Laporan Penjualan Semua Cabang";
                                    }
                                    ?>
                                    <a href="<?= base_url('superadmin/laporan_penjualan') ?>" class="btn btn-success mb-1 mr-1"><i class="fas fa-arrow-left"></i> Kembali</a>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/laporan_penjualan_hari') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/laporan_penjualan_hari') ?>?idCabang=<?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    Laporan Penjualan Barang : <?= $p['nama_cabang'] ?>
                                <?php endif; ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th width="30" class="text-center">
                                                No
                                            </th>
                                            <th>Tanggal</th>
                                            <th>Total Barang</th>
                                            <th>Total Pembayaran</th>
                                            <th>Uang</th>
                                            <th>Kembalian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['idCabang'])) :
                                            $tempat = $_GET['idCabang'];
                                            $data_penjualan_tempat = $this->db->get_where('riwayat_penjualan', ['id_cabang' => $tempat])->result_array();
                                        ?>
                                            <?php if (isset($_GET['idCabang']) && $_GET['awal']) :
                                                $awal = $_GET['awal'];
                                                $akhir = $_GET['akhir'];
                                                $asd = $_GET['idCabang'];
                                                $query = "SELECT * FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$awal' AND '$akhir' AND id_cabang = '$asd'";
                                                $data_penjualan_tgl = $this->db->query($query)->result_array();
                                            ?>
                                                <?php $no = 1;
                                                foreach ($data_penjualan_tgl as $dp) :
                                                    $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $dp['id_keranjang']])->num_rows();
                                                    $this->db->select_sum('total_pembayaran');
                                                    $penjualan_kotor = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind']])->row_array();
                                                ?>

                                                    <tr>
                                                        <td class="text-center">
                                                            <?= $no ?>
                                                        </td>
                                                        <td>
                                                            <?= date('d-m-Y  H:i', $dp['tanggal']) ?>
                                                        </td>
                                                        <td>
                                                            <?= $a ?>
                                                        </td>
                                                        <td>
                                                            Rp. <?= rupiah($dp['total_pembayaran']) ?>
                                                        </td>
                                                        <td>
                                                            Rp. <?= rupiah($dp['uang']) ?>
                                                        </td>
                                                        <td>
                                                            Rp. <?= rupiah($dp['kembalian']) ?>
                                                        </td>


                                                        <td>
                                                            <div class="btn-group-horizontal text-center">
                                                                <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_<?= $dp['id'] ?>"><i class="fas fa-eye"></i> Detail</button>
                                                                <?php if ($user['role_id'] == 1) : ?>
                                                                    <a href="<?= base_url('superadmin/cetak_data_penjualan/' . $dp['id_pembelian']) ?>" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
                                                                <?php elseif ($user['role_id'] == 2) : ?>
                                                                    <a href="<?= base_url('admin/cetak_data_penjualan/' . $dp['id_pembelian']) ?>" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php $no++;
                                                endforeach; ?>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php if (isset($_GET['awal'])) :
                                                $awal = $_GET['awal'];
                                                $akhir = $_GET['akhir'];
                                                $query = "SELECT * FROM riwayat_penjualan WHERE tanggal_ind BETWEEN '$awal' AND '$akhir'";
                                                $data_penjualan_tgl = $this->db->query($query)->result_array();
                                            ?>
                                                <?php $no = 1;
                                                foreach ($data_penjualan_tgl as $dp) :
                                                    $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $dp['id_keranjang']])->num_rows();
                                                    $this->db->select_sum('total_pembayaran');
                                                    $penjualan_kotor = $this->db->get_where('riwayat_penjualan', ['tanggal_ind' => $dp['tanggal_ind']])->row_array();
                                                ?>

                                                    <tr>
                                                        <td class="text-center">
                                                            <?= $no ?>
                                                        </td>
                                                        <td>
                                                            <?= date('d-m-Y  H:i', $dp['tanggal']) ?>
                                                        </td>
                                                        <td>
                                                            <?= $a ?>
                                                        </td>
                                                        <td>
                                                            Rp. <?= rupiah($dp['total_pembayaran']) ?>
                                                        </td>
                                                        <td>
                                                            Rp. <?= rupiah($dp['uang']) ?>
                                                        </td>
                                                        <td>
                                                            Rp. <?= rupiah($dp['kembalian']) ?>
                                                        </td>


                                                        <td>
                                                            <div class="btn-group-horizontal text-center">
                                                                <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_<?= $dp['id'] ?>"><i class="fas fa-eye"></i> Detail</button>
                                                                <?php if ($user['role_id'] == 1) : ?>
                                                                    <a href="<?= base_url('superadmin/cetak_data_penjualan/' . $dp['id_pembelian']) ?>" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
                                                                <?php elseif ($user['role_id'] == 2) : ?>
                                                                    <a href="<?= base_url('admin/cetak_data_penjualan/' . $dp['id_pembelian']) ?>" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php $no++;
                                                endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
</div>

<?php foreach ($data_penjualan as $daTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalUbahSiswa_<?= $daTwo['id'] ?>">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Pembelian Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <?php
                    $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $daTwo['id_keranjang']])->num_rows();
                    $b = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $daTwo['id_keranjang']])->result_array();
                    ?>
                    <p>ID Pembelian : <?= $daTwo['id_pembelian'] ?></p>
                    <p>Total Barang : <?= $a ?></p>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Harga Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($b as $barang) : ?>
                                        <tr>
                                            <td><?= $barang['nama'] ?></td>
                                            <td><?= $barang['jumlah'] ?> <?= $barang['satuan'] ?></td>
                                            <td><?= rupiah($barang['harga']) ?></td>
                                            <td><?= rupiah($barang['harga_total']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" align="right">Subtotal Harga</td>
                                        <td>Rp. <?= rupiah($daTwo['total_pembayaran']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>