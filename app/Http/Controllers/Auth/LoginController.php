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
            // much clean, me like :D
            $next = match (Auth::user()->role) {
                'admin_direktorat' => 'admin.dashboard',
                'prodi' =>  'prodi.dashboard',
                'fakultas' =>'fakultas.dashboard',
                'admin_pemeringkatan' => 'admin_pemeringkatan.dashboard',
                'dosen' => 'inovasi.dosen.dashboard',
                'admin_hilirisasi' => 'inovasi.admin_hilirisasi.dashboard',
                'kepala_sub_direktorat' => 'inovasi.admin_hilirisasi.dashboard',
                'validator' => 'inovasi.validator.dashboard',
            };

            return redirect(route($next));
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



