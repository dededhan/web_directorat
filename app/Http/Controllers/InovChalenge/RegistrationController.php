<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showForm()
    {
        return view('subdirektorat-inovasi.inovchalenge.register');
    }

    /**
     * Handle the registration submission.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email|unique:inov_chalenge_registrations,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => 'required|in:alumni,peneliti,dudi,pppk,mahasiswa',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
            'role.required'      => 'Pilih salah satu role.',
            'role.in'            => 'Role yang dipilih tidak valid.',
        ]);

        InovChalengeRegistration::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => 'pending',
        ]);

        return redirect()->route('inovchalenge.register.form')
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu persetujuan dari admin.');
    }
}
