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
                                <?php if ($user['role_id'] == 1) : ?>

                                    <?php
                                    if ($this->uri->segment(3)) {
                                        $tempat = $this->uri->segment(3);
                                        $p = $this->db->get_where('data_cabang', ['id' => $tempat])->row_array();
                                        echo "Log Cicilan " . $p['nama_cabang'];
                                    } else {
                                        echo "Log Cicilan Semua Cabang";
                                    }
                                    ?>
                                    <button type="button" onclick="location.reload()" class="btn btn-sm btn-outline-success"><i class="fas fa-redo-alt"></i> Refresh</button>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/log_cicilan') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/log_cicilan/') ?><?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if ($this->uri->segment(3)) : $cab = $this->uri->segment(3); ?>
                                            <a href="<?= base_url('export/excel_log_cicilan_c/' . $cab) ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php else : ?>
                                            <a href="<?= base_url('export/excel_log_cicilan') ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    Log Cicilan : <?= $p['nama_cabang'] ?>
                                    <button type="button" onclick="location.reload()" class="btn btn-sm btn-outline-success"><i class="fas fa-redo-alt"></i> Refresh</button>
                                    <a href="<?= base_url('export/excel_log_cicilan ') ?>" target="_blank" class="btn btn-outline-warning btn-sm" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>

                                <?php endif; ?>

                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-log">
                                    <thead>
                                        <tr>
                                            <th width="10" class="text-center">
                                                No
                                            </th>
                                            <th>Tanggal</th>
                                            <th width="70">ID Cicilan</th>
                                            <th>ID User</th>
                                            <th>Cabang</th>
                                            <th>Status</th>
                                            <th>Total Bayar</th>
                                            <th>Sisa Cicilan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($this->uri->segment(3)) :
                                            $tempat = $this->uri->segment(3);
                                            $this->db->order_by('id', 'desc');
                                            $data_log_tempat = $this->db->get_where('pembayaran_cicilan', ['id_cabang' => $tempat])->result_array();
                                        ?>
                                            <?php $no = 1;
                                            foreach ($data_log_tempat as $hut) :
                                                $d_cabang = $this->db->get_where('data_cabang', ['id' => $hut['id_cabang']])->row_array();
                                            ?>

                                                <tr>
                                                    <td>
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $hut['tanggal'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['id_cicilan'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $hut['id_user'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $d_cabang['nama_cabang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['sisa_cicilan_akhir'] == 0 ? '<span class="badge badge-success">Melunasi Cicilan</span>' : '<span class="badge badge-info">Membayar Cicilan</span>' ?>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($hut['uang']) ?>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($hut['sisa_cicilan_akhir']) ?>
                                                    </td>

                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        <?php else : ?>
                                            <?php $no = 1;
                                            foreach ($pembayaran as $hut) :
                                                $d_cabang = $this->db->get_where('data_cabang', ['id' => $hut['id_cabang']])->row_array();
                                            ?>

                                                <tr>
                                                    <td>
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $hut['tanggal'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['id_cicilan'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $hut['id_user'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $d_cabang['nama_cabang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['sisa_cicilan_akhir'] == 0 ? '<span class="badge badge-success">Melunasi Cicilan</span>' : '<span class="badge badge-info">Membayar Cicilan</span>' ?>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($hut['uang']) ?>
                                                    </td>
                                                    <td>
                                                        <?= rupiah($hut['sisa_cicilan_akhir']) ?>
                                                    </td>

                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
</div>