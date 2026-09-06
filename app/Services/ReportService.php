<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\RiwayatPengeluaran;
use App\Models\RiwayatPenjualan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getDashboardStats($user)
    {
        $cabangId = $user->isSuperAdmin() ? null : $user->penempatan_cabang;
        $today = Carbon::now('Asia/Jakarta')->format('d-m-Y');
        $currentMonth = Carbon::now('Asia/Jakarta')->format('m-Y');
        $currentYear = (int) Carbon::now('Asia/Jakarta')->format('Y');

        $salesQuery = RiwayatPenjualan::query();
        $barangQuery = Barang::query();
        $expenseQuery = RiwayatPengeluaran::query();

        if ($cabangId) {
            $salesQuery->where('id_cabang', $cabangId);
            $barangQuery->where('id_cabang', $cabangId);
            $expenseQuery->where('id_cabang', $cabangId);
        }

        // Today's Sales
        $penjualanHariIni = (clone $salesQuery)->where('tanggal_ind', $today)->sum('total_pembayaran');
        $pendapatanHariIni = (clone $salesQuery)->where('tanggal_ind', $today)->sum('pendapatan');
        $transaksiHariIni = (clone $salesQuery)->where('tanggal_ind', $today)->count();

        // Month Sales
        $penjualanBulanIni = (clone $salesQuery)->where('bulan_ind', $currentMonth)->sum('total_pembayaran');
        $pendapatanBulanIni = (clone $salesQuery)->where('bulan_ind', $currentMonth)->sum('pendapatan');
        $pengeluaranBulanIni = (clone $expenseQuery)->where('bulan_ind', $currentMonth)->sum('total_pengeluaran');

        // Products & Stock
        $totalBarang = (clone $barangQuery)->count();
        $stokMenipis = (clone $barangQuery)->where('stok', '<=', 5)->count();

        // Weekly Sales Chart Data (Days 1 to 7)
        $chartLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $chartSales = [0, 0, 0, 0, 0, 0, 0];
        $chartIncome = [0, 0, 0, 0, 0, 0, 0];

        $weeklyRecords = (clone $salesQuery)
            ->where('bulan_ind', $currentMonth)
            ->get();

        foreach ($weeklyRecords as $rec) {
            $dayIdx = ((int) $rec->hari) - 1;
            if ($dayIdx >= 0 && $dayIdx < 7) {
                $chartSales[$dayIdx] += $rec->total_pembayaran;
                $chartIncome[$dayIdx] += $rec->pendapatan;
            }
        }

        return [
            'penjualan_hari_ini' => $penjualanHariIni,
            'pendapatan_hari_ini' => $pendapatanHariIni,
            'transaksi_hari_ini' => $transaksiHariIni,
            'penjualan_bulan_ini' => $penjualanBulanIni,
            'pendapatan_bulan_ini' => $pendapatanBulanIni,
            'pengeluaran_bulan_ini' => $pengeluaranBulanIni,
            'laba_bersih_bulan_ini' => $pendapatanBulanIni - $pengeluaranBulanIni,
            'total_barang' => $totalBarang,
            'stok_menipis' => $stokMenipis,
            'chart_labels' => $chartLabels,
            'chart_sales' => $chartSales,
            'chart_income' => $chartIncome,
        ];
    }

    public function getDailySales($cabangId = null, $date = null)
    {
        $date = $date ?: Carbon::now('Asia/Jakarta')->format('d-m-Y');
        $query = RiwayatPenjualan::with(['cabang', 'items'])->where('tanggal_ind', $date);

        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function getMonthlySales($cabangId = null, $monthYear = null)
    {
        $monthYear = $monthYear ?: Carbon::now('Asia/Jakarta')->format('m-Y');
        $query = RiwayatPenjualan::with(['cabang', 'items'])->where('bulan_ind', $monthYear);

        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function getStockReport($cabangId = null)
    {
        $query = Barang::with(['cabang', 'suplier']);

        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }

        return $query->orderBy('nama_barang', 'asc')->get();
    }
}
