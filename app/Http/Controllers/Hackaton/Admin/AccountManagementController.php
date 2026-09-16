<?php

namespace App\Http\Controllers\Hackaton\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackatonRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountManagementController extends Controller
{
    private const MANAGED_ROLES = [
        'admin_hackaton',
        'hackaton_dosen',
        'hackaton_tendik',
        'hackaton_alumni',
        'hackaton_peneliti',
        'hackaton_dudi',
        'hackaton_pppk',
        'hackaton_mahasiswa',
        'reviewer_hackaton',
    ];

    public const ROLE_LABELS = [
        'admin_hackaton'     => 'Admin Hackaton',
        'hackaton_dosen'     => 'Dosen',
        'hackaton_tendik'    => 'Tendik',
        'hackaton_alumni'    => 'Alumni',
        'hackaton_peneliti'  => 'Peneliti',
        'hackaton_dudi'      => 'DUDI',
        'hackaton_pppk'      => 'PPPK',
        'hackaton_mahasiswa' => 'Mahasiswa',
        'reviewer_hackaton'  => 'Reviewer Hackaton',
    ];

    public const ROLE_COLORS = [
        'admin_hackaton'     => 'bg-yellow-100 text-yellow-700 border-yellow-200',
        'hackaton_dosen'     => 'bg-blue-100 text-blue-700 border-blue-200',
        'hackaton_tendik'    => 'bg-violet-100 text-violet-700 border-violet-200',
        'hackaton_alumni'    => 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'hackaton_peneliti'  => 'bg-indigo-100 text-indigo-700 border-indigo-200',
        'hackaton_dudi'      => 'bg-amber-100 text-amber-700 border-amber-200',
        'hackaton_pppk'      => 'bg-orange-100 text-orange-700 border-orange-200',
        'hackaton_mahasiswa' => 'bg-cyan-100 text-cyan-700 border-cyan-200',
        'reviewer_hackaton'  => 'bg-rose-100 text-rose-700 border-rose-200',
    ];

    public const ROLE_ICONS = [
        'admin_hackaton'     => 'fa-user-shield',
        'hackaton_dosen'     => 'fa-chalkboard-teacher',
        'hackaton_tendik'    => 'fa-user-tie',
        'hackaton_alumni'    => 'fa-user-graduate',
        'hackaton_peneliti'  => 'fa-microscope',
        'hackaton_dudi'      => 'fa-building',
        'hackaton_pppk'      => 'fa-user-tie',
        'hackaton_mahasiswa' => 'fa-graduation-cap',
        'reviewer_hackaton'  => 'fa-clipboard-check',
    ];

    public function index(Request $request)
    {
        $query = User::whereIn('role', self::MANAGED_ROLES);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $roleCounts = User::whereIn('role', self::MANAGED_ROLES)
            ->selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role');

        $roleLabels = self::ROLE_LABELS;
        $roleColors = self::ROLE_COLORS;
        $roleIcons  = self::ROLE_ICONS;

        return view('admin_hackaton.accounts.index', compact(
            'users',
            'roleCounts',
            'roleLabels',
            'roleColors',
            'roleIcons'
        ));
    }

    public function create()
    {
        $roleLabels = self::ROLE_LABELS;
        return view('admin_hackaton.accounts.create', compact('roleLabels'));
    }

    public function store(Request $request)
    {
        $rolesList = implode(',', self::MANAGED_ROLES);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => ['required', Password::min(8)],
            'role'     => "required|in:{$rolesList}",
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'status'   => 'active',
        ]);

        return redirect()
            ->route('admin_hackaton.accounts.index')
            ->with('success', "Akun {$validated['name']} berhasil dibuat.");
    }

    public function edit(User $user)
    {
        abort_unless(in_array($user->role, self::MANAGED_ROLES), 403);

        $roleLabels = self::ROLE_LABELS;
        return view('admin_hackaton.accounts.edit', compact('user', 'roleLabels'));
    }

    public function update(Request $request, User $user)
    {
        abort_unless(in_array($user->role, self::MANAGED_ROLES), 403);

        $rolesList = implode(',', self::MANAGED_ROLES);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => "required|email|max:255|unique:users,email,{$user->id}",
            'password' => ['nullable', Password::min(8)],
            'role'     => "required|in:{$rolesList}",
        ]);

        $updateData = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()
            ->route('admin_hackaton.accounts.index')
            ->with('success', "Akun {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        abort_unless(in_array($user->role, self::MANAGED_ROLES), 403);
        abort_if($user->id === Auth::id(), 403, 'Anda tidak dapat menghapus akun Anda sendiri.');

        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('admin_hackaton.accounts.index')
            ->with('success', "Akun {$name} berhasil dihapus.");
    }
}
