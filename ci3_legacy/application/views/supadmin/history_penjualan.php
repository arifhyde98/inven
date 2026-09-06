<?php
date_default_timezone_set('Asia/Jakarta');
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>
        <?= $this->session->flashdata('pesan') ?>
        <?php
        if (validation_errors()) :
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= validation_errors() ?>

            </div>
        <?php endif; ?>
        <div class="section-body">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="font-weight-bold">Filter Pencarian</p>
                            <form id="searchDate">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="">Dari Tanggal</label>
                                        <input type="text" placeholder="..." data-toggle="datepicker" name="dari" autocomplete="off" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Ke Tanggal</label>
                                        <input type="text" placeholder="..." data-toggle="datepicker" name="ke" autocomplete="off" class="form-control">
                                    </div>
                                    <div class="col-md-1 mt-4">
                                        <button type="button" class="btn btnSearch mt-2 btn-primary"><i class="fas fa-search"></i> Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <?php if ($user['role_id'] == 1) : ?>

                                    <?php
                                    if ($this->uri->segment(3)) {
                                        $tempat = $this->uri->segment(3);
                                        $p = $this->db->get_where('data_cabang', ['id' => $tempat])->row_array();
                                        echo "History Penjualan " . $p['nama_cabang'];
                                    } else {
                                        echo "History Penjualan Semua Cabang";
                                    }
                                    ?>
                                    <button type="button" id="reloadData" class="btn btn-sm btn-outline-success"><i class="fas fa-redo-alt"></i> Refresh</button>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/history_penjualan') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/history_penjualan/') ?><?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if ($this->uri->segment(3)) : $cab = $this->uri->segment(3) ?>
                                            <a href="<?= base_url('cetak/history_penjualan_c/' . $cab) ?>" target="_blank" class="btn btn-info btn-sm mt-2" title="Print"><i class="fas fa-print"></i></a>
                                            <a href="<?= base_url('export/excel_history_penjualan_c/' . $cab) ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php else : ?>
                                            <a href="<?= base_url('cetak/history_penjualan ') ?>" target="_blank" class="btn btn-info btn-sm mt-2" title="Print"><i class="fas fa-print"></i></a>
                                            <a href="<?= base_url('export/excel_history_penjualan ') ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    History Penjualan Barang : <?= $p['nama_cabang'] ?>
                                    <a href="<?= base_url('cetak/history_penjualan_c/' . $user['penempatan_cabang']) ?>" target="_blank" class="btn btn-info btn-sm mt-2" title="Print"><i class="fas fa-print"></i></a>
                                    <button type="button" id="reloadData" class="btn btn-sm btn-outline-success"><i class="fas fa-redo-alt"></i> Refresh</button>
                                    <a href="<?= base_url('export/excel_history_penjualan ') ?>" target="_blank" class="btn btn-outline-warning btn-sm" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>

                                <?php endif; ?>

                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="disini">

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
</div>

<?php foreach ($data_penjualan as $daTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalUbahSiswa_<?= $daTwo['id'] ?>">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Penjualan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <?php
                    $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $daTwo['id_keranjang']])->num_rows();
                    $b = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $daTwo['id_keranjang']])->result_array();
                    ?>
                    <div class="float-left">
                        <p>ID Penjualan : <?= $daTwo['id_pembelian'] ?></p>

                        <p>Total Barang : <?= $a ?></p>
                    </div>
                    <div class="float-right">
                        <?php if ($daTwo['metode_bayar'] == 'cicilan') : ?>
                            <p>ID Cicilan : <?= $daTwo['id_pembayaran_cicilan'] ?></p>
                            <p>ID User : <?= $daTwo['id_user'] ?></p>

                        <?php endif; ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Harga Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($b as $barang) : ?>
                                        <tr>
                                            <td><?= $barang['nama'] ?></td>
                                            <td><?= $barang['jumlah'] ?> <?= $barang['satuan'] ?></td>
                                            <td><?= rupiah($barang['harga']) ?></td>
                                            <td><?= rupiah($barang['harga_total']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" align="right">Total Harga</td>
                                        <td>Rp. <?= rupiah($daTwo['total_pembayaran']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if ($daTwo['status_utang'] == 1) : ?>
                                <p>Status Cicilan : Belum Lunas</p>
                                <p>Pembayaran Terakhir : Rp. <?= rupiah($daTwo['uang']) ?></p>
                                <p>Sisa Cicilan : Rp. <?= rupiah($daTwo['kembalian']) ?></p>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

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
<script src="<?= base_url('assets/') ?>modules/tooltip.js"></script>
<script src="<?= base_url('assets/') ?>modules/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/moment.min.js"></script>
<script src="<?= base_url('assets/') ?>js/stisla.js"></script>

<!-- JS Libraies -->
<script src="<?= base_url('assets/') ?>modules/cleave-js/dist/cleave.min.js"></script>
<script src="<?= base_url('assets/') ?>js/datepicker.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/jquery-selectric/jquery.selectric.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/datatables.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="<?= base_url('assets/') ?>js/jquery.number.min.js"></script>
<script src="<?= base_url('assets/') ?>js/sweetalert2.all.min.js"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url('assets/') ?>js/page/modules-datatables.js"></script>

<script>
    $(document).ready(function() {

        <?php if ($this->uri->segment(3)) : ?>
            $(document).on('click', '.btnSearch', function() {
                $.ajax({
                    url: "<?= $user['role_id'] == 1 ? base_url('superadmin/search_history_percabang/' . $this->uri->segment(3)) : base_url('admin/search_history') ?>",
                    type: "POST",
                    data: $('#searchDate').serialize(),
                    success: function(data) {
                        $('#disini').html(data);
                    }
                })
            })
            $(document).on('click', '#reloadData', function() {
                $('#disini').load("<?= $user['role_id'] == 1 ? base_url('superadmin/show_history_penjualan_percabang/' . $this->uri->segment(3)) : base_url('admin/show_history_penjualan') ?>");
            });
        <?php else : ?>
            $(document).on('click', '.btnSearch', function() {
                $.ajax({
                    url: "<?= $user['role_id'] == 1 ? base_url('superadmin/search_history') : base_url('admin/search_history') ?>",
                    type: "POST",
                    data: $('#searchDate').serialize(),
                    success: function(data) {
                        $('#disini').html(data);
                    }
                })
            })
            $(document).on('click', '#reloadData', function() {
                $('#disini').load("<?= $user['role_id'] == 1 ? base_url('superadmin/show_history_penjualan') : base_url('admin/show_history_penjualan') ?>");
            });
        <?php endif; ?>


        <?php if ($this->uri->segment(3)) : ?>
            $('#disini').load("<?= $user['role_id'] == 1 ? base_url('superadmin/show_history_penjualan_percabang/' . $this->uri->segment(3)) : base_url('admin/show_history_penjualan') ?>");
        <?php else : ?>
            $('#disini').load("<?= $user['role_id'] == 1 ? base_url('superadmin/show_history_penjualan') : base_url('admin/show_history_penjualan') ?>");
        <?php endif; ?>

    });
</script>

<!-- Template JS File -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<script src="<?= base_url('assets/') ?>js/custom.js"></script>


</body>

</html>