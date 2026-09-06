<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\PembayaranCicilan;
use App\Models\RiwayatPenjualan;
use App\Models\SemuaDataKeranjang;
use App\Models\StokBarang;
use App\Models\UserLangganan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PosService
{
    public function getCart($userId)
    {
        return Keranjang::with('barang')
            ->where('id_user', $userId)
            ->get();
    }

    public function addToCart($userId, $cabangId, $idBarang, $jumlah = 1)
    {
        $barang = Barang::findOrFail($idBarang);

        // Check if item already exists in cart for this user
        $existing = Keranjang::where('id_user', $userId)
            ->where('id_barang', $idBarang)
            ->first();

        $jumlah = max(1, (int) $jumlah);
        if ($jumlah > $barang->stok) {
            throw new \Exception("Stok tidak mencukupi! Stok tersisa: {$barang->stok}");
        }

        if ($existing) {
            $newJumlah = $existing->jumlah + $jumlah;
            if ($newJumlah > $barang->stok) {
                throw new \Exception("Total di keranjang melebihi stok! Stok tersisa: {$barang->stok}");
            }
            $existing->update([
                'jumlah' => $newJumlah,
                'harga_total' => $newJumlah * $barang->harga_jual,
                'profit' => $newJumlah * $barang->profit,
            ]);
            return $existing;
        }

        return Keranjang::create([
            'barcode' => $barang->barcode ?? '',
            'id_barang' => $barang->id,
            'id_cabang' => $cabangId,
            'jumlah' => $jumlah,
            'satuan' => $barang->satuan ?? 'pcs',
            'harga' => $barang->harga_jual,
            'profit' => $barang->profit * $jumlah,
            'harga_total' => $barang->harga_jual * $jumlah,
            'id_pembelian' => 1,
            'id_user' => $userId,
        ]);
    }

    public function addToCartByBarcode($userId, $cabangId, $barcode)
    {
        $query = Barang::where('barcode', $barcode);
        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }
        $barang = $query->first();

        if (!$barang) {
            // If not found in branch, try any branch or fallback
            $barang = Barang::where('barcode', $barcode)->first();
        }

        if (!$barang) {
            throw new \Exception("Barang dengan barcode [{$barcode}] tidak ditemukan.");
        }

        if ($barang->stok < 1) {
            throw new \Exception("Stok barang '{$barang->nama_barang}' habis!");
        }

        return $this->addToCart($userId, $cabangId, $barang->id, 1);
    }

    public function updateCartQuantity($cartId, $userId, $qty)
    {
        $item = Keranjang::where('id', $cartId)->where('id_user', $userId)->firstOrFail();
        $barang = Barang::findOrFail($item->id_barang);
        $qty = max(1, (int) $qty);

        if ($qty > $barang->stok) {
            throw new \Exception("Stok tidak mencukupi! Maksimal: {$barang->stok}");
        }

        $item->update([
            'jumlah' => $qty,
            'harga_total' => $qty * $item->harga,
            'profit' => $qty * ($barang->profit ?? ($item->harga - $barang->harga_beli)),
        ]);

        return $item;
    }

    public function removeFromCart($cartId, $userId)
    {
        return Keranjang::where('id', $cartId)->where('id_user', $userId)->delete();
    }

    public function clearCart($userId)
    {
        return Keranjang::where('id_user', $userId)->delete();
    }

    public function checkout($userId, array $payload)
    {
        $cartItems = Keranjang::where('id_user', $userId)->get();
        if ($cartItems->isEmpty()) {
            throw new \Exception("Keranjang belanja kosong!");
        }

        return DB::transaction(function () use ($userId, $cartItems, $payload) {
            $totalHarga = $cartItems->sum('harga_total');
            $totalProfit = $cartItems->sum('profit');
            $idKeranjang = rand(1000, 9999);
            $idCabang = $payload['id_cabang'] ?? $cartItems->first()->id_cabang ?? 1;

            $now = Carbon::now('Asia/Jakarta');
            $idPembelian = $payload['id_pembelian'] ?? ('JBR' . $now->format('dmy') . rand(1000, 9999));
            $metode = $payload['metode'] ?? 'tunai';
            $uang = (int) ($payload['uang_saya'] ?? $payload['uang'] ?? $totalHarga);
            $kembalian = max(0, $uang - $totalHarga);

            // Day of week index (1 = Senin .. 7 = Minggu)
            $dayOfWeek = $now->dayOfWeekIso; // 1 (for Monday) through 7 (for Sunday)

            // 1. Process Stock & Items
            foreach ($cartItems as $item) {
                $barang = Barang::lockForUpdate()->find($item->id_barang);
                if ($barang) {
                    if ($barang->stok < $item->jumlah) {
                        throw new \Exception("Stok '{$barang->nama_barang}' tidak mencukupi saat checkout!");
                    }

                    $barang->decrement('stok', $item->jumlah);

                    // Insert Stock Log
                    StokBarang::create([
                        'id_barang' => $barang->id,
                        'tgl' => time(),
                        'tanggal' => $now->format('d-m-Y'),
                        'jumlah' => $item->jumlah,
                        'keterangan' => 'Barang terjual - ID : ' . $idPembelian,
                        'status' => 2, // Out
                        'in_out' => 0,
                    ]);
                }

                // Insert into historical cart table
                SemuaDataKeranjang::create([
                    'barcode' => $item->barcode ?? ($barang ? $barang->barcode : ''),
                    'id_keranjang' => $idKeranjang,
                    'nama' => $barang ? $barang->nama_barang : 'Barang',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->satuan,
                    'harga' => $item->harga,
                    'harga_total' => $item->harga_total,
                    'id_del' => null,
                    'harga_beli' => $barang ? $barang->harga_beli : 0,
                    'harga_jual' => $item->harga,
                    'profit' => $item->profit,
                    'id_user' => $userId,
                    'id_cabang' => $idCabang,
                    'id_barang' => $item->id_barang,
                ]);
            }

            // 2. Prepare Cicilan ID if payment method is cicilan
            $idCicilan = '';
            $idUserLangganan = $payload['id_user'] ?? '';
            $statusUtang = 0;

            if ($metode === 'cicilan') {
                $idCicilan = $payload['id_cicilan'] ?? ('IPC' . $now->format('dmy') . rand(10000, 99999));
                $statusUtang = 1;

                // Sisa hutang / cicilan
                $sisaCicilan = max(0, $totalHarga - $uang);

                PembayaranCicilan::create([
                    'id_cicilan' => $idCicilan,
                    'id_pembelian' => $idPembelian,
                    'id_user' => $idUserLangganan,
                    'id_cabang' => $idCabang,
                    'tanggal' => $now->format('d-m-Y H:i:s'),
                    'sisa_cicilan' => $totalHarga,
                    'uang' => $uang,
                    'sisa_cicilan_akhir' => $sisaCicilan,
                    'kembalian' => $kembalian,
                ]);
            }

            // 3. Create Sales Record
            $penjualan = RiwayatPenjualan::create([
                'id_pembelian' => $idPembelian,
                'id_pembayaran_cicilan' => $idCicilan,
                'id_user' => $idUserLangganan,
                'id_keranjang' => $idKeranjang,
                'id_cabang' => $idCabang,
                'total_pembayaran' => $totalHarga,
                'tanggal' => $now->format('d-m-Y H:i:s'),
                'tanggal_ind' => $now->format('d-m-Y'),
                'bulan_ind' => $now->format('m-Y'),
                'single_bulan' => $now->format('m'),
                'single_tahun' => (int) $now->format('Y'),
                'uang' => $uang,
                'kembalian' => $kembalian,
                'pendapatan' => $totalProfit,
                'hari' => $dayOfWeek,
                'metode_bayar' => $metode,
                'status_utang' => $statusUtang,
            ]);

            // 4. Clear active cart
            Keranjang::where('id_user', $userId)->delete();

            return $penjualan;
        });
    }
}
