<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto my-5 border p-5">
            <div class="text-center">
                <h5 class="text-uppercase">Nota Pembelian Barang</h5>
                <h5 class="text-uppercase"><?= $p_umum['nama_perusahaan'] ?></h5>
                <p class="font-weight-bold"><?= $p_umum['alamat_perusahaan'] ?></p>
            </div>
            <div class="mt-3">
                <div class="float-left">
                    <p>Nama Pesanan : <?= $pesanan['nama'] ?></p>
                    <p>Pesan Dari : <?= !empty($sp['nama_suplier']) ? $sp['nama_suplier'] : '-' ?></p>
                    <p>Dikirm Ke : <?= isset($cb['nama_cabang']) ? $cb['nama_cabang'] : '-' ?> <br><?= isset($cb['alamat']) ? $cb['alamat'] : '' ?></p>
                </div>
                <div class="float-right">
                    <p>Tanggal Pesan : <?= $pesanan['tanggal_pesan'] ?></p>
                    <p>Tanggal Terima : <?= $pesanan['tanggal_terima'] ?></p>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <?php if ($pesanan['jenis_pesanan'] == 1) : ?>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Dipesan</th>
                            <th>Diterima</th>
                            <th>Harga Beli</th>
                            <th>Harga Total</th>
                        </tr>

                </thead>

                <tbody>
                    <?php
                        $this->db->select_sum('total_beli');
                        $xz = $this->db->get_where('isi_pesanan_barang', ['kode' => $pesanan['kode']])->row_array();
                        foreach ($isi_pesanan as $row) : ?>
                        <tr>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['stok_pesan'] ?></td>
                            <td><?= $row['stok_terima'] ?></td>
                            <td>Rp. <?= rupiah($row['harga_beli']) ?></td>
                            <td>Rp. <?= rupiah($row['total_beli']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" align="right">Total</td>
                        <td>Rp. <?= rupiah($xz['total_beli']) ?></td>
                    </tr>
                <?php elseif ($pesanan['jenis_pesanan'] == 2) : ?>
                    <tr>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Dipesan</th>
                        <th scope="col">Diterima</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">Harga Total</th>
                    </tr>
                    <?php
                        $opq = $this->db->get_where('pesanan_manual', ['kode' => $pesanan['kode']])->result_array();
                        $this->db->select_sum('harga_total');
                        $rst = $this->db->get_where('pesanan_manual', ['kode' => $pesanan['kode']])->row_array();
                    ?>
                    <?php foreach ($opq as $isi) : ?>
                        <tr>
                            <td><?= $isi['nama_barang'] ?></td>
                            <td><?= $isi['jumlah'] ?> <?= $isi['satuan'] ?></td>
                            <td><?= $isi['jumlah'] ?> <?= $isi['satuan'] ?></td>
                            <td><?= rupiah($isi['harga_beli']) ?></td>
                            <td><?= rupiah($isi['harga_total']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" align="right">Total</td>
                        <td>Rp. <?= rupiah($rst['harga_total']) ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <div class="float-left text-center mt-5">
                <span class="pr-5">(</span>....<span class="pl-5">)</span>
            </div>
            <div class="float-right text-center mt-5">
                <span class="pr-5">(</span>....<span class="pl-5">)</span>
            </div>
        </div>
    </div>
</div>