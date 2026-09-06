<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cabang;
use App\Models\PengaturanUmum;
use App\Models\RiwayatPenjualan;
use App\Models\UserLangganan;
use App\Services\PosService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    protected $posService;

    public function __construct(PosService $posService)
    {
        $this->posService = $posService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? ($request->cabang_id ?? 1) : $user->penempatan_cabang;

        $barangsQuery = Barang::where('id_cabang', $cabangId);
        if ($request->filled('search')) {
            $s = $request->search;
            $barangsQuery->where(function ($q) use ($s) {
                $q->where('nama_barang', 'like', "%{$s}%")
                  ->orWhere('barcode', 'like', "%{$s}%");
            });
        }
        $barangs = $barangsQuery->orderBy('nama_barang', 'asc')->get();

        $cart = $this->posService->getCart($user->id);
        $total = $cart->sum('harga_total');
        $customers = UserLangganan::where('penempatan', $cabangId)->get();
        $cabangs = Cabang::all();

        $now = Carbon::now('Asia/Jakarta');
        $idPembelian = 'JBR' . $now->format('dmy') . rand(1000, 9999);
        $idCicilan = 'IPC' . $now->format('dmy') . rand(1000, 9999);

        return view('pos.index', compact('barangs', 'cart', 'total', 'customers', 'cabangs', 'cabangId', 'idPembelian', 'idCicilan', 'user'));
    }

    public function scanBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
            'cabang_id' => 'nullable|integer',
        ]);

        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? ($request->cabang_id ?? 1) : $user->penempatan_cabang;

        try {
            $this->posService->addToCartByBarcode($user->id, $cabangId, $request->barcode);
            return response()->json([
                'status' => 'success',
                'message' => 'Barang berhasil dimasukkan ke keranjang.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
            'cabang_id' => 'nullable|integer',
        ]);

        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? ($request->cabang_id ?? 1) : $user->penempatan_cabang;

        try {
            $this->posService->addToCart($user->id, $cabangId, $request->id_barang, $request->jumlah);
            return response()->json([
                'status' => 'success',
                'message' => 'Barang ditambahkan ke keranjang.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        try {
            $this->posService->updateCartQuantity($id, $user->id, $request->jumlah);
            return response()->json([
                'status' => 'success',
                'message' => 'Jumlah barang diperbarui.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function deleteCart($id)
    {
        $user = Auth::user();
        $this->posService->removeFromCart($id, $user->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang dihapus dari keranjang.',
        ]);
    }

    public function clearCart()
    {
        $user = Auth::user();
        $this->posService->clearCart($user->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Keranjang dikosongkan.',
        ]);
    }

    public function getCartTable()
    {
        $user = Auth::user();
        $cart = $this->posService->getCart($user->id);
        $total = $cart->sum('harga_total');

        return view('pos.partials.cart_table', compact('cart', 'total'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'id_pembelian' => 'required|string',
            'metode' => 'required|in:tunai,cicilan',
            'uang_saya' => 'required|numeric|min:0',
            'id_user' => 'nullable|string',
            'id_cicilan' => 'nullable|string',
            'cabang_id' => 'nullable|integer',
        ]);

        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? ($validated['cabang_id'] ?? 1) : $user->penempatan_cabang;
        $validated['id_cabang'] = $cabangId;

        try {
            $penjualan = $this->posService->checkout($user->id, $validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Transaksi penjualan berhasil diselesaikan!',
                    'id_pembelian' => $penjualan->id_pembelian,
                    'redirect_url' => route('pos.struk', $penjualan->id_pembelian),
                ]);
            }

            return redirect()->route('pos.struk', $penjualan->id_pembelian)->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 422);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    public function struk($idPembelian)
    {
        $penjualan = RiwayatPenjualan::with(['cabang', 'customer', 'items'])->where('id_pembelian', $idPembelian)->firstOrFail();
        $pengaturan = PengaturanUmum::first();

        return view('pos.struk', compact('penjualan', 'pengaturan'));
    }

    public function strukThermal($idPembelian)
    {
        $penjualan = RiwayatPenjualan::with(['cabang', 'customer', 'items'])->where('id_pembelian', $idPembelian)->firstOrFail();
        $pengaturan = PengaturanUmum::first();

        return view('pos.struk_thermal', compact('penjualan', 'pengaturan'));
    }
}
