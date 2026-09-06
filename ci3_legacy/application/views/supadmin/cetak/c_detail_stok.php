<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto my-5 border p-5">
            <div class="text-center">
                <h5 class="text-uppercase">Riwayat Stok Barang</h5>
                <h5 class="text-uppercase"><?= $p_umum['nama_perusahaan'] ?></h5>
                <p class="font-weight-bold"><?= $p_umum['alamat_perusahaan'] ?></p>
            </div>
            <div class="mt-3 mb-3">

            </div>
            <p>Nama Barang : <?= $data_barang['nama_barang'] ?></p>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Keterangan</th>
                                    <th>Jml</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                $mutasi = 0;
                                $skurd = $this->db->get_where('stok_barang', ['id_barang' => $data_barang['id']])->result_array();
                                foreach ($skurd as $skrd) : ?>

                                    <tr>
                                        <td><?= date('d F Y - H:i', $skrd['tgl']) ?></td>
                                        <?php if ($skrd['status'] == 1) : ?>
                                            <td><?= $skrd['jumlah'] ?></td>
                                            <td></td>
                                            <td><?= $skrd['keterangan'] ?></td>
                                            <td><?= $mutasi += $skrd['jumlah'] ?></td>
                                        <?php elseif ($skrd['status'] == 2) : ?>
                                            <td></td>
                                            <td><?= $skrd['jumlah'] ?></td>
                                            <td><?= $skrd['keterangan'] ?></td>
                                            <td><?= $mutasi -= $skrd['jumlah'] ?></td>
                                        <?php endif; ?>

                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                                <tr>
                                    <td colspan="4" align="right">Stok saat ini</td>

                                    <td>
                                        <?= $data_barang['stok'] ?> <?= $data_barang['satuan'] ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="float-right text-center mt-5">
                <p class="mb-5">Admin</p>
                <span class="pr-5">(</span>....<span class="pl-5">)</span>
            </div>
        </div>
    </div>
</div>