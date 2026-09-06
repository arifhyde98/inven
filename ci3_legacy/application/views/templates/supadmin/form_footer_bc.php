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
<script src="<?= base_url('assets/') ?>modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/jquery-selectric/jquery.selectric.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/datatables.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/') ?>modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="<?= base_url('assets/') ?>js/jquery.number.min.js"></script>
<script src="<?= base_url('assets/') ?>js/jQuery.print.min.js"></script>
<?php if (isset($_GET['barcode'])) :
    $barcode = $_GET['barcode'];
    $row = $this->db->get_where('barang', ['barcode' => $barcode])->row_array();
    $harga = $row['harga_jual'];
    $kode = $row['barcode'];
?>
<?php endif; ?>
<script>
    $(document).ready(function() {
        $('#barang').on('change', function(e) {
            $("form").submit();
            $('#harga_barang').number(true);

        });
        $('#harga_barang').number(true);

        $('#buat_bc').click(function() {
            // var nama = $('#barang').val();
            var nama = $('select').find(':selected').attr('data-nama');
            let harga = $('#harga_barang').val();
            $('#harga_barang').number(true);
            let code = $('#code').val();
            let jumlah = $('#jumlah').val();
            $("#hasil").html("<h3>HASIL</h3>");
            $("#bar_disini").html("");
            for (let a = 1; a <= jumlah; a++) {
                <?php if (isset($_GET['barcode'])) : ?>
                    $('#bar_disini').append(`
                            <div class="kotak-barcode mb-4">
                           <div  class="bg-white p-2" style="border:1px solid #000;"> 
                                <?= "<img alt='Barcode Generator TEC-IT' src='https://barcode.tec-it.com/barcode.ashx?data=" . $kode . "&code=EAN13&multiplebarcodes=true&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0' />" ?><br>
                           </div>
                                <h5 class="text-center mb-1 mt-2" style="color:#000;">` + nama + `</h5>
                                <h5 class="text-center font-weight-normal mb-1" style="color:#000;">Rp. <?= rupiah($harga) ?></h5>
                            </div>
                        `);

                <?php else : ?>

                <?php endif; ?>
            }
            $('#cetak').html("<a class='btn btn-info text-center'><i class='fas fa-print'></i> Cetak</a>");
        })
        $("#cetak").on('click', function() {
            // //Print ele2 with default options
            $.print("#bar_disini");
        });
    })
</script>

<!-- Page Specific JS File -->
<script src="<?= base_url('assets/') ?>js/page/modules-datatables.js"></script>


<!-- Template JS File -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<script src="<?= base_url('assets/') ?>js/custom.js"></script>


</body>

</html>