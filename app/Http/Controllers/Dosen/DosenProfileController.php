<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class DosenProfileController extends Controller
{

    public function edit(Request $request)
    {
        $user = Auth::user();
        $user->load('profile.prodi.fakultas');

        $fakultas = Fakultas::orderBy('name')->get();
        
        $selectedProdiId = $user->profile?->prodi_id;
        $selectedFakultasId = $user->profile?->prodi?->fakultas_id;
        

        $prodi = $selectedFakultasId 
            ? Prodi::where('fakultas_id', $selectedFakultasId)->orderBy('name')->get() 
            : collect();

        return view('subdirektorat-inovasi.dosen.manageprofile.index', compact('user', 'fakultas', 'prodi', 'selectedFakultasId', 'selectedProdiId'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();
        
        $profileId = $user->profile?->id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'identifier_number' => ['required', 'string', 'max:255', Rule::unique('equity_user_profiles', 'identifier_number')->ignore($profileId)],
            'prodi_id' => 'required|exists:equity_prodi,id',
        ]);
        
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'identifier_number' => $validated['identifier_number'],
                'prodi_id' => $validated['prodi_id'],
            ]
        );

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
