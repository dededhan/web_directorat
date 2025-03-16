<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan google_id atau email
            $existingUser = User::where('google_id', $googleUser->id)
                                ->orWhere('email', $googleUser->email)
                                ->first();
            
            if ($existingUser) {
                // Update google_id jika belum ada
                if (!$existingUser->google_id) {
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                    ]);
                }
                
                Auth::login($existingUser);
            } else {
                // Buat user baru
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(rand(1, 10000)),
                    'role' => 'registered_user',
                    'email_verified_at' => now(), // Verifikasi email
                ]);
                
                Auth::login($newUser);
            }
            
            // Redirect sesuai role
            $next = match (Auth::user()->role) {
                'admin_direktorat' => 'admin.dashboard',
                // ... tambahkan role lainnya
                'registered_user' => 'inovasi.registered_user.dashboard',
                default => 'home',
            };
            
            return redirect()->route($next);
        } catch (Exception $e) {
            return redirect('login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}