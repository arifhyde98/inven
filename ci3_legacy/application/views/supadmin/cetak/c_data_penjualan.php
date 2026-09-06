<?php
$a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $penjualan['id_keranjang']])->num_rows();
$b = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $penjualan['id_keranjang']])->result_array();

?>
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto my-5 border p-5">
            <div class="text-center">
                <h5 class="text-uppercase">Nota Penjualan Barang</h5>
                <h5 class="text-uppercase"><?= $p_umum['nama_perusahaan'] ?></h5>
                <p class="font-weight-bold"><?= $p_umum['alamat_perusahaan'] ?></p>
            </div>
            <div class="mt-3">
                <div class="float-left">
                    <p>Kode Penjualan : <?= $penjualan['id_pembelian'] ?></p>
                    <p>Tanggal : <?= $penjualan['tanggal'] ?></p>
                    <p>Total Barang : <?= $a ?></p>
                </div>
                <div class="float-right">
                    <p>Nama Cabang : <?= $cb['nama_cabang'] ?></p>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Harga Total</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($b as $barang) : ?>
                        <tr>
                            <td><?= $barang['nama'] ?></td>
                            <td><?= $barang['jumlah'] ?></td>
                            <td><?= $barang['satuan'] ?></td>
                            <td>Rp. <?= rupiah($barang['harga']) ?></td>
                            <td>Rp. <?= rupiah($barang['harga_total']) ?></td>
                        </tr>
                    <?php endforeach; ?>


                </tbody>
            </table>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th width="150"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" align="right">Subtotal Harga</td>
                        <td align="right">Rp. <?= rupiah($penjualan['total_pembayaran']) ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right">Uang</td>
                        <td align="right">Rp. <?= rupiah($penjualan['uang']) ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right">Kembalian</td>
                        <td align="right">Rp. <?= rupiah($penjualan['kembalian']) ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="float-right text-center mt-5">
                <p class="mb-5">Admin</p>
                <span class="pr-5">(</span>....<span class="pl-5">)</span>
            </div>
        </div>
    </div>
</div>