<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function penjualanHarian(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;
        $tanggal = $request->tanggal ? Carbon::parse($request->tanggal)->format('d-m-Y') : Carbon::now('Asia/Jakarta')->format('d-m-Y');

        $laporan = $this->reportService->getDailySales($cabangId, $tanggal);
        $totalPenjualan = $laporan->sum('total_pembayaran');
        $totalProfit = $laporan->sum('pendapatan');

        $cabangs = Cabang::all();

        return view('laporan.penjualan_harian', compact('laporan', 'totalPenjualan', 'totalProfit', 'cabangs', 'tanggal', 'cabangId', 'user'));
    }

    public function penjualanBulanan(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;
        $bulan = $request->bulan ? Carbon::parse($request->bulan)->format('m-Y') : Carbon::now('Asia/Jakarta')->format('m-Y');

        $laporan = $this->reportService->getMonthlySales($cabangId, $bulan);
        $totalPenjualan = $laporan->sum('total_pembayaran');
        $totalProfit = $laporan->sum('pendapatan');

        $cabangs = Cabang::all();

        return view('laporan.penjualan_bulanan', compact('laporan', 'totalPenjualan', 'totalProfit', 'cabangs', 'bulan', 'cabangId', 'user'));
    }

    public function stok(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;

        $barangs = $this->reportService->getStockReport($cabangId);
        $totalStok = $barangs->sum('stok');
        $totalAsetBeli = $barangs->sum(fn ($b) => $b->stok * $b->harga_beli);
        $totalAsetJual = $barangs->sum(fn ($b) => $b->stok * $b->harga_jual);

        $cabangs = Cabang::all();

        return view('laporan.stok', compact('barangs', 'totalStok', 'totalAsetBeli', 'totalAsetJual', 'cabangs', 'cabangId', 'user'));
    }
}
