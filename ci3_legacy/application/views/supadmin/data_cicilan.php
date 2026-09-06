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
                                        echo "Data Cicilan " . $p['nama_cabang'];
                                    } else {
                                        echo "Data Cicilan Semua Cabang";
                                    }
                                    ?>
                                    <button type="button" onclick="location.reload()" class="btn btn-sm btn-outline-success"><i class="fas fa-redo-alt"></i> Refresh</button>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= base_url('superadmin/data_cicilan') ?>">Semua</a>
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/data_cicilan/') ?><?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if ($this->uri->segment(3)) : $cab = $this->uri->segment(3); ?>
                                            <a href="<?= base_url('export/excel_data_cicilan_c/' . $cab) ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php else : ?>
                                            <a href="<?= base_url('export/excel_data_cicilan') ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    Data Cicilan : <?= $p['nama_cabang'] ?>
                                    <button type="button" onclick="location.reload()" class="btn btn-sm btn-outline-success"><i class="fas fa-redo-alt"></i> Refresh</button>
                                    <a href="<?= base_url('export/excel_data_cicilan ') ?>" target="_blank" class="btn btn-outline-warning btn-sm" title="Export Ke Excel"><i class="fas fa-file-excel"></i> Export Ke Excel</a>
                                <?php endif; ?>

                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>ID Cicilan</th>
                                            <th>ID User</th>
                                            <th>Cabang</th>
                                            <th>Tanggal</th>
                                            <th>Total Bayar</th>
                                            <th>Sisa Cicilan</th>
                                            <th>Status</th>
                                            <th width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($this->uri->segment(3)) :
                                            $tempat = $this->uri->segment(3);
                                            $this->db->order_by('id', 'desc');
                                            $data_hutang_tempat = $this->db->get_where('riwayat_penjualan', ['metode_bayar' => 'cicilan', 'id_cabang' => $tempat])->result_array();
                                        ?>
                                            <?php $no = 1;
                                            foreach ($data_hutang_tempat as $hut) :
                                                $d_cabang = $this->db->get_where('data_cabang', ['id' => $hut['id_cabang']])->row_array();
                                            ?>

                                                <tr>
                                                    <td>
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $hut['id_pembayaran_cicilan'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $hut['id_user'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $d_cabang['nama_cabang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['tanggal'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['total_pembayaran'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['kembalian'] ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($hut['status_utang'] == 1) : ?>
                                                            <span class="badge badge-dark">Belum Lunas</span>
                                                        <?php else : ?>
                                                            <span class="badge badge-success">Lunas</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalDetail<?= $hut['id'] ?>"><i class="fas fa-eye"></i> Detail</button>
                                                            <?php if ($hut['metode_bayar'] == 'cicilan' && $hut['status_utang'] == 0) : ?>
                                                                <a href="<?= $user['role_id'] == 1 ? base_url('cetak/struk_pembayaran_cicilan/' . $hut['id_pembayaran_cicilan']) : base_url('cetak/struk_pembayaran_cicilan/' . $hut['id_pembayaran_cicilan']) ?>" class="btn btn-sm btn-info" target="_blank"><i class="fas fa-print"></i> Print Struk</a>

                                                            <?php else : ?>
                                                                <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/bayar_cicilan/' . $hut['id_pembayaran_cicilan']) : base_url('admin/bayar_cicilan/' . $hut['id_pembayaran_cicilan']) ?>" class="btn btn-primary btn-sm mb-1"><i class="fas fa-money-bill"></i> Bayar</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $no++;
                                            endforeach; ?>
                                        <?php else : ?>
                                            <?php $no = 1;
                                            foreach ($hutang as $hut) :
                                                $d_cabang = $this->db->get_where('data_cabang', ['id' => $hut['id_cabang']])->row_array();
                                            ?>

                                                <tr>
                                                    <td>
                                                        <?= $no ?>
                                                    </td>

                                                    <td>
                                                        <?= $hut['id_pembayaran_cicilan'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $hut['id_user'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $d_cabang['nama_cabang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['tanggal'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['total_pembayaran'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $hut['kembalian'] ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($hut['status_utang'] == 1) : ?>
                                                            <span class="badge badge-dark">Belum Lunas</span>
                                                        <?php else : ?>
                                                            <span class="badge badge-success">Lunas</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#modalDetail<?= $hut['id'] ?>"><i class="fas fa-eye"></i> Detail</button>
                                                            <?php if ($hut['metode_bayar'] == 'cicilan' && $hut['status_utang'] == 0) : ?>
                                                                <a href="<?= $user['role_id'] == 1 ? base_url('cetak/struk_pembayaran_cicilan/' . $hut['id_pembayaran_cicilan']) : base_url('cetak/struk_pembayaran_cicilan/' . $hut['id_pembayaran_cicilan']) ?>" class="btn btn-sm btn-info" target="_blank"><i class="fas fa-print"></i> Print Struk</a>

                                                            <?php else : ?>
                                                                <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/bayar_cicilan/' . $hut['id_pembayaran_cicilan']) : base_url('admin/bayar_cicilan/' . $hut['id_pembayaran_cicilan']) ?>" class="btn btn-primary btn-sm mb-1"><i class="fas fa-money-bill"></i> Bayar</a>
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
                </div>/

            </div>
        </div>

    </section>
</div>


<?php foreach ($hutang as $daTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalBayarCicilan_<?= $daTwo['id'] ?>">
        <div class="modal-dialog modal-lgx modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bayar Cicilan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <?php
                            $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $daTwo['id_keranjang']])->num_rows();
                            $b = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $daTwo['id_keranjang']])->result_array();
                            ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Harga Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($b as $barang) : ?>
                                                <tr>
                                                    <td><?= $barang['nama'] ?></td>
                                                    <td><?= $barang['jumlah'] ?> <?= $barang['satuan'] ?></td>
                                                    <td><?= rupiah($barang['harga']) ?></td>
                                                    <td><?= rupiah($barang['harga_total']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="3" align="right">Total Harga</td>
                                                <td>Rp. <?= rupiah($daTwo['total_pembayaran']) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php if ($daTwo['status_utang'] == 1) : ?>
                                        <p>Status Cicilan : Belum Lunas</p>
                                        <p>Pembayaran Terakhir : Rp. <?= rupiah($daTwo['uang']) ?></p>
                                        <p>Sisa Cicilan : Rp. <?= rupiah($daTwo['kembalian']) ?></p>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <p>Pembayaran Cicilan</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">ID Pembelian</label>
                                        <input type="text" readonly class="form-control" value="<?= $daTwo['id_pembelian'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">ID Pembayaran</label>
                                        <input type="text" readonly class="form-control" value="<?= $daTwo['id_pembayaran_cicilan'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">ID User</label>
                                <input type="text" readonly class="form-control" value="<?= $daTwo['id_user'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Sisa Cicilan</label>
                                <input type="text" readonly class="form-control" value="<?= $daTwo['id_user'] ?>">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php foreach ($hutang as $daTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDetail<?= $daTwo['id'] ?>">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <?php
                    $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $daTwo['id_keranjang']])->num_rows();
                    $b = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $daTwo['id_keranjang']])->result_array();
                    ?>
                    <div class="float-left">
                        <p>ID Penjualan : <?= $daTwo['id_pembelian'] ?></p>

                        <p>Total Barang : <?= $a ?></p>
                    </div>
                    <div class="float-right">
                        <?php if ($daTwo['metode_bayar'] == 'cicilan') : ?>
                            <p>ID Cicilan : <?= $daTwo['id_pembayaran_cicilan'] ?></p>
                            <p>ID User : <?= $daTwo['id_user'] ?></p>

                        <?php endif; ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Harga Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($b as $barang) : ?>
                                        <tr>
                                            <td><?= $barang['nama'] ?></td>
                                            <td><?= $barang['jumlah'] ?> <?= $barang['satuan'] ?></td>
                                            <td><?= rupiah($barang['harga']) ?></td>
                                            <td><?= rupiah($barang['harga_total']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" align="right">Total Harga</td>
                                        <td>Rp. <?= rupiah($daTwo['total_pembayaran']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if ($daTwo['status_utang'] == 1) : ?>
                                <p>Status Cicilan : Belum Lunas</p>
                                <p>Pembayaran Terakhir : Rp. <?= rupiah($daTwo['uang']) ?></p>
                                <p>Sisa Cicilan : Rp. <?= rupiah($daTwo['kembalian']) ?></p>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>