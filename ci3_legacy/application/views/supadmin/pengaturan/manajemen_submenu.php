<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= base_url('superadmin/pengaturan') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
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


            <div id="output-status"></div>
            <div class="row">

                <div class="col-md-12">
                    <form id="setting-form" action="<?= base_url('superadmin/pengaturan_umum') ?>" method="POST" enctype="multipart/form-data">
                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <h4>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fas fa-plus"></i> Tambah Submenu
                                    </button>
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="50">#</th>
                                                <th scope="col">Menu</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Icon</th>
                                                <th scope="col">Url</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($submenu as $sm) : ?>
                                                <?php $n_menu = $this->db->get_where('menu', ['id' => $sm['menu_id']])->row_array(); ?>
                                                <tr>
                                                    <th scope="row"><?= $no ?></th>
                                                    <td><?= $n_menu['menu'] ?></td>
                                                    <td><?= $sm['nama'] ?></td>
                                                    <td><?= $sm['icon'] ?></td>
                                                    <td><?= $sm['url'] ?></td>
                                                    <td>
                                                        <?php if ($sm['status'] == 1) : ?>
                                                            <span class="badge badge-success">Aktif</span>
                                                        <?php else : ?>
                                                            <span class="badge badge-danger">Tidak Aktif</span>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('superadmin/hapus_submenu_manajemen/' . $sm['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus submenu ini?')"><i class="fas fa-trash"></i></a>
                                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalEdit_<?= $sm['id'] ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button> </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Submenu Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('superadmin/manajemen_submenu') ?>" method="POST">
                    <div class="form-group">
                        <select name="menu" class="form-control" id="">
                            <option selected disabled>-- Pilih Menu --</option>
                            <?php foreach ($menu as $i_m) : ?>
                                <option value="<?= $i_m['id'] ?>"><?= $i_m['menu'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="submenu" class="form-control" placeholder="Nama Submenu">
                    </div>
                    <div class="form-group">
                        <input type="text" name="icon" class="form-control" placeholder="Icon">
                    </div>
                    <div class="form-group">
                        <input type="text" name="url" class="form-control" placeholder="Url">
                    </div>
                    <div class="form-group">
                        <select name="status" class="form-control" id="">
                            <option selected disabled>-- Pilih Status --</option>
                            <option value="1">Aktif</option>
                            <option value="2">Tidak Aktif</option>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit -->
<?php foreach ($submenu as $sm_edit) : ?>
    <div class="modal fade" id="modalEdit_<?= $sm_edit['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalEdit">Ubah Submenu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('superadmin/ubah_manajemen_submenu') ?>" method="POST">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?= $sm_edit['id'] ?>">
                            <label for="">Nama Menu</label>
                            <select name="menu" class="form-control" id="" required>
                                <?php
                                    $awikwok = $this->db->get_where('menu', ['id' => $sm_edit['menu_id']])->row_array();
                                    $awikwik = $this->db->get_where('menu', ['id !=' => $sm_edit['menu_id']])->result_array();
                                    ?>
                                <option selected value="<?= $sm_edit['menu_id'] ?>"><?= $awikwok['menu'] ?></option>
                                <?php foreach ($awikwik as $aw) : ?>
                                    <option value="<?= $aw['id'] ?>"><?= $aw['menu'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Submenu</label>
                            <input type="text" value="<?= $sm_edit['nama'] ?>" name="submenu" class="form-control" placeholder="Nama Submenu" required>
                        </div>
                        <div class="form-group">
                            <label for="">Icon</label>
                            <input type="text" name="icon" value="<?= $sm_edit['icon'] ?>" class="form-control" placeholder="Icon" required>
                        </div>
                        <div class="form-group">
                            <label for="">Url</label>
                            <input type="text" name="url" value="<?= $sm_edit['url'] ?>" class="form-control" placeholder="Url" required>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" id="" required>
                                <?php if ($sm_edit['status'] == 1) : ?>
                                    <option selected value="<?= $sm_edit['status'] ?>">Aktif</option>
                                <?php else : ?>
                                    <option selected value="<?= $sm_edit['status'] ?>">TIdak Aktif</option>
                                <?php endif ?>
                                <option value="1">Aktif</option>
                                <option value="2">Tidak Aktif</option>
                            </select>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>