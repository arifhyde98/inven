<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function pesanan(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;
        return $this->exportService->exportPesanan($cabangId);
    }

    public function penjualan(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;
        return $this->exportService->exportPenjualan($cabangId);
    }

    public function stok(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;
        return $this->exportService->exportStok($cabangId);
    }

    public function pengeluaran(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;
        return $this->exportService->exportPengeluaran($cabangId);
    }
}
