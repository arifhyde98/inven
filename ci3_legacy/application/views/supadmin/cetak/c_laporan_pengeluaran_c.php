<?php
    $cabang = $this->db->get_where('data_cabang', ['id' =>  $this->uri->segment(3)])->row_array();
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto my-5 border p-5">
            <div class="text-center">
                <h5 class="text-uppercase">Laporan Pengeluaran</h5>
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
                        <th>Kode Pesanan</th>
                        <th>Tanggal</th>
                        <th>Cabang</th>
                        <th>Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $this->db->select_sum('total_pengeluaran');
                   $total =  $this->db->get_where('riwayat_pengeluaran',  ['id_cabang' => $this->uri->segment(3)])->row_array();
                    foreach ($pengeluaran as $dp) :
                        $cab = $this->db->get_where('data_cabang', ['id' => $dp['id_cabang']])->row_array();
                    ?>

                        <tr>
                            <td class="text-center">
                                <?= $no ?>
                            </td>

                            <td>
                                <?= $dp['kode_pesanan'] ?>
                            </td>
                            <td>
                                <?= $dp['tanggal_ind'] ?>
                            </td>
                            <td>
                                <?= $cab['nama_cabang'] ?>
                            </td>
                           
                            <td>
                                Rp. <?= rupiah($dp['total_pengeluaran']) ?>
                            </td>


                        </tr>
                    <?php $no++;
                    endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-right">Total Pengeluaran</td>
                        <td >Rp. <?= rupiah($total['total_pengeluaran']) ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="float-right text-center mt-5">
                <span class="pr-5">(</span>....<span class="pl-5">)</span>
            </div>
        </div>
    </div>
</div>