<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\Recaptcha; 
use App\Models\User;


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
            'password' => 'required',
            'g-recaptcha-response' => ['required', new Recaptcha()]
        ]);

        $authCredentials = $request->only('email', 'password');

        if (Auth::attempt($authCredentials)) {
            $request->session()->regenerate();
            
            // PERBAIKAN: Ambil objek user yang sedang login dan simpan ke variabel $user
            $user = Auth::user(); 
            
            // much clean, me like :D
            $next = match ($user->role) {
                'admin_direktorat' => 'admin.dashboard',
                'prodi' =>  'prodis.manage.account',
                    //    'prodi' => 'maintenance.page',
                'fakultas' =>'fakultas.dashboard',
                'admin_pemeringkatan' => 'admin_pemeringkatan.dashboard',
                'dosen' => 'subdirektorat-inovasi.dosen.dashboard',
                'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.dashboard',
                // 'kepala_sub_direktorat' => 'inovasi.admin_hilirisasi.dashboard',
                'validator' => 'subdirektorat-inovasi.validator.dashboard',
                'admin_equity' => 'admin_equity.dashboard',
                'reviewer_equity' => 'reviewer_equity.dashboard',
            };
            
            // *** NEW LOGIC FOR DOSEN ***
            if ($user->role === 'dosen') {
                $user->load('profile');
                // Check if profile is incomplete (e.g., missing profile record or prodi_id)
                if (empty($user->profile) || empty($user->profile->prodi_id)) {
                    return redirect(route('subdirektorat-inovasi.dosen.manageprofile.edit'))
                        ->with('info', 'Silakan lengkapi profil Anda sebelum melanjutkan.');
                }
            }

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