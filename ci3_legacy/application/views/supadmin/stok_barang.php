<?php
date_default_timezone_set('Asia/Jakarta');
?>
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

                                    <button type="button" onclick="history.back(-1)" class="btn btn-outline-primary mb-2"><i class="fas fa-arrow-left"></i> Kembali</button>
                                    <button type="button" onclick="location.reload()" class="btn btn-outline-success mb-2"><i class="fas fa-redo-alt"></i> Refresh</button>
                                   
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/stok_barang') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/stok_barang') ?>?idCabang=<?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    Data Stok Barang : <?= $p['nama_cabang'] ?>
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
                                            <th width="200">Nama Barang</th>
                                            <th width="100">Stok</th>
                                            <th>Tempat</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['idCabang'])) :
                                            $tempat = $_GET['idCabang'];
                                            $data_barang_tempat = $this->db->get_where('barang', ['id_cabang' => $tempat])->result_array();
                                        ?>

                                            <?php $no = 1;
                                            foreach ($data_barang_tempat as $db) :
                                                $penempatan = $this->db->get_where('data_cabang', ['id' => $db['id_cabang']])->row_array()
                                            ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $db['nama_barang'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $db['stok'] ?> <?= $db['satuan'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $penempatan['nama_cabang'] ?>
                                                    </td>

                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_<?= $db['id'] ?>"><i class="fas fa-eye"></i> Detail</button>
                                                            <button class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#terimaStok_<?= $db['id'] ?>"><i class="fas fa-download"></i> Stok In</button>
                                                            <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#keluarStok_<?= $db['id'] ?>"><i class="fas fa-upload"></i> Stok Out</button> </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        <?php else : ?>
                                            <?php $no = 1;
                                            foreach ($data_barang as $db) :
                                                $penempatan = $this->db->get_where('data_cabang', ['id' => $db['id_cabang']])->row_array()
                                            ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $db['nama_barang'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $db['stok'] ?> <?= $db['satuan'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $penempatan['nama_cabang'] ?>
                                                    </td>

                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_<?= $db['id'] ?>"><i class="fas fa-eye"></i> Detail</button>
                                                            <button class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#terimaStok_<?= $db['id'] ?>"><i class="fas fa-download"></i> Stok In</button>
                                                            <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#keluarStok_<?= $db['id'] ?>"><i class="fas fa-upload"></i> Stok Out</button>
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

<?php foreach ($data_barang as $ktbTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="terimaStok_<?= $ktbTwo['id'] ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stok In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php if ($user['role_id'] == 1) : ?>
                    <form action="<?= base_url('superadmin/tambah_stok_barang') ?>" method="POST" enctype="multipart/form-data">
                    <?php elseif ($user['role_id'] == 2) : ?>
                        <form action="<?= base_url('admin/tambah_stok_barang') ?>" method="POST" enctype="multipart/form-data">
                        <?php endif; ?>
                        <input type="hidden" name="id" value="<?= $ktbTwo['id'] ?>">
                        <div class="modal-body">
                            <p>Nama Barang : <?= $ktbTwo['nama_barang'] ?></p>

                            <div class="form-group">
                                <label>Jumlah Stok</label>
                                <input type="hidden" name="stok_in" value="1">
                                <input type="hidden" name="stok_out" value="0">
                                <div class="input-group">
                                    <input type="number" min="1" name="stok" required class="form-control">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <?= $ktbTwo['satuan'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" required></textarea>
                                </div>
                                <small class="text-danger">*Waktu penambahan stok otomatis diambil pada hari dan jam sekarang</small>
                            </div>

                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                        </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($data_barang as $ktbTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="keluarStok_<?= $ktbTwo['id'] ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stok Out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php if ($user['role_id'] == 1) : ?>
                    <form action="<?= base_url('superadmin/tambah_stok_barang') ?>" method="POST" enctype="multipart/form-data">
                    <?php elseif ($user['role_id'] == 2) : ?>
                        <form action="<?= base_url('admin/tambah_stok_barang') ?>" method="POST" enctype="multipart/form-data">
                        <?php endif; ?>
                        <input type="hidden" name="id" value="<?= $ktbTwo['id'] ?>">
                        <div class="modal-body">
                            <p>Nama Barang : <?= $ktbTwo['nama_barang'] ?></p>

                            <div class="form-group">
                                <label>Jumlah Stok</label>
                                <input type="hidden" name="stok_in" value="0">
                                <input type="hidden" name="stok_out" value="1">
                                <div class="input-group">
                                    <input type="number" min="1" name="stok" required class="form-control">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <?= $ktbTwo['satuan'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" required></textarea>
                                </div>
                                <small class="text-danger">*Waktu pengeluaran stok otomatis diambil pada hari dan jam sekarang</small>
                            </div>

                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                        </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($data_barang as $daTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalUbahSiswa_<?= $daTwo['id'] ?>">
        <div class="modal-dialog modal-lgx modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Stok Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Nama Barang : <?= $daTwo['nama_barang'] ?></p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped dtc">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Masuk</th>
                                            <th>Keluar</th>
                                            <th>Keterangan</th>
                                            <th>Jml</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $mutasi = 0;
                                        $skurd = $this->db->get_where('stok_barang', ['id_barang' => $daTwo['id']])->result_array();
                                        foreach ($skurd as $skrd) : ?>

                                            <tr>
                                                <td><?= date('d F Y - H:i', $skrd['tgl']) ?></td>
                                                <?php if ($skrd['status'] == 1) : ?>
                                                    <td><?= $skrd['jumlah'] ?></td>
                                                    <td></td>
                                                    <td><?= $skrd['keterangan'] ?></td>
                                                    <td><?= $mutasi += $skrd['jumlah'] ?></td>
                                                <?php elseif ($skrd['status'] == 2) : ?>
                                                    <td></td>
                                                    <td><?= $skrd['jumlah'] ?></td>
                                                    <td><?= $skrd['keterangan'] ?></td>
                                                    <td><?= $mutasi -= $skrd['jumlah'] ?></td>
                                                <?php endif; ?>

                                            </tr>
                                        <?php $no++;
                                        endforeach; ?>
                                        <tr>
                                            <td colspan="4" align="right">Stok saat ini</td>

                                            <td>
                                                <?= $daTwo['stok'] ?> <?= $daTwo['satuan'] ?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

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