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

    // MENGAMBIL SEMUA FAKULTAS DAN PRODI SEKALIGUS
    $fakultas = Fakultas::orderBy('name')->get();
    $prodi = Prodi::orderBy('name')->get(); // Mengambil semua prodi
    
    $selectedProdiId = $user->profile?->prodi_id;
    $selectedFakultasId = $user->profile?->prodi?->fakultas_id;
    
    // Kirim semua data ke view
    return view('subdirektorat-inovasi.dosen.manageprofile.index', compact(
        'user', 
        'fakultas', 
        'prodi', // Variabel $prodi sekarang berisi semua prodi
        'selectedFakultasId', 
        'selectedProdiId'
    ));
}


    public function update(Request $request)
{
    try {
        $user = Auth::user();
        $profileId = $user->profile?->id;

        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'identifier_number' => ['nullable', 'string', 'max:255', Rule::unique('equity_user_profiles', 'identifier_number')->ignore($profileId)],
            'prodi_id' => 'required|exists:equity_prodi,id',
        ]);
        
        
        // --- PERUBAHAN DIMULAI DARI SINI ---

        // 1. Update data user secara langsung, bukan melalui array
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // 2. Cek dan update password jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // 3. Gunakan metode save() untuk menyimpan perubahan pada user
        $user->save();
        
        // --- AKHIR DARI PERUBAHAN ---


        // Bagian ini tetap sama untuk mengupdate profil
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'identifier_number' => $validated['identifier_number'],
                'prodi_id' => $validated['prodi_id'],
            ]
        );

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        throw $e;
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan pada server. Gagal memperbarui profil.');
    }
}
}
