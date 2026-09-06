<?php date_default_timezone_set('Asia/Jakarta'); ?>
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
                                Tambah Pesanan Baru
                            </h4>
                        </div>
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Data Pesanan</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Checkout</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <form id="save-pesanan">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="">Nama Barang</label>
                                                    <input type="text" name="nama_barang" class="form-control cus-validate">
                                                </div>
                                                <input type="hidden" name="id_user" value="<?= $user['id'] ?>">
                                                <input type="hidden" name="id_cabang" value="<?= $user['penempatan_cabang'] ?>">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Kategori Barang</label>
                                                            <select class="form-control selectric" name="kategori">
                                                                <?php foreach ($kategori_barang as $kat_bar) : ?>
                                                                    <option value="<?= $kat_bar['nama_kategori'] ?>"><?= $kat_bar['nama_kategori'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Satuan Beli</label>
                                                            <select class="form-control selectric" name="satuan">
                                                                <?php foreach ($satuan_barang_inp as $sat_bar) : ?>
                                                                    <option value="<?= $sat_bar['nama_satuan'] ?>"><?= $sat_bar['nama_asli'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Harga Beli</label>
                                                            <input type="text" name="harga_beli" autocomplete="off" class="form-control cus-validate uang-rp">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Jumlah Beli</label>
                                                            <input type="number" min="1" name="jumlah_beli" autocomplete="off" class="form-control cus-validate">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <label for="">Total Harga</label>
                                                    <input type="text" name="total_harga" readonly class="form-control cus-validate uang-rp">
                                                </div>
                                                <button class="btn btn-primary btn-save"><i class="fas fa-save"></i> Simpan</button>
                                    </form>
                                </div>
                                <div class="col-md-7">
                                    <p class="mb-0 border-bottom">
                                        Data Barang
                                    </p>
                                    <ul class="list-group" id="show-barang">

                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                            <form action="<?= $user['role_id'] == 1 ? base_url('superadmin/pesan_barang') : base_url('admin/pesan_barang') ?>" method="POST">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Tempat</label>
                                            <?php if ($user['role_id'] == 1) : ?>
                                                <select class="form-control selectric" name="cabang">
                                                    <?php foreach ($data_cabang as $dt_sup) : ?>
                                                        <option value="<?= $dt_sup['id'] ?>"><?= $dt_sup['nama_cabang'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php else : $c = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                                <input type="text" readonly class="form-control" value="<?= $c['nama_cabang'] ?>">
                                                <input type="hidden" name="cabang" readonly class="form-control" value="<?= $c['id'] ?>">
                                            <?php endif; ?>

                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama Pesanan</label>
                                            <input type="text" placeholder="Contoh: Pesanan minggu ke-2" class="form-control" name="nama">
                                            <input type="hidden" name="iduser" value="<?= $user['id'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Pesan Dari</label>
                                            <select class="form-control selectric" name="suplier">
                                                <option disabled selected>-- Pilih Suplier --</option>
                                                <option value="-">-</option>
                                                <?php foreach ($data_suplier as $dt_sup) : ?>
                                                    <option value="<?= $dt_sup['id_suplier'] ?>"><?= $dt_sup['nama_suplier'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Kode Pesanan</label>
                                            <?php $rand_kp = rand($jum, 99999) ?>
                                            <input type="text" value="PSN00<?= $rand_kp ?>" readonly class="form-control" name="kode">
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Pesan</label>
                                            <input type="text" data-toggle="datepicker" autocomplete="off" name="tgl_pesan" value="" class="form-control datepicker">
                                        </div>

                                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Pesanan</button>
                            </form>
                        </div>
                    </div>
                </div>
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


<!-- Template JS File -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<script src="<?= base_url('assets/') ?>js/custom.js"></script>
<script src="<?= base_url('assets/') ?>modules/izitoast/js/iziToast.min.js"></script>
<script>
    $(document).ready(function() {

        $("input[name='harga_beli']").on('keyup', function() {
            let hargaBeli = $("input[name='harga_beli']").val();
            let jumlahBeli = $("input[name='jumlah_beli']").val();
            let total = hargaBeli * jumlahBeli;
            $("input[name='total_harga']").val(total);
        })
        $("input[name='jumlah_beli']").on('keyup', function() {
            let hargaBeli = $("input[name='harga_beli']").val();
            let jumlahBeli = $("input[name='jumlah_beli']").val();
            let total = hargaBeli * jumlahBeli;

            $("input[name='total_harga']").val(total);
        })
        $('.btn-save').click(function(e) {
            let validati = $('.cus-validate').val();
            if (validati == '') {
                iziToast.warning({
                    message: 'Isi Form Pesanan Dengan Benar',
                    position: 'topCenter'
                });
                return false;
            }
            $.ajax({
                url: "<?= $user['role_id'] == 1 ? base_url('superadmin/simpan_barang_sementara') : base_url('admin/simpan_barang_sementara') ?>",
                type: "post",
                data: $('#save-pesanan').serialize(),
                success: function(data) {
                    $('#show-barang').load("<?= $user['role_id'] == 1 ? base_url('superadmin/list_pesanan_barang') : base_url('admin/list_pesanan_barang') ?>");
                    $('.cus-validate').val('');
                    iziToast.success({
                        message: 'Barang Ditambahkan',
                        position: 'topCenter'
                    });
                }
            })
            e.preventDefault();
        });

        $(document).on('click', '.btn-del', function() {
            var id = $(this).data("id");
            $.ajax({
                url: "<?= $user['role_id'] == 1 ? base_url('superadmin/hapus_isi_pesanan_manual') : base_url('admin/hapus_isi_pesanan_manual') ?>",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#show-barang').load("<?= $user['role_id'] == 1 ? base_url('superadmin/list_pesanan_barang') : base_url('admin/list_pesanan_barang') ?>");
                    iziToast.success({
                        message: 'Barang berhasil dihapus',
                        position: 'topCenter'
                    });
                }
            });
        });

        $(document).on('click', '.btn-ubk', function() {
            var id = $(this).data("idk");

            let jumlah = $('.inputJumlah-' + id).val();
            let harga = $('.h-beli-' + id).val();
            let idCabang = $('.cbg-' + id).val();
            let totalBaru = jumlah * harga;
            $.ajax({
                url: "<?= $user['role_id'] == 1 ? base_url('superadmin/ubah_p_keranjang') : base_url('admin/ubah_p_keranjang') ?>",
                type: "POST",
                data: {
                    jumlah: jumlah,
                    idCabang: idCabang,
                    harga_total: totalBaru,
                    id_barang: id
                },
                success: function(data) {
                    $('#show-barang').load("<?= $user['role_id'] == 1 ? base_url('superadmin/list_pesanan_barang') : base_url('admin/list_pesanan_barang') ?>");
                    iziToast.success({
                        message: 'Jumlah berhasil diubah',
                        position: 'topCenter'
                    });
                }
            });
        });


        $('#show-barang').load("<?= $user['role_id'] == 1 ? base_url('superadmin/list_pesanan_barang') : base_url('admin/list_pesanan_barang') ?>");

    })
</script>
</body>

</html>