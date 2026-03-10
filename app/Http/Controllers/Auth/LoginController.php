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
            // Temporarily disabled for testing
            //'g-recaptcha-response' => ['', new Recaptcha()]
        ]);

        // Check if account exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                ->with('login_error', 'account_not_found')
                ->with('error_title', 'Akun Tidak Ditemukan')
                ->with('error_message', 'Email "' . $request->email . '" tidak terdaftar dalam sistem. Silakan periksa kembali email Anda atau daftar akun baru.');
        }

        $authCredentials = $request->only('email', 'password');

        if (Auth::attempt($authCredentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // much clean, me like :D
            $next = match ($user->role) {
                'super_admin' => 'admin.dashboard',
                'admin_direktorat' => 'admin.dashboard',
                'prodi' =>  'prodis.manage.account',
                //    'prodi' => 'maintenance.page',
                'fakultas' => 'fakultas.dashboard',
                'admin_pemeringkatan' => 'admin_pemeringkatan.dashboard',
                'admin_inovasi' => 'admin_inovasi.dashboard',
                'admin_inovchalenge' => 'admin_inovchalenge.dashboard',
                'dosen' => 'subdirektorat-inovasi.dosen.dashboard',
                'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.dashboard',
                // 'kepala_sub_direktorat' => 'inovasi.admin_hilirisasi.dashboard',
                'validator' => 'validator.index', // Updated to use Validator V2
                'admin_equity' => 'admin_equity.dashboard',
                'sub_admin_equity' => 'admin_equity.dashboard',
                'reviewer_equity' => 'reviewer_equity.dashboard',
                'reviewer_hibah' => 'reviewer_equity.dashboard',
                'reviewer_student_exchange' => 'reviewer_equity.dashboard',
                'equity_fakultas' => 'equity_fakultas.dashboard',
                'inovchalange' => 'admin.inov_challenge.dashboard',
                'reviewer_inovchalange' => 'admin.inov_challenge.dashboard',
                'reviewer_inovchalenge' => 'reviewer_inovchalenge.dashboard',
                'alumni' => 'inovchalenge.role.dashboard',
                'peneliti' => 'inovchalenge.role.dashboard',
                'dudi' => 'inovchalenge.role.dashboard',
                'pppk' => 'inovchalenge.role.dashboard',
                'mahasiswa' => 'inovchalenge.role.dashboard',
                default => 'admin.dashboard',
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

        // Account exists but password is wrong
        return back()->withInput($request->only('email'))
            ->with('login_error', 'wrong_password')
            ->with('error_title', 'Password Salah')
            ->with('error_message', 'Password yang Anda masukkan salah. Silakan coba lagi atau gunakan fitur "Lupa Password" untuk mereset password Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
