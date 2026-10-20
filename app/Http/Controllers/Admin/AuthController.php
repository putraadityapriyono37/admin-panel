<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['username' => 'Username atau password salah.'])
                ->onlyInput('username');
        }

        $admin = Auth::guard('admin')->user();

        if (!$admin->isSuperAdmin() && !$admin->microsites()->exists()) {
            Auth::guard('admin')->logout();

            return back()
                ->withErrors(['username' => 'Akun belum ditugaskan ke microsite mana pun.'])
                ->onlyInput('username');
        }

        $request->session()->regenerate();

        return redirect()->to($admin->homeUrl());
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}