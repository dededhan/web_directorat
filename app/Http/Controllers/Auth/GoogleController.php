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
            
            // Check if user already exists
            $existingUser = User::where('google_id', $googleUser->id)
                                ->orWhere('email', $googleUser->email)
                                ->first();
            
            if ($existingUser) {
                // User exists - update Google ID if necessary
                if (empty($existingUser->google_id)) {
                    $existingUser->google_id = $googleUser->id;
                    $existingUser->save();
                }
                
                Auth::login($existingUser);
            } else {
                // Create new user
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(rand(1, 10000)), // Random password as it won't be used
                    'role' => 'registered_user', // Assign the role as requested
                ]);
                
                Auth::login($newUser);
            }
            
            // Determine where to redirect based on role
            $next = match (Auth::user()->role) {
                'admin_direktorat' => 'admin.dashboard',
                'prodi' => 'prodi.dashboard',
                'fakultas' => 'fakultas.dashboard',
                'admin_pemeringkatan' => 'admin_pemeringkatan.dashboard',
                'dosen' => 'inovasi.dosen.dashboard',
                'admin_hilirisasi' => 'inovasi.admin_hilirisasi.dashboard',
                'registered_user' => 'inovasi.registered_user.dashboard', 
                default => 'home',
            };
            
            return redirect()->route($next);
        } catch (Exception $e) {
            return redirect('login')->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }
}