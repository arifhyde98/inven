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
                                            <th width="70">Stok</th>
                                            <th>Tempat</th>
                                            <th>Status</th>
                                            <th width="200">Keterangan</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $no = 1;
                                        foreach ($in_out as $db) :
                                            $barang = $this->db->get_where('barang', ['id' => $db['id_barang']])->row_array();
                                            $penempatan = $this->db->get_where('data_cabang', ['id' => $barang['id_cabang']])->row_array();
                                        ?>

                                            <tr>
                                                <td class="text-center">
                                                    <?= $no ?>
                                                </td>

                                                <td>
                                                    <?= $barang['nama_barang'] ?>
                                                </td>

                                                <td>
                                                    <?= $db['jumlah'] ?> <?= $barang['satuan'] ?>
                                                </td>
                                                <td>
                                                    <?= $penempatan['nama_cabang'] ?>
                                                </td>
                                                <td>
                                                    <?php if ($db['status'] == 1) : ?>
                                                        <button type="button" class="btn btn-outline-primary">Stok In</button>
                                                    <?php else : ?>
                                                        <button type="button" class="btn btn-outline-danger">Stok Out</button>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= $db['keterangan'] ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group-horizontal text-center">
                                                    <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/hapus_in_out/'.$db['id']) : base_url('admin/hapus_in_out/'.$db['id']) ?>" class="btn btn-danger custom-hapus-alert btn-sm" data-ctexta="Dengan menghapus data ini maka stok akan kembali ke semula sebelum data ini ditambahkan" title="Hapus"><i class="fas fa-trash"></i> Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $no++;
                                        endforeach; ?>
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