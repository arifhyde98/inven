<?php

namespace App\Http\Controllers;

use App\Models\PengaturanUmum;
use App\Services\UploadService;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        $pengaturan = PengaturanUmum::firstOrCreate(['id' => 1], [
            'nama_perusahaan' => 'Joona InventoryX',
            'pemilik' => 'Cep Guna',
            'alamat_perusahaan' => 'Bandung, Indonesia',
            'title' => 'JInventory',
            'footer' => 'Copyright © 2026 Joona Code',
            'favicon' => 'default.png',
        ]);

        return view('pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = PengaturanUmum::firstOrCreate(['id' => 1]);

        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'pemilik' => 'nullable|string|max:255',
            'alamat_perusahaan' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'footer' => 'nullable|string|max:255',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $favicon = $pengaturan->favicon;
        if ($request->hasFile('favicon')) {
            $favicon = $this->uploadService->uploadImage($request->file('favicon'), 'profiles', $pengaturan->favicon);
        }

        $pengaturan->update([
            'nama_perusahaan' => $validated['nama_perusahaan'],
            'pemilik' => $validated['pemilik'] ?? '',
            'alamat_perusahaan' => $validated['alamat_perusahaan'] ?? '',
            'title' => $validated['title'] ?? '',
            'footer' => $validated['footer'] ?? '',
            'favicon' => $favicon,
        ]);

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan umum berhasil disimpan.');
    }
}
