<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\IsiPesananBarang;
use App\Models\IsiStokOpname;
use App\Models\PesananBarang;
use App\Models\RiwayatPengeluaran;
use App\Models\StokBarang;
use App\Models\StokOpname;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StockService
{
    public function receiveOrder($kode)
    {
        return DB::transaction(function () use ($kode) {
            $pesanan = PesananBarang::where('kode', $kode)->firstOrFail();
            if ($pesanan->status == 1) {
                throw new \Exception("Pesanan [{$kode}] sudah diterima sebelumnya.");
            }

            $items = IsiPesananBarang::where('kode', $kode)->get();
            $now = Carbon::now('Asia/Jakarta');

            foreach ($items as $item) {
                $item->update([
                    'stok_terima' => $item->stok_pesan,
                    'status' => 1,
                ]);

                // Create stock entry
                StokBarang::create([
                    'id_barang' => $item->id_barang,
                    'tgl' => time(),
                    'tanggal' => $now->format('d-m-Y'),
                    'jumlah' => $item->stok_pesan,
                    'keterangan' => 'Pembelian Stok Barang - Kode : ' . $kode,
                    'status' => 1, // In
                    'in_out' => 0,
                ]);

                // Increment product stock
                $barang = Barang::find($item->id_barang);
                if ($barang) {
                    $barang->increment('stok', $item->stok_pesan);
                }
            }

            // Create Expense Record
            $totalBeli = $items->sum('total_beli');
            RiwayatPengeluaran::create([
                'kode_pesanan' => $kode,
                'id_cabang' => (int) $pesanan->tempat,
                'total_pengeluaran' => $totalBeli,
                'tanggal_ind' => $now->format('d-m-Y'),
                'bulan_ind' => $now->format('m-Y'),
                'single_bulan' => $now->format('m'),
                'single_tahun' => (int) $now->format('Y'),
                'status_bukti' => 1,
                'hari' => $now->dayOfWeekIso,
            ]);

            $pesanan->update([
                'tanggal_terima' => $now->format('d-m-Y'),
                'status' => 1,
            ]);

            return $pesanan;
        });
    }

    public function processOpname($kode, array $checkedIds, array $stokFisik, array $stokAplikasi)
    {
        return DB::transaction(function () use ($kode, $checkedIds, $stokFisik, $stokAplikasi) {
            $opname = StokOpname::where('kode', $kode)->firstOrFail();

            foreach ($checkedIds as $key => $val) {
                // Determine item ID: if $val is valid ID use it, otherwise $key
                $idBarang = null;
                if (Barang::where('id', $val)->exists()) {
                    $idBarang = (int) $val;
                } elseif (Barang::where('id', $key)->exists()) {
                    $idBarang = (int) $key;
                }

                if (!$idBarang) continue;

                $barang = Barang::find($idBarang);
                if (!$barang) continue;

                $fisik = isset($stokFisik[$key]) ? (int) $stokFisik[$key] : (isset($stokFisik[$idBarang]) ? (int) $stokFisik[$idBarang] : 0);
                $aplikasi = isset($stokAplikasi[$key]) ? (int) $stokAplikasi[$key] : (isset($stokAplikasi[$idBarang]) ? (int) $stokAplikasi[$idBarang] : $barang->stok);
                $selisihTotal = $fisik - $aplikasi;
                $selisihHarga = $selisihTotal * $barang->harga_jual;

                IsiStokOpname::updateOrCreate(
                    [
                        'kode' => $kode,
                        'id_barang' => $barang->id,
                    ],
                    [
                        'nama' => $barang->nama_barang,
                        'stok_aplikasi' => $aplikasi,
                        'stok_fisik' => $fisik,
                        'selisih_total' => $selisihTotal,
                        'selisih_harga' => $selisihHarga,
                        'id_cabang' => $opname->tempat,
                        'status' => 1,
                    ]
                );

                // Reconcile product stock to actual physical stock
                $barang->update(['stok' => $fisik]);

                // Record adjustment stock log if there was a difference
                if ($selisihTotal !== 0) {
                    StokBarang::create([
                        'id_barang' => $barang->id,
                        'tgl' => time(),
                        'tanggal' => Carbon::now('Asia/Jakarta')->format('d-m-Y'),
                        'jumlah' => abs($selisihTotal),
                        'keterangan' => 'Penyesuaian Stok Opname - Kode : ' . $kode,
                        'status' => $selisihTotal > 0 ? 1 : 2,
                        'in_out' => 0,
                    ]);
                }
            }

            $opname->update(['disabled' => 1]);

            return $opname;
        });
    }
}
