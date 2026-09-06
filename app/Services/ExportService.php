<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\DataHutang;
use App\Models\PesananBarang;
use App\Models\RiwayatPengeluaran;
use App\Models\RiwayatPenjualan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    public function exportPesanan($cabangId = null): StreamedResponse
    {
        $query = PesananBarang::with(['cabang', 'suplierRelasi', 'items', 'itemsManual'])->orderBy('id', 'desc');
        if ($cabangId) {
            $query->where('tempat', $cabangId);
        }
        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pesanan');

        $headers = ['No', 'Kode Pesanan', 'Nama Pesanan', 'Penempatan Cabang', 'Suplier', 'Jumlah Item', 'Jenis Pesanan', 'Status'];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            $namaCabang = $item->cabang ? $item->cabang->nama_cabang : 'Cabang ' . $item->tempat;
            $namaSuplier = $item->suplierRelasi ? $item->suplierRelasi->nama_suplier : ($item->suplier ?? '-');
            $jmlItem = $item->jenis_pesanan == 1 ? $item->items->count() : $item->itemsManual->count();
            $jenis = $item->jenis_pesanan == 1 ? 'Pesanan Stok' : 'Pesanan Baru';
            $status = $item->status == 1 ? 'Diterima' : 'Dipesan';

            $sheet->fromArray([
                $no++,
                $item->kode,
                $item->nama,
                $namaCabang,
                $namaSuplier,
                $jmlItem,
                $jenis,
                $status,
            ], null, "A{$row}");
            $row++;
        }

        return $this->downloadSpreadsheet($spreadsheet, 'Data_Pesanan_' . date('Ymd_His') . '.xlsx');
    }

    public function exportPenjualan($cabangId = null): StreamedResponse
    {
        $query = RiwayatPenjualan::with('cabang')->orderBy('id', 'desc');
        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }
        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Penjualan');

        $headers = ['No', 'ID Pembelian', 'Tanggal', 'Cabang', 'Total Pembayaran', 'Metode Bayar', 'Uang Diterima', 'Kembalian', 'Keuntungan/Profit'];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            $sheet->fromArray([
                $no++,
                $item->id_pembelian,
                $item->tanggal,
                $item->cabang ? $item->cabang->nama_cabang : ('Cabang ' . $item->id_cabang),
                $item->total_pembayaran,
                ucfirst($item->metode_bayar),
                $item->uang,
                $item->kembalian,
                $item->pendapatan,
            ], null, "A{$row}");
            $row++;
        }

        return $this->downloadSpreadsheet($spreadsheet, 'Data_Penjualan_' . date('Ymd_His') . '.xlsx');
    }

    public function exportStok($cabangId = null): StreamedResponse
    {
        $query = Barang::with(['cabang', 'suplier'])->orderBy('nama_barang', 'asc');
        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }
        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Stok Barang');

        $headers = ['No', 'Barcode', 'Nama Barang', 'Kategori', 'Harga Beli', 'Harga Jual', 'Stok', 'Satuan', 'Cabang', 'Expired Date'];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            $sheet->fromArray([
                $no++,
                $item->barcode,
                $item->nama_barang,
                $item->kategori,
                $item->harga_beli,
                $item->harga_jual,
                $item->stok,
                $item->satuan,
                $item->cabang ? $item->cabang->nama_cabang : ('Cabang ' . $item->id_cabang),
                $item->exp_date ?? '-',
            ], null, "A{$row}");
            $row++;
        }

        return $this->downloadSpreadsheet($spreadsheet, 'Laporan_Stok_' . date('Ymd_His') . '.xlsx');
    }

    public function exportPengeluaran($cabangId = null): StreamedResponse
    {
        $query = RiwayatPengeluaran::with('cabang')->orderBy('id', 'desc');
        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }
        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pengeluaran');

        $headers = ['No', 'Kode Pesanan', 'Cabang', 'Total Pengeluaran', 'Tanggal', 'Catatan', 'Status Bukti'];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            $status = $item->status_bukti == 1 ? 'Disetujui' : ($item->status_bukti == 2 ? 'Ditolak' : 'Menunggu');
            $sheet->fromArray([
                $no++,
                $item->kode_pesanan ?? '-',
                $item->cabang ? $item->cabang->nama_cabang : ('Cabang ' . $item->id_cabang),
                $item->total_pengeluaran,
                $item->tanggal_ind,
                $item->catatan ?? '-',
                $status,
            ], null, "A{$row}");
            $row++;
        }

        return $this->downloadSpreadsheet($spreadsheet, 'Data_Pengeluaran_' . date('Ymd_His') . '.xlsx');
    }

    protected function downloadSpreadsheet(Spreadsheet $spreadsheet, string $filename): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
