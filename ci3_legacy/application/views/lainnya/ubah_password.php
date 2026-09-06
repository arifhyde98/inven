<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>
        <div id="text-flash" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>
        <div id="tipe-flash" data-tipe="<?= $this->session->flashdata('tipe'); ?>"></div>
        <div id="status-flash" data-status="<?= $this->session->flashdata('status'); ?>"></div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <button type="button" onclick="location.reload()" class="btn btn-outline-secondary"><i class="fas fa-redo-alt"></i> Refresh</button>
                                <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/profile') : base_url('admin/profile') ?>" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </h4>
                        </div>
                        <?php if ($user['role_id'] == 1) : ?>
                            <form action="<?= base_url('superadmin/ubah_password') ?>" method="POST">
                            <?php elseif ($user['role_id'] == 2) : ?>
                                <form action="<?= base_url('admin/ubah_password') ?>" method="POST">
                                <?php endif; ?>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Password Lama</label>
                                        <input type="password" name="pl" class="form-control">
                                        <?= form_error('pl', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password Baru</label>
                                        <input type="password" name="pb" class="form-control">
                                        <?= form_error('pb', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Verifikasi Password Baru</label>
                                        <input type="password" name="up" class="form-control">
                                        <?= form_error('up', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Ubah</button>
                                </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>