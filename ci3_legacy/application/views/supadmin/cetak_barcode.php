<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <?php if ($user['role_id'] == 1) : ?>
                                <a href="<?= base_url('cetak/barcode_semua') ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-barcode"></i> Cetak Barcode Semua Barang</a>
                            <?php else : ?>
                                <a href="<?= base_url('cetak/barcode_semua') ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-barcode"></i> Cetak Barcode Semua Barang</a>
                            <?php endif; ?>
                            <span class="badge badge-warning ml-2"><i class="fas fa-info"></i> Untuk Mendapatkan Barcode Harus Konek Internet</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <form method="get">
                                        <?php if (isset($_GET['barcode'])) :
                                            $barcode = $_GET['barcode'];
                                            $row = $this->db->get_where('barang', ['barcode' => $barcode])->row_array();
                                            $kode = $row['barcode'];
                                        ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Nama Barang</label>
                                                        <select name="barcode" class="form-control selectric" id="barang">
                                                            <option selected disabled>Nama Barang</option>
                                                            <?php foreach ($barang as $bar) : ?>
                                                                <option value="<?= $bar['barcode'] ?>" data-nama="<?= $bar['nama_barang'] ?>" <?= $bar['barcode'] == $barcode ? 'selected' : '' ?>><?= $bar['nama_barang'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Harga Barang</label>
                                                        <input type="text" class="form-control" value="<?= $row['harga_jual'] ?>" id="harga_barang" readonly>
                                                    </div>
                                                    <button type="button" id="buat_bc" class="btn btn-primary"><i class="fas fa-download"></i> Buat</button>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?= $code_barcodenya ?>
                                                        <label for="">Code</label>
                                                        <input type="text" class="form-control" value="<?= $kode ?>" id="code" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Jumlah</label>
                                                        <select name="" class="form-control selectric" id=jumlah>
                                                            <?php for ($a = 1; $a <= 100; $a++) : ?>
                                                                <option value="<?= $a ?>"><?= $a ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Nama Barang</label>
                                                        <select name="barcode" class="form-control selectric" id="barang">
                                                            <option selected disabled>Nama Barang</option>
                                                            <?php foreach ($barang as $bar) : ?>
                                                                <option value="<?= $bar['barcode'] ?>"><?= $bar['nama_barang'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Harga Barang</label>
                                                        <input type="text" class="form-control" id="harga_barang" readonly>
                                                    </div>
                                                    <button type="button" id="buat_bc" class="btn btn-primary"><i class="fas fa-download"></i> Buat</button>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?= $code_barcodenya ?>
                                                        <label for="">Code</label>
                                                        <input type="text" class="form-control" id="code" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Jumlah</label>
                                                        <select name="" class="form-control selectric" id=jumlah>
                                                            <?php for ($a = 1; $a <= 100; $a++) : ?>
                                                                <option value="<?= $a ?>"><?= $a ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </form>
                                </div>
                                <div class="col-md-12 mt-4 border-top pt-2">
                                    <div id="hasil" class="mb-4 mt-3"></div>
                                    <div id="cetak" class="text-white mb-4"></div>

                                    <div id="bar_disini"></div><br>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>