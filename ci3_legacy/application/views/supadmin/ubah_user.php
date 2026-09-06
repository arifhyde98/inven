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
                                <button type="button" onclick="location.reload()" class="btn btn-outline-success mb-2"><i class="fas fa-redo-alt"></i> Refresh</button>
                                <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/data_user') : base_url('admin/data_user') ?>" class="btn btn-outline-primary mb-2"><i class="fas fa-arrow-left"></i> Kembali</a>

                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= $user['role_id'] == 1 ? base_url('superadmin/ubah_user/' . $data_user['id_user']) : base_url('admin/ubah_user/' . $data_user['id_user']) ?>" method="POST">

                                <input type="hidden" name="penempatan" value="<?= $data_user['penempatan'] ?>">
                                <div class="form-group">
                                    <label>Nama User</label>
                                    <input type="text" value="<?= $data_user['nama_user'] ?>" name="nama_user" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>User ID</label>
                                    <input type="text" name="id_user" value="<?= $data_user['id_user'] ?>" readonly class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>No Telp</label>
                                    <input type="text" name="no_telp" value="<?= $data_user['tlp_user'] ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Alamat User</label>
                                    <textarea name="alamat_user" class="form-control" cols="30" rows="10"><?= $data_user['alamat'] ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-check"></i> Simpan</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<footer class="main-footer">
    <div class="footer-left">
        <?= $p_umum['footer'] ?>
    </div>
    <div class="footer-right">

    </div>
</footer>
</div>
</div>

<!-- General JS Scripts -->

<script src="<?= base_url('assets/') ?>modules/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/popper.js"></script>
<script src="<?= base_url('assets/') ?>js/datepicker.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/tooltip.js"></script>
<script src="<?= base_url('assets/') ?>modules/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/moment.min.js"></script>
<script src="<?= base_url('assets/') ?>js/stisla.js"></script>

<!-- JS Libraies -->
<script src="<?= base_url('assets/') ?>modules/datatables/datatables.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= base_url('assets/') ?>js/sweetalert2.all.min.js"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url('assets/') ?>js/page/modules-datatables.js"></script>

<!-- Template JS File -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<script src="<?= base_url('assets/') ?>js/custom.js"></script>
<script>
    $("input[name='nama_user']").on('keyup', function() {
        var namaInput = $("input[name='nama_user']").val();
        var nama_input = namaInput.replace(/\s/g, '');
        let toLow = nama_input.toLowerCase();
        let randLow = Math.floor(Math.random() * 9999);
        let idDo = toLow + "_" + randLow;
        $("input[name='id_user']").val(idDo);
        if (namaInput == '') {
            $("input[name='id_user']").val('');
        }
    })
</script>
</body>

</html>