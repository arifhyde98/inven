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
                            <h4>Cabang Utama</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>

                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Jumlah Admin</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?= $cabang_utama['nama_cabang'] ?>
                                            </td>
                                            <td>
                                                <?= $cabang_utama['alamat'] ?>
                                            </td>
                                            <td>
                                                <?= $this->db->get_where('user', ['penempatan_cabang' => $cabang_utama['id']])->num_rows() ?>
                                            </td>


                                            <td>
                                                <div class="btn-group-horizontal text-center">
                                                    <button class="btn btn-warning btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_<?= $cabang_utama['id'] ?>"><i class="fas fa-pen"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                                            <th>Nama Cabang</th>
                                            <th>Alamat</th>
                                            <th>Jumlah Admin</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data_cabang as $ds) : ?>

                                            <tr>
                                                <td>
                                                    <?= $no ?>
                                                </td>

                                                <td>
                                                    <?= $ds['nama_cabang'] ?>
                                                </td>
                                                <td>
                                                    <?= $ds['alamat'] ?>
                                                </td>
                                                <td>
                                                    <?= $this->db->get_where('user', ['penempatan_cabang' => $ds['id']])->num_rows() ?>
                                                </td>


                                                <td>
                                                    <div class="btn-group-horizontal text-center">
                                                        <button class="btn btn-warning btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_<?= $ds['id'] ?>"><i class="fas fa-pen"></i></button>
                                                        <a href="<?= base_url('superadmin/hapus_dataCabang/' . $ds['id']) ?>" class="btn ask-alert btn-danger btn-sm mb-1" data-asktext="Seluruh data yang berkaitan dengan cabang ini akan ikut terhapus" data-askbtn="Hapus" data-asktitle="Hapus Cabang" title="Hapus"><i class="fas fa-trash"></i></a>
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
            <form action="<?= base_url('superadmin/data_cabang') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Nama Cabang</label>
                        <input type="text" name="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Cabang</label>
                        <input type="text" name="alamat" class="form-control">
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

<?php foreach ($data_cabang as $daTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalUbahSiswa_<?= $daTwo['id'] ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Cabang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('superadmin/ubah_dataCabang') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $daTwo['id'] ?>">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="">Nama Cabang</label>
                            <input type="text" value="<?= $daTwo['nama_cabang'] ?>" name="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Alamat Cabang</label>
                            <input type="text" name="alamat" value="<?= $daTwo['alamat'] ?>" class="form-control">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modalUbahSiswa_<?= $cabang_utama['id'] ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data Cabang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('superadmin/ubah_dataCabang') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $cabang_utama['id'] ?>">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Nama Cabang</label>
                        <input type="text" value="<?= $cabang_utama['nama_cabang'] ?>" name="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Cabang</label>
                        <input type="text" name="alamat" value="<?= $cabang_utama['alamat'] ?>" class="form-control">
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