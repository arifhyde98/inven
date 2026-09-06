<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>
        <?= $this->session->flashdata('pesan'); ?>
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
                                <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/data_cicilan') : base_url('admin/data_cicilan') ?>" class="btn btn-outline-primary mb-2"><i class="fas fa-arrow-left"></i> Kembali</a>

                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <p>Riwayat Pembayaran Cicilan
                                        <a href="<?= $user['role_id'] == 1 ? base_url('cetak/struk_pembayaran_cicilan/' . $this->uri->segment(3)) : base_url('cetak/struk_pembayaran_cicilan/' . $this->uri->segment(3)) ?>" class="btn btn-sm btn-danger" target="_blank"><i class="fas fa-print"></i> Print Struk</a>

                                    </p>
                                    <?php
                                    $b = $this->db->get_where('pembayaran_cicilan', ['id_cicilan' => $cicilan['id_pembayaran_cicilan']])->result_array();
                                    ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Sisa Cicilan</th>
                                                        <th scope="col">Uang</th>
                                                        <th scope="col">Cicilan Akhir</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $a = 1;
                                                    foreach ($b as $log) : ?>
                                                        <tr>
                                                            <td><?= $a ?></td>
                                                            <td><?= $log['tanggal'] ?></td>
                                                            <td><?= rupiah($log['sisa_cicilan']) ?></td>
                                                            <td><?= rupiah($log['uang']) ?></td>
                                                            <td><?= rupiah($log['sisa_cicilan_akhir']) ?></td>
                                                        </tr>
                                                    <?php $a++;
                                                    endforeach; ?>
                                                    <tr>
                                                        <td colspan="4" align="right">Sisa Cicilan</td>
                                                        <td>Rp. <?= rupiah($cicilan['kembalian']) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <p>Pembayaran Cicilan</p>
                                    <form action="<?= $user['role_id'] == 1 ? base_url('superadmin/bayar_cicilan/' . $this->uri->segment(3)) : base_url('admin/bayar_cicilan/' . $this->uri->segment(3)) ?>" method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">ID Pembelian</label>
                                                    <input type="text" name="id_pembelian" readonly class="form-control" value="<?= $cicilan['id_pembelian'] ?>">
                                                </div>
                                            </div>
                                            <input type="hidden" name="id_cabang" value="<?= $cicilan['id_cabang'] ?>">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">ID Pembayaran</label>
                                                    <input type="text" name="id_pembayaran" readonly class="form-control" value="<?= $cicilan['id_pembayaran_cicilan'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">ID User</label>
                                            <input type="text" readonly name="id_user" class="form-control" value="<?= $cicilan['id_user'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Sisa Cicilan</label>
                                            <input type="text" readonly class="form-control" value="<?= rupiah($cicilan['kembalian']) ?>">
                                            <input type="hidden" name="sisa_cicilan" class="form-control harga-total" value="<?= $cicilan['kembalian'] ?>">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Uang</label>
                                                    <input type="number" required min="1" name="uang" min="0" class="form-control uang-saya">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="kSisa">Sisa Cicilan Akhir</label>
                                                    <input type="number" name="sisa_cicilan_akhir" readonly class="form-control awikwod">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="kSisa">Kembalian</label>
                                            <input type="number" name="kembalian_saya" value="0" readonly class="form-control kmba">
                                        </div>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Bayar</button>
                                    </form>
                                </div>
                            </div>
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
    $('.uang-saya').on('keyup', function() {
        let uang = $('.uang-saya').val();
        let hargaTotal = $('.harga-total').val();
        let x = hargaTotal - uang;
        if (uang == '') {
            $('.awikwod').val('');
            $('.kmba').val('');
        } else if (x < 0) {
            $('.awikwod').val(0);
            let c = uang - hargaTotal;
            $('.kmba').val(c);
        } else {
            let i = hargaTotal - uang;
            $('.kmba').val(0);

            $('.awikwod').val(i);
        }


    })
</script>
</body>

</html>