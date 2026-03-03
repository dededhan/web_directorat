<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountManagementController extends Controller
{
    /**
     * Inovasi-related roles that this admin manages.
     */
    private const MANAGED_ROLES = [
        'admin_inovasi',
        'dosen',
        'alumni',
        'peneliti',
        'dudi',
        'pppk',
        'mahasiswa',
        'reviewer_inovchalenge',
        'validator',
        'registered_user',
    ];

    /**
     * Role labels for display.
     */
    public const ROLE_LABELS = [
        'admin_inovasi'         => 'Admin Inovasi',
        'dosen'                 => 'Dosen',
        'alumni'                => 'Alumni',
        'peneliti'              => 'Peneliti',
        'dudi'                  => 'DUDI',
        'pppk'                  => 'PPPK',
        'mahasiswa'             => 'Mahasiswa',
        'reviewer_inovchalenge' => 'Reviewer Inov Challenge',
        'validator'             => 'Reviewer Katsinov',
        'registered_user'       => 'Google User',
    ];

    /**
     * Role badge colors.
     */
    public const ROLE_COLORS = [
        'admin_inovasi'         => 'bg-purple-100 text-purple-700 border-purple-200',
        'dosen'                 => 'bg-blue-100 text-blue-700 border-blue-200',
        'alumni'                => 'bg-emerald-100 text-emerald-700 border-emerald-200',
        'peneliti'              => 'bg-indigo-100 text-indigo-700 border-indigo-200',
        'dudi'                  => 'bg-amber-100 text-amber-700 border-amber-200',
        'pppk'                  => 'bg-orange-100 text-orange-700 border-orange-200',
        'mahasiswa'             => 'bg-cyan-100 text-cyan-700 border-cyan-200',
        'reviewer_inovchalenge' => 'bg-rose-100 text-rose-700 border-rose-200',
        'validator'             => 'bg-violet-100 text-violet-700 border-violet-200',
        'registered_user'       => 'bg-gray-100 text-gray-700 border-gray-200',
    ];

    /**
     * Role icons.
     */
    public const ROLE_ICONS = [
        'admin_inovasi'         => 'fa-user-shield',
        'dosen'                 => 'fa-chalkboard-teacher',
        'alumni'                => 'fa-user-graduate',
        'peneliti'              => 'fa-microscope',
        'dudi'                  => 'fa-building',
        'pppk'                  => 'fa-user-tie',
        'mahasiswa'             => 'fa-graduation-cap',
        'reviewer_inovchalenge' => 'fa-clipboard-check',
        'validator'             => 'fa-star',
        'registered_user'       => 'fa-google',
    ];

    /**
     * Roles available for registration (non-admin roles).
     */
    private const REGISTRABLE_ROLES = [
        'alumni',
        'peneliti',
        'dudi',
        'pppk',
        'mahasiswa',
    ];

    // ──────────────────────────────────────────────────────────────────────
    //  Account Management (manage existing users)
    // ──────────────────────────────────────────────────────────────────────

    /**
     * List all inovasi-related user accounts.
     */
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

        return view('admin_inovasi.accounts.index', compact('users', 'roleCounts', 'roleLabels', 'roleColors', 'roleIcons'));
    }

    /**
     * Show form to create a new user account.
     */
    public function create()
    {
        return view('admin_inovasi.accounts.create');
    }

    /**
     * Store a new user account.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => ['required', Password::min(8)],
            'role'     => 'required|in:' . implode(',', self::MANAGED_ROLES),
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin_inovasi.accounts.index')
            ->with('success', 'Akun berhasil dibuat.');
    }

    /**
     * Show form to edit an existing user account.
     */
    public function edit(User $user)
    {
        abort_if(!in_array($user->role, self::MANAGED_ROLES), 403);

        $roleLabels = self::ROLE_LABELS;

        return view('admin_inovasi.accounts.edit', compact('user', 'roleLabels'));
    }

    /**
     * Update an existing user account.
     */
    public function update(Request $request, User $user)
    {
        abort_if(!in_array($user->role, self::MANAGED_ROLES), 403);

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|in:' . implode(',', self::MANAGED_ROLES),
        ];

        // Password is optional on edit
        if ($request->filled('password')) {
            $rules['password'] = [Password::min(8)];
        }

        $request->validate($rules);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin_inovasi.accounts.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Delete a user account.
     */
    public function destroy(User $user)
    {
        abort_if(!in_array($user->role, self::MANAGED_ROLES), 403, 'Tidak dapat menghapus akun ini.');
        abort_if($user->id === Auth::id(), 403, 'Tidak dapat menghapus akun sendiri.');

        $user->delete();

        return redirect()->route('admin_inovasi.accounts.index')
            ->with('success', 'Akun berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────────────────────────
    //  Registration Approval
    // ──────────────────────────────────────────────────────────────────────

    /**
     * List pending registrations.
     */
    public function registrations(Request $request)
    {
        $query = InovChalengeRegistration::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();

        $pendingCount = InovChalengeRegistration::where('status', 'pending')->count();

        return view('admin_inovasi.accounts.registrations', compact('registrations', 'pendingCount'));
    }

    /**
     * Approve a registration — create User account.
     */
    public function approve(Request $request, InovChalengeRegistration $registration)
    {
        abort_if($registration->status !== 'pending', 403, 'Pendaftaran ini sudah diproses.');

        // Create actual user account
        User::create([
            'name'     => $registration->name,
            'email'    => $registration->email,
            'password' => $registration->password, // already hashed
            'role'     => $registration->role,
        ]);

        $registration->update([
            'status'       => 'approved',
            'admin_notes'  => $request->input('admin_notes'),
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return back()->with('success', "Pendaftaran {$registration->name} berhasil disetujui. Akun telah dibuat.");
    }

    /**
     * Decline a registration.
     */
    public function decline(Request $request, InovChalengeRegistration $registration)
    {
        abort_if($registration->status !== 'pending', 403, 'Pendaftaran ini sudah diproses.');

        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $registration->update([
            'status'       => 'declined',
            'admin_notes'  => $request->input('admin_notes'),
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return back()->with('success', "Pendaftaran {$registration->name} telah ditolak.");
    }
}
