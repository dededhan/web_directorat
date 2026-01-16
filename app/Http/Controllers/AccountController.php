<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $role = $user->role;
        
        // Return the appropriate view based on user role
        if ($role === 'fakultas') {
            return view('fakultas.manage_account', compact('user'));
        } elseif ($role === 'prodi') {
            return view('prodis.manage_account', compact('user'));
        }
        
        // Fallback if role doesn't match
        abort(403, 'Unauthorized access');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $updateData = [
                'email' => $validated['email'],
            ];

            // Only update password if provided
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $user->update($updateData);
            
            Log::info('User updated their own account', [
                'user_id' => $user->id,
                'role' => $user->role,
                'email' => $user->email,
                'password_changed' => !empty($validated['password'])
            ]);
            
            return redirect()->back()->with('success', 'Akun berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update user account', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }
    }
}
