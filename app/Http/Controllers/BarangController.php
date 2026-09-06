<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cabang;
use App\Models\KategoriBarang;
use App\Models\SatuanBarang;
use App\Models\StokBarang;
use App\Models\Suplier;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Barang::with(['cabang', 'suplier']);

        if (!$user->isSuperAdmin()) {
            $query->where('id_cabang', $user->penempatan_cabang);
        } elseif ($request->filled('cabang_id')) {
            $query->where('id_cabang', $request->cabang_id);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_barang', 'like', "%{$s}%")
                  ->orWhere('barcode', 'like', "%{$s}%");
            });
        }

        $barangs = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();
        $cabangs = Cabang::all();
        $kategoris = KategoriBarang::all();

        return view('barang.index', compact('barangs', 'cabangs', 'kategoris', 'user'));
    }

    public function create()
    {
        $cabangs = Cabang::all();
        $kategoris = KategoriBarang::all();
        $satuans = SatuanBarang::all();
        $supliers = Suplier::all();
        $user = Auth::user();

        return view('barang.create', compact('cabangs', 'kategoris', 'satuans', 'supliers', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'nullable|string|max:50',
            'nama_barang' => 'required|string|max:128',
            'kategori' => 'required|string',
            'satuan' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'id_cabang' => 'nullable|integer',
            'id_suplier' => 'nullable|integer',
            'exp_date' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $user = Auth::user();
        $idCabang = $user->isSuperAdmin() ? ($validated['id_cabang'] ?? 1) : $user->penempatan_cabang;
        $profit = max(0, $validated['harga_jual'] - $validated['harga_beli']);

        $gambar = 'default.png';
        if ($request->hasFile('foto')) {
            $gambar = $this->uploadService->uploadImage($request->file('foto'), 'barang', 'default.png');
        }

        $barang = Barang::create([
            'barcode' => $validated['barcode'] ?: (string) rand(100000000000, 999999999999),
            'nama_barang' => $validated['nama_barang'],
            'gambar' => $gambar,
            'kategori' => $validated['kategori'],
            'harga_beli' => $validated['harga_beli'],
            'harga_jual' => $validated['harga_jual'],
            'profit' => $profit,
            'stok' => $validated['stok'],
            'satuan' => $validated['satuan'],
            'id_cabang' => $idCabang,
            'id_suplier' => $validated['id_suplier'] ?? null,
            'exp_date' => $validated['exp_date'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        // Record initial stock entry
        if ($validated['stok'] > 0) {
            StokBarang::create([
                'id_barang' => $barang->id,
                'tgl' => time(),
                'tanggal' => Carbon::now('Asia/Jakarta')->format('d-m-Y'),
                'jumlah' => $validated['stok'],
                'keterangan' => 'Stok Awal Produk Baru',
                'status' => 1,
                'in_out' => 0,
            ]);
        }

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['cabang', 'suplier', 'stokLogs']);
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $cabangs = Cabang::all();
        $kategoris = KategoriBarang::all();
        $satuans = SatuanBarang::all();
        $supliers = Suplier::all();
        $user = Auth::user();

        return view('barang.edit', compact('barang', 'cabangs', 'kategoris', 'satuans', 'supliers', 'user'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'barcode' => 'nullable|string|max:50',
            'nama_barang' => 'required|string|max:128',
            'kategori' => 'required|string',
            'satuan' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'id_cabang' => 'nullable|integer',
            'id_suplier' => 'nullable|integer',
            'exp_date' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $user = Auth::user();
        $profit = max(0, $validated['harga_jual'] - $validated['harga_beli']);

        $gambar = $barang->gambar;
        if ($request->hasFile('foto')) {
            $gambar = $this->uploadService->uploadImage($request->file('foto'), 'barang', $barang->gambar);
        }

        $idCabang = $user->isSuperAdmin() ? ($validated['id_cabang'] ?? $barang->id_cabang) : $user->penempatan_cabang;

        $barang->update([
            'barcode' => $validated['barcode'] ?? $barang->barcode,
            'nama_barang' => $validated['nama_barang'],
            'gambar' => $gambar,
            'kategori' => $validated['kategori'],
            'harga_beli' => $validated['harga_beli'],
            'harga_jual' => $validated['harga_jual'],
            'profit' => $profit,
            'stok' => $validated['stok'],
            'satuan' => $validated['satuan'],
            'id_cabang' => $idCabang,
            'id_suplier' => $validated['id_suplier'] ?? $barang->id_suplier,
            'exp_date' => $validated['exp_date'] ?? $barang->exp_date,
            'keterangan' => $validated['keterangan'] ?? $barang->keterangan,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function barcode()
    {
        $user = Auth::user();
        $query = Barang::query();
        if (!$user->isSuperAdmin()) {
            $query->where('id_cabang', $user->penempatan_cabang);
        }
        $barangs = $query->orderBy('nama_barang', 'asc')->get();

        return view('barang.barcode', compact('barangs'));
    }

    public function logInOut(Request $request)
    {
        $user = Auth::user();
        $query = StokBarang::with('barang.cabang')->orderBy('id', 'desc');

        if (!$user->isSuperAdmin()) {
            $query->whereHas('barang', function ($q) use ($user) {
                $q->where('id_cabang', $user->penempatan_cabang);
            });
        }

        $logs = $query->paginate(20);
        return view('barang.log_in_out', compact('logs'));
    }
}
