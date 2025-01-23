<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('loginpopup');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
   
            if (Auth::user()->role === 'admin_direktorat') {
                return redirect()->route('admin.dashboard');
            }
            
            // Default redirect
            return redirect('/admin');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->with('error', 'Email atau password salah.'); // Flash message
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
}


