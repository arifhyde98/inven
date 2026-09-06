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
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Perbedaan Pesan Barang dan Pesan Stok Barang</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Pesan Barang</a>
                            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Pesan Stok Barang</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Data Pengeluaran</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <p>Perbedaan antara pesan barang dan pesan stok barang yaitu pesan barang digunakan untuk memesan barang
                                yang belum pernah ada di aplikasi, sedangkan pesan stok barang digunakan hanya untuk
                                memesan stok barang yang sudah ada diaplikasi dengan harga beli yang sudah pernah ditentukan. untuk harga beli dan jual barang bisa diatur di menu barang submenu data barang.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Cara menambahkan barang yang akan dipesan </h5>
                                    <img src="<?= base_url('assets/dok/databarang.png') ?>" class="img-thumbnail"><br>

                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>
                                        Sebelum menambahkan pesanan baru harus memasukan data barang terlebih dahulu.

                                    </p>
                                    <p>
                                        <ol>
                                            <li>Nama barang</li>
                                            <li>Kategori barang</li>
                                            <li>Satuan barang yang dibeli</li>
                                            <li>Harga beli barang</li>
                                            <li>Jumlah beli barang</li>
                                            <li>Total harga beli barang</li>
                                            <li>Klik tombol simpan untuk menyimpan barang</li>
                                            <li>Tombol untuk menghapus barang</li>
                                            <li>Form inputan untuk jumlah barang ( jumlah bisa diubah )</li>
                                            <li>Satuan barang yang sudah disimpan</li>
                                            <li>Tombol checklist untuk menyimpan perubahan dari jumlah barang yang dibeli</li>
                                            <li>Jika barang dirasa sudah cukup maka klik tombol checkout untuk melakukan checkout</li>
                                        </ol>
                                    </p>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Cara checkout pemesanan barang</h5>
                                    <img src="<?= base_url('assets/dok/checkout.png') ?>" class="img-thumbnail">
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>
                                        <ol>
                                            <li>Yaitu tempat diletakannya barang yang sudah dibeli</li>
                                            <li>Nama pesanan</li>
                                            <li>Suplier</li>
                                            <li>Kode pesanan</li>
                                            <li>Tanggal pemesanan barang</li>
                                            <li>Tombol simpan</li>
                                        </ol>
                                        jika sudah klik tombol tambah pesanan, maka otomatis diarahkan ke halaman data pesanan. ( perlu di ingat barang yang baru dipesan tidak langsung masuk ke data barang harus melakukan proses
                                        simpan barang terlebih dahulu )
                                    </p>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Penjelasan barang / stok yang sudah dipesan</h5>
                                    <img src="<?= base_url('assets/dok/datapesanan.png') ?>" class="img-thumbnail">
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>
                                        Semua data pesanan yang sudah ditambahkan akan masuk ke data pesanan berikut penjelasannya.
                                        <ol>
                                            <li>Untuk mengurutkan pesanan barang berdasarkan cabang</li>
                                            <li>Menambah pesanan barang baru</li>
                                            <li>Mengexport data pesanan ke excel</li>
                                            <li>Kode pesanan merupakan identitas inti dari data pesanan</li>
                                            <li>Nama pesanan</li>
                                            <li>Tempat diletakakan barang</li>
                                            <li>Suplier</li>
                                            <li>Jumlah barang yang dipesan</li>
                                            <li>Status pesanan yang dipesan ( Jika pesanan sudah diterima maka statusnya berubah jadi diterima )</li>
                                            <li>Jenis pesanan ada dua yaitu barang dan stok</li>
                                            <li>Untuk melihat detail dari pesanan</li>
                                            <li>Untuk menghapus pesanan ( jika sudah dihapus maka pesanan dianggap sudah dibatalkan dan tidak dapat dikembalikan )</li>
                                            <li>Tombol unduh itu untuk menyimpan data barang atau stok ke gudang sesuai penempatan</li>
                                            <li>Untuk mengprint data pesanan</li>
                                        </ol>
                                    </p>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Penjelasan penerimaan barang</h5>
                                    <img src="<?= base_url('assets/dok/terimabarang.png') ?>" class="img-thumbnail">
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>
                                        Jika membeli dalam satuan kardus dan ingin dijual eceran selalu gunakan satuan "pcs" jangan yang lain.
                                        <ol>
                                            <li>Nama barang</li>
                                            <li>Kategori barang</li>
                                            <li>Stok barang yang dibeli</li>
                                            <li>Harga barang yang dibeli</li>
                                            <li>Satuan jual barang ( jika ingin menjual dengan satuan beda dari satuan beli )</li>
                                            <li>Harga jual barang ( Harga yang akan dijual ke pelanggan )</li>
                                            <li>Isi stok dari satuan jual ( Jika dari kardus ke picis maka stoknya juga akan berbeda )</li>
                                            <li>Tombol untuk menyimpan barang ke gudang dan siap dijual</li>
                                        </ol>
                                        <br>
                                        Contoh : Saya membeli aqua botol 1 kardus dengan harga 39000 ingin dijual dengan satuan pcs bagaimana cara mengetahui keuntungan dari 1x penjualan dengan satuan pcs.
                                        <br>Penjelasan : 1 kardus aqua botol berisi 24 botol maka rumusnya jumlah aqua x harga jual. contohnya 24 x 3000 = 72000 kita sebut dengan harga asli. 24 itu jumlah aqua 3000 itu harga jual.<br>
                                        proses selanjutnya ( harga asli - harga beli ). contohnya 72000 - 39000 = 33000. 72000 itu harga asli, 39000 harg beli 1dus, 33000 itu keuntungan dari penjualan 1dus. maka sudah didapat profit / keuntungan dari penjualan 1dus dengan harga jual 3000 perbotol. tetapi
                                        kita ingin mengetahui keuntungan di setiap penjualan 1botol. caranya gampang rumus ( profit / jumlah aqua ). contohnya 33000 / 24 = 1375. 33000 itu profit, 24 itu jumlah aqua botol dari 1dus, 1375 itu keuntungan yang didapat dari satu penjualan aqua botol.
                                        Jadi sudah ketemu profit atau keuntungan dari penjualan 1aqua botol dari penjualan 3000 yaitu 1375 ( seribu tigaratus tujuhpuluh lima rupiah ).<br><br>
                                        <span class="text-danger">Perlu diingat data barang yang baru dipesan belum mempunyai barcode dan harus di update datanya di halaman data barang</span>

                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <div class="row">
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Cara membuat pesanan stok barang</h5>
                                    <img src="<?= base_url('assets/dok/stokbarang.png') ?>" class="img-thumbnail"><br>

                                </div>
                                <div class="col-md-6 border-bottom mb-4">

                                    <p>
                                        <ol>
                                            <li>Tempat penyimpanan stok barang</li>
                                            <li>Nama pesanan</li>
                                            <li>Suplier</li>
                                            <li>Kode pesanan</li>
                                            <li>Tanggal pesan</li>
                                            <li>Jika ingin memesan stok klik checkbox maka inputan jumlah pesanan bisa digunakan tidak readonly ( Untuk menandai barang mana yang ingin di pesan stoknya )</li>
                                            <li>Inputan jumlah stok barang yang akan dipesan.</li>
                                            <li>Tombol untuk menambahkan pesanan ( Sama seperti pesan barang stok barang tidak langsung nambah ke barang, harus melakukan proses penyimpanan tapi proses penyimpananya berbeda dengan pesan barang )</li>
                                        </ol>
                                    </p>
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Cara menerima pesanan berupa stok barang</h5>
                                    <img src="<?= base_url('assets/dok/terimastok.png') ?>" class="img-thumbnail"><br>

                                </div>
                                <div class="col-md-6 border-bottom mb-4">

                                    <p>
                                        <ol>
                                            <li>Status pesanan dipesan ( karena belum diterima )</li>
                                            <li>Jenis pesanan menjadi stok</li>
                                            <li>Tombol mata untuk melihat detail, tombol tong sampah untuk menghapus data pesanan, dan untuk menerima stok barang tinggal klik tombol unduhan maka akan muncul</li>
                                            <li>Popup berupa pertanyaan ketika tombol unduhan / terima di klik</li>
                                            <li>Klik terima jika ingin menerima pesanan. maka otomatis stok bertambah dan status pesanan berubah menjadi diterima</li>
                                            <li>Note : tidak perlu ribet setting harga jual dll untuk pemesanan stok barang karena harga sudah ada sebelumnya.</li>

                                        </ol>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <div class="row">
                                <div class="col-md-6 border-bottom mb-4">
                                    <h5>Penjelasan penerimaan barang</h5>
                                    <img src="<?= base_url('assets/dok/datapengeluaran.png') ?>" class="img-thumbnail">
                                </div>
                                <div class="col-md-6 border-bottom mb-4">
                                    <p>
                                        Data pengeluaran merupakan data yang mencatat pengeluaran setiap pembelian barang
                                        <ol>
                                            <li>Tanggal pengeluaran / tanggal penerimaan stok</li>
                                            <li>Kode pengeluaran sama dengan kode pemesanan, jika ingin melihat apa yang dibeli tinggal search aja di data pesanan dengan kode pesanan berikut</li>
                                            <li>Cabang yang melakukan pengeluaran</li>
                                            <li>Total pengeluaran</li>
                                            <li>Tombol untuk mengupload bukti pengeluaran, filenya dapat berupa jpg, jpeg, png dengan size max 2mb</li>
                                            <li>Tombol untuk tidak mengupload bukti pengeluaran</li>
                                            <li>Status jika bukti tidak diupload</li>
                                            <li>Tombol yang akan muncul jika bukti pengeluaran diupload, jika menekan tombol tersebut maka akan menampilkan bukti peneluaran berupa gambar</li>
                                        </ol>


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