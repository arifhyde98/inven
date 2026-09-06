<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\RiwayatPengeluaran;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = RiwayatPengeluaran::with('cabang')->orderBy('id', 'desc');

        if (!$user->isSuperAdmin()) {
            $query->where('id_cabang', $user->penempatan_cabang);
        }

        $pengeluarans = $query->paginate(15);
        $cabangs = Cabang::all();

        return view('pengeluaran.index', compact('pengeluarans', 'cabangs', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'total_pengeluaran' => 'required|numeric|min:1',
            'catatan' => 'required|string',
            'kode_pesanan' => 'nullable|string',
            'id_cabang' => 'nullable|integer',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $user = Auth::user();
        $cabangId = $user->isSuperAdmin() ? ($validated['id_cabang'] ?? 1) : $user->penempatan_cabang;

        $bukti = 'default.png';
        if ($request->hasFile('bukti')) {
            $bukti = $this->uploadService->uploadImage($request->file('bukti'), 'bukti_pengeluaran', 'default.png');
        }

        $now = Carbon::now('Asia/Jakarta');

        RiwayatPengeluaran::create([
            'kode_pesanan' => $validated['kode_pesanan'] ?? '',
            'id_cabang' => $cabangId,
            'total_pengeluaran' => $validated['total_pengeluaran'],
            'tanggal_ind' => $now->format('d-m-Y'),
            'bulan_ind' => $now->format('m-Y'),
            'single_bulan' => $now->format('m'),
            'single_tahun' => (int) $now->format('Y'),
            'bukti_pengeluaran' => $bukti,
            'status_bukti' => $user->isSuperAdmin() ? 1 : 0, // Superadmin auto-approved, admin needs review
            'catatan' => $validated['catatan'],
            'jenis' => 2,
            'hari' => $now->dayOfWeekIso,
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil disimpan.');
    }

    public function approve($id)
    {
        $pengeluaran = RiwayatPengeluaran::findOrFail($id);
        $pengeluaran->update(['status_bukti' => 1]);

        return redirect()->route('pengeluaran.index')->with('success', 'Bukti pengeluaran telah disetujui.');
    }

    public function reject($id)
    {
        $pengeluaran = RiwayatPengeluaran::findOrFail($id);
        $pengeluaran->update(['status_bukti' => 2]);

        return redirect()->route('pengeluaran.index')->with('success', 'Bukti pengeluaran telah ditolak.');
    }

    public function destroy($id)
    {
        $pengeluaran = RiwayatPengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
