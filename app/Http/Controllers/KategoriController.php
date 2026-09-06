<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBarang::orderBy('id', 'desc')->get();
        return view('kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:128',
        ]);

        KategoriBarang::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori barang berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriBarang $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:128',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori barang diperbarui.');
    }

    public function destroy(KategoriBarang $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori barang berhasil dihapus.');
    }
}
