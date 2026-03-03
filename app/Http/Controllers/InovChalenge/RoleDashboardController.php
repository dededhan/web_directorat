<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\InovChalengeSubmissionMember;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoleDashboardController extends Controller
{
    /**
     * Role label map.
     */
    private const ROLE_LABELS = [
        'alumni'    => 'Alumni',
        'peneliti'  => 'Peneliti',
        'dudi'      => 'DUDI',
        'pppk'      => 'PPPK',
        'mahasiswa' => 'Mahasiswa',
    ];

    /**
     * Show the dashboard for the current authenticated role.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $user->load('profile.fakultas', 'profile.prodi');
        $role = $user->role;
        $roleLabel = self::ROLE_LABELS[$role] ?? ucfirst($role);

        // Get Innovation Challenge participations via team membership
        $participations = InovChalengeSubmissionMember::where('user_id', $user->id)
            ->with(['submission.session', 'submission.user', 'submission.members'])
            ->latest()
            ->get();

        // Fakultas & Prodi for optional dropdowns
        $fakultasList = Fakultas::orderBy('name')->get();
        $prodiList = Prodi::orderBy('name')->get();

        return view('subdirektorat-inovasi.inovchalenge.dashboard', compact(
            'user',
            'role',
            'roleLabel',
            'participations',
            'fakultasList',
            'prodiList'
        ));
    }

    /**
     * Update user biodata (name, identifier_number, alamat, kode_pos, fakultas, prodi).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profileId = $user->profile?->id;

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'identifier_number' => ['required', 'string', 'max:255', Rule::unique('equity_user_profiles', 'identifier_number')->ignore($profileId)],
            'alamat'            => 'nullable|string|max:500',
            'kode_pos'          => 'nullable|string|max:10',
            'fakultas_id'       => 'nullable|exists:equity_fakultas,id',
            'prodi_id'          => 'nullable|exists:equity_prodi,id',
        ]);

        $user->update(['name' => $validated['name']]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'identifier_number' => $validated['identifier_number'],
                'alamat'            => $validated['alamat'],
                'kode_pos'          => $validated['kode_pos'],
                'fakultas_id'       => $validated['fakultas_id'],
                'prodi_id'          => $validated['prodi_id'],
            ]
        );

        return back()->with('success', 'Biodata berhasil diperbarui.');
    }

    /**
     * Approve an invitation (accept team membership).
     */
    public function approveInvitation(InovChalengeSubmissionMember $member)
    {
        abort_if($member->user_id !== Auth::id(), 403);
        abort_if($member->approval_status !== 'pending', 403, 'Undangan ini sudah direspon.');

        $member->update([
            'approval_status' => 'approved',
            'responded_at'    => now(),
        ]);

        return back()->with('success', 'Undangan berhasil diterima.');
    }

    /**
     * Reject an invitation (decline team membership).
     */
    public function rejectInvitation(InovChalengeSubmissionMember $member)
    {
        abort_if($member->user_id !== Auth::id(), 403);
        abort_if($member->approval_status !== 'pending', 403, 'Undangan ini sudah direspon.');

        $member->update([
            'approval_status' => 'rejected',
            'responded_at'    => now(),
        ]);

        return back()->with('success', 'Undangan berhasil ditolak.');
    }
}
