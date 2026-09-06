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
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Data Cicilan</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Bayar Cicilan</a>

                        </div>
                    </nav>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Data Cicilan</h5>
                                    <img src="<?= base_url('assets/dok/datacicilan.png') ?>" class="img-thumbnail"><br>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <ol>
                                        <li>ID Cicilan, identitas inti dari data cicilan karena mewakili semuanya</li>
                                        <li>Id user adalah id dari yang melakukan cicilan</li>
                                        <li>Tempat melakukan cicilan</li>
                                        <li>Tanggal melakukan cicilan</li>
                                        <li>Total pembayaran cicilan</li>
                                        <li>Sisa cicilan</li>
                                        <li>Status cicilan ( status berubah jadi lunas jika cicilan sudah dilunasi )</li>
                                        <li>Tombol untuk melakukan pembayaran cicilan</li>
                                        <li>Untuk melihat detail barang apa saja yang dibeli</li>
                                        <li>Untuk memprint stuk cicilan jika sudah lunas</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Data Cicilan</h5>
                                    <img src="<?= base_url('assets/dok/bayarcicilan.png') ?>" class="img-thumbnail"><br>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <ol>
                                        <li>Untuk memprint struk cicilan</li>
                                        <li>Tanggal pembayaran cicilan</li>
                                        <li>Sisa cicilan awal</li>
                                        <li>Uang yang dibayar</li>
                                        <li>Sisa cicilan akhir setelah pembayaran</li>
                                        <li>ID Pembelian</li>
                                        <li>ID pembayaran itu id cicilan</li>
                                        <li>ID User id yang melakukan cicilan</li>
                                        <li>Sisa cicilan</li>
                                        <li>Uang yang dibayar</li>
                                        <li>Sisa cicilan setelah uang diinputkan, jika uang kurang dari sisa cicilan ( No.9 ) maka sisa cicilannya tidak 0</li>
                                        <li>Kembalian. jika sisa cicilan akhir tidak 0 ( No.11 ) Maka kembaliannya 0 </li>
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