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
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <h4>
                                    <?php if ($user['role_id'] == 1) : ?>

                                        <?php
                                        if (isset($_GET['idCabang'])) {
                                            $tempat = $_GET['idCabang'];
                                            $p = $this->db->get_where('data_cabang', ['id' => $tempat])->row_array();
                                            echo "Laporan Stok " . $p['nama_cabang'];
                                        } else {
                                            echo "Laporan Stok Semua Cabang";
                                        }
                                        ?>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Kategori Cabang
                                            </button>
                                            <div class="dropdown-menu mb-1" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= base_url('superadmin/laporan_stok') ?>">Semua</a>
                                                <?php foreach ($data_cabang as $dac) : ?>
                                                    <a class="dropdown-item" href="<?= base_url('superadmin/laporan_stok') ?>?idCabang=<?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php if (isset($_GET['idCabang'])) :
                                                $tempat = $_GET['idCabang'];
                                            ?>
                                                <a href="<?= base_url('cetak/laporan_stok_c?idCabang=' . $tempat) ?>" target="_blank" class="btn btn-sm btn-info mt-2"><i class="fas fa-print"></i> Cetak Semua</a>
                                                <a href="<?= base_url('export/excel_laporan_stok_c/' . $tempat) ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                            <?php else : ?>
                                                <a href="<?= base_url('cetak/laporan_stok') ?>" target="_blank" class="btn btn-sm btn-info mt-2"><i class="fas fa-print"></i> Cetak Semua</a>
                                                <a href="<?= base_url('export/excel_laporan_stok') ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif ($user['role_id'] == 2) :
                                        $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                        Laporan Stok Barang : <?= $p['nama_cabang'] ?>
                                        <a href="<?= base_url('cetak/laporan_stok_c?idCabang=' . $user['penempatan_cabang']) ?>" target="_blank" class="btn btn-sm btn-info mt-2"><i class="fas fa-print"></i> Cetak Semua</a>
                                        <a href="<?= base_url('export/excel_laporan_stok_c/'.$user['penempatan_cabang']) ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>

                                    <?php endif; ?>
                                </h4>
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
                                            <th>Nama Barang</th>
                                            <th>Tanggal</th>
                                            <th>Expired</th>
                                            <th>Masuk</th>
                                            <th>Keluar</th>
                                            <th>Stok Akhir</th>
                                            <th>Cabang</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['idCabang'])) :
                                            $tempat = $_GET['idCabang'];
                                            $this->db->order_by('id', 'desc');
                                            $data_barang_tempat = $this->db->get_where('barang', ['id_cabang' => $tempat])->result_array();
                                        ?>
                                            <?php $no = 1;
                                            foreach ($data_barang_tempat as $db) :
                                                $cabang = $this->db->get_where('data_cabang', ['id' => $db['id_cabang']])->row_array();
                                                $this->db->select_sum('jumlah');
                                                $pemasukan = $this->db->get_where('stok_barang', ['id_barang' => $db['id'], 'status' => 1])->row_array();
                                                $this->db->select_sum('jumlah');
                                                $keluar = $this->db->get_where('stok_barang', ['id_barang' => $db['id'], 'status' => 2])->row_array();
                                                $qTgl = $this->db->get_where('stok_barang', ['id_barang' => $db['id']])->row_array();
                                            ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $db['nama_barang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= date('d F Y', $qTgl['tgl']) ?>
                                                    </td>
                                                    <td>
                                                        
                                                        <?= $db['exp_date'] == 0 ? "-" : $db['exp_date'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $pemasukan['jumlah'] ?> <?= $db['satuan'] ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($keluar['jumlah'] == 0) : ?>
                                                            0
                                                        <?php else : ?>
                                                            <?= $keluar['jumlah'] ?> <?= $db['satuan'] ?>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td>
                                                        <b><?= $db['stok'] ?> <?= $db['satuan'] ?></b>
                                                    </td>
                                                    <td>
                                                        <?= $cabang['nama_cabang'] ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= $user['role_id'] == 1 ? base_url('cetak/detail_stok/' . $db['id']) : base_url('cetak/detail_stok/' . $db['id']) ?>" target="_blank" title="Cetak Detail Stok" class="btn btn-sm btn-info"><i class="fas fa-print"></i></a>

                                                        <a href="<?= $user['role_id'] == 1 ? base_url('export/excel_detail_stok/' . $db['id']) : base_url('export/excel_detail_stok') ?>" target="_blank" class="btn btn-outline-warning btn-sm" title="Export Ke Excel Detail Stok"><i class="fas fa-file-excel"></i></a>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        <?php else : ?>
                                            <?php $no = 1;
                                            foreach ($data_barang as $db) :
                                                $cabang = $this->db->get_where('data_cabang', ['id' => $db['id_cabang']])->row_array();
                                                $this->db->select_sum('jumlah');
                                                $pemasukan = $this->db->get_where('stok_barang', ['id_barang' => $db['id'], 'status' => 1])->row_array();
                                                $this->db->select_sum('jumlah');
                                                $keluar = $this->db->get_where('stok_barang', ['id_barang' => $db['id'], 'status' => 2])->row_array();
                                                $qTgl = $this->db->get_where('stok_barang', ['id_barang' => $db['id']])->row_array();
                                            ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $db['nama_barang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= date('d F Y', $qTgl['tgl']) ?>
                                                    </td>
                                                    <td>
                                                        
                                                        <?= $db['exp_date'] == 0 ? "-" : $db['exp_date'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $pemasukan['jumlah'] ?> <?= $db['satuan'] ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($keluar['jumlah'] == 0) : ?>
                                                            0
                                                        <?php else : ?>
                                                            <?= $keluar['jumlah'] ?> <?= $db['satuan'] ?>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td>
                                                        <b><?= $db['stok'] ?> <?= $db['satuan'] ?></b>
                                                    </td>
                                                    <td>
                                                        <?= $cabang['nama_cabang'] ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= $user['role_id'] == 1 ? base_url('cetak/detail_stok/' . $db['id']) : base_url('cetak/detail_stok/' . $db['id']) ?>" target="_blank" title="Cetak Detail Stok" class="btn btn-sm btn-info"><i class="fas fa-print"></i></a>
                                                        <a href="<?= $user['role_id'] == 1 ? base_url('export/excel_detail_stok/' . $db['id']) : base_url('export/excel_detail_stok/' . $db['id']) ?>" target="_blank" class="btn btn-outline-warning btn-sm" title="Export Ke Excel Detail Stok"><i class="fas fa-file-excel"></i></a>

                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
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