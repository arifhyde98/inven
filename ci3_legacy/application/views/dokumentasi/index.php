<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Cara instalasi JInventory
                        </div>
                        <div class="card-body">
                            <ol>
                                <li>Ekstrak file yang sudah didownload</li>
                                <li>Pindahkan folder yang sudah diekstrak ke xampp/htdocs</li>
                                <li>Buka xampp</li>
                                <li>Nyalakan Apache dan MySQL</li>
                                <li>Buka web browser kesukaan anda</li>
                                <li>Import database yang ada difolder inven dengan nama db_inven.sql</li>
                                <li>Jika sudah di import databasenya, ketik localhost/inven di search bar web browser kamu lalu enter.</li>
                                <img src="<?= base_url('assets/dok/krom.png') ?>" class="img-thumbnail" alt="">
                                <li>Selamat JInventory sudah terinstall.</li>
                            </ol>
                            <p>Catatan : Jika ingin mengubah nama foldernya jadi bukan inven tidak usah mengubah lagi base_urlnya karena sudah otomatis.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Catatan Penting
                        </div>
                        <div class="card-body">
                            <ol>
                                <li>Semua data barang pesanan yang baru belum mempunyai barcode harus di update dulu barcodenya di halaman data barang.</li>
                                <li>Jika ada barang pesanan dengan satuan kardus dan ingin dijual jadi eceran, setting satuan jual menjadi pcs terlebih dahulu
                                    ( note : meskipun data barang minuman, jangan ubah satuan jual menjadi btl atau botol ) karena itu untuk memperhitungkan harga beli dari 1 barang dan profit penjualan dari 1 barang.</li>
                                <li>Jika menambahkan stok di Stok In bukan di pesan stok, maka tidak akan ada data pengeluaran.</li>
                                <li>Jika ingin menjual barang / memesan barang dengan jumlah koma misal 1.5kg silahkan ubah dulu di beberapa tabel tipe datanya karena default tipe datanya integer (Bilangan bulat). Berikut
                                    field yang harus diubah tipe datanya menjadi float :</li>

                            </ol>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Tabel</th>
                                    <th>Field</th>
                                </tr>
                                <tr>
                                    <td>barang</td>
                                    <td>stok</td>
                                </tr>
                                <tr>
                                    <td>isi_pesanan_barang</td>
                                    <td>stok_sekarang, stok_pesan, stok_terima</td>
                                </tr>
                                <tr>
                                    <td>isi_stok_opname</td>
                                    <td>stok_aplikasi, stok_fisik, selisih_total</td>
                                </tr>
                                <tr>
                                    <td>keranjang</td>
                                    <td>jumlah</td>
                                </tr>
                                <tr>
                                    <td>pesanan_manual</td>
                                    <td>jumlah</td>
                                </tr>
                                <tr>
                                    <td>semua_data_keranjang</td>
                                    <td>jumlah</td>
                                </tr>
                                <tr>
                                    <td>stok_barang</td>
                                    <td>jumlah</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>