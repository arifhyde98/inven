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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <a href="<?= $user['role_id'] == 1 ? base_url('superadmin/stok_opname') : base_url('admin/stok_opname') ?>" class="btn btn-outline-primary mb-1 mr-1"><i class="fas fa-arrow-left"></i> Kembali</a>

                            </h4>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_GET['idCabang'])) :
                                $idCabang = $_GET['idCabang']; ?>
                                <form action="<?= base_url('superadmin/tambah_stok_opname?idCabang=' . $idCabang) ?>" method="POST">
                                <?php else : ?>
                                    <?php if ($user['role_id'] == 1) : ?>
                                        <form action="<?= base_url('superadmin/tambah_stok_opname') ?>" method="POST">
                                        <?php else : ?>
                                            <form action="<?= base_url('admin/tambah_stok_opname') ?>" method="POST">
                                            <?php endif; ?>
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
                                                                <option value="<?= base_url('superadmin/tambah_stok_opname?idCabang=' . $dt_sup['id']) ?>" <?= $dt_sup['id'] == $idCabang ? 'selected' : '' ?>><?= $dt_sup['nama_cabang'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Nama</label>
                                                        <input type="text" class="form-control" name="nama">
                                                        <input type="hidden" value="<?= $idCabang ?>" name="tempat">
                                                        <?php $kodee  = rand($jum, 99999) ?>
                                                        <input type="hidden" value="SON00<?= $kodee ?>" name="kode">
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal</label>
                                                        <input type="text" data-toggle="datepicker" autocomplete="off" name="tgl" value="" class="form-control datepicker">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Catatan</label>
                                                        <textarea name="catatan" class="form-control" id="" cols="30" rows="7"></textarea>
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
                                                                    <th>Produk</th>
                                                                    <th>Stok Aplikasi</th>

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
                                                                        <?= $db['nama_barang'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $db['stok'] ?>
                                                                    </td>


                                                                </tr>
                                                            <?php $no++;
                                                            endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-plus"></i> Tambah</button>
                                                </div>

                                            </div>
                                        <?php else : ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?php if ($user['role_id'] == 1) : ?>
                                                        <div class="form-group">
                                                            <label>Tempat</label>
                                                            <select class="form-control selectric" onchange="location = this.value;">
                                                                <?php foreach ($data_cabang as $dt_sup) : ?>
                                                                    <option value="<?= base_url('superadmin/tambah_stok_opname?idCabang=' . $dt_sup['id']) ?>"><?= $dt_sup['nama_cabang'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <input type="hidden" value="1" name="tempat">

                                                    <?php else : ?>
                                                        <div class="form-group">

                                                            <label for="">Nama</label>
                                                            <input type="text" readonly value="<?= $data_cabang['nama_cabang'] ?>" class="form-control">
                                                            <input type="hidden" value="<?= $user['penempatan_cabang'] ?>" name="tempat">
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="form-group">
                                                        <label for="">Nama</label>
                                                        <input type="text" class="form-control" name="nama">
                                                        <?php $kodee  = rand($jum, 99999) ?>
                                                        <input type="hidden" value="SON00<?= $kodee ?>" name="kode">

                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal</label>
                                                        <input type="text" name="tgl" data-toggle="datepicker" autocomplete="off" value="" class="form-control datepicker">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Catatan</label>
                                                        <textarea name="catatan" class="form-control" id="" cols="30" rows="7"></textarea>
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
                                                                    <th>Produk</th>
                                                                    <th>Stok Aplikasi</th>

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
                                                                        <?= $db['nama_barang'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $db['stok'] ?>
                                                                    </td>


                                                                </tr>
                                                            <?php $no++;
                                                            endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-plus"></i> Tambah</button>
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