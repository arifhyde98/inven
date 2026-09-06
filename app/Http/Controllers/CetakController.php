<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cabang;
use App\Models\PengaturanUmum;
use App\Models\PesananBarang;
use App\Models\RiwayatPengeluaran;
use App\Models\RiwayatPenjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CetakController extends Controller
{
    public function buktiPesanan($kode)
    {
        $pesanan = PesananBarang::with(['cabang', 'suplierRelasi', 'items.barang', 'itemsManual'])->where('kode', $kode)->firstOrFail();
        $pengaturan = PengaturanUmum::first();

        return view('cetak.bukti_pesanan', compact('pesanan', 'pengaturan'));
    }

    public function historyPenjualan(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;

        $query = RiwayatPenjualan::with(['cabang', 'items'])->orderBy('id', 'desc');
        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }

        $penjualans = $query->get();
        $cabang = $cabangId ? Cabang::find($cabangId) : null;
        $pengaturan = PengaturanUmum::first();

        return view('cetak.history_penjualan', compact('penjualans', 'cabang', 'pengaturan'));
    }

    public function laporanPenjualanHari(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;
        $tanggal = $request->tanggal ? Carbon::parse($request->tanggal)->format('d-m-Y') : Carbon::now('Asia/Jakarta')->format('d-m-Y');

        $query = RiwayatPenjualan::with(['cabang', 'items'])->where('tanggal_ind', $tanggal);
        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }

        $penjualans = $query->get();
        $pengaturan = PengaturanUmum::first();
        $cabang = $cabangId ? Cabang::find($cabangId) : null;

        return view('cetak.laporan_penjualan_hari', compact('penjualans', 'pengaturan', 'cabang', 'tanggal'));
    }

    public function laporanPengeluaran(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->cabang_id : $user->penempatan_cabang;

        $query = RiwayatPengeluaran::with('cabang')->orderBy('id', 'desc');
        if ($cabangId) {
            $query->where('id_cabang', $cabangId);
        }

        $pengeluarans = $query->get();
        $pengaturan = PengaturanUmum::first();
        $cabang = $cabangId ? Cabang::find($cabangId) : null;

        return view('cetak.laporan_pengeluaran', compact('pengeluarans', 'pengaturan', 'cabang'));
    }

    public function barcodeSheet(Request $request)
    {
        $user = Auth::user();
        $query = Barang::query();
        if (!$user->isSuperAdmin()) {
            $query->where('id_cabang', $user->penempatan_cabang);
        }
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        $barangs = $query->orderBy('nama_barang', 'asc')->get();
        $jumlahPerItem = (int) ($request->qty ?? 12);
        $pengaturan = PengaturanUmum::first();

        return view('cetak.barcode_sheet', compact('barangs', 'jumlahPerItem', 'pengaturan'));
    }
}
