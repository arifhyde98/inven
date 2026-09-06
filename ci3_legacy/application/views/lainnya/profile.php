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
                <div class="col-md-6">
                    <div class="card author-box card-primary">
                        <div class="card-body">
                            <div class="author-box-left mt-3">
                                <img alt="image" src="<?= base_url('assets/images/profiles/' . $user['foto_profile']) ?>" class="rounded-circle shadow author-box-picture">
                                <div class="clearfix"></div>
                            </div>

                            <div class="author-box-details">
                                <div class="author-box-description">
                                    <p class="mb-0">Nama : <?= $user['nama'] ?></p>
                                    <p class="mb-0">Jenis Kelamin : <?= $user['jenis_kelamin'] == 'l' ? 'Laki-laki' : 'Perempuan'; ?></p>
                                    <p class="mb-0">Username : <?= $user['username'] ?></p>
                                    <p class="mb-0">Email : <?= $user['email'] ?></p>
                                    <p class="mb-0">Status : Admin</p>
                                </div>

                                <div class="mt-2">
                                    <?php if ($user['role_id'] == 1) : ?>
                                        <a href="<?= base_url('superadmin/ubah_profile') ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Ubah Profile</a>
                                        <a href="<?= base_url('superadmin/ubah_password') ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Ubah Password</a>
                                    <?php elseif ($user['role_id'] == 2) : ?>
                                        <a href="<?= base_url('admin/ubah_profile') ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Ubah Profile</a>
                                        <a href="<?= base_url('admin/ubah_password') ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Ubah Password</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>