<?php
$a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $penjualan['id_keranjang']])->num_rows();
$b = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $penjualan['id_keranjang']])->result_array();

?>
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto my-5 border p-5">
            <div class="text-center">
                <h5 class="text-uppercase">Nota Pembayaran Cicilan</h5>
                <h5 class="text-uppercase"><?= $p_umum['nama_perusahaan'] ?></h5>
                <p class="font-weight-bold"><?= $p_umum['alamat_perusahaan'] ?></p>
            </div>
            <div class="mt-3">
                <div class="float-left">
                    <p>Kode Penjualan : <?= $penjualan['id_pembelian'] ?></p>
                </div>
                <div class="float-right">
                    <p>Id User : <?= $penjualan['id_user'] ?></p>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Sisa Cicilan</th>
                        <th>Uang</th>
                        <th>Cicilan Akhir</th>
                        <th>Kembalian</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cicilan as $cc) : ?>
                        <tr>
                            <td><?= $cc['tanggal'] ?></td>
                            <td><?= rupiah2($cc['sisa_cicilan']) ?></td>
                            <td><?= rupiah2($cc['uang']) ?></td>
                            <td><?= rupiah2($cc['sisa_cicilan_akhir']) ?></td>
                            <td><?= rupiah2($cc['kembalian']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr style="border-top:solid 1px #000;border-bottom:solid 1px #000">
                        <td colspan="5" align="right">Status : <?= $penjualan['status_utang'] == 0 ? 'Lunas' : 'Belum Lunas' ?>
                        </td>
                    </tr>


                </tbody>
            </table>
            <?php
            $us = $this->db->get_where('user_langganan', ['id_user' => $penjualan['id_user']])->row_array();

            ?>
            <div class="float-right text-center mt-5">
                <p class="mb-5">Admin</p>
                <span class="pr-5">(</span>....<span class="pl-5">)</span>
            </div>
            <div class="float-left text-center mt-5">
                <p class="mb-5"><?= $us['nama_user'] ?></p>
                <span class="pr-5">(</span>....<span class="pl-5">)</span>
            </div>

        </div>
    </div>
</div>