<div class="mt-2 mb-2">
    <?php foreach ($barang as $row) : ?>

        <div class="kotak-barcode mb-4">
            <div class="bg-white p-2" style="border:1px solid #000;">
                <img alt='Barcode Generator TEC-IT' src='https://barcode.tec-it.com/barcode.ashx?data=<?= $row['barcode'] ?>&code=EAN13&multiplebarcodes=true&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0' />
            </div>

            <h5 class="text-center mb-1 mt-2" style="color:#000;"><?= $row['nama_barang'] ?></h5>
            <h5 class="text-center font-weight-normal mb-1" style="color:#000;">Rp. <?= rupiah($row['harga_jual']) ?></h5>
        </div>
    <?php endforeach; ?>
</div>