<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\InovChalengeStatusLog;
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
        'tendik'    => 'Tendik',
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
            ->with(['submission.session', 'submission.user', 'submission.members', 'submission.submissionTahap.tahap'])
            ->latest()
            ->get();

        // Gather status logs for all submissions the user participates in (approved)
        $approvedSubmissionIds = $participations
            ->where('approval_status', 'approved')
            ->pluck('inov_chalenge_submission_id')
            ->unique()
            ->values();

        $statusLogs = InovChalengeStatusLog::whereIn('inov_chalenge_submission_id', $approvedSubmissionIds)
            ->with(['submission.session', 'submission.user', 'tahap', 'causer'])
            ->orderByDesc('created_at')
            ->get();

        // Unread count: logs from the last 7 days as "new" notifications
        $unreadCount = $statusLogs->where('created_at', '>=', now()->subDays(7))->count();

        // Fakultas & Prodi for optional dropdowns
        $fakultasList = Fakultas::orderBy('name')->get();
        $prodiList = Prodi::orderBy('name')->get();

        return view('subdirektorat-inovasi.inovchalenge.dashboard', compact(
            'user',
            'role',
            'roleLabel',
            'participations',
            'statusLogs',
            'unreadCount',
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
            'institusi'         => $user->role === 'dudi' ? 'required|string|max:255' : 'nullable|string|max:255',
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
                'institusi'         => $validated['institusi'],
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

    /**
     * Show a submission read-only for a role member (same as dosen member-show).
     */
    public function showSubmission(\App\Models\InovChalengeSubmission $submission)
    {
        $user = Auth::user();

        $member = InovChalengeSubmissionMember::where('inov_chalenge_submission_id', $submission->id)
            ->where('user_id', $user->id)
            ->whereIn('approval_status', ['approved', 'not_required'])
            ->first();

        abort_if(!$member, 403, 'Anda tidak memiliki akses ke submission ini.');

        $submission->load([
            'session',
            'submissionTahap.tahap',
            'members.user',
            'identitas',
            'reviewers',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        $hasReviewer = $submission->reviewers->isNotEmpty();
        $role = $user->role;
        $roleLabel = self::ROLE_LABELS[$role] ?? ucfirst($role);

        return view('subdirektorat-inovasi.inovchalenge.submission-show', compact(
            'submission',
            'hasReviewer',
            'role',
            'roleLabel'
        ));
    }

    /**
     * Show a tahap read-only for a role member.
     */
    public function showTahap(\App\Models\InovChalengeSubmission $submission, $tahapId)
    {
        $user = Auth::user();

        $member = InovChalengeSubmissionMember::where('inov_chalenge_submission_id', $submission->id)
            ->where('user_id', $user->id)
            ->whereIn('approval_status', ['approved', 'not_required'])
            ->first();

        abort_if(!$member, 403, 'Anda tidak memiliki akses ke submission ini.');

        $submissionTahap = \App\Models\InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->firstOrFail();

        $submissionTahap->load(['tahap.sections.fields', 'tahap.unsectionedFields']);

        $fieldValues = \App\Models\InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->get()
            ->keyBy('inov_chalenge_tahap_field_id');

        $submission->load('session');

        return view('subdirektorat-inovasi.inovchalenge.submission-tahap', [
            'submission' => $submission,
            'submissionTahap' => $submissionTahap,
            'fieldValues' => $fieldValues,
            'isReadOnly' => true,
        ]);
    }
}
