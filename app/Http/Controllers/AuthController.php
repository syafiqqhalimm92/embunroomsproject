<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'ic_no' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {

            if (auth()->user()->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'ic_no' => 'Akaun anda telah dinyahaktifkan.'
                ]);
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'ic_no' => 'No IC atau password salah.',
        ])->onlyInput('ic_no');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}