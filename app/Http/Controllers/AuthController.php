<?php

namespace App\Http\Controllers;

use App\Models\PengaturanUmum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $pengaturan = PengaturanUmum::first();
        return view('auth.login', compact('pengaturan'));
    }

    public function login(Request $request)
    {
        $loginInput = $request->input('username') ?? $request->input('useremail');
        $password = $request->input('password');

        if (!$loginInput || !$password) {
            return back()->withInput()->withErrors([
                'username' => 'Username/Email dan Password wajib diisi!'
            ])->with('error', 'Username/Email dan Password wajib diisi!');
        }

        // Search user by username or email
        $user = User::where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if (!$user) {
            return back()->withInput()->withErrors([
                'username' => 'Email atau Username tidak terdaftar!'
            ])->with('error', 'Email atau Username tidak terdaftar!');
        }

        if (!$user->isActive()) {
            return back()->withInput()->withErrors([
                'username' => 'Akun belum aktif atau dinonaktifkan oleh Administrator!'
            ])->with('error', 'Akun belum aktif atau dinonaktifkan oleh Administrator!');
        }

        if (!Hash::check($password, $user->password)) {
            return back()->withInput()->withErrors([
                'username' => 'Password yang Anda masukkan salah!'
            ])->with('error', 'Password yang Anda masukkan salah!');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Selamat datang kembali, ' . ($user->nama ?? $user->username) . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
