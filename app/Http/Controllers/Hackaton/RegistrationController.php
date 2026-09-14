<?php

namespace App\Http\Controllers\Hackaton;

use App\Http\Controllers\Controller;
use App\Mail\HackatonRegistrationMail;
use App\Models\HackatonRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    public function showForm()
    {
        return view('subdirektorat-inovasi.hackaton.register', [
            'roleLabels' => HackatonRegistration::ROLE_LABELS,
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'unique:hackaton_registrations,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => ['required', 'in:' . implode(',', array_keys(HackatonRegistration::ROLE_LABELS))],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required' => 'Pilih salah satu role.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ]);

        HackatonRegistration::create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'password' => Hash::make($request->string('password')->toString()),
            'role' => $request->string('role')->toString(),
            'status' => 'pending',
        ]);

        try {
            Mail::to($request->string('email')->toString())
                ->send(new HackatonRegistrationMail(
                    $request->string('name')->toString(),
                    $request->string('role')->toString(),
                ));
        } catch (\Throwable $exception) {
            logger()->error('Hackaton registration email failed: ' . $exception->getMessage());
        }

        return redirect()->route('hackaton.register.form')
            ->with('success', 'Pendaftaran Hackaton berhasil dikirim! Silakan tunggu persetujuan admin.');
    }
}
