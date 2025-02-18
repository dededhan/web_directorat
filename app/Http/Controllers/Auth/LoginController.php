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
            } else if (Auth::user()->role === 'prodi') {
                return redirect()->route('prodi.dashboard');
            } else if (Auth::user()->role === 'fakultas') {
                return redirect()->route('fakultas.dashboard');
            } else if (Auth::user()->role === 'admin_pemeringkatan'){
                return redirect()->route('admin_pemeringkatan.dashboard');
            } else if (Auth::user()->role === 'dosen'){
                return redirect()->route('Inovasi.dosen.dashboard');
            }  else if (Auth::user()->role === 'admin_hilirisasi'){
                return redirect()->route('Inovasi.admin_hilirisasi.dashboard');
            }
            
            // Default redirect
            // if (Auth::user()->role === 'admin_direktorat') {
            //     return redirect('/admin');
            // }

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


