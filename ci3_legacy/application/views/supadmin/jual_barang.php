<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>

        </div>
        <div id="dialog-message">
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
                            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#bmd">
                                <i class="fas  fa-search"></i> Barang
                            </button>
                            Tekan F8 Untuk Cari Barang
                            <form id="barScan" class="ml-auto">
                                <input type="text" class="form-control ml-2" placeholder="Barcode disini" id="barScanValue" autofocus>
                                <input type="hidden" class="form-control" value="<?= $user['penempatan_cabang'] ?>" id="barPlace">
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="10">-</th>
                                            <th width="80">Nama</th>
                                            <th width="200">Jumlah</th>
                                            <th width="80">Harga</th>
                                            <th width="80">Harga Total</th>
                                            <th width="10"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="show-keranjang">

                                        <?php
                                        $this->db->select_sum('harga_total');
                                        $q = $this->db->get('keranjang')->row_array();
                                        $this->db->select_sum('profit');
                                        $x = $this->db->get('keranjang')->row_array();
                                        ?>

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
                            <form class="formCheckout" method="POST">
                            <?php elseif ($user['role_id'] == 2) : ?>
                                <form class="formCheckout" method="POST">
                                <?php endif; ?>

                                <div class="card-body" id="checkout-here">


                                </div>
                                </form>
                    </div>
                </div>

            </div>
        </div>



    </section>


</div>



<div class="modal fade" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Transaksi Berhasil!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalPrintBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" autofocus id="notaJual">Cetak Struk <i class="fas fa-print"></i></button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="bmd" tabindex="-1" role="dialog" aria-labelledby="bmdTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lgx" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bmdTitle">Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h4>

                            <?php
                            $p = $this->db->get_where('data_cabang', ['id' => $user['penempatan_cabang']])->row_array(); ?>
                            Data Barang : <?= $p['nama_cabang'] ?>

                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="sdb">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalUsr" tabindex="-1" role="dialog" aria-labelledby="modalUsrLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUsrLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTU">
                    <input type="hidden" name="penempatan" value="<?= $user['penempatan_cabang'] ?>">
                    <div class="form-group">
                        <label>Nama User</label>
                        <input type="text" name="nama_user" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>User ID</label>
                        <input type="text" name="id_user" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label>No Telp</label>
                        <input type="text" name="no_telp" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alamat User</label>
                        <textarea name="alamat_user" class="form-control" cols="30" rows="10"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary" id="btnUsrL">Tambah <i class="fas fa-plus"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>