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

    public function index(Request $request)
    {
        $search = $request->input('search');
        $fakultasId = $request->input('fakultas_id');
        $prodiId = $request->input('prodi_id');

        $query = User::whereIn('role', ['dosen', 'reviewer_equity', 'equity_fakultas'])
            ->with('profile.prodi.fakultas', 'profile.fakultas');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($prodiId) {
            $query->whereHas('profile', function ($q) use ($prodiId) {
                $q->where('prodi_id', $prodiId);
            });
        } 
        elseif ($fakultasId) {
            $query->where(function($q) use ($fakultasId) {
                $q->whereHas('profile.prodi', function ($sub) use ($fakultasId) {
                    $sub->where('fakultas_id', $fakultasId);
                })->orWhereHas('profile', function ($sub) use ($fakultasId) {
                    $sub->where('fakultas_id', $fakultasId);
                });
            });
        }

        $users = $query->latest()->paginate(10)->appends($request->query());
        
        $fakultas = Fakultas::orderBy('name')->get();
        $prodi = $fakultasId ? Prodi::where('fakultas_id', $fakultasId)->orderBy('name')->get() : collect();

        return view('admin_equity.manageuser.index', compact('users', 'fakultas', 'prodi'));
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
            'role' => ['required', Rule::in(['dosen', 'reviewer_equity', 'equity_fakultas'])],
            'identifier_number' => 'nullable|string|max:255|unique:equity_user_profiles,identifier_number',
            'prodi_id' => 'nullable|required_if:role,dosen|exists:equity_prodi,id',
            'fakultas_id' => [
                'nullable',
                'required_if:role,equity_fakultas',
                'exists:equity_fakultas,id',
                Rule::unique('equity_user_profiles', 'fakultas_id')
            ],
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
            } elseif ($validated['role'] === 'equity_fakultas') {
                UserProfile::create([
                    'user_id' => $user->id,
                    'fakultas_id' => $validated['fakultas_id'],
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
        if (!in_array($user->role, ['dosen', 'reviewer_equity', 'equity_fakultas'])) {
            abort(404);
        }
        $user->load('profile.prodi.fakultas', 'profile.fakultas');
        return view('admin_equity.manageuser.show', compact('user'));
    }


    public function edit(User $user)
    {
         if (!in_array($user->role, ['dosen', 'reviewer_equity', 'equity_fakultas'])) {
            abort(404);
        }
        $user->load('profile.prodi.fakultas', 'profile.fakultas');
        $fakultas = Fakultas::orderBy('name')->get();
        
        $fakultasIdForProdi = old('fakultas_id', $user->profile?->prodi?->fakultas_id);
        
        $prodi = $fakultasIdForProdi 
            ? Prodi::where('fakultas_id', $fakultasIdForProdi)->orderBy('name')->get() 
            : collect();

        return view('admin_equity.manageuser.edit', compact('user', 'fakultas', 'prodi'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', Rule::in(['dosen', 'reviewer_equity', 'equity_fakultas'])],
            'identifier_number' => ['nullable', 'string', 'max:255', Rule::unique('equity_user_profiles', 'identifier_number')->ignore($user->profile->id ?? null)],
            'prodi_id' => 'nullable|required_if:role,dosen|exists:equity_prodi,id',
            'fakultas_id' => [
                'nullable',
                'required_if:role,equity_fakultas',
                'exists:equity_fakultas,id',
                Rule::unique('equity_user_profiles', 'fakultas_id')->ignore($user->profile->id ?? null)
            ],
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
                        'fakultas_id' => null,
                    ]
                );
            } elseif ($validated['role'] === 'equity_fakultas') {
                $user->profile()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'fakultas_id' => $validated['fakultas_id'],
                        'prodi_id' => null,
                        'identifier_number' => null,
                    ]
                );
            } else {
                if($user->profile){
                    $user->profile()->delete();
                }
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
        if (!in_array($user->role, ['dosen', 'reviewer_equity', 'equity_fakultas'])) {
            abort(404);
        }

        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return redirect()->route('admin_equity.manageuser.index')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}

