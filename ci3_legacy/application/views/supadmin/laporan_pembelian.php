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
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <?php if ($user['role_id'] == 1) : ?>

                                    <?php
                                        if (isset($_GET['idCabang'])) {
                                            $tempat = $_GET['idCabang'];
                                            $p = $this->db->get_where('data_cabang', ['id' => $tempat])->row_array();
                                            echo "Laporan Pembelian " . $p['nama_cabang'];
                                        } else {
                                            echo "Laporan Pembelian Semua Cabang";
                                        }
                                        ?>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/laporan_pembelian') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/laporan_pembelian') ?>?idCabang=<?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    Laporan Pembelian Barang : <?= $p['nama_cabang'] ?>
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
                                            <th>Kode</th>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Total</th>
                                            <th>Suplier</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['idCabang'])) :
                                            $tempat = $_GET['idCabang'];
                                            $data_pembelian_tempat = $this->db->get_where('riwayat_pembelian', ['id_cabang' => $tempat])->result_array();
                                            ?>
                                            <?php $no = 1;
                                                foreach ($data_pembelian_tempat as $dp) :
                                                    $a = $this->db->get_where('suplier', ['id_suplier' => $dp['id_suplier']])->row_array();
                                                    ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $dp['kode_pembelian'] ?>
                                                    </td>
                                                    <td>
                                                        <?= date('d-m-Y', $dp['tanggal']) ?>
                                                    </td>

                                                    <td>
                                                        <?= $dp['nama_barang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['jumlah'] ?> <?= $dp['satuan'] ?>
                                                    </td>
                                                    <td>
                                                        Rp. <?= rupiah($dp['harga_beli']) ?>
                                                    </td>
                                                    <td>
                                                        Rp. <?= rupiah($dp['harga_total']) ?>
                                                    </td>
                                                    <td>
                                                        <?= $a['nama_suplier'] ?>
                                                    </td>


                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <a href="<?= base_url('superadmin/cetak_data_pembelian/' . $dp['kode_pembelian']) ?>" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                                endforeach; ?>
                                        <?php else : ?>
                                            <?php $no = 1;
                                                foreach ($data_pembelian as $dp) :
                                                    $a = $this->db->get_where('suplier', ['id_suplier' => $dp['id_suplier']])->row_array();
                                                    ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $dp['kode_pembelian'] ?>
                                                    </td>
                                                    <td>
                                                        <?= date('d-m-Y', $dp['tanggal']) ?>
                                                    </td>

                                                    <td>
                                                        <?= $dp['nama_barang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['jumlah'] ?> <?= $dp['satuan'] ?>
                                                    </td>
                                                    <td>
                                                        Rp. <?= rupiah($dp['harga_beli']) ?>
                                                    </td>
                                                    <td>
                                                        Rp. <?= rupiah($dp['harga_total']) ?>
                                                    </td>
                                                    <td>
                                                        <?= $a['nama_suplier'] ?>
                                                    </td>


                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <?php if ($user['role_id'] == 1) : ?>
                                                                <a href="<?= base_url('superadmin/cetak_data_pembelian/' . $dp['kode_pembelian']) ?>" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
                                                            <?php elseif ($user['role_id'] == 2) : ?>
                                                                <a href="<?= base_url('admin/cetak_data_pembelian/' . $dp['kode_pembelian']) ?>" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="fas fa-print"></i></a>
                                                            <?php endif; ?>
                                                        </div>
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