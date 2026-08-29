<div class="container-fluid text-pure-dark">


    <div class="row p-5">
        <div class="col-md-6" style="border: 1px solid #000;">
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
                        <div class="float-left">

                            <span><?= $data_barang['id_pembelian'] ?></span><br><br>
                            <span><?= $data_barang['id_pembayaran_cicilan'] ?></span>
                        </div>
                        <div class="float-right">
                            <span>User : <?= $data_barang['id_user'] ?></span>
                        </div>
                    </p>

                </div>
                <div class="col-md-12 mt-3">
                    <table class="table table-sm table-borderless">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Sisa</th>
                                <th width="70">Uang</th>
                                <th width="70">Akhir</th>
                                <th width="70">Kembalian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $data_barang['id_keranjang']])->result_array();
                            foreach ($cicilan as $cc) :
                            ?>
                                <tr style="border-top:solid 1px #000;border-bottom:solid 1px #000">
                                    <td><?= $cc['tanggal'] ?></td>
                                    <td><?= rupiah2($cc['sisa_cicilan']) ?></td>
                                    <td><?= rupiah2($cc['uang']) ?></td>
                                    <td><?= rupiah2($cc['sisa_cicilan_akhir']) ?></td>
                                    <td><?= rupiah2($cc['kembalian']) ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <tr style="border-top:solid 1px #000;border-bottom:solid 1px #000">
                                <td colspan="5" align="right">Status : <?= $data_barang['status_utang'] == 0 ? 'Lunas' : 'Belum Lunas' ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center mb-3">
                    <span class="text-uppercase">STRUK TIDAK BOLEH HILANG</span><br>
                    <span class="text-uppercase">BERIKAN STRUK JIKA SAAT MEMBAYAR !</span><br>
                    <span class="text-uppercase">=== MEMBAYAR CICILAN ===</span><br>
                    <span class="text-uppercase">WA 0813 1685 6161 </span><br>
                    <span class="text-uppercase">Email : a.bakrie508@gmail.com</span><br>
                </div>
            </div>
        </div>
    </div>
</div>