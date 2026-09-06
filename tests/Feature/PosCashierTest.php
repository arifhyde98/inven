<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\DataHutang;
use App\Models\Keranjang;
use App\Models\RiwayatPenjualan;
use App\Models\SemuaDataKeranjang;
use App\Models\StokBarang;
use App\Models\User;
use App\Models\UserLangganan;
use Tests\TestCase;

class PosCashierTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Clear carts for clean testing
        Keranjang::truncate();
    }

    public function test_cashier_screen_renders_successfully(): void
    {
        $admin = User::where('role_id', 2)->first();

        $response = $this->actingAs($admin)->get(route('pos.index'));
        $response->assertStatus(200);
        $response->assertSee('Kasir POS');
    }

    public function test_can_add_item_to_cart_and_update_quantity(): void
    {
        $admin = User::where('role_id', 2)->first();
        $barang = Barang::where('id_cabang', $admin->penempatan_cabang)->first();

        if (!$barang) {
            $barang = Barang::first();
        }

        $barang->update(['stok' => 50]);

        // Add to cart
        $response = $this->actingAs($admin)->postJson(route('pos.cart.add'), [
            'id_barang' => $barang->id,
            'jumlah' => 2,
            'cabang_id' => $admin->penempatan_cabang,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $cartItem = Keranjang::where('id_user', $admin->id)->where('id_barang', $barang->id)->first();
        $this->assertNotNull($cartItem);
        $this->assertEquals(2, $cartItem->jumlah);

        // Update quantity
        $responseUpdate = $this->actingAs($admin)->putJson(route('pos.cart.update', $cartItem->id), [
            'jumlah' => 5,
        ]);

        $responseUpdate->assertStatus(200);
        $cartItem->refresh();
        $this->assertEquals(5, $cartItem->jumlah);
    }

    public function test_can_remove_item_from_cart(): void
    {
        $admin = User::where('role_id', 2)->first();
        $barang = Barang::first();

        $cartItem = Keranjang::create([
            'id_user' => $admin->id,
            'id_barang' => $barang->id,
            'nama' => $barang->nama_barang,
            'harga' => $barang->harga_jual,
            'jumlah' => 1,
            'harga_total' => $barang->harga_jual,
            'id_cabang' => $admin->penempatan_cabang,
        ]);

        $response = $this->actingAs($admin)->deleteJson(route('pos.cart.delete', $cartItem->id));
        $response->assertStatus(200);

        $this->assertDatabaseMissing('keranjang', ['id' => $cartItem->id]);
    }

    public function test_checkout_cash_transaction_atomic_flow(): void
    {
        $admin = User::where('role_id', 2)->first();
        $barang = Barang::where('id_cabang', $admin->penempatan_cabang)->where('stok', '>=', 5)->first();

        if (!$barang) {
            $barang = Barang::first();
            $barang->update(['stok' => 20, 'id_cabang' => $admin->penempatan_cabang]);
        }

        $initialStock = $barang->stok;
        $qtyToBuy = 2;

        // Add to cart
        Keranjang::create([
            'id_user' => $admin->id,
            'id_barang' => $barang->id,
            'nama' => $barang->nama_barang,
            'harga' => $barang->harga_jual,
            'jumlah' => $qtyToBuy,
            'harga_total' => $barang->harga_jual * $qtyToBuy,
            'id_cabang' => $admin->penempatan_cabang,
        ]);

        $idPembelian = 'TEST-CASH-' . rand(1000, 9999);
        $totalHarga = $barang->harga_jual * $qtyToBuy;

        $response = $this->actingAs($admin)->postJson(route('pos.checkout'), [
            'id_pembelian' => $idPembelian,
            'metode' => 'tunai',
            'uang_saya' => $totalHarga + 10000,
            'cabang_id' => $admin->penempatan_cabang,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        // Assert sale record
        $penjualan = RiwayatPenjualan::where('id_pembelian', $idPembelian)->first();
        $this->assertNotNull($penjualan);
        $this->assertEquals('tunai', $penjualan->metode_bayar); // Cash
        $this->assertEquals(0, $penjualan->status_utang);

        // Assert items saved in semua_data_keranjang
        $soldItems = SemuaDataKeranjang::where('id_keranjang', $penjualan->id_keranjang)->get();
        $this->assertGreaterThanOrEqual(1, $soldItems->count());

        // Assert stock decreased
        $barang->refresh();
        $this->assertEquals($initialStock - $qtyToBuy, $barang->stok);

        // Assert stock log recorded (status 2 = keluar)
        $stokLog = StokBarang::where('id_barang', $barang->id)
            ->where('status', 2)
            ->where('jumlah', $qtyToBuy)
            ->latest('id')
            ->first();
        $this->assertNotNull($stokLog);

        // Assert cart is empty
        $remainingCart = Keranjang::where('id_user', $admin->id)->count();
        $this->assertEquals(0, $remainingCart);
    }

    public function test_checkout_cicilan_creates_installment_and_debt_records(): void
    {
        $admin = User::where('role_id', 2)->first();
        $customer = UserLangganan::first();

        if (!$customer) {
            $customer = UserLangganan::create([
                'id_user' => 'CUST-001',
                'nama_user' => 'Test Customer',
                'alamat' => 'Jl. Test',
                'tlp_user' => '08123456789',
                'penempatan' => $admin->penempatan_cabang,
            ]);
        }

        $barang = Barang::where('id_cabang', $admin->penempatan_cabang)->first();
        if (!$barang) {
            $barang = Barang::first();
            $barang->update(['stok' => 20, 'id_cabang' => $admin->penempatan_cabang]);
        }

        $qtyToBuy = 1;
        Keranjang::create([
            'id_user' => $admin->id,
            'id_barang' => $barang->id,
            'nama' => $barang->nama_barang,
            'harga' => $barang->harga_jual,
            'jumlah' => $qtyToBuy,
            'harga_total' => $barang->harga_jual * $qtyToBuy,
            'id_cabang' => $admin->penempatan_cabang,
        ]);

        $idPembelian = 'TEST-CICIL-' . rand(1000, 9999);
        $idCicilan = 'CICIL-' . rand(1000, 9999);
        $dp = 5000;

        $response = $this->actingAs($admin)->postJson(route('pos.checkout'), [
            'id_pembelian' => $idPembelian,
            'metode' => 'cicilan',
            'uang_saya' => $dp,
            'id_user' => (string) $customer->id_user,
            'id_cicilan' => $idCicilan,
            'cabang_id' => $admin->penempatan_cabang,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        // Assert sale record marked as installment
        $penjualan = RiwayatPenjualan::where('id_pembelian', $idPembelian)->first();
        $this->assertNotNull($penjualan);
        $this->assertEquals('cicilan', $penjualan->metode_bayar); // Cicilan
        $this->assertEquals(1, $penjualan->status_utang); // Belum lunas

        // Assert installment payment record created
        $cicilanRecord = \App\Models\PembayaranCicilan::where('id_cicilan', $idCicilan)->first();
        $this->assertNotNull($cicilanRecord);
        $this->assertEquals($customer->id_user, $cicilanRecord->id_user);
    }
}
