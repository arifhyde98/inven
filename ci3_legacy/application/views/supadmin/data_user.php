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
                                <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalUsr"><i class="fas fa-plus"></i> Tambah User</button>
                                <button type="button" onclick="location.reload()" class="btn btn-outline-success mb-2"><i class="fas fa-redo-alt"></i> Refresh</button>
                                <button type="button" onclick="history.back(-1)" class="btn btn-outline-primary mb-2"><i class="fas fa-arrow-left"></i> Kembali</button>

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
                                            <th>User ID</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Alamat</th>
                                            <th>Cabang</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data_user as $du) :
                                            $cabang = $this->db->get_where('data_cabang', ['id' => $du['penempatan']])->row_array();
                                        ?>

                                            <tr>
                                                <td>
                                                    <?= $no ?>
                                                </td>

                                                <td>
                                                    <?= $du['id_user'] ?>
                                                </td>
                                                <td>
                                                    <?= $du['nama_user'] ?>
                                                </td>
                                                <td>
                                                    <?= $du['tlp_user'] ?>
                                                </td>
                                                <td>
                                                    <?= $du['alamat'] ?>
                                                </td>
                                                <td>
                                                    <?= $cabang['nama_cabang'] ?>
                                                </td>

                                                <td>
                                                    <div class="btn-group-horizontal text-center">

                                                        <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/ubah_user/' . $du['id_user']) : base_url('admin/ubah_user/' . $du['id']) ?>" class="btn btn-warning btn-sm mb-1" title="Ubah"><i class="fas fa-pen"></i></a>
                                                        <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/hapus_user/' . $du['id_user']) : base_url('admin/hapus_user/' . $du['id_user']) ?>" class="btn ask-alert btn-danger btn-sm mb-1" data-asktext="Seluruh data yang berkaitan dengan user ini akan ikut terhapus termasuk log cicilan" data-askbtn="Hapus" data-asktitle="Hapus User" title="Hapus"><i class="fas fa-trash"></i></a>
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


<div class="modal fade" id="modalUsr" tabindex="-1" role="dialog" aria-labelledby="modalUsrLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUsrLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= $user['role_id'] == 1 ? base_url('superadmin/data_user') : base_url('admin/data_user') ?>" method="POST">
                    <?php if ($user['role_id'] == 1) : ?>
                        <div class="form-group">
                            <label>Penempatan User</label>
                            <select name="penempatan" class="form-control">
                                <?php $cabang = $this->db->get('data_cabang')->result_array();
                                foreach ($cabang as $cab) : ?>
                                    <option value="<?= $cab['id'] ?>"><?= $cab['nama_cabang'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else : ?>
                        <input type="hidden" name="penempatan" value="<?= $user['penempatan_cabang'] ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Nama User</label>
                        <input type="text" name="nama_user" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>User ID</label>
                        <input type="text" name="id_user" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label>No Telp</label>
                        <input type="text" name="no_telp" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alamat User</label>
                        <textarea name="alamat_user" class="form-control" cols="30" rows="10"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary" id="btnUsrL">Tambah <i class="fas fa-plus"></i></button>
            </div>
            </form>
        </div>
    </div>
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