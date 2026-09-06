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
<script src="<?= base_url('assets/') ?>js/sweetalert2.all.min.js"></script>

<!-- JS Libraies -->
<script src="<?= base_url('assets/') ?>js/Chart.min.js"></script>

<!-- Page Specific JS File -->
<script>
    $(document).ready(function() {
        showStatSell();
        showStatSellMonth();
        showStatSellYear();
        showStatPendapatan();
        showStatPendapatanMonth();
        showStatPendapatanYear()
    });


    function showStatSell() {
        {
            $.post("<?= $user['role_id'] == 1 ? base_url('superadmin/getStatSell/' . $cabang['id']) : base_url('admin/getStatSell/' . $cabang['id']) ?>",
                function(data) {
                    var name = [];
                    var marks = [];
                    var marksa = [];
                    var hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu"];
                    
                    for (var i in data) {
                        if (data[i] == null) {
                            marks.push(0);
                            marksa.push(0);
                        } else {
                            marks.push(data[i].total_pembayaran);
                            marksa.push(data[i].pendapatan);
                        }
                    }

                    var chartdata = {

                        labels: hari,
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            hoverBackgroundColor: '#6777ef',
                            hoverBorderColor: '#6777ef',
                            data: marks
                        }, {
                            label: 'Total Pendapatan (Rp)',
                            backgroundColor: '#f9b282',
                            borderColor: '#f9b282',
                            hoverBackgroundColor: '#f9b282',
                            hoverBorderColor: '#f9b282',
                            data: marksa
                        }]
                    };
                    var graphTarget = $("#graphCanvas1");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                });
        }
    }

    function showStatSellMonth() {
        {
            $.post("<?= $user['role_id'] == 1 ? base_url('superadmin/getStatSellMonth/' . $cabang['id']) : base_url('admin/getStatSellMonth/' . $cabang['id']) ?>",
                function(data) {
                    var name = [];
                    var marks = [];
                    var marksa = [];
                    var hari = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                    
                    for (var i in data) {
                        if (data[i] == null) {
                            marks.push(0);
                            marksa.push(0);
                        } else {
                            marks.push(data[i].total_pembayaran);
                            marksa.push(data[i].pendapatan);
                        }
                    }

                    var chartdata = {

                        labels: hari,
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            hoverBackgroundColor: '#6777ef',
                            hoverBorderColor: '#6777ef',
                            data: marks
                        }, {
                            label: 'Total Pendapatan (Rp)',
                            backgroundColor: '#f9b282',
                            borderColor: '#f9b282',
                            hoverBackgroundColor: '#f9b282',
                            hoverBorderColor: '#f9b282',
                            data: marksa
                        }]
                    };
                    var graphTarget = $("#graphCanvas2");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                });
        }
    }

    function showStatSellYear() {
        {
            $.post("<?= $user['role_id'] == 1 ? base_url('superadmin/getStatSellYear/' . $cabang['id']) : base_url('admin/getStatSellYear/' . $cabang['id']) ?>",
                function(data) {
                    var name = [];
                    var marks = [];
                    var marksa = [];
                    var hari = ["2020", "2021", "2022", "2023", "2024", "2025", "2026", "2027", "2028", "2029", "2030"];
                    
                    for (var i in data) {
                        if (data[i] == null) {
                            marks.push(0);
                            marksa.push(0);
                        } else {
                            marks.push(data[i].total_pembayaran);
                            marksa.push(data[i].pendapatan);
                        }
                    }

                    var chartdata = {

                        labels: hari,
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            hoverBackgroundColor: '#6777ef',
                            hoverBorderColor: '#6777ef',
                            data: marks
                        }, {
                            label: 'Total Pendapatan (Rp)',
                            backgroundColor: '#f9b282',
                            borderColor: '#f9b282',
                            hoverBackgroundColor: '#f9b282',
                            hoverBorderColor: '#f9b282',
                            data: marksa
                        }]
                    };
                    var graphTarget = $("#graphCanvas3");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                });
        }
    }

    function showStatPendapatan() {
        {
            $.post("<?= $user['role_id'] == 1 ? base_url('superadmin/getStatPendapatan/' . $cabang['id']) : base_url('admin/getStatPendapatan/' . $cabang['id']) ?>",
                function(data) {
                    var name = [];
                    var marks = [];
                    var hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu"];
                    
                    for (var i in data) {
                        if (data[i] == null) {
                            marks.push(0);
                        } else {
                            marks.push(data[i].total_pengeluaran);
                        }
                    }

                    var chartdata = {

                        labels: hari,
                        datasets: [{
                            label: 'Total Pengeluaran (Rp)',
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            hoverBackgroundColor: '#6777ef',
                            hoverBorderColor: '#6777ef',
                            data: marks
                        }]
                    };
                    var graphTarget = $("#graphCanvas4");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                });
        }
    }
    
    function showStatPendapatanMonth() {
        {
            $.post("<?= $user['role_id'] == 1 ? base_url('superadmin/getStatPendapatanMonth/' . $cabang['id']) : base_url('admin/getStatPendapatanMonth/' . $cabang['id']) ?>",
                function(data) {
                    var name = [];
                    var marks = [];
                    var hari = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                    console.log(data);
                    for (var i in data) {
                        if (data[i] == null) {
                            marks.push(0);
                        } else {
                            marks.push(data[i].total_pengeluaran);
                        }
                    }

                    var chartdata = {

                        labels: hari,
                        datasets: [{
                            label: 'Total Pengeluaran (Rp)',
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            hoverBackgroundColor: '#6777ef',
                            hoverBorderColor: '#6777ef',
                            data: marks
                        }]
                    };
                    var graphTarget = $("#graphCanvas5");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                });
        }
    }

    function showStatPendapatanYear() {
        {
            $.post("<?= $user['role_id'] == 1 ? base_url('superadmin/getStatPendapatanYear/' . $cabang['id']) : base_url('admin/getStatPendapatanYear/' . $cabang['id']) ?>",
                function(data) {
                    var name = [];
                    var marks = [];
                    var hari = ["2020", "2021", "2022", "2023", "2024", "2025", "2026", "2027", "2028", "2029", "2030"];
                    console.log(data);
                    for (var i in data) {
                        if (data[i] == null) {
                            marks.push(0);
                        } else {
                            marks.push(data[i].total_pengeluaran);
                        }
                    }

                    var chartdata = {

                        labels: hari,
                        datasets: [{
                            label: 'Total Pengeluaran (Rp)',
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            hoverBackgroundColor: '#6777ef',
                            hoverBorderColor: '#6777ef',
                            data: marks
                        }]
                    };
                    var graphTarget = $("#graphCanvas6");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                });
        }
    }

</script>

<!-- Template JS File -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<script src="<?= base_url('assets/') ?>js/custom.js"></script>
</body>

</html>