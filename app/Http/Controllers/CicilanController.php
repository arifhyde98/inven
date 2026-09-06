<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\PembayaranCicilan;
use App\Models\PengaturanUmum;
use App\Models\RiwayatPenjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CicilanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = RiwayatPenjualan::with(['cabang', 'customer', 'cicilans'])
            ->where('metode_bayar', 'cicilan')
            ->orderBy('id', 'desc');

        if (!$user->isSuperAdmin()) {
            $query->where('id_cabang', $user->penempatan_cabang);
        }

        $cicilans = $query->paginate(15);
        $cabangs = Cabang::all();

        return view('cicilan.index', compact('cicilans', 'cabangs', 'user'));
    }

    public function show($idCicilan)
    {
        $penjualan = RiwayatPenjualan::with(['cabang', 'customer', 'items'])
            ->where('id_pembayaran_cicilan', $idCicilan)
            ->firstOrFail();

        $payments = PembayaranCicilan::where('id_cicilan', $idCicilan)->orderBy('id', 'asc')->get();
        $lastPayment = $payments->last();
        $sisaHutang = $lastPayment ? $lastPayment->sisa_cicilan_akhir : $penjualan->total_pembayaran;

        return view('cicilan.show', compact('penjualan', 'payments', 'sisaHutang', 'idCicilan'));
    }

    public function pay(Request $request, $idCicilan)
    {
        $request->validate([
            'uang' => 'required|numeric|min:1',
        ]);

        $penjualan = RiwayatPenjualan::where('id_pembayaran_cicilan', $idCicilan)->firstOrFail();
        $lastPayment = PembayaranCicilan::where('id_cicilan', $idCicilan)->orderBy('id', 'desc')->first();
        $sisaSebelum = $lastPayment ? $lastPayment->sisa_cicilan_akhir : $penjualan->total_pembayaran;

        $bayar = (int) $request->uang;
        $kembalian = max(0, $bayar - $sisaSebelum);
        $sisaAkhir = max(0, $sisaSebelum - $bayar);

        $now = Carbon::now('Asia/Jakarta');

        DB::transaction(function () use ($penjualan, $idCicilan, $sisaSebelum, $bayar, $sisaAkhir, $kembalian, $now) {
            PembayaranCicilan::create([
                'id_cicilan' => $idCicilan,
                'id_pembelian' => $penjualan->id_pembelian,
                'id_user' => $penjualan->id_user,
                'id_cabang' => $penjualan->id_cabang,
                'tanggal' => $now->format('d-m-Y H:i:s'),
                'sisa_cicilan' => $sisaSebelum,
                'uang' => $bayar,
                'sisa_cicilan_akhir' => $sisaAkhir,
                'kembalian' => $kembalian,
            ]);

            // If completely paid off, update status_utang to 0 (lunas)
            if ($sisaAkhir === 0) {
                $penjualan->update(['status_utang' => 0]);
            }
        });

        return redirect()->route('cicilan.show', $idCicilan)->with('success', 'Pembayaran cicilan berhasil dicatat.');
    }

    public function struk($idCicilan)
    {
        $penjualan = RiwayatPenjualan::with(['cabang', 'customer', 'items'])
            ->where('id_pembayaran_cicilan', $idCicilan)
            ->firstOrFail();

        $payments = PembayaranCicilan::where('id_cicilan', $idCicilan)->orderBy('id', 'asc')->get();
        $pengaturan = PengaturanUmum::first();

        return view('cicilan.struk', compact('penjualan', 'payments', 'pengaturan'));
    }

    public function log(Request $request)
    {
        $user = Auth::user();
        $query = PembayaranCicilan::with(['cabang', 'penjualan.customer'])->orderBy('id', 'desc');

        if (!$user->isSuperAdmin()) {
            $query->where('id_cabang', $user->penempatan_cabang);
        }

        $logs = $query->paginate(20);
        return view('cicilan.log', compact('logs'));
    }
}
