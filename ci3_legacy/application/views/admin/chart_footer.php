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
<script src="<?= base_url('assets/') ?>modules/chart.min.js"></script>

<!-- Page Specific JS File -->
<script>
    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Rokok", "Sabun", "Permen", "Minuman", "Mie", "Makanan", "Elektronik", "Alat"],
            datasets: [{
                label: 'Statistics',
                data: [
                    <?= $this->db->get_where('barang', ['kategori' => "Rokok", 'id_cabang' => $user['penempatan_cabang']])->num_rows() ?>,
                    <?= $this->db->get_where('barang', ['kategori' => "Sabun", 'id_cabang' => $user['penempatan_cabang']])->num_rows() ?>,
                    <?= $this->db->get_where('barang', ['kategori' => "Permen", 'id_cabang' => $user['penempatan_cabang']])->num_rows() ?>,
                    <?= $this->db->get_where('barang', ['kategori' => "Minuman", 'id_cabang' => $user['penempatan_cabang']])->num_rows() ?>,
                    <?= $this->db->get_where('barang', ['kategori' => "Mie", 'id_cabang' => $user['penempatan_cabang']])->num_rows() ?>,
                    <?= $this->db->get_where('barang', ['kategori' => "Makanan", 'id_cabang' => $user['penempatan_cabang']])->num_rows() ?>,
                    <?= $this->db->get_where('barang', ['kategori' => "Elektronik", 'id_cabang' => $user['penempatan_cabang']])->num_rows() ?>,
                    <?= $this->db->get_where('barang', ['kategori' => "Alat", 'id_cabang' => $user['penempatan_cabang']])->num_rows() ?>
                ],
                borderWidth: 2,
                backgroundColor: '#6777ef',
                borderColor: '#6777ef',
                borderWidth: 2.5,
                pointBackgroundColor: '#ffffff',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }],
                xAxes: [{

                    gridLines: {
                        display: false
                    }
                }]
            },
        }
    });
    
</script>
<script src="<?= base_url('assets/') ?>js/page/modules-chartjs.js"></script>

<!-- Template JS File -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<script src="<?= base_url('assets/') ?>js/custom.js"></script>
</body>

</html>