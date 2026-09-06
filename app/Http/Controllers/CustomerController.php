<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\UserLangganan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = UserLangganan::with('cabang')->orderBy('id', 'desc');

        if (!$user->isSuperAdmin()) {
            $query->where('penempatan', $user->penempatan_cabang);
        }

        $customers = $query->paginate(15);
        $cabangs = Cabang::all();

        return view('customer.index', compact('customers', 'cabangs', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'nama_user' => 'required|string|max:50',
            'tlp_user' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'penempatan' => 'nullable|integer',
        ]);

        $cabangId = $user->isSuperAdmin() ? ($validated['penempatan'] ?? 1) : $user->penempatan_cabang;
        $idUser = strtolower(str_replace(' ', '', $validated['nama_user'])) . '_' . rand(100, 9999);

        UserLangganan::create([
            'id_user' => $idUser,
            'nama_user' => $validated['nama_user'],
            'tlp_user' => $validated['tlp_user'] ?? '',
            'alamat' => $validated['alamat'] ?? '',
            'penempatan' => $cabangId,
        ]);

        return redirect()->route('customer.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function update(Request $request, UserLangganan $customer)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'nama_user' => 'required|string|max:50',
            'tlp_user' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'penempatan' => 'nullable|integer',
        ]);

        $cabangId = $user->isSuperAdmin() ? ($validated['penempatan'] ?? $customer->penempatan) : $user->penempatan_cabang;

        $customer->update([
            'nama_user' => $validated['nama_user'],
            'tlp_user' => $validated['tlp_user'] ?? '',
            'alamat' => $validated['alamat'] ?? '',
            'penempatan' => $cabangId,
        ]);

        return redirect()->route('customer.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(UserLangganan $customer)
    {
        $customer->delete();
        return redirect()->route('customer.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
