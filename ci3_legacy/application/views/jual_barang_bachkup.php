<?php
date_default_timezone_set('Asia/Jakarta');
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>
        <?= $this->session->flashdata('pesan') ?>
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
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>Keranjang <i class="fas fa-cart-arrow-down"></i></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="10">-</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Harga Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show-keranjang">
                                        <?php foreach ($keranjang as $ker) :
                                            $q = $this->db->get_where('barang', ['id' => $ker['id_barang']])->row_array();
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php if ($user['role_id'] == 1) : ?>
                                                        <a href="<?= base_url('superadmin/hapus_data_keranjang/' . $ker['id']) ?>" class="btn btn-sm btn-danger"><i class="fas fa-minus"></i></a>
                                                    <?php elseif ($user['role_id'] == 2) : ?>
                                                        <a href="<?= base_url('admin/hapus_data_keranjang/' . $ker['id']) ?>" class="btn btn-sm btn-danger"><i class="fas fa-minus"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $q['nama_barang'] ?></td>
                                                <td><?= $ker['jumlah'] ?> <?= $q['satuan'] ?></td>
                                                <td><?= rupiah($ker['harga']) ?></td>

                                                <td><?= rupiah($ker['harga_total']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if ($jum_keranjang == 0) : ?>
                                            <tr>
                                                <td colspan="5" align="center">Belum ada barang</td>
                                            </tr>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="4">Subtotal Pembelian</td>
                                                <?php
                                                    $this->db->select_sum('harga_total');
                                                    $q = $this->db->get('keranjang')->row_array();
                                                    $this->db->select_sum('harga_beli');
                                                    $x = $this->db->get('keranjang')->row_array();
                                                    ?>
                                                <td>
                                                    <?= rupiah($q['harga_total']) ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pembayaran <i class="fas fa-money-bill"></i></h4>
                        </div>
                        <?php if ($user['role_id'] == 1) : ?>
                            <form action="<?= base_url('superadmin/checkout') ?>" method="POST">
                            <?php elseif ($user['role_id'] == 2) : ?>
                                <form action="<?= base_url('admin/checkout') ?>" method="POST">
                                <?php endif; ?>

                                <div class="card-body">
                                    <?php if ($jum_keranjang == 0) : ?>
                                        Belum ada data barang
                                    <?php else : ?>
                                        <div class="form-group">
                                            <label for="">ID Pembelian</label>
                                            <?php $a = $this->db->get('riwayat_penjualan')->num_rows(); ?>
                                            <input type="text" name="id_pembelian" readonly class="form-control" value="JBR00<?= $a += 1; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Total Pembayaran</label>
                                            <input type="text" name="total_bayar" readonly class="form-control" value="<?= rupiah($q['harga_total']) ?>">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Uang</label>
                                                    <input type="number" min="1" name="uang_saya" class="form-control uang-saya">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Kembalian</label>
                                                    <input type="hidden" name="harga_total" value="<?= $q['harga_total'] ?>" class="harga-total-saya">
                                                    <input type="hidden" name="harga_total_beli" value="<?= $x['harga_beli'] ?>" class="harga-total-saya">
                                                    <input type="text" name="kembalian_saya" readonly class="form-control kembalian-saya">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-right"><i class="fas fa-check"></i> Bayar</button>
                                        <div class="clearfix"></div>
                                    <?php endif; ?>
                                </div>
                                </form>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <?php if ($user['role_id'] == 1) : ?>
                                    <?php
                                        if (isset($_GET['idCabang'])) {
                                            $tempat = $_GET['idCabang'];
                                            $p = $this->db->get_where('data_cabang', ['id' => $tempat])->row_array();
                                            echo "Data Barang " . $p['nama_cabang'];
                                        } else {
                                            echo "Data Barang Cabang Utama";
                                        }
                                        ?>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Kategori Cabang
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <?php foreach ($data_cabang as $dac) : ?>
                                                <a class="dropdown-item" href="<?= base_url('superadmin/jual_barang') ?>?idCabang=<?= $dac['id'] ?>"><?= $dac['nama_cabang'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php elseif ($user['role_id'] == 2) :
                                    $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                                    Data Barang : <?= $p['nama_cabang'] ?>
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
                                            <th width="80">Kategori</th>
                                            <th width="200">Nama Barang</th>
                                            <th width="80">Stok</th>
                                            <th width="80">Harga</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['idCabang'])) :
                                            $tempat = $_GET['idCabang'];
                                            $data_barang_tempat = $this->db->get_where('barang', ['id_cabang' => $tempat])->result_array();
                                            ?>
                                            <?php $no = 1;
                                                foreach ($data_barang_tempat as $db) : ?>
                                                <tr>
                                                    <form action="<?= base_url('superadmin/tambah_beli') ?>" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="id_cabang" value="<?= $db['id_cabang'] ?>">
                                                        <input type="hidden" name="id_barang" value="<?= $db['id'] ?>">
                                                        <input type="hidden" name="harga_barang" value="<?= $db['harga_jual_tax'] ?>">
                                                        <input type="hidden" name="harga_beli" value="<?= $db['harga_peroleh'] ?>">
                                                        <input type="hidden" name="satuan" value="<?= $db['satuan'] ?>" id="">
                                                        <td class="text-center">
                                                            <?= $no ?>
                                                        </td>
                                                        <td>
                                                            <?= $db['kategori'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $db['nama_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $db['stok'] ?> <?= $db['satuan'] ?>
                                                        </td>

                                                        <td>
                                                            Rp. <?= rupiah($db['harga_jual_tax']) ?>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="number" name="jml" min="1" max="<?= $db['stok'] ?>" required class="form-control">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <?= $db['satuan'] ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group-horizontal text-center">
                                                                <?php if ($db['stok'] < 1) : ?>
                                                                    <button class="btn btn-primary btn-sm mb-1" disabled><i class="fas fa-check"></i> Beli</button>
                                                                <?php else : ?>
                                                                    <button type="submit" class="btn btn-primary btn-sm mb-1"><i class="fas fa-check"></i> Beli</button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </form>
                                                </tr>

                                            <?php $no++;
                                                endforeach; ?>
                                        <?php else : ?>
                                            <?php $no = 1;
                                                foreach ($data_barang as $db) : ?>
                                                <tr>


                                                    <td class="text-center">
                                                        <?= $no ?>
                                                    </td>
                                                    <td>
                                                        <?= $db['kategori'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $db['nama_barang'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $db['stok'] ?> <?= $db['satuan'] ?>
                                                    </td>

                                                    <td>
                                                        Rp. <?= rupiah($db['harga_jual_tax']) ?>
                                                    </td>
                                                   
                                                    <td>
                                                        <div class="btn-group-horizontal text-center">
                                                            <?php if ($db['stok'] < 1) : ?>
                                                                <button class="btn btn-primary btn-sm mb-1" disabled><i class="fas fa-check"></i> Beli</button>
                                                            <?php else : ?>
                                                                <button class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#terimaStok_<?= $db['id'] ?>"><i class="fas fa-check"></i> Beli</button>
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

<?php foreach ($data_barang as $ktbTwo) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="terimaStok_<?= $ktbTwo['id'] ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php if ($user['role_id'] == 1) : ?>
                    <form action="<?= base_url('superadmin/tambah_beli') ?>" method="POST" enctype="multipart/form-data">
                    <?php elseif ($user['role_id'] == 2) : ?>
                        <form action="<?= base_url('admin/tambah_beli') ?>" method="POST" enctype="multipart/form-data">
                        <?php endif; ?> <input type="hidden" name="id" value="<?= $ktbTwo['id'] ?>">
                        <div class="modal-body">
                            <p>Nama Barang : <?= $ktbTwo['nama_barang'] ?></p>
                            <input type="hidden" name="id_barang" value="<?= $ktbTwo['id'] ?>">
                            <input type="hidden" name="id_cabang" value="<?= $ktbTwo['id_cabang'] ?>">

                            <input type="hidden" name="harga_barang" value="<?= $ktbTwo['harga_jual_tax'] ?>">
                            <input type="hidden" name="harga_beli" value="<?= $ktbTwo['harga_peroleh'] ?>">
                            <input type="hidden" name="satuan" value="<?= $ktbTwo['satuan'] ?>" id="">
                            <div class="form-group">
                                <label>Jumlah Yang Dibeli</label>
                                <div class="input-group">
                                    <input type="number" name="jml" min="1" max="<?= $ktbTwo['stok'] ?>" required class="form-control">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <?= $ktbTwo['satuan'] ?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                        </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>