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
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Stok Opname</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Tambah Stok Opname</a>

                        </div>
                    </nav>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <h5>Pengertian Stock Opname</h5>
                            <p>Stock Opname adalah kegiatan penghitungan secara fisik atas persediaan barang di gudang yang akan dijual. Secara umum, kegiatan ini dilakukan guna
                                mengetahui secara pasti dan akurat mengenai catatan pembukuan yang merupakan fungsi dari salah satu sistem pengendalian internal.</p>
                            <h5> Tujuan Stock Opname</h5>
                            <p>Hal ini dilakukan tidak hanya untuk mengetahui persediaan perusahaan saja, melainkan juga diharapkan dapat membantu menghitung kas, aktiva, piutang, dan utang. Pada beberapa perusahaan, kegiatan ini dilakukan untuk menghitung persediaan barang dan kas.</p>
                            <p>Pada umumnya, stock opname dilakukan setiap akhir tahun atau bahkan setiap akhir bulan</p>

                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Menambahkan stok opname</h5>
                                    <img src="<?= base_url('assets/dok/tambahstokopname.png') ?>" class="img-thumbnail"><br>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <ol>
                                        <li>Khusus untuk superadmin bisa memilih tempat atau cabang</li>
                                        <li>Nama stok opname</li>
                                        <li>Tanggal pembuatan stok opname</li>
                                        <li>Catatan untuk pembuatan stok opname, bersifat opsional</li>
                                        <li>Nama produk</li>
                                        <li>Jumlah stok yang ada di aplikasi</li>
                                        <li>Tombol untuk menyimpan pembuatan stok opname</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Data stok opname</h5>
                                    <img src="<?= base_url('assets/dok/stokopname.png') ?>" class="img-thumbnail"><br>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>Semua stok opname yang baru ditambahkan akan masuk ke data stok opname</p>
                                    <ol>
                                        <li>Menambahkan stok opname baru</li>
                                        <li>Nama stok opname</li>
                                        <li>Tanggal pembuatan stok opname</li>
                                        <li>Tempat atau cabang</li>
                                        <li>Status stok opname ( jika belum diproses statusnya menjadi Belum Di Proses )</li>
                                        <li>Jumlah Stok fisik</li>
                                        <li>Melihat detail stok opname</li>
                                        <li>Menghapus stok opname</li>
                                        <li>Untuk memproses pembuatan stok opname</li>
                                        <li>Mencetak stok opname</li>
                                    </ol>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Memproses stok opname</h5>
                                    <img src="<?= base_url('assets/dok/prosesstokopname.png') ?>" class="img-thumbnail"><br>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>Semua stok opname yang baru ditambahkan akan masuk ke data stok opname</p>
                                    <ol>
                                        <li>Abaikan checkboxnya jangan di uncheck</li>
                                        <li>Stok yang ada diaplikasi</li>
                                        <li>Form inputan untuk memasukan jumlah stok yang ada digudang ( stok fisik )</li>
                                        <li>Untuk menyimpan stok opname</li>
                                    </ol>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>