<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\User;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        $users = User::with('cabang')->where('role_id', 2)->orderBy('id', 'desc')->get();
        $cabangs = Cabang::all();

        return view('users.index', compact('users', 'cabangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:128|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:3',
            'jenis_kelamin' => 'required|in:l,p',
            'penempatan_cabang' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $foto = 'default.png';
        if ($request->hasFile('foto')) {
            $foto = $this->uploadService->uploadImage($request->file('foto'), 'profiles', 'default.png');
        }

        User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'penempatan_cabang' => $validated['penempatan_cabang'],
            'foto_profile' => $foto,
            'role_id' => 2, // Admin
            'status' => 1,
        ]);

        return redirect()->route('users.index')->with('success', 'Admin cabang baru berhasil dibuat.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:128|unique:users,username,' . $user->id,
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:3',
            'jenis_kelamin' => 'required|in:l,p',
            'penempatan_cabang' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $foto = $user->foto_profile;
        if ($request->hasFile('foto')) {
            $foto = $this->uploadService->uploadImage($request->file('foto'), 'profiles', $user->foto_profile);
        }

        $data = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'penempatan_cabang' => $validated['penempatan_cabang'],
            'foto_profile' => $foto,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data admin cabang berhasil diperbarui.');
    }

    public function toggleStatus(User $user)
    {
        $newStatus = $user->status == 1 ? 0 : 1;
        $user->update(['status' => $newStatus]);

        $pesan = $newStatus == 1 ? 'Akun admin diaktifkan.' : 'Akun admin dinonaktifkan / diblokir.';
        return redirect()->route('users.index')->with('success', $pesan);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Admin berhasil dihapus.');
    }
}
