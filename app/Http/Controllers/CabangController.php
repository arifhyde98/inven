<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::withCount('barangs')->get();
        return view('cabang.index', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_cabang' => 'required|string|max:128',
            'alamat' => 'required|string|max:255',
        ]);

        Cabang::create([
            'nama_cabang' => $validated['nama_cabang'],
            'alamat' => $validated['alamat'],
            'jumlah_barang' => 0,
        ]);

        return redirect()->route('cabang.index')->with('success', 'Cabang baru berhasil ditambahkan.');
    }

    public function update(Request $request, Cabang $cabang)
    {
        $validated = $request->validate([
            'nama_cabang' => 'required|string|max:128',
            'alamat' => 'required|string|max:255',
        ]);

        $cabang->update($validated);

        return redirect()->route('cabang.index')->with('success', 'Data cabang berhasil diperbarui.');
    }

    public function destroy(Cabang $cabang)
    {
        if ($cabang->barangs()->count() > 0) {
            return back()->with('error', 'Cabang tidak dapat dihapus karena masih memiliki barang terdaftar.');
        }

        $cabang->delete();
        return redirect()->route('cabang.index')->with('success', 'Cabang berhasil dihapus.');
    }
}
