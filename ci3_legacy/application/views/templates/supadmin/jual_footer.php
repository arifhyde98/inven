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
<script src="<?= base_url('assets/') ?>js/jquery-ui-me.js"></script>
<script src="<?= base_url('assets/') ?>js/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets/') ?>js/jquery.number.min.js"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url('assets/') ?>js/page/modules-datatables.js"></script>


<!-- Template JS File -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<script src="<?= base_url('assets/') ?>js/custom.js"></script>
<script src="<?= base_url('assets/') ?>modules/izitoast/js/iziToast.min.js"></script>

<script src="<?= base_url('assets/') ?>js/page/modules-toastr.js"></script>
<script src="<?= base_url('assets/') ?>js/jQuery.print.min.js"></script>

<script>
    $(document).ready(function() {

        $(document).on('change', '#hutang', function() {
            $('.uang-saya').val('');
            $('.kembalian-saya').val('');
            $('.kembalian-saya-bg').val('');
            $('#pIp').addClass('col-lg-6');
            $('.hiddenHutang').fadeIn();
            $(this).attr('checked', true);
            $('.kSisa').html('Sisa Cicilan');
            $('#tunai').removeAttr('checked');
            $('#didie').load(
                "<?= $user['role_id'] == 1 ? base_url('superadmin/dinamis_user') : base_url('admin/dinamis_user') ?>"
            );
        })
        $(document).on('change', '#tunai', function() {
            $('.uang-saya').val('');
            $('.kembalian-saya').val('');
            $('.kembalian-saya-bg').val('');
            $('#pIp').removeClass('col-lg-6');
            $('#didie').html('');
            $(this).attr('checked', true);
            $('#hutang').removeAttr('checked');
            $('.kSisa').html('Kembalian');
            $('.hiddenHutang').hide();
        })





        $('#barScan').submit(function(e) {
            let bar = $('#barScanValue').val();
            let place = $('#barPlace').val();
            $.ajax({
                url: "<?= $user['role_id'] == 1 ? base_url('superadmin/save_keranjang_barcode') : base_url('admin/save_keranjang_barcode') ?>",
                type: "POST",
                data: {
                    barcode: bar,
                    cabang: place
                },
                success: function(data) {
                    $('#show-keranjang').html(data);
                    $('.inp-jum').val('1');
                    $('#barScanValue').val('');
                    $('#checkout-here').load("<?= $user['role_id'] == 1 ? base_url('superadmin/tampil_checkout') : base_url('admin/tampil_checkout') ?>");

                }
            });
            return false;
            e.preventDefault();
            console.log(bar);
        })

        $(document).on('click', '.btn-save', function() {
            var id = $(this).data('id');

            var inputMax = $('.inputId-' + id).data('stok');
            var inputMaxine = $('.inputId-' + id).val();
            if (inputMaxine > inputMax) {
                iziToast.warning({
                    title: 'Stok Kurang!',
                    message: 'Max pembelian ' + inputMax,
                    position: 'topCenter'
                });

                return false;

            } else if (inputMaxine == 0) {
                iziToast.warning({
                    message: 'Jumlah Barang Belum Dimasukan!!',
                    position: 'topCenter'
                });

                return false;
            } else {
                let idCabang = $('.idCabang-' + id).val();
                let idBarang = $('.idBarang-' + id).val();
                let kib = $('.kib-' + id).val();
                let hargaBarang = $('.hargaBarang-' + id).val();
                let profit = $('.profit-' + id).val();
                let satuan = $('.satuan-' + id).val();

                if (kib == idBarang) {
                    iziToast.warning({
                        message: 'Barang sudah ada dikeranjang',
                        position: 'topCenter'
                    });
                    $('.inp-jum').val('1');

                    return false;
                } else {
                    $.ajax({
                        url: "<?= $user['role_id'] == 1 ? base_url('superadmin/savedata_keranjang') : base_url('admin/savedata_keranjang') ?>",
                        type: "POST",
                        data: {
                            id_barang: idBarang,
                            id_cabang: idCabang,
                            harga_barang: hargaBarang,
                            satuan: satuan,
                            jml: inputMaxine
                        },
                        success: function(data) {
                            $('#show-keranjang').html(data);
                            $('.inp-jum').val('1');
                            $('#barScanValue').focus();
                            $('#checkout-here').load("<?= $user['role_id'] == 1 ? base_url('superadmin/tampil_checkout') : base_url('admin/tampil_checkout') ?>");
                            iziToast.success({
                                message: 'Barang disimpan di keranjang',
                                position: 'topCenter'
                            });
                        }
                    });
                    return false;
                }
            }
        });

        $(document).on('keyup', '.uang-saya', function() {
            var tunai = $("#tunai").is(':checked');
            var hutang = $("#hutang").is(':checked');
            $('.uang-saya').number(true);
            $('.kembalian-saya-bg').number(true);
            if (tunai) {
                let uang = $('.uang-saya').val();
                let hargaTotal = $('.harga-total-saya').val();
                if (uang == '') {
                    $('.kembalian-saya').val('');
                    $('.kembalian-saya-bg').val('');
                } else {
                    let i = uang - hargaTotal;
                    $('.kembalian-saya').val(i);
                    $('.kembalian-saya-bg').val(i);
                    
                }
            } else if (hutang) {
                let uang = $('.uang-saya').val();
                let hargaTotal = $('.harga-total-saya').val();
                if (uang == '') {
                    $('.kembalian-saya').val('');
                    $('.kembalian-saya-bg').val('');
                } else {
                    let i = hargaTotal - uang;
                    $('.kembalian-saya').val(i);
                    $('.kembalian-saya-bg').val(i);
                }

            }

        })
        $(document).on('click', '#btn-checkout', function() {

            var uangKu = $('.uang-saya').val();
            var totalBayar = $('.tot-ber').val();
            var idPembelian = $('.idPembelian').val();
            var kembalian = $('.kembalian-saya').val();
            var idUsr = $('.idUs').val();

            var tunai = $("#tunai").is(':checked');
            var hutang = $("#hutang").is(':checked');
            if (idUsr == '') {
                iziToast.warning({
                    title: 'Masukan Id User!',
                    position: 'topCenter'
                });
                return false;
            } else if (kembalian < 0) {
                iziToast.warning({
                    title: 'Uang anda kurang!',
                    position: 'topCenter'
                });
                return false;
            } else if (uangKu == 0 && tunai) {
                iziToast.warning({
                    title: 'Uang belum dimasukan!',
                    position: 'topCenter'
                });
                return false;
            } else if (kembalian == 0 && hutang) {
                iziToast.warning({
                    title: 'Uang belum dimasukan!',
                    position: 'topCenter'
                });
                return false;
            } else {

                $.ajax({
                    url: "<?= $user['role_id'] == 1 ? base_url('superadmin/checkout') : base_url('admin/checkout') ?>",
                    type: "post",
                    data: $(".formCheckout").serialize(),
                    success: function(data) {
                        var tunai = $("#tunai").is(':checked');
                        var hutang = $("#hutang").is(':checked');
                        // var getval = metode.data('mB');
                        console.log(tunai);
                        $('#show-keranjang').html(data);
                        $('.inp-jum').val('1');
                        $('#barScanValue').focus();
                        $('#checkout-here').load("<?= $user['role_id'] == 1 ? base_url('superadmin/tampil_checkout') : base_url('admin/tampil_checkout') ?>");
                        if (tunai) {
                            $('#modalPrintBody').load("<?= $user['role_id'] == 1 ? base_url('superadmin/struk_penjualan_c/') : base_url('admin/struk_penjualan_c/') ?>" + idPembelian);
                        } else if (hutang) {
                            $('#modalPrintBody').load("<?= $user['role_id'] == 1 ? base_url('superadmin/struk_penjualan_h/') : base_url('admin/struk_penjualan_h/') ?>" + idPembelian);
                        }
                        $('#modalPrint').modal('show');

                        $('#sdb').load("<?= $user['role_id'] == 1 ? base_url('superadmin/show_data_barang') : base_url('admin/show_data_barang') ?>");
                        $('#modalPrint').on('keyup', function(e) {
                            if (e.which === 13) {
                                $.print("#modalPrintBody");
                            }
                        })
                        $("#notaJual").on('click', function() {
                            $.print("#modalPrintBody");
                        });
                    }
                });
            }
        });
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
        $('#btnUsrL').on('click', function(e) {
            var nama_input = $("input[name='nama_user']").val();
            var telp_input = $("input[name='no_telp']").val();
            var alamat_input = $("textarea[name='alamat_user']").val();

            if (nama_input == '' || telp_input == '' || alamat_input == '') {
                iziToast.warning({
                    title: 'Form tidak boleh kosong',
                    position: 'topCenter'
                });
                return false;
            } else {
                $.ajax({
                    url: "<?= $user['role_id'] == 1 ? base_url('superadmin/addUser') : base_url('admin/addUser') ?>",
                    type: "post",
                    data: $('#formTU').serialize(),
                    success: function(data) {
                        $("input[name='nama_user']").val('');
                        $("input[name='no_telp']").val('');
                        $("textarea[name='alamat_user']").val('');
                        $("input[name='id_user']").val('');
                        $('#didie').load(
                            "<?= $user['role_id'] == 1 ? base_url('superadmin/dinamis_user') : base_url('admin/dinamis_user') ?>"
                        );
                        $('#modalUsr').modal('hide');
                        iziToast.success({
                            title: 'User berhasil ditambahkan',
                            position: 'topCenter'
                        });
                    }
                })
            }
            e.preventDefault();
        })


        $(document).on('click', '.btn-del', function() {
            var id = $(this).data("id");
            $.ajax({
                url: "<?= $user['role_id'] == 1 ? base_url('superadmin/hapus_data_keranjang') : base_url('admin/hapus_data_keranjang') ?>",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#show-keranjang').html(data);
                    $('#barScanValue').focus();
                    $('#checkout-here').load("<?= $user['role_id'] == 1 ? base_url('superadmin/tampil_checkout') : base_url('admin/tampil_checkout') ?>");
                    iziToast.success({
                        message: 'Barang berhasil dihapus',
                        position: 'topCenter'
                    });
                }
            });
        });

        $(document).on('click', '.btn-ubk', function() {
            var id = $(this).data("idk");

            var inputMax = $('.inputJumlah-' + id).data('stok');
            var inputMaxine = $('.inputJumlah-' + id).val();
            if (inputMaxine > inputMax) {
                iziToast.warning({
                    title: 'Stok Kurang!',
                    message: 'Max pembelian ' + inputMax,
                    position: 'topCenter'
                });

                return false;

            } else if (inputMaxine == 0) {
                iziToast.warning({
                    message: 'Jumlah Barang Belum Dimasukan!!',
                    position: 'topCenter'
                });

                return false;
            } else {
                let jumlah = $('.inputJumlah-' + id).val();
                let harga = $('.hbk-' + id).val();
                let idCabang = $('.cbg-' + id).val();
                let profit = $('.pft-' + id).val();
                let idUsr = $('.itusr').val();

                $.ajax({
                    url: "<?= $user['role_id'] == 1 ? base_url('superadmin/ubah_d_keranjang') : base_url('admin/ubah_d_keranjang') ?>",
                    type: "POST",
                    data: {
                        jumlah: jumlah,
                        harga: harga,
                        idCabang: idCabang,
                        idUsr: idUsr,
                        profit: profit,
                        idBarang: id
                    },
                    success: function(data) {
                        $('#show-keranjang').html(data);
                        $('#barScanValue').focus();
                        $('#checkout-here').load("<?= $user['role_id'] == 1 ? base_url('superadmin/tampil_checkout') : base_url('admin/tampil_checkout') ?>");
                        iziToast.success({
                            message: 'Jumlah berhasil diubah',
                            position: 'topCenter'
                        });
                    }
                });
                return false;
            }

        });

        $('.btnKlose').on('click', function() {
            $(window).load('<?= base_url() ?>');
        })

        $(document).on('keyup', function(e) {
            if (e.which === 120) {
                $('.uang-saya').focus();
            } else if (e.which === 115) {
                $('.btnCheckout').click();
            } else if (e.which === 119) {
                $('#bmd').modal('show');
            } else if (e.which === 118) {
                $('#barScanValue').focus();
            }
        })


        $('#show-keranjang').load("<?= $user['role_id'] == 1 ? base_url('superadmin/list_barang') : base_url('admin/list_barang') ?>");
        $('#checkout-here').load("<?= $user['role_id'] == 1 ? base_url('superadmin/tampil_checkout') : base_url('admin/tampil_checkout') ?>");
        $('#disini').load("<?= $user['role_id'] == 1 ? base_url('superadmin/show_data_barang') : base_url('admin/show_data_barang') ?>");

        $('#sdb').load("<?= $user['role_id'] == 1 ? base_url('superadmin/show_data_barang') : base_url('admin/show_data_barang') ?>");
        $("#barScanValue").autocomplete({

            source: "<?= $user['role_id'] == 1 ? base_url('superadmin/get_autocomplete/?') : base_url('admin/get_autocomplete/?') ?>"
        });
    });
</script>
</body>

</html>