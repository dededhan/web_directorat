<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class TendikProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $user->load('profile');

        return view('subdirektorat-inovasi.tendik.manageprofile.index', compact('user'));
    }

    public function update(Request $request)
    {
        try {
            $user    = Auth::user();
            $profileId = $user->profile?->id;

            $validated = $request->validate([
                'name'              => 'required|string|max:255',
                'password'          => ['nullable', 'confirmed', Rules\Password::defaults()],
                'identifier_number' => ['nullable', 'string', 'max:255', Rule::unique('equity_user_profiles', 'identifier_number')->ignore($profileId)],
                'institusi'         => 'nullable|string|max:255',
            ]);

            $user->name = $validated['name'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'identifier_number' => $validated['identifier_number'],
                    'institusi'         => $validated['institusi'],
                ]
            );

            return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan. Gagal memperbarui profil.');
        }
    }
}
