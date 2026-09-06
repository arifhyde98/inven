<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto my-5 border p-5">
            <div class="text-center">
                <h5 class="text-uppercase">Stok Opname</h5>
                <h5 class="text-uppercase"><?= $stok_opname['nama'] ?></h5>

            </div>
            <div class="mt-3">
                <div class="float-left">
                    <p>Nama : <?= $stok_opname['nama'] ?></p>
                    <p>Status : <?= $stok_opname['status'] ?></p>
                    <p>Tempat : <?= $cb['nama_cabang'] ?></p>
                </div>
                <div class="float-right">
                    <p>Tanggal Kirim : <?= $stok_opname['tanggal'] ?></p>
                    <p>Catatan : <?= $stok_opname['catatan'] ?></p>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2">Produk</th>
                        <th class="text-center" rowspan="2">Stok Di Aplikasi</th>
                        <th class="text-center" rowspan="2">Stok Fisik</th>
                        <th class="text-center" colspan="2">Selisih</th>

                    </tr>
                    <tr>
                        <th class="text-center">Total</th>
                        <th class="text-center">Rp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($isi_stok as $isi) :
                        $this->db->select_sum('selisih_harga');
                        $xz = $this->db->get_where('isi_stok_opname', ['kode' => $isi['kode']])->row_array(); ?>
                        <tr>
                            <td><?= $isi['nama'] ?></td>
                            <td><?= $isi['stok_aplikasi'] ?></td>
                            <td><?= $isi['stok_fisik'] ?></td>
                            <td><?= $isi['selisih_total'] ?></td>
                            <td><?= rupiah($isi['selisih_harga']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" align="right">Total</td>
                        <td><?= rupiah($xz['selisih_harga']) ?></td>
                    </tr>
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