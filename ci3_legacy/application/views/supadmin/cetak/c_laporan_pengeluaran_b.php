<?php
$cab = $this->db->get_where('data_cabang', ['id' => $_GET['idCabang']])->row_array();
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto my-5 border p-5">
            <div class="text-center">
                <h5 class="text-uppercase">Laporan Pengeluaran Perbulan</h5>
                <h5 class="text-uppercase"><?= $cab['nama_cabang'] ?></h5>
                <p class="font-weight-bold"><?= $cab['alamat'] ?></p>
            </div>
            <div class="mt-3 mb-3">

            </div>
            <table class="table table-bordered" id="table-1">
                <thead>
                    <tr>
                        <th width="30" class="text-center">
                            No
                        </th>
                        <th>Tanggal</th>
                        <th>Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $tempat = $_GET['idCabang'];
                    $this->db->order_by('single_tahun', 'desc');
                    $dats = "SELECT DISTINCT bulan_ind FROM riwayat_pengeluaran WHERE id_cabang='$tempat' AND status_bukti != '0'";
                    $anjay = $this->db->query($dats)->result_array();
                    foreach ($anjay as $dp) :
                        $this->db->select_sum('total_pengeluaran');
                        $total_pengeluaran = $this->db->get_where('riwayat_pengeluaran', ['bulan_ind' => $dp['bulan_ind'], 'id_cabang' => $tempat, 'status_bukti !=' => 0])->row_array();
                        $split = $dp['bulan_ind'];
                        $split = explode('-', $split);
                        $nama_bulan = '';
                        if ($split[0] == '01') {
                            $nama_bulan = 'Januari ' . $split[1];
                        } elseif ($split[0] == '02') {
                            $nama_bulan = 'Februari ' . $split[1];
                        } elseif ($split[0] == '03') {
                            $nama_bulan = 'Maret ' . $split[1];
                        } elseif ($split[0] == '04') {
                            $nama_bulan = 'April ' . $split[1];
                        } elseif ($split[0] == '05') {
                            $nama_bulan = 'Mei ' . $split[1];
                        } elseif ($split[0] == '06') {
                            $nama_bulan = 'Juni ' . $split[1];
                        } elseif ($split[0] == '07') {
                            $nama_bulan = 'Juli ' . $split[1];
                        } elseif ($split[0] == '08') {
                            $nama_bulan = 'Agustus ' . $split[1];
                        } elseif ($split[0] == '09') {
                            $nama_bulan = 'September ' . $split[1];
                        } elseif ($split[0] == '10') {
                            $nama_bulan = 'Oktober ' . $split[1];
                        } elseif ($split[0] == '11') {
                            $nama_bulan = 'November ' . $split[1];
                        } elseif ($split[0] == '12') {
                            $nama_bulan = 'Desember ' . $split[1];
                        }
                    ?>

                        <tr>
                            <td class="text-center">
                                <?= $no ?>
                            </td>

                            <td>
                                <?= $nama_bulan ?>
                            </td>
                            <td>
                                Rp. <?= rupiah($total_pengeluaran['total_pengeluaran']) ?>
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