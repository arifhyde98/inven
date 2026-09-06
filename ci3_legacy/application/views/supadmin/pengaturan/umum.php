<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= base_url('superadmin/pengaturan') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
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


            <div id="output-status"></div>
            <div class="row">

                <div class="col-md-12">
                    <form id="setting-form" action="<?= base_url('superadmin/pengaturan_umum') ?>" method="POST" enctype="multipart/form-data">
                        <div class="card" id="settings-card">
                            <div class="card-header">
                                <h4>Pengaturan Umum</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row align-items-center">
                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right">Nama Perusahaan</label>
                                    <div class="col-sm-6 col-md-9">
                                        <input type="text" name="nama" value="<?= $umum['nama_perusahaan'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right">Nama Pemilik</label>
                                    <div class="col-sm-6 col-md-9">
                                        <input type="text" name="pemilik" value="<?= $umum['pemilik'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label for="site-description" class="form-control-label col-sm-3 text-md-right">Alamat Perusahaan</label>
                                    <div class="col-sm-6 col-md-9">
                                        <textarea class="form-control" name="alamat" id="site-description"><?= $umum['alamat_perusahaan'] ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group row align-items-center">
                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right">Title Website</label>
                                    <div class="col-sm-6 col-md-9">
                                        <input type="text" name=title value="<?= $umum['title'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right">Footer</label>
                                    <div class="col-sm-6 col-md-9">
                                        <input type="text" name="footer" value="<?= $umum['footer'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="form-control-label col-sm-3 text-md-right">Favicon</label>
                                    <div class="col-sm-6 col-md-9">
                                        <div class="custom-file">
                                            <input type="file" name="favicon" class="custom-file-input" id="site-favicon">
                                            <label class="custom-file-label">Pilih Favicon</label>
                                        </div>
                                        <div class="form-text text-muted">Max size 1MB</div>
                                    </div>
                                </div>
                                <input type="hidden" name="favicon_lama" value="<?= $umum['favicon'] ?>">
                                <div class="form-group row align-items-center">
                                    <label class="form-control-label col-sm-3 text-md-right">Favicon Lama</label>
                                    <div class="col-sm-6 col-md-9">
                                        <img src="<?= base_url('assets/images/' . $umum['favicon']) ?>" class="img-thumbnail" width="100" alt="">
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer bg-whitesmoke text-md-right">
                                <button class="btn btn-primary" id="save-btn"><i class="fas fa-save"></i> Simpan Perubahan</button>
                                <input class="btn btn-secondary" type="reset" value="Reset">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>