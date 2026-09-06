<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>

        <div class="section-body">


            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-4">Statistik <a href="<?= $user['role_id'] == 1 ? base_url('superadmin') : base_url('admin') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-arrow-left"></i> Kembali</a></h5>
                </div>
                <div class="col-md-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Penjualan & Pendapatan</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Pengeluaran</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <?php
                                                    date_default_timezone_set('Asia/Jakarta');
                                                    $wdate = date('d-m-Y', strtotime('monday this week'));
                                                    $wdate_to = $wdate;
                                                    $wdate_to = strtotime("+6 days", strtotime($wdate_to));
                                                    $wdate_to = date("d-m-Y", $wdate_to);

                                                    ?>
                                                    <h4>
                                                        Statistik <?= $cabang['nama_cabang'] ?>
                                                        <p class="text-small font-weight-normal mb-0">Dari Tanggal : <?= $wdate ?> - <?= $wdate_to ?></p>
                                                    </h4>

                                                </div>
                                                <div class="card-body">
                                                    <canvas id="graphCanvas1"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="row">
                                        <?php if ($user['role_id'] == 1) : ?>
                                            <?php foreach ($semua_cabang as $sm) : ?>
                                                <div class="col-md-12">
                                                    <a href="<?= base_url('superadmin/statistik_penjualan/' . $sm['id']) ?>" class="btn mb-3 btn-success btn-block"><i class="fas fa-eye"></i> Statistik <?= $sm['nama_cabang'] ?></a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <?php
                                                    date_default_timezone_set('Asia/Jakarta');
                                                    $Year = date('Y');


                                                    ?>
                                                    <h4>
                                                        Statistik <?= $cabang['nama_cabang'] ?>
                                                        <p class="text-small font-weight-normal mb-0">Statistik Bulanan Tahun : <?= $Year ?></p>
                                                    </h4>

                                                </div>
                                                <div class="card-body">
                                                    <canvas id="graphCanvas2"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <?php
                                                    date_default_timezone_set('Asia/Jakarta');
                                                    $wdate = date('d-m-Y', strtotime('monday this week'));
                                                    $wdate_to = $wdate;
                                                    $wdate_to = strtotime("+6 days", strtotime($wdate_to));
                                                    $wdate_to = date("d-m-Y", $wdate_to);

                                                    ?>
                                                    <h4>
                                                        Statistik <?= $cabang['nama_cabang'] ?>
                                                        <p class="text-small font-weight-normal mb-0">Statistik Dari Tahun 2020 - 2030</p>
                                                    </h4>

                                                </div>
                                                <div class="card-body">
                                                    <canvas id="graphCanvas3"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <?php
                                                    date_default_timezone_set('Asia/Jakarta');
                                                    $wdate = date('d-m-Y', strtotime('monday this week'));
                                                    $wdate_to = $wdate;
                                                    $wdate_to = strtotime("+6 days", strtotime($wdate_to));
                                                    $wdate_to = date("d-m-Y", $wdate_to);

                                                    ?>
                                                    <h4>
                                                        Statistik Pengeluaran <?= $cabang['nama_cabang'] ?>
                                                        <p class="text-small font-weight-normal mb-0">Dari Tanggal : <?= $wdate ?> - <?= $wdate_to ?></p>
                                                    </h4>

                                                </div>
                                                <div class="card-body">
                                                    <canvas id="graphCanvas4"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <?php if ($user['role_id'] == 1) : ?>
                                            <?php foreach ($semua_cabang as $sm) : ?>
                                                <div class="col-md-12">
                                                    <a href="<?= base_url('superadmin/statistik_penjualan/' . $sm['id']) ?>" class="btn mb-3 btn-success btn-block"><i class="fas fa-eye"></i> Statistik <?= $sm['nama_cabang'] ?></a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <?php
                                                    date_default_timezone_set('Asia/Jakarta');
                                                    $wdate = date('d-m-Y', strtotime('monday this week'));
                                                    $wdate_to = $wdate;
                                                    $wdate_to = strtotime("+6 days", strtotime($wdate_to));
                                                    $wdate_to = date("d-m-Y", $wdate_to);

                                                    ?>
                                                    <h4>
                                                        Statistik Pengeluaran <?= $cabang['nama_cabang'] ?>
                                                        <p class="text-small font-weight-normal mb-0">Statistik Bulanan Tahun : <?= $Year ?></p>
                                                    </h4>

                                                </div>
                                                <div class="card-body">
                                                    <canvas id="graphCanvas5"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <?php
                                                    date_default_timezone_set('Asia/Jakarta');
                                                    $wdate = date('d-m-Y', strtotime('monday this week'));
                                                    $wdate_to = $wdate;
                                                    $wdate_to = strtotime("+6 days", strtotime($wdate_to));
                                                    $wdate_to = date("d-m-Y", $wdate_to);

                                                    ?>
                                                    <h4>
                                                        Statistik Pengeluaran <?= $cabang['nama_cabang'] ?>
                                                        <p class="text-small font-weight-normal mb-0">Statistik Dari Tahun 2020 - 2030</p>
                                                    </h4>

                                                </div>
                                                <div class="card-body">
                                                    <canvas id="graphCanvas6"></canvas>
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

        </div>
    </section>
</div>