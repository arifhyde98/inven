<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\IsiPesananBarang;
use App\Models\IsiStokOpname;
use App\Models\PesananBarang;
use App\Models\RiwayatPengeluaran;
use App\Models\StokOpname;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class StockWorkflowTest extends TestCase
{
    public function test_pesanan_screen_renders_successfully(): void
    {
        $admin = User::where('role_id', 2)->first();

        $response = $this->actingAs($admin)->get(route('pesanan.index'));
        $response->assertStatus(200);
        $response->assertSee('Pesanan Barang');
    }

    public function test_create_purchase_order_and_receive_items_updates_stock(): void
    {
        $admin = User::where('role_id', 2)->first();
        $barang = Barang::where('id_cabang', $admin->penempatan_cabang)->first();

        if (!$barang) {
            $barang = Barang::first();
            $barang->update(['id_cabang' => $admin->penempatan_cabang]);
        }

        $initialStock = $barang->stok;
        $orderQty = 15;
        $kodePesanan = 'PO-TEST-' . rand(10000, 99999);

        // 1. Create Purchase Order
        $pesanan = PesananBarang::create([
            'kode' => $kodePesanan,
            'nama' => 'Restock Test Order',
            'suplier' => 'Test Supplier',
            'tempat' => (string) $admin->penempatan_cabang,
            'tanggal_pesan' => Carbon::now('Asia/Jakarta')->format('d-m-Y'),
            'tanggal_terima' => '',
            'status' => 0, // Pending
            'jenis_pesanan' => 1,
        ]);

        IsiPesananBarang::create([
            'kode' => $kodePesanan,
            'nama' => $barang->nama_barang,
            'id_barang' => $barang->id,
            'stok_sekarang' => $initialStock,
            'stok_pesan' => $orderQty,
            'stok_terima' => $orderQty,
            'harga_beli' => $barang->harga_beli,
            'total_beli' => $orderQty * $barang->harga_beli,
            'status' => 0,
            'id_cabang' => $admin->penempatan_cabang,
        ]);

        // 2. Receive Order
        $response = $this->actingAs($admin)->post(route('pesanan.receive', $kodePesanan));
        $response->assertRedirect(route('pesanan.index'));
        $response->assertSessionHas('success');

        // 3. Assert Order Status
        $pesanan->refresh();
        $this->assertEquals(1, $pesanan->status);
        $this->assertNotEmpty($pesanan->tanggal_terima);

        // 4. Assert Stock Incremented
        $barang->refresh();
        $this->assertEquals($initialStock + $orderQty, $barang->stok);

        // 5. Assert Expense Record Generated
        $pengeluaran = RiwayatPengeluaran::where('kode_pesanan', $kodePesanan)->first();
        $this->assertNotNull($pengeluaran);
        $this->assertEquals($orderQty * $barang->harga_beli, $pengeluaran->total_pengeluaran);
    }

    public function test_stock_opname_workflow_and_reconciliation(): void
    {
        $admin = User::where('role_id', 2)->first();
        $barang = Barang::where('id_cabang', $admin->penempatan_cabang)->first();

        if (!$barang) {
            $barang = Barang::first();
            $barang->update(['id_cabang' => $admin->penempatan_cabang]);
        }

        $barang->update(['stok' => 20]);
        $kodeOpname = 'OPN-TEST-' . rand(10000, 99999);

        // 1. Create Stock Opname Session
        $opname = StokOpname::create([
            'kode' => $kodeOpname,
            'nama' => 'Audit Stock Bulanan',
            'tanggal' => Carbon::now('Asia/Jakarta')->format('d-m-Y'),
            'tempat' => (string) $admin->penempatan_cabang,
            'status' => 'Stok Opname',
            'catatan' => 'Audit Rutin',
            'disabled' => 0,
        ]);

        $physicalStock = 25; // Physical count is 25 (surplus 5)

        // 2. Process reconciliation
        $response = $this->actingAs($admin)->post(route('stok-opname.process.post', $kodeOpname), [
            'is_check' => [$barang->id => '1'],
            'stok_fisik' => [$barang->id => $physicalStock],
            'stok_aplikasi' => [$barang->id => 20],
        ]);

        $response->assertRedirect(route('stok-opname.index'));
        $response->assertSessionHas('success');

        // 3. Assert Stock Opname Completed
        $opname->refresh();
        $this->assertEquals(1, $opname->disabled);

        // 4. Assert Physical Stock Reconciled
        $barang->refresh();
        $this->assertEquals($physicalStock, $barang->stok);

        // 5. Assert Audit Log Item
        $isiOpname = IsiStokOpname::where('kode', $kodeOpname)->where('id_barang', $barang->id)->first();
        $this->assertNotNull($isiOpname);
        $this->assertEquals(20, $isiOpname->stok_aplikasi);
        $this->assertEquals(25, $isiOpname->stok_fisik);
        $this->assertEquals(5, $isiOpname->selisih_total);
    }
}
