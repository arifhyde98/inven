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
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Cetak Barcode</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Cetak Barcode</h5>
                                    <img src="<?= base_url('assets/dok/barcode.png') ?>" class="img-thumbnail">
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>
                                        Disini saya menggunakan barcode tipe EAN-13 karena banyak digunakan di toko-toko retail
                                        <ol>
                                            <li>Mencetak seluruh barcode di cabang tertentu</li>
                                            <li>Kenapa mencetak barcode harus online ? karena saya menggunakan aplikasi Barcode Generator TEC-IT milik <a href="https://barcode.tec-it.com/" target="_blank">https://barcode.tec-it.com/</a> jadi harus online
                                            </li>
                                            <li>Barang harus dipilih, data barang berupa select option jadi tinggal klik nanti otomatis code dan harga barang berubah sesuai dengan nama barang yang dipilih.</li>
                                            <li>Barcodenya</li>
                                            <li>Jumlah barcde yang akan dicetak</li>
                                            <li>Tombol untuk mengenerate jumlah barcode ( halaman tidak diload )</li>
                                            <li>Hasil generate barcode</li>

                                        </ol>


                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <p>Jika ingin menginputkan manual barcodenya di databarang digit terakhir jangan diinputkan</p>
                                    <p>
                                        Penjelasan lainnya mengapa code di nomor 4 ada 12 digit sedangkan di generator ada 13 digit ( yang saya garis bawahi angka 6 ).
                                        berikut penjelasannya : <br>
                                        <img src="<?= base_url('assets/dok/bc1.png') ?>" class="img-thumbnail mb-2">
                                        <img src="<?= base_url('assets/dok/bc2.png') ?>" class="img-thumbnail mb-2">
                                        <img src="<?= base_url('assets/dok/bc3.png') ?>" class="img-thumbnail mb-2">
                                        <img src="<?= base_url('assets/dok/bc4.png') ?>" class="img-thumbnail mb-2">
                                    </p>
                                    <p>Jadi begitu penjelasannya source : <a href="https://www.kosim.web.id/2015/08/barcode-ean-13-arti-asal-negara-dan.html" target="_blank">https://www.kosim.web.id/2015/08/barcode-ean-13-arti-asal-negara-dan.html</a></p>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>
</div>