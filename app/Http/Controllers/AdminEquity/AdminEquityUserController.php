<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AdminEquityUserController extends Controller
{

    public function index()
    {
        $users = User::whereIn('role', ['dosen', 'reviewer_equity'])
            ->with('profile.prodi.fakultas')
            ->latest()
            ->paginate(10);
            
        return view('admin_equity.manageuser.index', compact('users'));
    }


    public function create()
    {
        $fakultas = Fakultas::orderBy('name')->get();
        return view('admin_equity.manageuser.create', compact('fakultas'));
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', Rule::in(['dosen', 'reviewer_equity'])],
            'identifier_number' => 'nullable|string|max:255|unique:equity_user_profiles,identifier_number',
            'prodi_id' => 'required_if:role,dosen|exists:equity_prodi,id',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'status' => 'active',
            ]);


            if ($validated['role'] === 'dosen') {
                UserProfile::create([
                    'user_id' => $user->id,
                    'identifier_number' => $validated['identifier_number'] ?? null,
                    'prodi_id' => $validated['prodi_id'],
                ]);
            }
            
            DB::commit();
            return redirect()->route('admin_equity.manageuser.index')->with('success', 'User berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat user: ' . $e->getMessage())->withInput();
        }
    }


    public function show(User $user)
    {

        if (!in_array($user->role, ['dosen', 'reviewer_equity'])) {
            abort(404);
        }
        $user->load('profile.prodi.fakultas');
        return view('admin_equity.manageuser.show', compact('user'));
    }


    public function edit(User $user)
    {
         if (!in_array($user->role, ['dosen', 'reviewer_equity'])) {
            abort(404);
        }
        $user->load('profile.prodi.fakultas');
        $fakultas = Fakultas::orderBy('name')->get();
        $prodi = $user->profile?->prodi?->fakultas_id 
            ? Prodi::where('fakultas_id', $user->profile->prodi->fakultas_id)->orderBy('name')->get() 
            : collect();

        return view('admin_equity.manageuser.edit', compact('user', 'fakultas', 'prodi'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', Rule::in(['dosen', 'reviewer_equity'])],
            'identifier_number' => ['nullable', 'string', 'max:255', Rule::unique('equity_user_profiles', 'identifier_number')->ignore($user->profile->id ?? null)],
            'prodi_id' => 'required_if:role,dosen|exists:equity_prodi,id',
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);


            if ($validated['role'] === 'dosen') {
                $user->profile()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'identifier_number' => $validated['identifier_number'] ?? null,
                        'prodi_id' => $validated['prodi_id'],
                    ]
                );
            } else {
                $user->profile()->delete();
            }
            
            DB::commit();
            return redirect()->route('admin_equity.manageuser.index')->with('success', 'User berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy(User $user)
    {
        if (!in_array($user->role, ['dosen', 'reviewer_equity'])) {
            abort(404);
        }

        try {
            $user->delete();
            return redirect()->route('admin_equity.manageuser.index')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}

