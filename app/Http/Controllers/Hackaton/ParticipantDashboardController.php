<?php

namespace App\Http\Controllers\Hackaton;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\HackatonRegistration;
use App\Models\HackatonReview;
use App\Models\HackatonSession;
use App\Models\HackatonStatusLog;
use App\Models\HackatonSubmission;
use App\Models\HackatonSubmissionFieldValue;
use App\Models\HackatonSubmissionMember;
use App\Models\HackatonSubmissionTahap;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ParticipantDashboardController extends Controller
{
    private const ROLE_LABELS = [
        'hackaton_dosen'     => 'Dosen',
        'hackaton_tendik'    => 'Tendik',
        'hackaton_alumni'    => 'Alumni',
        'hackaton_peneliti'  => 'Peneliti',
        'hackaton_dudi'      => 'DUDI',
        'hackaton_pppk'      => 'PPPK',
        'hackaton_mahasiswa' => 'Mahasiswa',
        'reviewer_hackaton'  => 'Reviewer',
        'reviewer_inovchalenge' => 'Reviewer',
    ];

    private const ROLE_ICONS = [
        'hackaton_dosen'     => 'fa-chalkboard-teacher',
        'hackaton_tendik'    => 'fa-user-tie',
        'hackaton_alumni'    => 'fa-user-graduate',
        'hackaton_peneliti'  => 'fa-microscope',
        'hackaton_dudi'      => 'fa-building',
        'hackaton_pppk'      => 'fa-user-tie',
        'hackaton_mahasiswa' => 'fa-graduation-cap',
        'reviewer_hackaton'  => 'fa-clipboard-check',
        'reviewer_inovchalenge' => 'fa-clipboard-check',
    ];

    public function index()
    {
        $user = Auth::user();
        $user->load('profile.fakultas', 'profile.prodi');

        $role = $user->role;
        $baseRole = str_replace('hackaton_', '', $role);
        $roleLabel = self::ROLE_LABELS[$role] ?? ucfirst($baseRole);
        $roleIcon = self::ROLE_ICONS[$role] ?? 'fa-user';

        $registration = HackatonRegistration::where('email', $user->email)
            ->latest()
            ->first();

        // 1. Data for Ketua (Dosen & Tendik)
        $isPengusul = in_array($role, ['hackaton_dosen', 'hackaton_tendik', 'dosen', 'tendik']);
        $mySubmissions = collect();
        $activeSessions = collect();
        if ($isPengusul) {
            $mySubmissions = HackatonSubmission::where('user_id', $user->id)
                ->with(['session', 'submissionTahap.tahap', 'members'])
                ->latest()
                ->get();

            $activeSessions = HackatonSession::where('status', 'active')
                ->with('tahap')
                ->latest()
                ->get();
        }

        // 2. Data for Team Members / Collaborators
        $participations = HackatonSubmissionMember::where('user_id', $user->id)
            ->with(['submission.session', 'submission.user', 'submission.members', 'submission.submissionTahap.tahap'])
            ->latest()
            ->get();

        $pendingInvitations = $participations->where('approval_status', 'pending');
        $approvedParticipations = $participations->where('approval_status', 'approved');

        // Status activity logs for approved submissions
        $approvedSubmissionIds = $participations
            ->whereIn('approval_status', ['approved', 'not_required'])
            ->pluck('hackaton_submission_id')
            ->unique()
            ->values();

        $statusLogs = HackatonStatusLog::whereIn('hackaton_submission_id', $approvedSubmissionIds)
            ->with(['submission.session', 'submission.user', 'tahap', 'causer'])
            ->orderByDesc('created_at')
            ->limit(15)
            ->get();

        // 3. Data for Reviewer
        $isReviewer = in_array($role, ['reviewer_hackaton', 'reviewer_inovchalenge']);
        $assignedReviewsCount = 0;
        $pendingReviewsCount = 0;
        $reviewedCount = 0;
        $assignedSubmissions = collect();
        if ($isReviewer) {
            $assignedSubmissions = HackatonSubmission::whereHas('reviewers', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })
                ->with(['session', 'user', 'submissionTahap.tahap'])
                ->latest()
                ->get();

            $assignedReviewsCount = $assignedSubmissions->count();
            $reviewedCount = HackatonReview::where('reviewer_id', $user->id)
                ->distinct('hackaton_submission_id')
                ->count('hackaton_submission_id');
            $pendingReviewsCount = max(0, $assignedReviewsCount - $reviewedCount);
        }

        $fakultasList = Fakultas::orderBy('name')->get();
        $prodiList = Prodi::orderBy('name')->get();

        return view('subdirektorat-inovasi.hackaton.dashboard', compact(
            'user',
            'role',
            'baseRole',
            'roleLabel',
            'roleIcon',
            'registration',
            'isPengusul',
            'mySubmissions',
            'activeSessions',
            'participations',
            'pendingInvitations',
            'approvedParticipations',
            'statusLogs',
            'isReviewer',
            'assignedReviewsCount',
            'pendingReviewsCount',
            'reviewedCount',
            'assignedSubmissions',
            'fakultasList',
            'prodiList'
        ));
    }

    /**
     * Update user profile data.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profileId = $user->profile?->id;

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'identifier_number' => ['required', 'string', 'max:255'],
            'alamat'            => 'nullable|string|max:500',
            'kode_pos'          => 'nullable|string|max:10',
            'institusi'         => $user->role === 'hackaton_dudi' ? 'required|string|max:255' : 'nullable|string|max:255',
            'fakultas_id'       => 'nullable|exists:equity_fakultas,id',
            'prodi_id'          => 'nullable|exists:equity_prodi,id',
        ]);

        $user->update(['name' => $validated['name']]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'identifier_number' => $validated['identifier_number'],
                'alamat'            => $validated['alamat'] ?? null,
                'kode_pos'          => $validated['kode_pos'] ?? null,
                'institusi'         => $validated['institusi'] ?? null,
                'fakultas_id'       => $validated['fakultas_id'] ?? null,
                'prodi_id'          => $validated['prodi_id'] ?? null,
            ]
        );

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Approve invitation to join a team.
     */
    public function approveInvitation(HackatonSubmissionMember $member)
    {
        abort_if($member->user_id !== Auth::id(), 403, 'Akses ditolak.');
        abort_if($member->approval_status !== 'pending', 422, 'Undangan tidak dalam status menunggu.');

        $member->update([
            'approval_status' => 'approved',
            'responded_at'    => now(),
        ]);

        $submission = $member->submission;
        HackatonStatusLog::logSubmissionStatus(
            $submission->id,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            "{$member->nama_lengkap} menyetujui undangan sebagai {$member->getTipeLabel()}",
            Auth::id(),
            Auth::user()->role
        );

        return back()->with('success', 'Undangan tim Hackaton berhasil disetujui.');
    }

    /**
     * Reject invitation to join a team.
     */
    public function rejectInvitation(HackatonSubmissionMember $member)
    {
        abort_if($member->user_id !== Auth::id(), 403, 'Akses ditolak.');
        abort_if($member->approval_status !== 'pending', 422, 'Undangan tidak dalam status menunggu.');

        $member->update([
            'approval_status' => 'rejected',
            'responded_at'    => now(),
        ]);

        $submission = $member->submission;
        HackatonStatusLog::logSubmissionStatus(
            $submission->id,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            "{$member->nama_lengkap} menolak undangan sebagai {$member->getTipeLabel()}",
            Auth::id(),
            Auth::user()->role
        );

        return back()->with('success', 'Undangan tim Hackaton telah ditolak.');
    }

    /**
     * Show submission read-only for team member.
     */
    public function showSubmission(HackatonSubmission $submission)
    {
        $user = Auth::user();

        // Must be a member or reviewer
        $isMember = $submission->members()->where('user_id', $user->id)->exists();
        $isReviewer = $submission->reviewers()->where('users.id', $user->id)->exists();

        abort_unless($isMember || $isReviewer || $user->role === 'admin_hackaton', 403, 'Anda bukan anggota dari tim ini.');

        $submission->load([
            'session',
            'user',
            'submissionTahap.tahap',
            'members.user',
            'identitas',
            'reviewers',
            'reviews.reviewer',
            'reviews.tahap',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        $hasReviewer = $submission->reviewers->isNotEmpty();

        return view('subdirektorat-inovasi.hackaton.submission-show', compact('submission', 'hasReviewer'));
    }

    /**
     * Show tahap read-only for team member.
     */
    public function showTahap(HackatonSubmission $submission, $tahapId)
    {
        $user = Auth::user();
        $isMember = $submission->members()->where('user_id', $user->id)->exists();
        $isReviewer = $submission->reviewers()->where('users.id', $user->id)->exists();

        abort_unless($isMember || $isReviewer || $user->role === 'admin_hackaton', 403);

        $submissionTahap = HackatonSubmissionTahap::where('hackaton_submission_id', $submission->id)
            ->where('hackaton_tahap_id', $tahapId)
            ->firstOrFail();

        $submissionTahap->load(['tahap.sections.fields', 'tahap.unsectionedFields']);

        $fieldValues = HackatonSubmissionFieldValue::where('hackaton_submission_id', $submission->id)
            ->where('hackaton_tahap_id', $tahapId)
            ->get()
            ->keyBy('hackaton_tahap_field_id');

        $submission->load('session');

        return view('subdirektorat-inovasi.hackaton.submission-tahap', [
            'submission'      => $submission,
            'submissionTahap' => $submissionTahap,
            'fieldValues'     => $fieldValues,
            'isReadOnly'      => true,
        ]);
    }
}
