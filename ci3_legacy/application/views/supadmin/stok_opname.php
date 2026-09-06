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
                                        echo "Stok Opname " . $p['nama_cabang'];
                                    } else {
                                        echo "Stok Opname Semua Cabang";
                                    }
                                    ?>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/stok_opname') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/stok_opname') ?>?idCabang=<?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <a href="<?= base_url('superadmin/tambah_stok_opname') ?>" class="btn btn-sm btn-primary mt-2"><i class="fas fa-plus"></i> Tambah Stok Opname Baru</a>
                                        <?php if (isset($_GET['idCabang'])) : $cab = $_GET['idCabang'] ?>
                                            <a href="<?= base_url('export/excel_data_opname_c/' . $cab) ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php else : ?>
                                            <a href="<?= base_url('export/excel_data_opname') ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php endif; ?>
                                    </div>

                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    <p class="mb-1">Stok Opname <?= $p['nama_cabang'] ?></p>
                                    <a href="<?= base_url('admin/tambah_stok_opname') ?>" class="btn btn-sm btn-primary mt-2"><i class="fas fa-plus"></i> Tambah Stok Opname Baru</a>
                                    <a href="<?= base_url('export/excel_data_opname ') ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>

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
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Tempat</th>
                                            <th>Status</th>
                                            <th>Jumlah</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['idCabang'])) :
                                            $tempat = $_GET['idCabang'];
                                            $stok_opname_tempat = $this->db->get_where('stok_opname', ['tempat' => $tempat])->result_array();
                                        ?>
                                            <?php $no = 1;
                                            foreach ($stok_opname_tempat as $dp) :
                                                $cabang = $this->db->get_where('data_cabang', ['id' => $dp['tempat']])->row_array();
                                                $this->db->select_sum('stok_fisik');
                                                $jum = $this->db->get_where('isi_stok_opname', ['kode' => $dp['kode']])->row_array();
                                            ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $dp['nama'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['tanggal'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $cabang['nama_cabang'] ?>
                                                    </td>

                                                    <td>
                                                        <span class="badge badge-success"><?= $dp['status'] ?></span>
                                                    </td>
                                                    <td>
                                                        <?= $jum['stok_fisik'] ?>
                                                    </td>


                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <button class="btn btn-success btn-sm mb-1" title="Lihat Pesanan" data-toggle="modal" data-target="#modalUbahSiswa_<?= $dp['id'] ?>"><i class="fas fa-eye"></i></button>
                                                            <?php if ($dp['disabled'] != 1) : ?>
                                                                <a href="<?= base_url('superadmin/hapus_stok_opname/' . $dp['kode']) ?>" class="btn btn-danger hapus-alert btn-sm mb-1" title="Hapus Pesanan"><i class="fas fa-trash"></i></a>
                                                                <a href="<?= base_url('superadmin/proses_stok_opname/' . $dp['kode']) ?>" class="btn btn-warning btn-sm mb-1" title="Proses Stok Opname"><i class="fas fa-pen"></i></a>
                                                            <?php elseif ($dp['disabled'] == 1) : ?>
                                                                <a href="<?= base_url('cetak/stok_opname/' . $dp['kode']) ?>" target="_blank" class="btn btn-info btn-sm mb-1" title="Cetak"><i class="fas fa-print"></i></a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        <?php else : ?>
                                            <?php $no = 1;
                                            foreach ($stop_opname as $dp) :
                                                $cabang = $this->db->get_where('data_cabang', ['id' => $dp['tempat']])->row_array();
                                                $this->db->select_sum('stok_fisik');
                                                $jum = $this->db->get_where('isi_stok_opname', ['kode' => $dp['kode']])->row_array();
                                            ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $dp['nama'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['tanggal'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $cabang['nama_cabang'] ?>
                                                    </td>

                                                    <td>
                                                        <span class="badge badge-<?= $dp['disabled'] == 0 ? 'warning' : 'success' ?>">
                                                            <?php if ($dp['disabled'] == 0) : ?>
                                                                Belum Di Proses
                                                            <?php else : ?>
                                                                Sudah Di Proses
                                                            <?php endif; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?= $jum['stok_fisik'] ?>
                                                    </td>


                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <button class="btn btn-success btn-sm mb-1" title="Lihat Pesanan" data-toggle="modal" data-target="#modalUbahSiswa_<?= $dp['id'] ?>"><i class="fas fa-eye"></i></button>
                                                            <?php if ($user['role_id'] == 1) : ?>
                                                                <?php if ($dp['disabled'] != 1) : ?>
                                                                    <a href="<?= base_url('superadmin/hapus_stok_opname/' . $dp['kode']) ?>" class="btn btn-danger hapus-alert btn-sm mb-1" title="Hapus Pesanan"><i class="fas fa-trash"></i></a>
                                                                    <a href="<?= base_url('superadmin/proses_stok_opname/' . $dp['kode']) ?>" class="btn btn-warning btn-sm mb-1" title="Proses Stok Opname"><i class="fas fa-pen"></i></a>
                                                                <?php elseif ($dp['disabled'] == 1) : ?>
                                                                    <a href="<?= base_url('cetak/stok_opname/' . $dp['kode']) ?>" target="_blank" class="btn btn-info btn-sm mb-1" title="Cetak"><i class="fas fa-print"></i></a>
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                <?php if ($dp['disabled'] != 1) : ?>
                                                                    <a href="<?= base_url('admin/hapus_stok_opname/' . $dp['kode']) ?>" class="btn btn-danger hapus-alert btn-sm mb-1" title="Hapus Pesanan"><i class="fas fa-trash"></i></a>
                                                                    <a href="<?= base_url('admin/proses_stok_opname/' . $dp['kode']) ?>" class="btn btn-warning btn-sm mb-1" title="Proses Stok Opname"><i class="fas fa-pen"></i></a>
                                                                <?php elseif ($dp['disabled'] == 1) : ?>
                                                                    <a href="<?= base_url('cetak/stok_opname/' . $dp['kode']) ?>" target="_blank" class="btn btn-info btn-sm mb-1" title="Cetak"><i class="fas fa-print"></i></a>
                                                                <?php endif; ?>
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

<?php foreach ($stop_opname as $daTwo) : ?>
    <?php
    // $x = $this->db->get_where('suplier', ['id_suplier' => $daTwo['suplier']])->row_array();
    $y = $this->db->get_where('data_cabang', ['id' => $daTwo['tempat']])->row_array();
    $this->db->order_by('id', 'desc');
    $z = $this->db->get_where('isi_stok_opname', ['kode' => $daTwo['kode']])->result_array();
    $this->db->select_sum('selisih_harga');
    $xz = $this->db->get_where('isi_stok_opname', ['kode' => $daTwo['kode']])->row_array();
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalUbahSiswa_<?= $daTwo['id'] ?>">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stock Opname <?= $daTwo['nama'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" readonly class="form-control" value="<?= $daTwo['nama'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <input type="text" readonly class="form-control" value="<?= $daTwo['status'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Tempat</label>
                                <input type="text" readonly class="form-control" value="<?= $y['nama_cabang'] ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal Kirim</label>
                                <input type="text" readonly class="form-control" value="<?= $daTwo['tanggal'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Catatan</label>
                                <textarea name="" class="form-control" id="" cols="30" readonly rows="4"><?= $daTwo['catatan'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h5>Order Produk</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2">Produk</th>
                                            <th class="text-center" rowspan="2">Stok Di Aplikasi</th>
                                            <th class="text-center" rowspan="2">Stok Fisik</th>
                                            <th class="text-center" colspan="2">Selisih</th>

                                        </tr>
                                        <tr>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Rp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($z as $isi) : ?>
                                            <tr>
                                                <td><?= $isi['nama'] ?></td>
                                                <td><?= $isi['stok_aplikasi'] ?></td>
                                                <td><?= $isi['stok_fisik'] ?></td>
                                                <td><?= $isi['selisih_total'] ?></td>
                                                <td><?= rupiah($isi['selisih_harga']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="4" align="right">Total</td>
                                            <td><?= rupiah($xz['selisih_harga']) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>