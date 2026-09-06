<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                            <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/barang') : base_url('admin/barang') ?>" class="btn btn-outline-primary mb-1 mr-1"><i class="fas fa-arrow-left"></i> Kembali</a>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-4 text-center">
                                    <img src="<?= base_url('assets/images/barang/' . $data_barang['gambar']) ?>" class="img-thumbnail" alt=""><br>
                                    <?php if ($user['role_id'] == 1) : ?>
                                        <a href="<?= base_url('superadmin/ubah_barang/' . $data_barang['id']) ?>" class="btn btn-warning btn-sm mb-1"><i class="fas fa-pen"></i> Ubah Barang</a><br>
                                        <a href="<?= base_url('superadmin/hapus_barang/' . $data_barang['id']) ?>" class="btn btn-danger custom-hapus-alert btn-sm mb-1" data-ctexta="Data barang serta riwayat stok akan ikut terhapus. Apakah anda yakin ?" title="Hapus"><i class="fas fa-trash"></i> Hapus Barang</a>
                                    <?php else : ?>
                                        <a href="<?= base_url('admin/ubah_barang/' . $data_barang['id']) ?>" class="btn btn-warning btn-sm mb-1"><i class="fas fa-pen"></i> Ubah Barang</a><br>
                                    <?php endif; ?>

                                </div>
                                <div class="col-md-9 border-left mb-3">
                                    <table width="100%" cellpadding="10">

                                        <tr class="border-top border-bottom">
                                            <td width="140">Nama Produk</td>
                                            <td width="5">:</td>
                                            <td><?= $data_barang['nama_barang'] ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="border-top border-bottom">
                                            <td width="140">Barcode</td>
                                            <td width="5">:</td>
                                            <td><?= $data_barang['barcode'] ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="border-top border-bottom">
                                            <td>Harga Beli</td>
                                            <td>:</td>
                                            <td><?= rupiah($data_barang['harga_beli']) ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="border-top border-bottom">
                                            <td>Harga Jual</td>
                                            <td>:</td>
                                            <td><?= rupiah($data_barang['harga_jual']) ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="border-top border-bottom">
                                            <td>Profit</td>
                                            <td>:</td>
                                            <td><?= rupiah($data_barang['profit']) ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="border-top border-bottom">
                                            <td>Stok</td>
                                            <td>:</td>
                                            <td><?= $data_barang['stok'] ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="border-top border-bottom">
                                            <td width="140">Penempatan</td>
                                            <td width="5">:</td>
                                            <td><?= $data_cabang['nama_cabang'] ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="border-top border-bottom">
                                            <td></td>
                                            <td colspan="4"><?= $data_barang['keterangan'] ?></td>
                                        </tr>
                                        <tr class="border-top border-bottom">
                                            <td>Kategori Produk</td>
                                            <td>:</td>
                                            <td><?= $data_barang['kategori'] ?></td>
                                            <td width="130">Suplier</td>
                                            <td width="10">:</td>
                                            <td><?= $suplier['nama_suplier'] ?></td>
                                        </tr>
                                        <tr class="border-top border-bottom">
                                            <td>Kode Penjualan</td>
                                            <td>:</td>
                                            <td><?= $data_barang['kode_penjualan'] ?></td>
                                            <td width="130">Kode Pembelian</td>
                                            <td width="10">:</td>
                                            <td><?= $data_barang['kode_pembelian'] ?></td>
                                        </tr>
                                        <tr class="border-top border-bottom" colspan="3">
                                            <td>Tanggal Kadaluarsa</td>
                                            <td>:</td>
                                            <td><?= $data_barang['exp_date'] ?></td>
                                            
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>