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
                                <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/stok_opname') : base_url('admin/stok_opname') ?>" class="btn btn-outline-primary mb-1 mr-1"><i class="fas fa-arrow-left"></i> Kembali</a>

                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" readonly value="<?= $stok_opname['nama'] ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tempat</label>
                                        <input type="text" readonly value="<?= $data_cabang['nama_cabang'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="text" readonly value="<?= $stok_opname['tanggal'] ?>" class="form-control datepicker">
                                    </div>
                                    <div class="form-group">
                                        <label>Catatan</label>
                                        <textarea readonly class="form-control" id="" cols="30" rows="7"><?= $stok_opname['catatan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <?php if ($user['role_id'] == 1) : ?>
                                        <form action="<?= base_url('superadmin/proses_stok_opname/' . $stok_opname['kode']) ?>" method="POST">
                                        <?php else : ?>
                                            <form action="<?= base_url('admin/proses_stok_opname/' . $stok_opname['kode']) ?>" method="POST">
                                            <?php endif; ?>
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table-1">
                                                    <thead>
                                                        <tr>
                                                            <th width="10" class="text-center">
                                                                No
                                                            </th>
                                                            <th></th>
                                                            <th width="300">Produk</th>
                                                            <th>Kategori</th>
                                                            <th>Stok Aplikasi</th>
                                                            <th width="150">Stok Fisik</th>
                                                        </tr>
                                                    </thead>

                                                    <?php $no = 1;
                                                    foreach ($isi_barang as $db) :
                                                        $baranga = $this->db->get_where('barang', ['id' => $db['id_barang']])->row_array()
                                                    ?>
                                                        <tr id="<?= $db['id'] ?>">
                                                            <td align="center">
                                                                <?= $no ?>
                                                            </td>

                                                            <td>
                                                                <input type="checkbox" checked="checked" name="is_check[]" value="<?= $db['id_barang'] ?>">
                                                            </td>
                                                            <td>
                                                                <?= $db['nama'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $baranga['kategori'] ?>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="stok_aplikasi[]" readonly class="form-control" value="<?= $db['stok_aplikasi'] ?>">

                                                            </td>
                                                            <td>
                                                                <input type="text" name=" stok_fisik[]" class="form-control">
                                                            </td>


                                                        </tr>
                                                    <?php $no++;
                                                    endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-save"></i> Simpan</button>
                                </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
</div>

</section>
</div>