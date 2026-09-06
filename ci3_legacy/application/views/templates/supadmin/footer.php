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

<script src="<?= base_url('assets') ?>/modules/jquery.min.js"></script>
<script src="<?= base_url('assets') ?>/modules/popper.js"></script>
<script src="<?= base_url('assets/') ?>js/datepicker.min.js"></script>
<script src="<?= base_url('assets') ?>/modules/tooltip.js"></script>
<script src="<?= base_url('assets') ?>/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url('assets') ?>/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?= base_url('assets') ?>/modules/moment.min.js"></script>
<script src="<?= base_url('assets') ?>/js/stisla.js"></script>
<script src="<?= base_url('assets/') ?>js/sweetalert2.all.min.js"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="<?= base_url('assets') ?>/js/scripts.js"></script>
<script src="<?= base_url('assets') ?>/js/custom.js"></script>
<script>
  $('.form-check-inputx').on('click', function() {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');

    $.ajax({
      url: "<?= base_url('supadmin/ubah_akses'); ?>",
      type: 'post',
      data: {
        menuId: menuId,
        roleId: roleId
      },
      success: function() {
        document.location.href = "<?= base_url('supadmin/manage_akses/'); ?>" + roleId;
      }
    });

  });
</script>
</body>

</html>