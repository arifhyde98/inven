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
                                <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah Data</button>
                                <button type="button" onclick="location.reload()" class="btn btn-outline-success mb-2"><i class="fas fa-redo-alt"></i> Refresh</button>
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
                                            <th>Kode Suplier</th>
                                            <th>Nama Suplier</th>
                                            <th>Alamat</th>
                                            <th>Telp</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data_suplier as $ds) : ?>

                                            <tr>
                                                <td>
                                                    <?= $no ?>
                                                </td>
                                                <td>
                                                    <?= $ds['id_suplier'] ?>
                                                </td>
                                                <td>
                                                    <?= $ds['nama_suplier'] ?>
                                                </td>
                                                <td>
                                                    <?= $ds['alamat_suplier'] ?>
                                                </td>
                                                <td>
                                                    <?= $ds['telp'] ?>
                                                </td>


                                                <td>
                                                    <div class="btn-group-horizontal text-center">
                                                        <button class="btn btn-warning btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_<?= $ds['id'] ?>"><i class="fas fa-pen"></i></button>
                                                        <a href="<?= base_url('superadmin/hapus_suplier/' . $ds['id']) ?>" class="btn btn-danger hapus-alert btn-sm mb-1" title="Hapus"><i class="fas fa-trash"></i></a>
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

<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('superadmin/suplier') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <?php
                        $jml_br = $this->db->get('suplier')->num_rows();
                        $kd = $jml_br + 1;
                        ?>
                        <label for="">Kode Suplier</label>
                        <input type="text" value="SUP00<?= $kd ?>" readonly name="kode" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Suplier</label>
                        <input type="text" name="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Suplier</label>
                        <input type="text" name="alamat" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Nomor Telepon</label>
                        <input type="text" name="telp" class="form-control">
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

<?php foreach ($data_suplier as $daTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalUbahSiswa_<?= $daTwo['id'] ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Suplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('superadmin/ubah_suplier') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $daTwo['id'] ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Kode Suplier</label>
                            <input type="text" value="<?= $daTwo['id_suplier'] ?>" readonly name="kode" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Suplier</label>
                            <input type="text" name="nama" value="<?= $daTwo['nama_suplier'] ?>" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Alamat Suplier</label>
                            <input type="text" name="alamat" value="<?= $daTwo['alamat_suplier'] ?>" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Nomor Telepon</label>
                            <input type="text" name="telp" value="<?= $daTwo['telp'] ?>" required class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>