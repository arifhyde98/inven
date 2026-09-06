<?php
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto my-5 border p-5">
            <div class="text-center">
                <h5 class="text-uppercase">Laporan Penjualan</h5>
                <h5 class="text-uppercase"><?= $cabang['nama_cabang'] ?></h5>
                <h5 class="text-uppercase"><?= $cabang['alamat'] ?></h5>

            </div>
            <div class="mt-3 mb-3">

            </div>
            <table class="table table-bordered" id="table-1">
                <thead>
                    <tr>
                        <th width="30" class="text-center">
                            No
                        </th>
                        <th>Id Penjualan</th>
                        <th>Tanggal</th>
                        <th>Cabang</th>
                        <th>Total Barang</th>
                        <th>Total Pembayaran</th>
                        <th>Metode Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;

                    foreach ($history as $dp) :
                        $cab = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
                        $a = $this->db->get_where('semua_data_keranjang', ['id_keranjang' => $dp['id_keranjang']])->num_rows();
                        $d_cabang = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();

                        if ($dp['metode_bayar'] == 'tunai') {
                            $status_cicilan = '';
                        } else {
                            if ($dp['status_utang'] == 0) {

                                $status_cicilan = ' (Lunas)';
                            } else {
                                $status_cicilan = ' (Belum Lunas)';
                            }
                        }
                    ?>

                        <tr>
                            <td class="text-center">
                                <?= $no ?>
                            </td>

                            <td>
                                <?= $dp['id_pembelian'] ?>
                            </td>
                            <td>
                                <?= $dp['tanggal'] ?>
                            </td>
                            <td>
                                <?= $d_cabang['nama_cabang'] ?>
                            </td>

                            <td>
                                <?= $a ?>
                            </td>
                            <td>
                                <?= $dp['total_pembayaran'] ?>
                            </td>
                            <td>
                                <?= $dp['metode_bayar']  . $status_cicilan ?>
                            </td>


                        </tr>
                    <?php $no++;
                    endforeach; ?>
                   
                </tbody>
            </table>
            <div class="float-right text-center mt-5">
                <span class="pr-5">(</span>....<span class="pl-5">)</span>
            </div>
        </div>
    </div>
</div>