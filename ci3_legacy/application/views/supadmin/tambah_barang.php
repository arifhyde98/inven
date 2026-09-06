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
                        <?php if ($user['role_id'] == 1) : ?>
                            <form action="<?= base_url('superadmin/tambah_barang') ?>" method="POST" enctype="multipart/form-data">
                            <?php else : ?>
                                <form action="<?= base_url('admin/tambah_barang') ?>" method="POST" enctype="multipart/form-data">
                                <?php endif; ?>

                                <div class="card-header">
                                    <?php if ($user['role_id'] == 1) : ?>
                                        <a href="<?= base_url('superadmin/barang') ?>" class="btn btn-outline-primary mb-1 mr-1"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="fas fa-save"></i> Simpan</button>
                                        <a href="<?= base_url('superadmin/kategori_barang') ?>" class="btn btn-primary mr-1 mb-1"><i class="fas fa-plus"></i> Tambah Kategori Barang</a>
                                        <a href="<?= base_url('superadmin/suplier') ?>" class="btn btn-primary mr-1 mb-1"><i class="fas fa-plus"></i> Tambah Suplier</a>
                                    <?php else : ?>
                                        <a href="<?= base_url('admin/barang') ?>" class="btn btn-outline-primary mb-1 mr-1"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="fas fa-save"></i> Simpan</button>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="info-prod" data-toggle="tab" href="#nav-prod" role="tab" aria-controls="nav-prod" aria-selected="true">Info Produk</a>
                                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Detail Produk</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-prod" role="tabpanel" aria-labelledby="info-prod">
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label for="">Barcode</label><button type="button" id="btnBarcode" class="btn ml-2 btn-sm btn-outline-primary">Generate Barcode</button>
                                                        <input type="number" name="barcode" value="<?= set_value('barcode') ?>" id="barcodeInp" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Nama Barang</label>
                                                        <input type="text" name="nama" value="<?= set_value('nama') ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kategori Barang <sup>*Optional</sup></label>
                                                        <select class="form-control selectric" name="kategori">
                                                            <option selected value=""> </option>
                                                            <?php foreach ($kategori_barang as $kat_bar) : ?>
                                                                <option value="<?= $kat_bar['nama_kategori'] ?>"><?= $kat_bar['nama_kategori'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Satuan Stok</label>
                                                        <select class="form-control selectric" name="satuan">
                                                            <option disabled selected>-- Pilih Satuan --</option>
                                                            <?php foreach ($satuan_barang_inp as $sb_inp) : ?>
                                                                <option value="<?= $sb_inp['nama_satuan'] ?>"><?= $sb_inp['nama_asli'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <?php if ($user['role_id'] == 1) : ?>
                                                        <div class="form-group">
                                                            <label>Penempatan</label>
                                                            <select class="form-control selectric" name="penempatan">
                                                                <?php foreach ($data_cabang as $dc) : ?>
                                                                    <option value="<?= $dc['id'] ?>"><?= $dc['nama_cabang'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="form-group">
                                                            <label>Penempatan</label>
                                                            <input type="hidden" name="penempatan" value="<?= $data_cabang['id'] ?>">
                                                            <input type="text" readonly class="form-control" value="<?= $data_cabang['nama_cabang'] ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="form-group">
                                                        <label>Gambar <sup>*Optional</sup></label>
                                                        <div class="custom-file">
                                                            <input type="file" name="foto" class="custom-file-input" id="customFile">
                                                            <label class="custom-file-label" for="customFile">Pilih gambar</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 border-top">
                                                    <div class="table-responsive mt-3">
                                                        <table width="100%" class="mb-5">
                                                            <tr>
                                                                <td>
                                                                    <strong>Harga Beli</strong>
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    <strong>Harga Jual</strong>
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    <strong>Profit</strong>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" required id="harga_beli" value="<?= set_value('harga_beli') ?>" name="harga_beli" class="form-control text-right count_hr uang-rp">
                                                                </td>
                                                                <td class="text-center" width="40"></td>
                                                                <td>
                                                                    <input type="text" id="harga_jual" name="harga_jual" value="<?= set_value('harga_jual') ?>" class="form-control text-right count_hr uang-rp">
                                                                </td>
                                                                <td class="text-center" width="40"></td>
                                                                <td>
                                                                    <input type="text" required id="profit" readonly name="profit" value="<?= set_value('profit') ?>" class="form-control text-right count_hr uang-rp">
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td>
                                                                    Profit = harga jual - harga beli
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Keterangan <sup>*Optional</sup></label>
                                                        <textarea class="form-control" name="keterangan" id="" cols="30" rows="10"><?= set_value('keterangan') ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Suplier <sup>*Optional</sup></label>
                                                        <select class="form-control selectric" name="suplier">
                                                            <option disabled selected>-- Pilih Suplier --</option>
                                                            <?php foreach ($suplier as $sup) : ?>
                                                                <option value="<?= $sup['id'] ?>"><?= $sup['nama_suplier'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal Kadaluarsa <sup>*Optional</sup></label>
                                                        <input type="text" data-toggle="datepicker" autocomplete="off" name="kadaluarsa" value="" class="form-control datepicker">
                                                    </div>


                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Kode Penjualan <sup>*Optional</sup></label>
                                                        <input type="text" value="<?= set_value('kd_penjualan') ?>" name="kd_penjualan" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Kode Pembelian <sup>*Optional</sup></label>
                                                        <input type="text" name="kd_pembelian" value="<?= set_value('kd_pembelian') ?>" class="form-control">
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                    </div>
                </div>
            </div>
    </section>
</div>