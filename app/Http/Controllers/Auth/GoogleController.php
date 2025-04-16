<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Log Google user data for debugging
            Log::info('Google user data:', [
                'id' => $googleUser->id,
                'email' => $googleUser->email,
                'name' => $googleUser->name
            ]);
            
            // Find existing user by Google ID or email
            $existingUser = User::where('google_id', $googleUser->id)
                                ->orWhere('email', $googleUser->email)
                                ->first();
            
            if ($existingUser) {
                // Update Google ID and avatar if not already set
                if (!$existingUser->google_id) {
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                    ]);
                    
                    Log::info('Updated Google details for existing user', [
                        'user_id' => $existingUser->id,
                        'email' => $existingUser->email
                    ]);
                }
                
                Auth::login($existingUser);
                
                // Use match for redirection
                $next = match ($existingUser->role) {
                    'admin_direktorat' => 'admin.dashboard',
                    'prodi' =>  'prodi.dashboard',
                    'fakultas' =>'fakultas.dashboard',
                    'admin_pemeringkatan' => 'admin_pemeringkatan.dashboard',
                    'dosen' => 'subdirektorat-inovasi.dosen.dashboard',
                    'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.dashboard',
                    'validator' => 'subdirektorat-inovasi.validator.dashboard',
                    // 'kepala_sub_direktorat' => 'subdirektorat-inovasi.admin_hilirisasi.dashboard',
                    'registered_user' => 'subdirektorat-inovasi.registered_user.dashboard',
                    default => 'home',
                };
                
                return redirect()->route($next)->with('success', 'Berhasil login dengan Google');
            } else {
                // Create a new user with role 'registered_user'
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(uniqid()), // Generate a random password
                    'role' => 'registered_user', // Set default role
                    'status' => 'unactive', // Tambahkan ini
                    'email_verified_at' => now(),
                ]);
                
                Log::info('Created new user with Google sign-in', [
                    'user_id' => $newUser->id,
                    'email' => $newUser->email,
                    'role' => 'registered_user'
                ]);
                
                Auth::login($newUser);
                
                // Redirect to registered user dashboard
                return redirect()->route('inovasi.registered_user.dashboard')
                    ->with('success', 'Akun berhasil dibuat dengan Google');
            }
        } catch (Exception $e) {
            Log::error('Google sign-in error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}