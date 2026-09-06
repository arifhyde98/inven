<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto my-5 border p-5">
            <div class="text-center">
                <h5 class="text-uppercase">Laporan Stok Barang</h5>
                <h5 class="text-uppercase"><?= $p_umum['nama_perusahaan'] ?></h5>
                <p class="font-weight-bold"><?= $p_umum['alamat_perusahaan'] ?></p>
            </div>
            <div class="mt-3 mb-3">

            </div>
            <?php
            $tempat = $_GET['idCabang'];
            $cabang = $this->db->get_where('data_cabang', ['id' => $tempat])->row_array();
            ?>
            <p>Nama Cabang : <?= $cabang['nama_cabang'] ?></p>
            <table class="table table-bordered" id="table-1">
                <thead>
                    <tr>
                        <th width="30" class="text-center">
                            No
                        </th>
                        <th>Nama Barang</th>
                        <th>Tanggal</th>
                        <th>Expired</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Stok Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;

                    $this->db->order_by('id', 'desc');
                    $data_barang = $this->db->get_where('barang', ['id_cabang' => $tempat])->result_array();
                    foreach ($data_barang as $db) :
                        $this->db->select_sum('jumlah');
                        $pemasukan = $this->db->get_where('stok_barang', ['id_barang' => $db['id'], 'status' => 1])->row_array();
                        $this->db->select_sum('jumlah');
                        $keluar = $this->db->get_where('stok_barang', ['id_barang' => $db['id'], 'status' => 2])->row_array();
                        $qTgl = $this->db->get_where('stok_barang', ['id_barang' => $db['id']])->row_array();
                    ?>

                        <tr>
                            <td class="text-center">
                                <?= $no ?>
                            </td>

                            <td>
                                <?= $db['nama_barang'] ?>
                            </td>
                            <td>
                                <?= date('d F Y', $qTgl['tgl']) ?>
                            </td>
                            <td>
                                <?= $db['exp_date'] == 0 ? "-" : $db['exp_date'] ?>
                            </td>
                            <td>
                                <?= $pemasukan['jumlah'] ?> <?= $db['satuan'] ?>
                            </td>
                            <td>
                                <?php if ($keluar['jumlah'] == 0) : ?>
                                    0
                                <?php else : ?>
                                    <?= $keluar['jumlah'] ?> <?= $db['satuan'] ?>
                                <?php endif; ?>
                            </td>

                            <td>
                                <b><?= $db['stok'] ?> <?= $db['satuan'] ?></b>
                            </td>
                        </tr>
                    <?php $no++;
                    endforeach; ?>
                </tbody>
            </table>
            <div class="float-right text-center mt-5">
                <p class="mb-5">Admin</p>
                <span class="pr-5">(</span>....<span class="pl-5">)</span>
            </div>
        </div>
    </div>
</div>