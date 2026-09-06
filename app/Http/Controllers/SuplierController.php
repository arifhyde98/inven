<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    public function index()
    {
        $supliers = Suplier::withCount('barangs')->orderBy('id', 'desc')->get();
        $kodeBaru = 'SUP' . str_pad(Suplier::count() + 1, 3, '0', STR_PAD_LEFT);

        return view('suplier.index', compact('supliers', 'kodeBaru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_suplier' => 'required|string|unique:suplier,id_suplier',
            'nama_suplier' => 'required|string|max:128',
            'alamat_suplier' => 'nullable|string',
            'telp' => 'nullable|string',
        ]);

        Suplier::create($validated);

        return redirect()->route('suplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function update(Request $request, Suplier $suplier)
    {
        $validated = $request->validate([
            'nama_suplier' => 'required|string|max:128',
            'alamat_suplier' => 'nullable|string',
            'telp' => 'nullable|string',
        ]);

        $suplier->update($validated);

        return redirect()->route('suplier.index')->with('success', 'Data supplier diperbarui.');
    }

    public function destroy(Suplier $suplier)
    {
        $suplier->delete();
        return redirect()->route('suplier.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
