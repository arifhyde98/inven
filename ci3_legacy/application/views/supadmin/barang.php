<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>
        <div id="text-flash" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>
        <div id="tipe-flash" data-tipe="<?= $this->session->flashdata('tipe'); ?>"></div>
        <div id="status-flash" data-status="<?= $this->session->flashdata('status'); ?>"></div>
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
                                <?php if ($user['role_id'] == 1) : ?>
                                    <a href="<?= base_url('superadmin/tambah_barang') ?>" class="btn btn-primary mb-2"><i class="fas fa-plus"></i> Tambah Data</a>
                                    <button type="button" onclick="location.reload()" class="btn btn-outline-success mb-2"><i class="fas fa-redo-alt"></i> Refresh</button>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/barang') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/barang') ?>?idCabang=<?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if (isset($_GET['idCabang'])) : $cab = $_GET['idCabang'] ?>
                                            <a href="<?= base_url('export/excel_data_barang_c/' . $cab) ?>" target="_blank" class="btn btn-outline-warning btn-sm" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php else : ?>
                                            <a href="<?= base_url('export/excel_data_barang') ?>" target="_blank" class="btn btn-outline-warning btn-sm" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php endif; ?>

                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array();
                                ?>
                                    Data Barang <?= $p['nama_cabang'] ?><br>
                                    <a href="<?= base_url('admin/tambah_barang') ?>" class="btn btn-primary mb-2"><i class="fas fa-plus"></i> Tambah Data</a>
                                    <a href="<?= base_url('export/excel_data_barang ') ?>" target="_blank" class="btn btn-outline-warning mb-2 btn-sm" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>

                                <?php endif; ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Profit</th>
                                            <th>Stok</th>
                                            <th>Tempat</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if (isset($_GET['idCabang'])) :
                                        $tempat = $_GET['idCabang'];
                                        $this->db->order_by('id', 'desc');
                                        $data_barang_tempat = $this->db->get_where('barang', ['id_cabang' => $tempat])->result_array();
                                    ?>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($data_barang_tempat as $db) :
                                                $penempatan = $this->db->get_where('data_cabang', ['id' => $db['id_cabang']])->row_array()
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $db['barcode'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $db['nama_barang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $db['kategori'] ?>
                                                    </td>
                                                    <td>
                                                        Rp. <?= Rupiah($db['harga_beli']) ?>
                                                    </td>
                                                    <td>
                                                        Rp. <?= Rupiah($db['harga_jual']) ?>
                                                    </td>
                                                    <td>
                                                        Rp. <?= Rupiah($db['profit']) ?>
                                                    </td>
                                                    <td>
                                                        <?= $db['stok'] ?> <?= $db['satuan'] ?> -
                                                        <?php if ($db['stok'] == 0) : ?>
                                                            <a href="<?= base_url('superadmin/stok_barang') ?>" title="Tambah stok" class="btn btn-sm btn-outline-dark"><i class="fas fa-plus"></i></a>
                                                        <?php else : ?>
                                                            <a href="<?= base_url('superadmin/stok_barang') ?>" title="Lihat detail stok" class="btn btn-sm btn-outline-dark"><i class="fas fa-eye"></i></a>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td>
                                                        <?= $penempatan['nama_cabang'] ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <a href="<?= base_url('superadmin/detail_barang/' . $db['id']) ?>" title="Lihat detail barang" class="btn btn-success btn-sm mb-1"><i class="fas fa-eye"></i></a>
                                                            <a href="<?= base_url('superadmin/ubah_barang/' . $db['id']) ?>" title="Ubah barang" class="btn btn-warning btn-sm mb-1"><i class="fas fa-pen"></i></a>
                                                            <a href="<?= base_url('superadmin/hapus_barang/' . $db['id']) ?>" class="btn custom-hapus-alert btn-danger btn-sm mb-1" data-ctexta="Data barang serta riwayat stok akan ikut terhapus. Apakah anda yakin ?" title="Hapus"><i class="fas fa-trash"></i></a>
                                                            <a href="<?= base_url('superadmin/cetak_barcode?barcode=' . $db['barcode']) ?>" class="btn btn-info btn-sm mb-1" title="Cetak Barcode"><i class="fas fa-barcode"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        </tbody>
                                    <?php else : ?>
                                        <?php $no = 1;
                                        foreach ($data_barang as $db) :
                                            $penempatan = $this->db->get_where('data_cabang', ['id' => $db['id_cabang']])->row_array()
                                        ?>

                                            <tr>
                                                <td>
                                                    <?= $no ?>
                                                </td>
                                                <td>
                                                    <?= $db['barcode'] ?>
                                                </td>
                                                <td>
                                                    <?= $db['nama_barang'] ?>
                                                </td>
                                                <td>
                                                    <?= $db['kategori'] ?>
                                                </td>
                                                <td>
                                                    Rp. <?= Rupiah($db['harga_beli']) ?>
                                                </td>
                                                <td>
                                                    Rp. <?= Rupiah($db['harga_jual']) ?>
                                                </td>
                                                <td>
                                                    Rp. <?= Rupiah($db['profit']) ?>
                                                </td>
                                                <?php if ($user['role_id'] == 1) : ?>
                                                    <td>
                                                        <?= $db['stok'] ?> <?= $db['satuan'] ?> -
                                                        <?php if ($db['stok'] == 0) : ?>
                                                            <a href="<?= base_url('superadmin/stok_barang') ?>" title="Tambah stok" class="btn btn-sm btn-outline-dark"><i class="fas fa-plus"></i></a>
                                                        <?php else : ?>
                                                            <a href="<?= base_url('superadmin/stok_barang') ?>" title="Lihat detail stok" class="btn btn-sm btn-outline-dark"><i class="fas fa-eye"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php elseif ($user['role_id'] == 2) : ?>
                                                    <td>
                                                        <?= $db['stok'] ?> <?= $db['satuan'] ?> -
                                                        <?php if ($db['stok'] == 0) : ?>
                                                            <a href="<?= base_url('admin/stok_barang') ?>" title="Tambah stok" class="btn btn-sm btn-outline-dark"><i class="fas fa-plus"></i></a>
                                                        <?php else : ?>
                                                            <a href="<?= base_url('admin/stok_barang') ?>" title="Lihat detail stok" class="btn btn-sm btn-outline-dark"><i class="fas fa-eye"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <?= $penempatan['nama_cabang'] ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group-horizontal text-center">
                                                        <?php if ($user['role_id'] == 1) : ?>
                                                            <a href="<?= base_url('superadmin/detail_barang/' . $db['id']) ?>" title="Lihat detail barang" class="btn btn-success btn-sm mb-1"><i class="fas fa-eye"></i></a>
                                                            <a href="<?= base_url('superadmin/ubah_barang/' . $db['id']) ?>" title="Ubah barang" class="btn btn-warning btn-sm mb-1"><i class="fas fa-pen"></i></a>
                                                            <a href="<?= base_url('superadmin/hapus_barang/' . $db['id']) ?>" class="btn custom-hapus-alert btn-danger btn-sm mb-1" data-ctexta="Data barang serta riwayat stok akan ikut terhapus" title="Hapus"><i class="fas fa-trash"></i></a>
                                                            <a href="<?= base_url('superadmin/cetak_barcode?barcode=' . $db['barcode']) ?>" class="btn btn-info btn-sm mb-1" title="Cetak Barcode"><i class="fas fa-barcode"></i></a>
                                                        <?php else : ?>
                                                            <a href="<?= base_url('admin/detail_barang/' . $db['id']) ?>" title="Lihat detail barang" class="btn btn-success btn-sm mb-1"><i class="fas fa-eye"></i></a>
                                                            <a href="<?= base_url('admin/ubah_barang/' . $db['id']) ?>" title="Ubah barang" class="btn btn-warning btn-sm mb-1"><i class="fas fa-pen"></i></a>
                                                            <a href="<?= base_url('admin/hapus_barang/' . $db['id']) ?>" class="btn custom-hapus-alert btn-danger btn-sm mb-1" data-ctexta="Data barang serta riwayat stok akan ikut terhapus" title="Hapus"><i class="fas fa-trash"></i></a>
                                                            <a href="<?= base_url('admin/cetak_barcode?barcode=' . $db['barcode']) ?>" class="btn btn-info btn-sm mb-1" title="Cetak Barcode"><i class="fas fa-barcode"></i></a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>

                                            </tr>
                                        <?php $no++;
                                        endforeach; ?>
                                        </tbody>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
</div>