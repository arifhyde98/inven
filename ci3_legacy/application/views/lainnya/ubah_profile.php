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
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>
                                <button type="button" onclick="location.reload()" class="btn btn-outline-secondary"><i class="fas fa-redo-alt"></i> Refresh</button>
                                <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/profile') : base_url('admin/profile') ?>" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php if ($user['role_id'] == 1) : ?>
                                <?php echo form_open_multipart('superadmin/ubah_profile'); ?>
                            <?php elseif ($user['role_id'] == 2) : ?>
                                <?php echo form_open_multipart('admin/ubah_profile'); ?>
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $user['nama'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>">
                                <input type="hidden" name="gambar_lama" class="form-control" value="<?= $user['foto_profile'] ?>">
                                <input type="hidden" name="id" class="form-control" value="<?= $user['id'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" readonly class="form-control" value="<?= $user['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Foto Profile</label>
                                <div class="custom-file">
                                    <input type="file" name="foto" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <p>Foto Profile Lama</p>
                                <img src="<?= base_url('assets/images/profiles/' . $user['foto_profile']) ?>" class="img-thumbnail" width="100" alt="">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Ubah</button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
</div>