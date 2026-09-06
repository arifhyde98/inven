<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Jual Barang Tunai</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Jual Barang Cicilan</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Jual Barang Tunai</h5>
                                    <img src="<?= base_url('assets/dok/jualbarang.png') ?>" class="img-thumbnail">
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>
                                        Penjelasan beberapa
                                        <ol>
                                            <li>Tombol untuk menampilkan seluruh barang yang ada di cabang yang ditempatinya</li>
                                            <li>Form input untuk barcode dan perlu diingat posisi inputan harus focus atau harus diklik di bagian form barcode jika ingin menginputkan barang otomatis dengan barcode. form inputan barcode juga auto complete
                                                jadi jika kesusahan mengscan bisa ketika beberapa angka maka akan mucul otomatis barcode disetiap barang sesuai yang diinputkan.
                                            </li>
                                            <li>Tombol untuk menghapus barang yang sudah disimpan di keranjang</li>
                                            <li>inputan untuk jumlah barang yang dibeli jika jumlahnya ingin diganti</li>
                                            <li>Tombol untuk menyimpan perubahan dari jumlah inputan barang yang dibeli</li>
                                            <li>Pilihan metode pemayaran</li>
                                            <li>ID pembelian digenerate secara random ( Ada yang tertinggal di bawah ID pembelian ada total harga pembayaran )</li>
                                            <li>Uang dari pembeli</li>
                                            <li>Kembalian pembeli</li>
                                            <li>Tombol untuk menyelesaikan transaksi</li>
                                            <li>Keyboard shortcut</li>
                                        </ol>


                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Jual Barang Cicilan</h5>
                                    <img src="<?= base_url('assets/dok/jualcicil.png') ?>" class="img-thumbnail">
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>
                                        Penjelasan beberapa
                                        <ol>
                                            <li>Metode pembayaran cicilan</li>
                                            <li>ID pembelian digenerate secara random ( Ada yang tertinggal di bawah ID pembelian ada total harga pembayaran )</li>
                                            <li>ID Cicilan digunakan jika penyicil ingin membayar cicilan tinggal berikan struk cicilannya dan cari data cicilan sesuai dengan id cicilan yang ada distruk</li>
                                            <li>Digunakan untuk menambah user penyicil ( Saya sarankan buat data user baru setia ada penyicil baru untuk mempermudah pemrosesan bayar )</li>
                                            <li>ID User yang melakukan cicilan</li>
                                            <li>Total pembayaran</li>
                                            <li>Uang cicilan pertama ( bisa 0 rupiah ) </li>
                                            <li>Sisa cicilan </li>
                                            <li>Tombol untuk menyelesaikan proses transaksi </li>
                                        </ol>
                                        <span class="text-danger">
                                            Perlu diingat jika ada user yang akan melakukan pembayaran cicilan maka pembayaran cicilannya di lakukan di menu data cicilan akan ada tombol bayar tinggal klik dan masukan nominal cicilan lalu klik print struk
                                        </span>


                                    </p>
                                </div>
                            </div>

                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>
</div>