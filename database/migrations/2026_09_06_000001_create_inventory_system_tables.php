<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Roles
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->string('role', 128);
            $table->timestamps();
        });

        // 2. Settings
        Schema::create('pengaturan_umum', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan', 255);
            $table->string('pemilik', 255)->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('footer', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->timestamps();
        });

        // 3. Branches
        Schema::create('data_cabang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_cabang', 128);
            $table->string('alamat', 255);
            $table->integer('jumlah_barang')->default(0);
            $table->timestamps();
        });

        // 4. Suppliers
        Schema::create('suplier', function (Blueprint $table) {
            $table->id();
            $table->string('id_suplier', 128)->unique();
            $table->string('nama_suplier', 128);
            $table->string('alamat_suplier', 128)->nullable();
            $table->string('telp', 128)->nullable();
            $table->timestamps();
        });

        // 5. Product Categories
        Schema::create('kategori_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 128);
            $table->timestamps();
        });

        // 6. Product Units
        Schema::create('satuan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_satuan', 50);
            $table->string('nama_asli', 50);
            $table->timestamps();
        });

        // 7. Customers
        Schema::create('user_langganan', function (Blueprint $table) {
            $table->id();
            $table->string('id_user', 50)->index();
            $table->string('nama_user', 50);
            $table->string('tlp_user', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->integer('penempatan')->default(1);
            $table->timestamps();
        });

        // 8. Products
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 50)->nullable()->index();
            $table->string('nama_barang', 128);
            $table->string('gambar', 255)->default('default.png');
            $table->string('kategori', 128)->nullable();
            $table->integer('harga_beli')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->integer('profit')->default(0);
            $table->integer('stok')->default(0);
            $table->string('satuan', 50)->nullable();
            $table->integer('id_cabang')->default(1)->index();
            $table->text('keterangan')->nullable();
            $table->integer('id_suplier')->nullable()->index();
            $table->string('kode_penjualan', 50)->nullable();
            $table->string('kode_pembelian', 50)->nullable();
            $table->string('exp_date', 225)->nullable();
            $table->timestamps();
        });

        // 9. Stock Movement Log
        Schema::create('stok_barang', function (Blueprint $table) {
            $table->id();
            $table->integer('id_barang')->index();
            $table->integer('tgl')->default(0);
            $table->string('tanggal', 50)->nullable();
            $table->integer('jumlah')->default(0);
            $table->string('keterangan', 255)->nullable();
            $table->integer('status')->default(1); // 1 = in, 2 = out
            $table->integer('in_out')->default(0);
            $table->timestamps();
        });

        // 10. POS Active Cart
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 50)->nullable();
            $table->integer('id_barang')->index();
            $table->integer('id_cabang')->index();
            $table->integer('jumlah')->default(1);
            $table->string('satuan', 50)->nullable();
            $table->integer('harga')->default(0);
            $table->integer('profit')->default(0);
            $table->integer('harga_total')->default(0);
            $table->integer('id_pembelian')->default(1);
            $table->integer('id_user')->index();
            $table->timestamps();
        });

        // 11. Sales Transaction Header
        Schema::create('riwayat_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('id_pembelian', 128)->index();
            $table->string('id_pembayaran_cicilan', 50)->nullable()->index();
            $table->string('id_user', 50)->nullable()->index();
            $table->integer('id_keranjang')->nullable()->index();
            $table->integer('id_cabang')->default(1)->index();
            $table->integer('total_pembayaran')->default(0);
            $table->string('tanggal', 50)->nullable();
            $table->string('tanggal_ind', 128)->nullable();
            $table->string('bulan_ind', 50)->nullable();
            $table->string('single_bulan', 10)->nullable();
            $table->integer('single_tahun')->default(2026);
            $table->integer('uang')->default(0);
            $table->integer('kembalian')->default(0);
            $table->integer('pendapatan')->default(0);
            $table->integer('hari')->default(1);
            $table->string('metode_bayar', 50)->default('tunai');
            $table->integer('status_utang')->default(0);
            $table->timestamps();
        });

        // 12. Historical Cart Items
        Schema::create('semua_data_keranjang', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 50)->nullable();
            $table->integer('id_keranjang')->index();
            $table->string('nama', 128);
            $table->integer('jumlah')->default(1);
            $table->string('satuan', 50)->nullable();
            $table->integer('harga')->default(0);
            $table->integer('harga_total')->default(0);
            $table->integer('id_del')->nullable();
            $table->integer('harga_beli')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->integer('profit')->default(0);
            $table->integer('id_user')->nullable();
            $table->integer('id_cabang')->nullable()->index();
            $table->integer('id_barang')->nullable()->index();
            $table->timestamps();
        });

        // 13. Credit / Installment Payments
        Schema::create('pembayaran_cicilan', function (Blueprint $table) {
            $table->id();
            $table->string('id_cicilan', 50)->index();
            $table->string('id_pembelian', 50)->index();
            $table->string('id_user', 128)->nullable()->index();
            $table->integer('id_cabang')->default(1)->index();
            $table->string('tanggal', 50)->nullable();
            $table->integer('sisa_cicilan')->default(0);
            $table->integer('uang')->default(0);
            $table->integer('sisa_cicilan_akhir')->default(0);
            $table->integer('kembalian')->default(0);
            $table->timestamps();
        });

        // 14. Purchase Orders (PO)
        Schema::create('pesanan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 128)->unique();
            $table->string('nama', 128);
            $table->string('suplier', 128)->nullable();
            $table->string('tempat', 128)->default('1');
            $table->string('tanggal_pesan', 50)->nullable();
            $table->string('tanggal_terima', 50)->nullable();
            $table->integer('status')->default(0); // 0 = pending, 1 = received
            $table->integer('jenis_pesanan')->default(1); // 1 = restock, 2 = manual
            $table->timestamps();
        });

        // 15. PO Restock Items
        Schema::create('isi_pesanan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->index();
            $table->string('nama', 128);
            $table->integer('id_barang')->index();
            $table->integer('stok_sekarang')->default(0);
            $table->integer('stok_pesan')->default(0);
            $table->integer('stok_terima')->default(0);
            $table->integer('harga_beli')->default(0);
            $table->integer('total_beli')->default(0);
            $table->integer('status')->default(0);
            $table->integer('id_cabang')->default(1)->index();
            $table->timestamps();
        });

        // 16. PO Manual Items
        Schema::create('pesanan_manual', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 128)->index();
            $table->string('nama_barang', 128);
            $table->string('kategori', 50)->nullable();
            $table->string('satuan', 50)->nullable();
            $table->integer('harga_beli')->default(0);
            $table->integer('jumlah')->default(0);
            $table->integer('harga_total')->default(0);
            $table->integer('id_user')->default(1);
            $table->integer('id_cabang')->default(1)->index();
            $table->timestamps();
        });

        // 17. Stock Opname Sessions
        Schema::create('stok_opname', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->string('nama', 128);
            $table->string('tanggal', 50)->nullable();
            $table->string('tempat', 128)->default('1');
            $table->string('status', 128)->nullable();
            $table->text('catatan')->nullable();
            $table->integer('disabled')->default(0);
            $table->timestamps();
        });

        // 18. Stock Opname Items
        Schema::create('isi_stok_opname', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->index();
            $table->integer('id_barang')->index();
            $table->string('nama', 128);
            $table->integer('stok_aplikasi')->default(0);
            $table->integer('stok_fisik')->default(0);
            $table->integer('selisih_total')->default(0);
            $table->integer('selisih_harga')->default(0);
            $table->integer('id_cabang')->default(1)->index();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        // 19. Operational Expenses
        Schema::create('riwayat_pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan', 128)->nullable();
            $table->integer('id_cabang')->default(1)->index();
            $table->integer('total_pengeluaran')->default(0);
            $table->string('tanggal_ind', 50)->nullable();
            $table->string('bulan_ind', 50)->nullable();
            $table->string('single_bulan', 10)->nullable();
            $table->integer('single_tahun')->default(2026);
            $table->string('bukti_pengeluaran', 255)->default('default.png');
            $table->integer('status_bukti')->default(0); // 0 = pending, 1 = approved, 2 = rejected
            $table->text('catatan')->nullable();
            $table->integer('jenis')->default(0);
            $table->integer('hari')->default(1);
            $table->timestamps();
        });

        // 20. Debts
        Schema::create('data_hutang', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 128);
            $table->string('tanggal', 128)->nullable();
            $table->string('kode', 128)->index();
            $table->integer('id_cabang')->default(1)->index();
            $table->integer('total_hutang')->default(0);
            $table->integer('sisa_hutang')->default(0);
            $table->text('catatan')->nullable();
            $table->string('bukti', 255)->default('default.png');
            $table->integer('status')->default(0); // 0 = unpaid, 1 = paid
            $table->timestamps();
        });

        // 21. Debt Payments
        Schema::create('pembayaran_hutang', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 128)->index();
            $table->string('nama', 128);
            $table->integer('id_cabang')->default(1)->index();
            $table->string('tanggal', 128)->nullable();
            $table->integer('sisa_hutang')->default(0);
            $table->integer('uang')->default(0);
            $table->integer('sisa_hutang_akhir')->default(0);
            $table->integer('kembalian')->default(0);
            $table->timestamps();
        });

        // 22. Menus & Permissions
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('menu', 50);
            $table->timestamps();
        });

        Schema::create('akses_menu', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id')->index();
            $table->integer('menu_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akses_menu');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('pembayaran_hutang');
        Schema::dropIfExists('data_hutang');
        Schema::dropIfExists('riwayat_pengeluaran');
        Schema::dropIfExists('isi_stok_opname');
        Schema::dropIfExists('stok_opname');
        Schema::dropIfExists('pesanan_manual');
        Schema::dropIfExists('isi_pesanan_barang');
        Schema::dropIfExists('pesanan_barang');
        Schema::dropIfExists('pembayaran_cicilan');
        Schema::dropIfExists('semua_data_keranjang');
        Schema::dropIfExists('riwayat_penjualan');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('stok_barang');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('user_langganan');
        Schema::dropIfExists('satuan_barang');
        Schema::dropIfExists('kategori_barang');
        Schema::dropIfExists('suplier');
        Schema::dropIfExists('data_cabang');
        Schema::dropIfExists('pengaturan_umum');
        Schema::dropIfExists('role_user');
    }
};
