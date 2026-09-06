<?php

namespace App\Http\Controllers;

use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'jenis_kelamin' => 'required|in:l,p',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $foto = $user->foto_profile;
        if ($request->hasFile('foto')) {
            $foto = $this->uploadService->uploadImage($request->file('foto'), 'profiles', $user->foto_profile);
        }

        $user->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'foto_profile' => $foto,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah!');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui.');
    }
}
