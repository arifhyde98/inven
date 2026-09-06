<?php

namespace App\Http\Controllers;

use App\Models\SatuanBarang;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = SatuanBarang::orderBy('id', 'desc')->get();
        return view('satuan.index', compact('satuans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:50',
            'nama_asli' => 'required|string|max:50',
        ]);

        SatuanBarang::create($validated);

        return redirect()->route('satuan.index')->with('success', 'Satuan barang berhasil ditambahkan.');
    }

    public function update(Request $request, SatuanBarang $satuan)
    {
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:50',
            'nama_asli' => 'required|string|max:50',
        ]);

        $satuan->update($validated);

        return redirect()->route('satuan.index')->with('success', 'Satuan barang diperbarui.');
    }

    public function destroy(SatuanBarang $satuan)
    {
        $satuan->delete();
        return redirect()->route('satuan.index')->with('success', 'Satuan barang berhasil dihapus.');
    }
}
