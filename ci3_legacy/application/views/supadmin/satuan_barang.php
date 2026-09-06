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
                                <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalSatuan"><i class="fas fa-plus"></i> Tambah Data</button>
                                <button type="button" onclick="location.reload()" class="btn btn-outline-success mb-2"><i class="fas fa-redo-alt"></i> Refresh</button>

                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th width="10">
                                                No
                                            </th>
                                            <th>Satuan</th>
                                            <th>Asli</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($satuan_barang as $sab) : ?>

                                            <tr>
                                                <td>
                                                    <?= $no ?>
                                                </td>
                                                <td>
                                                    <?= $sab['nama_satuan'] ?>
                                                </td>
                                                <td>
                                                    <?= $sab['nama_asli'] ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group-horizontal text-center">
                                                        <button class="btn btn-warning btn-sm mb-1" data-toggle="modal" data-target="#ubahmodalSatuan_<?= $sab['id'] ?>"><i class="fas fa-pen"></i></button>
                                                        <a href="<?= base_url('superadmin/hapus_satuan_barang/' . $sab['id']) ?>" class="btn hapus-alert btn-danger btn-sm mb-1" title="Hapus"><i class="fas fa-trash"></i></a>
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


<div class="modal fade" tabindex="-1" role="dialog" id="modalSatuan">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Satuan Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('superadmin/tambah_satuan_barang') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Satuan</label>
                        <input type="text" name="nama_satuan" placeholder="Contoh : pcs, bks, kds" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Asli</label>
                        <input type="text" name="nama_asli" placeholder="Contoh : Picis, Bungkus, Kardus" class="form-control" required>
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

<?php foreach ($satuan_barang as $sbTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="ubahmodalSatuan_<?= $sbTwo['id'] ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Satuan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('superadmin/ubah_satuan_barang') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $sbTwo['id'] ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Satuan</label>
                            <input type="text" value="<?= $sbTwo['nama_satuan'] ?>" name="nama_satuan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Asli</label>
                            <input type="text" value="<?= $sbTwo['nama_asli'] ?>" name="nama_asli" class="form-control" required>
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