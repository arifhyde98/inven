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
<script src="<?= base_url('assets/') ?>modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url('assets/') ?>modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/jquery-selectric/jquery.selectric.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/datatables.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="<?= base_url('assets/') ?>js/jquery.number.min.js"></script>

<script>
    $(document).ready(function() {
        $('#barang').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var code = $(this).find(':selected').attr('data-code');
            var harga = $(this).find(':selected').attr('data-harga');
            $('#harga_barang').val(harga);
            $('#code').val(code);
        });
        $('#buat_bc').click(function() {
            var nama = $('#barang').val();
            let harga = $('#harga_barang').val();
            let code = $('#code').val();
            let jumlah = $('#jumlah').val();
            $("#bar_disini").html("");

            $.ajax({
                url: "http://localhost/inven/superadmin/ambil_barcode",
                type: 'post',
                data: {
                    code: code,
                },
                success: function() {
                    document.location.href = "<?= base_url('superadmin/ambil_barcode'); ?>";
                    for (let a = 1; a <= jumlah; a++) {
                        $('#kata').html('<h1>Hasil Pembuatan</h1>');
                        $('#bar_disini').append(`
                            <div class="kotak mb-2"><?= $asd->getBarcode('s', $asd::TYPE_CODE_128); ?>
                                <span class="text-center">` + code + `</span><br>
                                <span class="text-center">` + nama + `</span><br>
                                <span class="text-center">Rp. ` + harga + `</span><br>
                            </div>
                        `);
                    }
                }
            });


        })

    })
</script>

<!-- Page Specific JS File -->
<script src="<?= base_url('assets/') ?>js/page/forms-advanced-forms.js"></script>
<script src="<?= base_url('assets/') ?>js/page/modules-datatables.js"></script>


<!-- Template JS File -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<script src="<?= base_url('assets/') ?>js/custom.js"></script>


</body>

</html>