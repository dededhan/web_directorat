<?php

namespace App\Http\Controllers\Pemeringkatan;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\SulitestPesertaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SulitestPesertaController extends Controller
{
    public function index()
    {
        $peserta = User::where('role', 'sulitest_user')
            ->with(['sulitestProfile.fakultas', 'sulitestProfile.prodi'])
            ->latest()
            ->paginate(20);

        return view('admin_pemeringkatan.peserta.index', compact('peserta'));
    }

    public function create()
    {
        $fakultas = Fakultas::orderBy('name')->get();
        return view('admin_pemeringkatan.peserta.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'nullable|string|max:20|unique:sulitest_peserta_profiles,nim',
            'password' => 'required|string|min:8|confirmed',
            'fakultas_id' => 'required|exists:equity_fakultas,id',
            'prodi_id' => 'required|exists:equity_prodi,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'sulitest_user',
            'status' => 'active',
        ]);

        SulitestPesertaProfile::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'fakultas_id' => $request->fakultas_id,
            'prodi_id' => $request->prodi_id,
        ]);

        $user->assignRole('sulitest_user');

        return redirect()->route('admin_pemeringkatan.peserta.index')
            ->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function show(User $peserta)
    {
        $peserta->load(['sulitestProfile.fakultas', 'sulitestProfile.prodi', 'examSessions.exam']);
        return view('admin_pemeringkatan.peserta.show', compact('peserta'));
    }

    public function edit(User $peserta)
    {
        $peserta->load('sulitestProfile');
        $fakultas = Fakultas::orderBy('name')->get();
        $prodis = Prodi::where('fakultas_id', $peserta->sulitestProfile?->fakultas_id)->get();
        return view('admin_pemeringkatan.peserta.edit', compact('peserta', 'fakultas', 'prodis'));
    }

    public function update(Request $request, User $peserta)
    {
        $profileId = $peserta->sulitestProfile?->id;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($peserta->id)],
            'nim' => ['nullable', 'string', 'max:20', Rule::unique('sulitest_peserta_profiles')->ignore($profileId)],
            'password' => 'nullable|string|min:8|confirmed',
            'fakultas_id' => 'required|exists:equity_fakultas,id',
            'prodi_id' => 'required|exists:equity_prodi,id',
            'status' => 'required|in:active,inactive',
        ]);

        $peserta->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $peserta->update(['password' => Hash::make($request->password)]);
        }

        $peserta->sulitestProfile()->updateOrCreate(
            ['user_id' => $peserta->id],
            [
                'nim' => $request->nim,
                'fakultas_id' => $request->fakultas_id,
                'prodi_id' => $request->prodi_id,
            ]
        );

        return redirect()->route('admin_pemeringkatan.peserta.index')
            ->with('success', 'Data peserta berhasil diperbarui!');
    }

    public function destroy(User $peserta)
    {
        if ($peserta->role !== 'sulitest_user') {
            return back()->with('error', 'Tidak dapat menghapus user ini');
        }

        $peserta->delete();

        return redirect()->route('admin_pemeringkatan.peserta.index')
            ->with('success', 'Peserta berhasil dihapus!');
    }

    public function getProdiByFakultas($fakultasId)
    {
        $prodis = Prodi::where('fakultas_id', $fakultasId)->orderBy('name')->get();
        return response()->json($prodis);
    }
}
