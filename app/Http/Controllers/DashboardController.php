<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\RiwayatPenjualan;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        $user = Auth::user();
        $stats = $this->reportService->getDashboardStats($user);

        // Recent sales transactions
        $recentSalesQuery = RiwayatPenjualan::with(['cabang', 'items'])->orderBy('id', 'desc')->limit(10);
        if (!$user->isSuperAdmin()) {
            $recentSalesQuery->where('id_cabang', $user->penempatan_cabang);
        }
        $recentSales = $recentSalesQuery->get();

        $cabangs = Cabang::all();

        return view('dashboard.index', compact('stats', 'recentSales', 'cabangs', 'user'));
    }
}
