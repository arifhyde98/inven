<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cabang;
use App\Models\IsiPesananBarang;
use App\Models\KategoriBarang;
use App\Models\PesananBarang;
use App\Models\PesananManual;
use App\Models\SatuanBarang;
use App\Models\Suplier;
use App\Services\StockService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = PesananBarang::with(['cabang', 'suplierRelasi', 'items', 'itemsManual'])->orderBy('id', 'desc');

        if (!$user->isSuperAdmin()) {
            $query->where('tempat', $user->penempatan_cabang);
        }

        $pesanans = $query->paginate(15);
        $cabangs = Cabang::all();

        return view('pesanan.index', compact('pesanans', 'cabangs', 'user'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $jenis = $request->query('jenis', 1); // 1 = restock, 2 = manual
        $cabangId = $user->isSuperAdmin() ? ($request->query('cabang_id', 1)) : $user->penempatan_cabang;

        $cabangs = Cabang::all();
        $supliers = Suplier::all();
        $barangs = Barang::where('id_cabang', $cabangId)->orderBy('nama_barang', 'asc')->get();
        $kategoris = KategoriBarang::all();
        $satuans = SatuanBarang::all();

        $kodePesanan = 'PSN' . rand(100000, 999999);

        return view('pesanan.create', compact('cabangs', 'supliers', 'barangs', 'kategoris', 'satuans', 'user', 'jenis', 'cabangId', 'kodePesanan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $jenis = (int) $request->jenis_pesanan;

        $now = Carbon::now('Asia/Jakarta');
        $kode = $request->kode ?: ('PSN' . rand(100000, 999999));
        $cabangId = $user->isSuperAdmin() ? ($request->tempat ?? 1) : $user->penempatan_cabang;

        DB::transaction(function () use ($request, $user, $jenis, $kode, $cabangId, $now) {
            $pesanan = PesananBarang::create([
                'kode' => $kode,
                'nama' => $request->nama ?? ('Pesanan ' . $kode),
                'suplier' => $request->suplier ?? '-',
                'tempat' => (string) $cabangId,
                'tanggal_pesan' => $now->format('d-m-Y'),
                'tanggal_terima' => '',
                'status' => 0, // Pending
                'jenis_pesanan' => $jenis,
            ]);

            if ($jenis === 1) {
                // Restock items
                $itemIds = $request->barang_id ?? [];
                $qty = $request->stok_pesan ?? [];

                foreach ($itemIds as $index => $idBarang) {
                    $barang = Barang::find($idBarang);
                    if (!$barang) continue;

                    $jumlahPesan = isset($qty[$index]) ? max(1, (int) $qty[$index]) : 1;
                    $totalBeli = $jumlahPesan * $barang->harga_beli;

                    IsiPesananBarang::create([
                        'kode' => $kode,
                        'nama' => $barang->nama_barang,
                        'id_barang' => $barang->id,
                        'stok_sekarang' => $barang->stok,
                        'stok_pesan' => $jumlahPesan,
                        'stok_terima' => 0,
                        'harga_beli' => $barang->harga_beli,
                        'total_beli' => $totalBeli,
                        'status' => 0,
                        'id_cabang' => $cabangId,
                    ]);
                }
            } else {
                // Manual new purchase items
                $namaBarangs = $request->manual_nama ?? [];
                $kategoris = $request->manual_kategori ?? [];
                $satuans = $request->manual_satuan ?? [];
                $hargaBelis = $request->manual_harga_beli ?? [];
                $jumlahs = $request->manual_jumlah ?? [];

                foreach ($namaBarangs as $index => $nama) {
                    if (empty($nama)) continue;

                    $hrg = isset($hargaBelis[$index]) ? (int) $hargaBelis[$index] : 0;
                    $jml = isset($jumlahs[$index]) ? (int) $jumlahs[$index] : 1;

                    PesananManual::create([
                        'kode' => $kode,
                        'nama_barang' => $nama,
                        'kategori' => $kategoris[$index] ?? 'Umum',
                        'satuan' => $satuans[$index] ?? 'pcs',
                        'harga_beli' => $hrg,
                        'jumlah' => $jml,
                        'harga_total' => $hrg * $jml,
                        'id_user' => $user->id,
                        'id_cabang' => $cabangId,
                    ]);
                }
            }
        });

        return redirect()->route('pesanan.index')->with('success', "Pesanan [{$kode}] berhasil dibuat.");
    }

    public function show($kode)
    {
        $pesanan = PesananBarang::with(['cabang', 'suplierRelasi', 'items.barang', 'itemsManual'])->where('kode', $kode)->firstOrFail();
        return view('pesanan.show', compact('pesanan'));
    }

    public function receive($kode)
    {
        try {
            $this->stockService->receiveOrder($kode);
            return redirect()->route('pesanan.index')->with('success', "Pesanan [{$kode}] berhasil diterima dan stok otomatis ditambahkan!");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($kode)
    {
        DB::transaction(function () use ($kode) {
            PesananBarang::where('kode', $kode)->delete();
            IsiPesananBarang::where('kode', $kode)->delete();
            PesananManual::where('kode', $kode)->delete();
        });

        return redirect()->route('pesanan.index')->with('success', "Pesanan [{$kode}] telah dibatalkan/dihapus.");
    }
}
