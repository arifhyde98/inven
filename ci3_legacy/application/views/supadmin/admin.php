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
                                                #
                                            </th>
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Penempatan</th>
                                            <th>Status</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data_admin as $da) :
                                            $penempatan = $this->db->get_where('data_cabang', ['id' => $da['penempatan_cabang']])->row_array() ?>

                                            <tr>
                                                <td>
                                                    <?= $no ?>
                                                </td>
                                                <td>
                                                    <img alt="image" src="<?= base_url('assets/') ?>images/profiles/<?= $da['foto_profile'] ?>" class="rounded-circle" width="35" data-toggle="tooltip" title="<?= $da['nama'] ?>">
                                                </td>
                                                <td>
                                                    <?= $da['nama'] ?>
                                                </td>
                                                <td>
                                                    <?= $da['username'] ?>
                                                </td>
                                                <td>
                                                    <?= $da['email'] ?>
                                                </td>
                                                <td>
                                                    <span><?= $da['jenis_kelamin'] == "l" ? "Laki-laki" : "Perempuan" ?></span>
                                                </td>
                                                <td>
                                                    <?= $penempatan['nama_cabang'] ?>
                                                </td>
                                                <td>
                                                    <div class="badge badge-<?= $da['status'] == "1" ? "success" : "danger" ?>">
                                                        <?= $da['status'] == "1" ? "Aktif" : "Blokir" ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group-horizontal text-center">
                                                        <button class="btn btn-warning btn-sm mb-1" data-toggle="modal" data-target="#modalUbahSiswa_<?= $da['id'] ?>"><i class="fas fa-pen"></i></button>
                                                        <?php if ($da['status'] == 1) : ?>
                                                            <a href="<?= base_url('superadmin/blokir_admin/' . $da['id']) ?>" class="btn ask-alert btn-outline-dark btn-sm mb-1" data-asktext="Yakin ingin memblokir admin" data-askbtn="Blokir" data-asktitle="Blokir Admin" title="Blokir"><i class="fas fa-times"></i></a>
                                                        <?php else : ?>
                                                            <a href="<?= base_url('superadmin/aktifkan_admin/' . $da['id']) ?>" class="btn btn-success btn-sm mb-1 ask-alert" data-asktext="Yakin ingin mengaktifkan admin" data-askbtn="Aktifkan" data-asktitle="Aktifkan Admin" title="Aktif"><i class="fas fa-check"></i></a>
                                                        <?php endif; ?>
                                                        <a href="<?= base_url('superadmin/hapus_admin/' . $da['id']) ?>" class="btn hapus-alert btn-danger btn-sm mb-1" title="Hapus"><i class="fas fa-trash"></i></a>
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

<?php if ($user['role_id'] == 1) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('superadmin/admin') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" name="nama" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Jenis Kelamin</label>
                                    <select name="jk" class="form-control">
                                        <option selected disabled>-- Jenis Kelamin --</option>
                                        <option value="l">Laki-laki</option>
                                        <option value="p">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penempatan</label>
                                    <select class="form-control selectric" name="penempatan">
                                        <option disabled selected>-- Pilih Penempatan --</option>
                                        <?php foreach ($data_cabang as $dc) : ?>
                                            <option value="<?= $dc['id'] ?>"><?= $dc['nama_cabang'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Konfirmasi Password</label>
                                    <input type="password" name="conf_password" class="form-control">
                                </div>

                                <label for="">Foto Profile *<sup>Optional</sup></label>
                                <div class="custom-file">
                                    <input type="file" name="foto" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Pilih Foto</label>
                                </div>
                            </div>
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
<?php endif; ?>

<?php if ($user['role_id'] == 1) : ?>
    <?php foreach ($data_admin as $daTwo) :
        $penempatan = $this->db->get_where('data_cabang', ['id' => $daTwo['penempatan_cabang']])->row_array() ?>
        ?>
        <div class="modal fade" tabindex="-1" role="dialog" id="modalUbahSiswa_<?= $daTwo['id'] ?>">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Data Guru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('superadmin/ubah_admin') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $daTwo['id'] ?>">
                        <input type="hidden" name="gambar_lama" value="<?= $daTwo['foto_profile'] ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" value="<?= $daTwo['nama'] ?>" class="form-control" name="nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jenis Kelamin</label>
                                        <select name="jk" class="form-control" required>
                                            <?php if ($daTwo['jenis_kelamin'] == 'l') : ?>
                                                <option selected value="<?= $daTwo['jenis_kelamin'] ?>">Laki-laki</option>
                                            <?php else : ?>
                                                <option selected value="<?= $daTwo['jenis_kelamin'] ?>">Perempuan</option>

                                            <?php endif; ?>
                                            <option value="l">Laki-laki</option>
                                            <option value="p">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="email" required value="<?= $daTwo['email'] ?>" class="form-control" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" name="username" required value="<?= $daTwo['username'] ?>" class="form-control" name="username">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Penempatan</label>
                                        <select class="form-control selectric" name="penempatan">
                                            <option selected value="<?= $daTwo['penempatan_cabang'] ?>"><?= $penempatan['nama_cabang'] ?></option>
                                            <?php foreach ($data_cabang as $dc) : ?>
                                                <option value="<?= $dc['id'] ?>"><?= $dc['nama_cabang'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Foto Profile</label>
                                        <div class="custom-file">
                                            <input type="file" name="foto" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Pilih Foto</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Profile Lama</label><br>
                                        <img src="<?= base_url('assets/images/profiles/' . $daTwo['foto_profile']) ?>" class="img-thumbnail" width="80" alt="">
                                    </div>
                                </div>
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
<?php endif; ?>