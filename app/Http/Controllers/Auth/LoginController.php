<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Proses login
        if (Auth::attempt($credentials)) {
            // Redirect berdasarkan role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        // Jika gagal login
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
