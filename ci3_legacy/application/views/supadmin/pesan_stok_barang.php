<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>

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
                                Tambah Pesanan Baru
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->userdata('role_id') == 1) : ?>
                                <form action="<?= base_url('superadmin/pesan_stok_barang') ?>" method="POST">
                                <?php elseif ($this->session->userdata('role_id') == 2) : ?>
                                    <form action="<?= base_url('admin/pesan_stok_barang') ?>" method="POST">
                                    <?php endif; ?>
                                    <?php if (isset($_GET['idCabang'])) :
                                        $idCabang = $_GET['idCabang'];
                                        $barangBaru = $this->db->get_where('barang', ['id_cabang' => $idCabang])->result_array();
                                    ?>
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label>Tempat</label>
                                                    <select class="form-control selectric" onchange="location = this.value;">
                                                        <?php foreach ($data_cabang as $dt_sup) : ?>
                                                            <option value="<?= base_url('superadmin/pesan_stok_barang?idCabang=' . $dt_sup['id']) ?>" <?= $dt_sup['id'] == $idCabang ? 'selected' : '' ?>><?= $dt_sup['nama_cabang'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Nama Pesanan</label>
                                                    <input type="hidden" name="cabang" value="<?= $idCabang ?>">
                                                    <input type="text" placeholder="Contoh: Pesanan minggu ke-2" class="form-control" name="nama">
                                                </div>
                                                <div class="form-group">
                                                    <label>Pesan Dari</label>
                                                    <select class="form-control selectric" name="suplier">
                                                        <option disabled selected>-- Pilih Suplier --</option>
                                                        <option value="-">-</option>
                                                        <?php foreach ($data_suplier as $dt_sup) : ?>
                                                            <option value="<?= $dt_sup['id_suplier'] ?>"><?= $dt_sup['nama_suplier'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Kode Pesanan</label>
                                                    <?php $rand_kp = rand($jum, 99999) ?>
                                                    <input type="text" value="PSN00<?= $rand_kp ?>" readonly class="form-control" name="kode">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Pesan</label>
                                                    <input type="text" data-toggle="datepicker" autocomplete="off" name="tgl_pesan" value="" class="form-control datepicker">
                                                </div>


                                            </div>

                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped" id="table-1">
                                                        <thead>
                                                            <tr>
                                                                <th width="10" class="text-center">
                                                                    No
                                                                </th>
                                                                <th></th>
                                                                <th>Nama</th>
                                                                <th>Stok Saat Ini</th>
                                                                <th>Harga Beli</th>
                                                                <th>Jumlah</th>

                                                            </tr>
                                                        </thead>

                                                        <?php $no = 1;
                                                        foreach ($barangBaru as $db) :
                                                            $penempatan = $this->db->get_where('data_cabang', ['id' => $db['id_cabang']])->row_array()
                                                        ?>

                                                            <tr id="<?= $db['id'] ?>">
                                                                <td align="center">
                                                                    <?= $no ?>
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="is_check[]" value="<?= $db['id'] ?>" id="<?= $db['id'] ?>" data-id="<?= $db['id'] ?>" class="check-produk">
                                                                </td>
                                                                <td>
                                                                    <?= $db['nama_barang'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $db['stok'] ?>
                                                                </td>
                                                                <td>
                                                                    <input type="text" disabled class="form-control" value="<?= $db['harga_beli'] ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="jumlah[]" disabled class="form-control" value="1" id="j_<?= $db['id'] ?>">

                                                                </td>

                                                            </tr>
                                                        <?php $no++;
                                                        endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Tambah</button>
                                            </div>

                                        </div>
                                    <?php else : ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tempat</label>
                                                    <?php if ($user['role_id'] == 1) : ?>
                                                        <select class="form-control selectric" onchange="location = this.value;">
                                                            <?php foreach ($data_cabang as $dt_sup) : ?>
                                                                <option value="<?= base_url('superadmin/pesan_stok_barang?idCabang=' . $dt_sup['id']) ?>"><?= $dt_sup['nama_cabang'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <input type="hidden" name="cabang" value="1">

                                                    <?php elseif ($user['role_id'] == 2) : ?>
                                                        <input type="text" readonly class="form-control" value="<?= $data_cabang['nama_cabang'] ?>">
                                                        <input type="hidden" name="cabang" value="<?= $data_cabang['id'] ?>">
                                                    <?php else : ?>

                                                    <?php endif; ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Nama Pesanan</label>
                                                    <input type="text" placeholder="Contoh: Pesanan minggu ke-2" class="form-control" name="nama">
                                                </div>
                                                <div class="form-group">
                                                    <label>Pesan Dari</label>
                                                    <select class="form-control selectric" name="suplier">
                                                        <option disabled selected>-- Pilih Suplier --</option>
                                                        <option value="-">-</option>
                                                        <?php foreach ($data_suplier as $dt_sup) : ?>
                                                            <option value="<?= $dt_sup['id_suplier'] ?>"><?= $dt_sup['nama_suplier'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Kode Pesanan</label>
                                                    <?php $rand_kp = rand($jum, 99999) ?>
                                                    <input type="text" value="PSN00<?= $rand_kp ?>" readonly class="form-control" name="kode">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Pesan</label>
                                                    <input type="text" data-toggle="datepicker" autocomplete="off" name="tgl_pesan" value="" class="form-control datepicker">
                                                </div>


                                            </div>

                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped" id="table-1">
                                                        <thead>
                                                            <tr>
                                                                <th width="10" class="text-center">
                                                                    No
                                                                </th>
                                                                <th></th>
                                                                <th>Nama</th>
                                                                <th>Stok Saat Ini</th>
                                                                <th>Harga Beli</th>
                                                                <th>Jumlah</th>

                                                            </tr>
                                                        </thead>

                                                        <?php $no = 1;
                                                        foreach ($barang as $db) :
                                                            $penempatan = $this->db->get_where('data_cabang', ['id' => $db['id_cabang']])->row_array()
                                                        ?>

                                                            <tr id="<?= $db['id'] ?>">
                                                                <td align="center">
                                                                    <?= $no ?>
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="is_check[]" value="<?= $db['id'] ?>" id="<?= $db['id'] ?>" data-id="<?= $db['id'] ?>" class="check-produk">
                                                                </td>
                                                                <td>
                                                                    <?= $db['nama_barang'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $db['stok'] ?> <?= $db['satuan'] ?>
                                                                </td>
                                                                <td>
                                                                    <input type="text" disabled class="form-control" value="<?= $db['harga_beli'] ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="jumlah[]" disabled class="form-control" value="1" id="j_<?= $db['id'] ?>">

                                                                </td>

                                                            </tr>
                                                        <?php $no++;
                                                        endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-plus"></i> Tambah Pesanan</button>
                                            </div>

                                        </div>
                                    <?php endif; ?>

                                    </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
</div>

</section>
</div>