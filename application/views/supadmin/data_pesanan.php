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
                                        echo "Data Pesanan " . $p['nama_cabang'];
                                    } else {
                                        echo "Data Pesanan Semua Cabang";
                                    }
                                    ?>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/data_pesanan') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/data_pesanan') ?>?idCabang=<?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/pesan_barang') : base_url('admin/pesan_barang') ?>" class="btn btn-sm mt-2 btn-primary"><i class="fas fa-plus"></i> Tambah Pesanan Baru</a>
                                        <?php if (isset($_GET['idCabang'])) : $cab = $_GET['idCabang']; ?>
                                            <a href="<?= base_url('export/excel_data_pesanan_c/' . $cab) ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php else : ?>
                                            <a href="<?= base_url('export/excel_data_pesanan ') ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    Cabang : <?= $p['nama_cabang'] ?>
                                    <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/pesan_barang') : base_url('admin/pesan_barang') ?>" class="btn btn-sm ml-2 btn-primary"><i class="fas fa-plus"></i> Tambah Pesanan Baru</a>
                                    <a href="<?= base_url('admin/excel_data_pesanan ') ?>" target="_blank" class="btn btn-outline-warning btn-sm" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
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
                                            <th>Kode</th>
                                            <th>Nama</th>

                                            <th>Penempatan</th>
                                            <th>Suplier</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Jenis</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['idCabang'])) :
                                            $tempat = $_GET['idCabang'];
                                            $this->db->order_by('id', 'desc');
                                            $data_pesanan_tempat = $this->db->get_where('pesanan_barang', ['tempat' => $tempat])->result_array();
                                        ?>
                                            <?php $no = 1;
                                            foreach ($data_pesanan_tempat as $dp) :
                                                $a = $this->db->get_where('suplier', ['id_suplier' => $dp['suplier']])->row_array();
                                                $cabang = $this->db->get_where('data_cabang', ['id' => $dp['tempat']])->row_array();
                                                $jumlah_pesan_stok = $this->db->get_where('isi_pesanan_barang', ['kode' => $dp['kode']])->num_rows();
                                                $jumlah_pesan_barang = $this->db->get_where('pesanan_manual', ['kode' => $dp['kode']])->num_rows();                                            ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['kode'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['nama'] ?>
                                                    </td>

                                                    <td>
                                                        <?= isset($cabang['nama_cabang']) ? $cabang['nama_cabang'] : '-' ?>
                                                    </td>
                                                    <td>
                                                        <?= !empty($a['nama_suplier']) ? $a['nama_suplier'] : '-' ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['jenis_pesanan'] == 1 ? $jumlah_pesan_stok : $jumlah_pesan_barang ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-<?= $dp['status'] == 0 ? "success" : "primary" ?>"><?= $dp['status'] == 0 ? "Dipesan" : "Diterima" ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="btn btn-outline-<?= $dp['jenis_pesanan'] == 1 ? "danger" : "info" ?>"><?= $dp['jenis_pesanan'] == 1 ? "Stok" : "Barang" ?></span>
                                                    </td>


                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <button class="btn btn-success btn-sm mb-1" title="Lihat Pesanan" data-toggle="modal" data-target="#modalUbahSiswa_<?= $dp['id'] ?>"><i class="fas fa-eye"></i></button>
                                                            <?php if ($user['role_id'] == 1) : ?>
                                                                <?php if ($dp['status'] == 0) : ?>
                                                                    <a href="<?= $dp['jenis_pesanan'] == 1 ? base_url('superadmin/hapus_data_pesanan_stok/' . $dp['kode']) : base_url('superadmin/hapus_data_pesanan/' . $dp['kode']) ?>" class="btn btn-danger hapus-alert btn-sm mb-1" title="Hapus Pesanan"><i class="fas fa-trash"></i></a>
                                                                    <?php if ($dp['jenis_pesanan'] == 1) : ?>

                                                                        <a href="<?= base_url('superadmin/terima_pesanan/' . $dp['kode']) ?>" class="btn ask-alert btn-warning btn-sm mb-1" data-asktext="Yakin ingin menerima pesanan" data-askbtn="Terima" data-asktitle="Terima Pesanan" title="Terima Pesanan"><i class="fas fa-download"></i></a>
                                                                    <?php else : ?>
                                                                        <a href="<?= base_url('superadmin/terima_pesanan_barang/' . $dp['kode']) ?>" class="btn ask-alert btn-warning btn-sm mb-1" data-asktext="Anda akan diarahkan ke halaman proses penyimpanan barang" data-askbtn="Lanjut" data-asktitle="Proses Penyimpanan" title="Terima Pesanan"><i class="fas fa-download"></i></a>
                                                                    <?php endif; ?>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('cetak/bukti_pesanan/' . $dp['kode']) ?>" target="_blank" class="btn btn-info btn-sm mb-1" title="Print Bukti"><i class="fas fa-print"></i></a>
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                <?php if ($dp['status'] == 0) : ?>
                                                                    <a href="<?= base_url('admin/hapus_data_pesanan/' . $dp['kode']) ?>" class="btn btn-danger hapus-alert btn-sm mb-1" title="Hapus Pesanan"><i class="fas fa-trash"></i></a>
                                                                    <a href="<?= base_url('admin/terima_pesanan/' . $dp['kode']) ?>" class="btn ask-alert btn-warning btn-sm mb-1" data-asktext="Yakin ingin menerima pesanan" data-askbtn="Terima" data-asktitle="Terima Pesanan" title="Terima Pesanan"><i class="fas fa-download"></i></a>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('cetak/bukti_pesanan/' . $dp['kode']) ?>" target="_blank" class="btn btn-info btn-sm mb-1" title="Print Bukti"><i class="fas fa-print"></i></a>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        <?php else : ?>
                                            <?php $no = 1;
                                            foreach ($data_pesanan as $dp) :
                                                $a = $this->db->get_where('suplier', ['id_suplier' => $dp['suplier']])->row_array();
                                                $cabang = $this->db->get_where('data_cabang', ['id' => $dp['tempat']])->row_array();
                                                $jumlah_pesan_stok = $this->db->get_where('isi_pesanan_barang', ['kode' => $dp['kode']])->num_rows();
                                                $jumlah_pesan_barang = $this->db->get_where('pesanan_manual', ['kode' => $dp['kode']])->num_rows();
                                            ?>

                                                <tr>
                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['kode'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['nama'] ?>
                                                    </td>

                                                    <td>
                                                        <?= isset($cabang['nama_cabang']) ? $cabang['nama_cabang'] : '-' ?>
                                                    </td>
                                                    <td>
                                                        <?= !empty($a['nama_suplier']) ? $a['nama_suplier'] : '-' ?>
                                                    </td>
                                                    <td>
                                                        <?= $dp['jenis_pesanan'] == 1 ? $jumlah_pesan_stok : $jumlah_pesan_barang ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-<?= $dp['status'] == 0 ? "success" : "primary" ?>"><?= $dp['status'] == 0 ? "Dipesan" : "Diterima" ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="btn btn-outline-<?= $dp['jenis_pesanan'] == 1 ? "danger" : "info" ?>"><?= $dp['jenis_pesanan'] == 1 ? "Stok" : "Barang" ?></span>
                                                    </td>


                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <button class="btn btn-success btn-sm mb-1" title="Lihat Pesanan" data-toggle="modal" data-target="#modalUbahSiswa_<?= $dp['id'] ?>"><i class="fas fa-eye"></i></button>

                                                            <?php if ($user['role_id'] == 1) : ?>
                                                                <?php if ($dp['status'] == 0) : ?>
                                                                    <a href="<?= $dp['jenis_pesanan'] == 1 ? base_url('superadmin/hapus_data_pesanan_stok/' . $dp['kode']) : base_url('superadmin/hapus_data_pesanan/' . $dp['kode']) ?>" class="btn btn-danger hapus-alert btn-sm mb-1" title="Hapus Pesanan"><i class="fas fa-trash"></i></a>
                                                                    <?php if ($dp['jenis_pesanan'] == 1) : ?>

                                                                        <a href="<?= base_url('superadmin/terima_pesanan/' . $dp['kode']) ?>" class="btn ask-alert btn-warning btn-sm mb-1" data-asktext="Yakin ingin menerima pesanan" data-askbtn="Terima" data-asktitle="Terima Pesanan" title="Terima Pesanan"><i class="fas fa-download"></i></a>
                                                                    <?php else : ?>
                                                                        <a href="<?= base_url('superadmin/terima_pesanan_barang/' . $dp['kode']) ?>" class="btn ask-alert btn-warning btn-sm mb-1" data-asktext="Anda akan diarahkan ke halaman proses penyimpanan barang" data-askbtn="Lanjut" data-asktitle="Proses Penyimpanan" title="Terima Pesanan"><i class="fas fa-download"></i></a>
                                                                    <?php endif; ?>
                                                                <?php else : ?>
                                                                    <a href="<?= base_url('cetak/bukti_pesanan/' . $dp['kode']) ?>" target="_blank" class="btn btn-info btn-sm mb-1" title="Print Bukti"><i class="fas fa-print"></i></a>
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                <?php if ($dp['status'] == 0) : ?>
                                                                    <a href="<?= $dp['jenis_pesanan'] == 1 ? base_url('admin/hapus_data_pesanan_stok/' . $dp['kode']) : base_url('admin/hapus_data_pesanan/' . $dp['kode']) ?>" class="btn btn-danger hapus-alert btn-sm mb-1" title="Hapus Pesanan"><i class="fas fa-trash"></i></a>
                                                                    <?php if ($dp['jenis_pesanan'] == 1) : ?>

                                                                        <a href="<?= base_url('admin/terima_pesanan/' . $dp['kode']) ?>" class="btn ask-alert btn-warning btn-sm mb-1" data-asktext="Yakin ingin menerima pesanan" data-askbtn="Terima" data-asktitle="Terima Pesanan" title="Terima Pesanan"><i class="fas fa-download"></i></a>
                                                                    <?php else : ?>
                                                                        <a href="<?= base_url('admin/terima_pesanan_barang/' . $dp['kode']) ?>" class="btn ask-alert btn-warning btn-sm mb-1" data-asktext="Anda akan diarahkan ke halaman proses penyimpanan barang" data-askbtn="Lanjut" data-asktitle="Proses Penyimpanan" title="Terima Pesanan"><i class="fas fa-download"></i></a>
                                                                    <?php endif; ?> <?php else : ?>
                                                                    <a href="<?= base_url('cetak/bukti_pesanan/' . $dp['kode']) ?>" target="_blank" class="btn btn-info btn-sm mb-1" title="Print Bukti"><i class="fas fa-print"></i></a>
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

<?php foreach ($data_pesanan as $daTwo) : ?>
    <?php
    $x = $this->db->get_where('suplier', ['id_suplier' => $daTwo['suplier']])->row_array();

    $y = $this->db->get_where('data_cabang', ['id' => $daTwo['tempat']])->row_array();
    $z = $this->db->get_where('isi_pesanan_barang', ['kode' => $daTwo['kode']])->result_array();
    $opq = $this->db->get_where('pesanan_manual', ['kode' => $daTwo['kode']])->result_array();
    $this->db->select_sum('harga_total');
    $rst = $this->db->get_where('pesanan_manual', ['kode' => $daTwo['kode']])->row_array();
    $this->db->select_sum('total_beli');
    $xz = $this->db->get_where('isi_pesanan_barang', ['kode' => $daTwo['kode']])->row_array();
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalUbahSiswa_<?= $daTwo['id'] ?>">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pemesanan Produk </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Nama Pesanan : <?= $daTwo['nama'] ?> (<?= $daTwo['status'] == 0 ? "Dipesan" : "Diterima" ?>)</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kode Pesanan</label>
                                <input type="text" readonly class="form-control" value="<?= $daTwo['kode'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Nama Pesanan</label>
                                <input type="text" readonly class="form-control" value="<?= $daTwo['nama'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Pesan Dari</label>
                                <input type="text" readonly class="form-control" value="<?= !empty($x['nama_suplier']) ? $x['nama_suplier'] : '-' ?>">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Dikirm Ke</label>
                                <input type="text" readonly class="form-control" value="<?= isset($y['nama_cabang']) ? $y['nama_cabang'] : '-' ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Pesan</label>
                                <input type="text" readonly class="form-control" value="<?= $daTwo['tanggal_pesan'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Terima</label>
                                <input type="text" readonly class="form-control" value="<?= $daTwo['tanggal_terima'] ?>">
                            </div>

                        </div>
                        <div class="col-md-12">
                            <h5>Order Produk</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <?php if ($daTwo['jenis_pesanan'] == 1) : ?>
                                            <tr>
                                                <th scope="col">Produk</th>
                                                <th scope="col">Stok Saat Ini</th>
                                                <th scope="col">Dipesan</th>
                                                <th scope="col">Diterima</th>
                                                <th scope="col">Harga Beli</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($z as $isi) : ?>
                                            <tr>
                                                <td><?= $isi['nama'] ?></td>
                                                <td><?= $isi['stok_sekarang'] ?></td>
                                                <td><?= $isi['stok_pesan'] ?></td>
                                                <td><?= $isi['stok_terima'] ?></td>
                                                <td><?= rupiah($isi['harga_beli']) ?></td>
                                                <td><?= rupiah($isi['total_beli']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="5" align="right">Total</td>
                                            <td><?= rupiah($xz['total_beli']) ?></td>
                                        </tr>
                                    <?php elseif ($daTwo['jenis_pesanan'] == 2) : ?>
                                        <tr>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Satuan</th>
                                            <th scope="col">Jumlah Beli</th>
                                            <th scope="col">Harga Beli</th>
                                            <th scope="col">Harga Total</th>
                                        </tr>
                                        <?php foreach ($opq as $isi) : ?>
                                            <tr>
                                                <td><?= $isi['nama_barang'] ?></td>
                                                <td><?= $isi['kategori'] ?></td>
                                                <td><?= $isi['satuan'] ?></td>
                                                <td><?= $isi['jumlah'] ?></td>
                                                <td><?= rupiah($isi['harga_beli']) ?></td>
                                                <td><?= rupiah($isi['harga_total']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="5" align="right">Total</td>
                                            <td><?= rupiah($rst['harga_total']) ?></td>
                                        </tr>
                                    <?php endif; ?>
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