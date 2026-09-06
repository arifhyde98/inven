<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cabang;
use App\Models\IsiStokOpname;
use App\Models\StokOpname;
use App\Services\StockService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokOpnameController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index()
    {
        $user = Auth::user();
        $query = StokOpname::with('cabang')->orderBy('id', 'desc');

        if (!$user->isSuperAdmin()) {
            $query->where('tempat', $user->penempatan_cabang);
        }

        $opnames = $query->paginate(15);
        $cabangs = Cabang::all();

        return view('stok_opname.index', compact('opnames', 'cabangs', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $cabangs = Cabang::all();
        $kode = 'SON' . rand(100000, 999999);

        return view('stok_opname.create', compact('cabangs', 'kode', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'tempat' => 'required',
        ]);

        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? $request->tempat : $user->penempatan_cabang;
        $now = Carbon::now('Asia/Jakarta');
        $kode = $request->kode ?: ('SON' . rand(100000, 999999));

        $opname = StokOpname::create([
            'kode' => $kode,
            'nama' => $request->nama,
            'tanggal' => $now->format('d-m-Y'),
            'tempat' => (string) $cabangId,
            'status' => 'Stok Opname',
            'catatan' => $request->catatan ?? '',
            'disabled' => 0,
        ]);

        return redirect()->route('stok-opname.process', $kode)->with('success', 'Sesi stok opname dibuat. Silakan masukkan hasil perhitungan fisik.');
    }

    public function showProcess($kode)
    {
        $opname = StokOpname::with('cabang')->where('kode', $kode)->firstOrFail();
        $barangs = Barang::where('id_cabang', $opname->tempat)->orderBy('nama_barang', 'asc')->get();
        $items = IsiStokOpname::where('kode', $kode)->get()->keyBy('id_barang');

        return view('stok_opname.process', compact('opname', 'barangs', 'items'));
    }

    public function process(Request $request, $kode)
    {
        $request->validate([
            'is_check' => 'required|array',
            'stok_fisik' => 'required|array',
            'stok_aplikasi' => 'required|array',
        ]);

        try {
            $this->stockService->processOpname(
                $kode,
                $request->is_check,
                $request->stok_fisik,
                $request->stok_aplikasi
            );

            return redirect()->route('stok-opname.index')->with('success', 'Audit stok opname berhasil disimpan dan disesuaikan!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
