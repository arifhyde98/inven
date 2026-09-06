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
        <?php if ($user['role_id'] == 1) {
            $link = 'superadmin';
        } else {
            $link = 'admin';
        } ?>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <?= $title ?> <a href="<?= base_url($link . '/data_pesanan') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <p>Gunakan satuan jual "pcs" jika ingin menjual eceran </p<br>
                                <form action="<?= base_url($link . '/simpan_jual_barang') ?>" method="POST">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th width="10" class="text-center">
                                                        No
                                                    </th>
                                                    <th>Nama</th>
                                                    <th width="80">Kategori</th>
                                                    <th width="50">Stok</th>
                                                    <th width="70">Harga Beli</th>
                                                    <th width="100">Satuan Jual</th>
                                                    <th width="100">Harga Jual</th>
                                                    <th width="100">Isi Stok Per Satuan Jual</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $a = 1;
                                                foreach ($barang as $row) :
                                                    $suplier = $this->db->get_where('suplier', ['id_suplier' => $pesan['suplier']])->row_array();

                                                ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <?= $a ?>
                                                        </td>
                                                        <td><?= $row['nama_barang'] ?></td>
                                                        <td><?= $row['kategori'] ?></td>
                                                        <td><?= $row['jumlah'] ?> <?= $row['satuan'] ?></td>
                                                        <td><?= $row['harga_beli'] ?></td>
                                                        <td>
                                                            <select class="form-control" name="satuan_jual[]">
                                                                <option value="<?= $row['satuan'] ?>"><?= $row['satuan'] ?></option>
                                                                <?php
                                                                $b = $this->db->get_where('satuan_barang', ['nama_satuan !=' => $row['satuan']])->result_array();
                                                                foreach ($b as $c) :
                                                                ?>
                                                                    <option value="<?= $c['nama_satuan'] ?>"><?= $c['nama_satuan'] ?></option>

                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="number" required name="harga_jual[]" class="form-control">

                                                        </td>
                                                        <input type="hidden" name="id[]" value="<?= $row['id'] ?>">
                                                        <input type="hidden" name="total_harga_sekarang[]" value="<?= $row['harga_total'] ?>">
                                                        <input type="hidden" name="kode" value="<?= $row['kode'] ?>">
                                                        <input type="hidden" name="nama[]" value="<?= $row['nama_barang'] ?>">
                                                        <input type="hidden" name="kategori[]" value="<?= $row['kategori'] ?>">
                                                        <input type="hidden" name="harga_beli[]" value="<?= $row['harga_beli'] ?>">
                                                        <input type="hidden" name="id_cabang[]" value="<?= $row['id_cabang'] ?>">
                                                        <input type="hidden" name="id_suplier[]" value="<?= $suplier['id'] ?>">
                                                        <td>
                                                            <input type="number" value="<?= $row['jumlah'] ?>" required name="stok_jual[]" class="form-control">

                                                        </td>
                                                    </tr>
                                                <?php $a++;
                                                endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan dan Jual</button>
                                </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
</div>