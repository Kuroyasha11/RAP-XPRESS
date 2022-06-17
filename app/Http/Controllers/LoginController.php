<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'is_admin' => 1])) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        } elseif (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'is_mitra' => 1])) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('gagal', 'Login failed!');
    }

    // Request $request adalah mengambil data http yang dikirim lalu mengubahnya menjadi data dalam sebuah variabel
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
