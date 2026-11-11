<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class siswaAuthController extends Controller
{
    public function showLogin()
    {
        return view('siswa.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials + ['role' => 'siswa'])) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau Password salah.'])
            ->onlyInput('email');
    }

    public function showRegister()
    {
        return view('siswa.daftar');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'kelas' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        $data['role'] = 'siswa';
        User::create($data);

        return redirect()->route('siswa.login')
            ->with('success', 'Pendaftaran berhasil. Silahkan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
