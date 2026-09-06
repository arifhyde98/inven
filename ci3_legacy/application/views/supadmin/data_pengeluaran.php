<?php
date_default_timezone_set('Asia/Jakarta');
?>
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
                                    if (isset($_GET['idCabang'])) {
                                        $tempat = $_GET['idCabang'];
                                        $p = $this->db->get_where('data_cabang', ['id' => $tempat])->row_array();
                                        echo "Data Pengeluaran " . $p['nama_cabang'];
                                    } else {
                                        echo "Data Pengeluaran Semua Cabang";
                                    }
                                    ?>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/data_pengeluaran') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/data_pengeluaran') ?>?idCabang=<?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if (isset($_GET['idCabang'])) : $cab = $_GET['idCabang'] ?>
                                            <a href="<?= base_url('export/excel_data_pengeluaran_c/' . $cab) ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php else : ?>
                                            <a href="<?= base_url('export/excel_data_pengeluaran') ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    Cabang : <?= $p['nama_cabang'] ?>
                                    <a href="<?= base_url('export/excel_data_pengeluaran ') ?>" target="_blank" class="btn btn-outline-warning btn-sm" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                <?php endif; ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th width="30" class="text-center">
                                                No
                                            </th>
                                            <th>Tanggal</th>
                                            <th>Kode</th>
                                            <th>Cabang</th>
                                            <th>Pengeluaran</th>
                                            <th width="80">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['idCabang'])) :
                                            $tempat = $_GET['idCabang'];
                                            $this->db->order_by('id', 'desc');
                                            $data_pengeluaran_tempat = $this->db->get_where('riwayat_pengeluaran', ['id_cabang' => $tempat, 'status_bukti !=' => 0])->result_array();
                                        ?>
                                            <?php $no = 1;
                                            foreach ($data_pengeluaran_tempat as $dp) :
                                                $cabang = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
                                            ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['tanggal_ind'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['kode_pesanan'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $cabang['nama_cabang'] ?>
                                                    </td>
                                                    <td>
                                                        Rp. <?= rupiah($dp['total_pengeluaran']) ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <?php if ($dp['status_bukti'] == 0) : ?>
                                                            <?php elseif ($dp['status_bukti'] == 1) : ?>
                                                                <button class="btn btn-warning btn-sm mb-1" title="Lihat Pesanan" data-toggle="modal" data-target="#upBukti_<?= $dp['id'] ?>"><i class="fas fa-upload"></i> Upload Bukti Pengeluaran</button>
                                                                <a href="<?= base_url('superadmin/tolak_bukti_pengeluaran/' . $dp['kode_pesanan']) ?>" class="btn btn-sm btn-danger ask-alert" data-asktext="Yakin tidak ingin upload bukti" data-askbtn="Yakin" data-asktitle="Tolak Upload Bukti"><i class="fas fa-times"></i> Tidak Ingin Upload</a>

                                                            <?php elseif ($dp['status_bukti'] == 2) : ?>
                                                                <button class="btn btn-success btn-sm mb-1" title="Lihat Pesanan" data-toggle="modal" data-target="#seeBukti_<?= $dp['id'] ?>"><i class="fas fa-eye"></i> Lihat Bukti</button>

                                                            <?php elseif ($dp['status_bukti'] == 3) : ?>
                                                                <span class="badge badge-dark">Bukti Tidak Diupload</span>

                                                            <?php endif; ?>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        <?php else : ?>
                                            <?php $no = 1;
                                            foreach ($riwayat as $dp) :
                                                $cabang = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
                                            ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['tanggal_ind'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['kode_pesanan'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $cabang['nama_cabang'] ?>
                                                    </td>
                                                    <td>
                                                        Rp. <?= rupiah($dp['total_pengeluaran']) ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <?php if ($dp['status_bukti'] == 0) : ?>
                                                            <?php elseif ($dp['status_bukti'] == 1) : ?>
                                                                <button class="btn btn-warning btn-sm mb-1" title="Lihat Pesanan" data-toggle="modal" data-target="#upBukti_<?= $dp['id'] ?>"><i class="fas fa-upload"></i> Upload Bukti Pengeluaran</button>
                                                                <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/tolak_bukti_pengeluaran/' . $dp['kode_pesanan']) : base_url('admin/tolak_bukti_pengeluaran/' . $dp['kode_pesanan']) ?>" class="btn btn-sm btn-danger ask-alert" data-asktext="Yakin tidak ingin upload bukti" data-askbtn="Yakin" data-asktitle="Tolak Upload Bukti"><i class="fas fa-times"></i> Tidak Ingin Upload</a>

                                                            <?php elseif ($dp['status_bukti'] == 2) : ?>
                                                                <button class="btn btn-success btn-sm mb-1" title="Lihat Pesanan" data-toggle="modal" data-target="#seeBukti_<?= $dp['id'] ?>"><i class="fas fa-eye"></i> Lihat Bukti</button>

                                                            <?php elseif ($dp['status_bukti'] == 3) : ?>
                                                                <span class="badge badge-dark">Bukti Tidak Diupload</span>

                                                            <?php endif; ?>



                                                        </div>
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

<?php foreach ($riwayat as $r) : ?>
    <div class="modal fade" id="upBukti_<?= $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="upBuktiLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upBuktiLabel">Upload Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= $user['role_id'] == 1 ? base_url('superadmin/upload_bukti_pengeluaran/' . $r['kode_pesanan']) : base_url('admin/upload_bukti_pengeluaran/' . $r['kode_pesanan']) ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">extensi : png, jpg, jpeg. Max size : 2mb</label>
                            <div class="custom-file">
                                <input type="file" required name="foto" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Pilih gambar</label>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php foreach ($riwayat as $r) : ?>
    <div class="modal fade" id="seeBukti_<?= $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="seeBuktiLa" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seeBuktiLa">Lihat Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="<?= base_url('assets/images/bukti_pengeluaran/' . $r['bukti_pengeluaran']) ?>" class="img-thumbnail" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>