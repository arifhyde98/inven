<div class="container-fluid text-pure-dark">


    <div class="row p-5">
        <div class="col-md-5 " style="border: 1px solid #000;">
            <div class="row">


                <div class="col-md-12 mt-4 mb-1">
                    <div class="text-center">
                        <h5><?= $p_umum['nama_perusahaan'] ?></h5>
                        <?= $cabang['nama_cabang'] ?><br>
                        <?= $cabang['alamat'] ?>
                    </div>
                </div>

                <div class="col-md-12 py-2" style="border-top:solid 1px #000;border-bottom:solid 1px #000">
                    <p class="mb-1">
                        <span><?= $data_barang['id_pembelian'] ?></span>
                        <span class="float-right">
                            <span><?= $data_barang['tanggal'] ?></span>
                        </span>
                    </p>

                </div>
                <div class="col-md-12">
                    <table class="table table-sm table-borderless">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th width="70"></th>
                                <th width="70"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $data_barang['id_keranjang']])->result_array();
                            foreach ($q as $barang) :
                            ?>
                                <tr>
                                    <td><?= $barang['nama'] ?></td>
                                    <td><?= $barang['jumlah'] ?> <?= $barang['satuan'] ?></td>
                                    <td><?= rupiah2($barang['harga']) ?></td>
                                    <td><?= rupiah2($barang['harga_total']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr style="border-top:solid 1px #000;border-bottom:solid 1px #000">
                                <td colspan="3" align="right">Harga Jual :</td>
                                <td><?= rupiah2($data_barang['total_pembayaran']) ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right">Total :</td>
                                <td><?= rupiah2($data_barang['total_pembayaran'])  ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right">Tunai :</td>
                                <td><?= rupiah2($data_barang['uang']) ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right">Kembalian :</td>
                                <td><?= rupiah2($data_barang['kembalian']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center mb-3">
                    <span class="text-uppercase">Terimakasih Selamat Belanja Kembali </span><br>
                    <span class="text-uppercase">===== Sehat selalu ya :) ===== </span><br>
                    <span class="text-uppercase">Layanan Konsumen</span><br>
                    <span class="text-uppercase">=== Toko Andre ===</span><br>
                    <span class="text-uppercase">WA 0813 1685 6161 </span><br>
                    <span class="text-uppercase">Email : a.bakrie508@gmail.com</span><br>
                </div>
            </div>
        </div>
    </div>
</div>