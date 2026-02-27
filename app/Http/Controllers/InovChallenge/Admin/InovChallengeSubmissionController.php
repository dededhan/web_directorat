<?php

namespace App\Http\Controllers\InovChallenge\Admin;

use App\Http\Controllers\Controller;
use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeSession;
use App\Models\InovChallengeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InovChallengeSubmissionsExport;

class InovChallengeSubmissionController extends Controller
{
    /**
     * Display a listing of submissions with filters.
     */
    public function index(Request $request)
    {
        $query = InovChallengeSubmission::with(['session', 'user', 'teamMembers.user'])
            ->orderBy('created_at', 'desc');

        // Filter by session
        if ($request->filled('session_id')) {
            $query->where('session_id', $request->session_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('final_status', $request->status);
        }

        // Filter by phase
        if ($request->filled('phase')) {
            $phase = $request->phase;
            $phaseStatusField = $phase . '_status';
            $query->whereNotNull($phase . '_data')
                ->where($phaseStatusField, '!=', 'draft');
        }

        // Search by title or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $submissions = $query->paginate(15);

        // Get sessions for filter
        $sessions = InovChallengeSession::orderBy('created_at', 'desc')->get();

        // Statistics
        $statistics = [
            'total' => InovChallengeSubmission::count(),
            'draft' => InovChallengeSubmission::where('final_status', 'draft')->count(),
            'submitted' => InovChallengeSubmission::whereIn('final_status', ['submitted', 'under_review', 'reviewed'])->count(),
            'approved' => InovChallengeSubmission::where('final_status', 'approved')->count(),
            'rejected' => InovChallengeSubmission::where('final_status', 'rejected')->count(),
        ];

        return view('inov_challenge.admin.submissions.index', compact('submissions', 'sessions', 'statistics'));
    }

    /**
     * Display the specified submission.
     */
    public function show(InovChallengeSubmission $submission)
    {
        $submission->load([
            'session',
            'user',
            'teamMembers.user',
            'uploads',
            'reviews.reviewer',
            'notifications',
        ]);

        // Get form configurations for each phase
        $formConfigs = [];
        foreach (['phase_1', 'phase_2', 'phase_3'] as $phase) {
            $formBuilder = $submission->session->getFormByPhase($phase);
            $formConfigs[$phase] = $formBuilder ? $formBuilder->form_config : null;
        }

        // Calculate average scores per phase
        $scores = [];
        foreach (['phase_1', 'phase_2', 'phase_3'] as $phase) {
            $scores[$phase] = $submission->getAverageScoreForPhase($phase);
        }

        return view('inov_challenge.admin.submissions.show', compact('submission', 'formConfigs', 'scores'));
    }

    /**
     * Approve a submission for a specific phase.
     */
    public function approve(Request $request, InovChallengeSubmission $submission, $phase)
    {
        // Validate phase
        if (!in_array($phase, ['phase_1', 'phase_2', 'phase_3'])) {
            return back()->with('error', 'Phase tidak valid.');
        }

        $phaseStatusField = $phase . '_status';

        // Check current status
        if ($submission->$phaseStatusField !== 'reviewed') {
            return back()->with('error', 'Submission hanya dapat disetujui setelah direview.');
        }

        // Validate previous phase is approved (if sequential phases required)
        if (config('inov_challenge.require_sequential_phases', true)) {
            if ($phase === 'phase_2' && !$submission->isPhaseApproved('phase_1')) {
                return back()->with('error', 'Phase 1 harus disetujui terlebih dahulu sebelum menyetujui Phase 2.');
            }
            if ($phase === 'phase_3' && !$submission->isPhaseApproved('phase_2')) {
                return back()->with('error', 'Phase 2 harus disetujui terlebih dahulu sebelum menyetujui Phase 3.');
            }
        }

        // Check if minimum reviews are met
        $minReviewers = config('inov_challenge.min_reviewers_per_phase', 2);
        $reviewCount = $submission->reviewsByPhase($phase)->count();
        if ($reviewCount < $minReviewers) {
            return back()->with('error', "Minimum {$minReviewers} reviewer diperlukan untuk menyetujui phase ini. Saat ini: {$reviewCount} reviewer.");
        }

        // Check if score meets minimum threshold
        $minScore = config('inov_challenge.min_score_for_approval', 70);
        $averageScore = $submission->getAverageScoreForPhase($phase);
        if ($averageScore < $minScore) {
            return back()->with('error', "Rata-rata score ({$averageScore}) belum mencapai minimum score untuk approval ({$minScore}).");
        }

        try {
            DB::beginTransaction();

            $updates = [
                $phaseStatusField => 'approved',
            ];

            // Update final status based on phase
            if ($phase === 'phase_3') {
                $updates['final_status'] = 'approved';
            } elseif ($submission->final_status === 'draft') {
                $updates['final_status'] = 'in_progress';
            }

            // Update phase status
            $submission->update($updates);

            // Auto-unlock next phase (if enabled in config)
            if (config('inov_challenge.auto_unlock_next_phase', true)) {
                $this->unlockNextPhase($submission, $phase);
            }

            // Create notification for the user
            InovChallengeNotification::createForUser(
                $submission->user_id,
                $submission->id,
                'status_update',
                "Submission Anda untuk {$phase} telah disetujui oleh admin dengan rata-rata score {$averageScore}."
            );

            // Notify team members
            foreach ($submission->acceptedMembers as $member) {
                InovChallengeNotification::createForUser(
                    $member->user_id,
                    $submission->id,
                    'status_update',
                    "Submission tim untuk {$phase} telah disetujui oleh admin."
                );
            }

            // Send email notifications (if enabled)
            if (config('inov_challenge.notify_phase_decision', true)) {
                $this->sendApprovalNotification($submission, $phase, $averageScore);
            }

            DB::commit();

            $nextPhaseMessage = '';
            if (config('inov_challenge.auto_unlock_next_phase', true) && $phase !== 'phase_3') {
                $nextPhase = $this->getNextPhase($phase);
                $nextPhaseMessage = " {$nextPhase} telah dibuka.";
            }

            return back()->with('success', "Submission untuk {$phase} berhasil disetujui.{$nextPhaseMessage}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyetujui submission: ' . $e->getMessage());
        }
    }

    /**
     * Reject a submission for a specific phase.
     */
    public function reject(Request $request, InovChallengeSubmission $submission, $phase)
    {
        // Validate phase
        if (!in_array($phase, ['phase_1', 'phase_2', 'phase_3'])) {
            return back()->with('error', 'Phase tidak valid.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $phaseStatusField = $phase . '_status';

        // Check current status
        if (!in_array($submission->$phaseStatusField, ['submitted', 'under_review', 'reviewed'])) {
            return back()->with('error', 'Submission tidak dapat ditolak pada status ini.');
        }

        try {
            DB::beginTransaction();

            $updates = [
                $phaseStatusField => 'rejected',
            ];

            // Determine final status based on phase
            // Phase 1 rejection = full rejection
            // Phase 2/3 rejection = can revise previous phases or full rejection based on severity
            if ($phase === 'phase_1') {
                $updates['final_status'] = 'rejected';
            } else {
                // For phase 2 and 3, mark as needs_revision to allow resubmission
                $updates['final_status'] = 'needs_revision';
            }

            // Update phase status
            $submission->update($updates);

            // Create notification for the user with rejection reason
            InovChallengeNotification::createForUser(
                $submission->user_id,
                $submission->id,
                'status_update',
                "Submission Anda untuk {$phase} ditolak. Alasan: {$validated['rejection_reason']}"
            );

            // Notify team members
            foreach ($submission->acceptedMembers as $member) {
                InovChallengeNotification::createForUser(
                    $member->user_id,
                    $submission->id,
                    'status_update',
                    "Submission tim untuk {$phase} ditolak oleh admin. Lihat detail untuk informasi lebih lanjut."
                );
            }

            // Send email notifications (if enabled)
            if (config('inov_challenge.notify_phase_decision', true)) {
                $this->sendRejectionNotification($submission, $phase, $validated['rejection_reason']);
            }

            DB::commit();

            return back()->with('success', "Submission untuk {$phase} berhasil ditolak.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menolak submission: ' . $e->getMessage());
        }
    }

    /**
     * Unlock the next phase after approval.
     */
    protected function unlockNextPhase(InovChallengeSubmission $submission, $currentPhase)
    {
        $nextPhase = $this->getNextPhase($currentPhase);

        if ($nextPhase) {
            $nextPhaseStatusField = $nextPhase . '_status';

            // Only unlock if next phase is null (never started) or draft
            if (in_array($submission->$nextPhaseStatusField, [null, 'draft'])) {
                $submission->update([
                    $nextPhaseStatusField => 'draft',
                ]);

                // Notify user that next phase is unlocked
                InovChallengeNotification::createForUser(
                    $submission->user_id,
                    $submission->id,
                    'phase_unlocked',
                    "{$nextPhase} telah dibuka dan siap untuk diisi."
                );
            }
        }
    }

    /**
     * Get the next phase name.
     */
    protected function getNextPhase($currentPhase)
    {
        $phaseMap = [
            'phase_1' => 'phase_2',
            'phase_2' => 'phase_3',
            'phase_3' => null,
        ];

        return $phaseMap[$currentPhase] ?? null;
    }

    /**
     * Send approval notification email.
     */
    protected function sendApprovalNotification(InovChallengeSubmission $submission, $phase, $score)
    {
        // TODO: Implement email sending in Sprint 7 (Notification Module)
        // For now, this is a placeholder
        // Mail::to($submission->user->email)->send(new PhaseApproved($submission, $phase, $score));
    }

    /**
     * Send rejection notification email.
     */
    protected function sendRejectionNotification(InovChallengeSubmission $submission, $phase, $reason)
    {
        // TODO: Implement email sending in Sprint 7 (Notification Module)
        // For now, this is a placeholder
        // Mail::to($submission->user->email)->send(new PhaseRejected($submission, $phase, $reason));
    }

    /**
     * Export submissions to Excel.
     */
    public function export(Request $request)
    {
        // Validate filters
        $validated = $request->validate([
            'session_id' => 'nullable|exists:inov_challenge_sessions,id',
            'status' => 'nullable|in:draft,submitted,under_review,reviewed,approved,rejected,in_progress,needs_revision',
            'phase' => 'nullable|in:phase_1,phase_2,phase_3',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'search' => 'nullable|string|max:255',
        ]);

        $filters = [
            'session_id' => $validated['session_id'] ?? null,
            'status' => $validated['status'] ?? null,
            'phase' => $validated['phase'] ?? null,
            'date_from' => $validated['date_from'] ?? null,
            'date_to' => $validated['date_to'] ?? null,
            'search' => $validated['search'] ?? null,
        ];

        // Remove null values
        $filters = array_filter($filters, function ($value) {
            return $value !== null;
        });

        try {
            // Generate filename with applied filters
            $filename = 'innovation_challenge_submissions_' . date('Y-m-d_His');

            if (!empty($filters['session_id'])) {
                $session = \App\Models\InovChallengeSession::find($filters['session_id']);
                if ($session) {
                    $filename .= '_session_' . $session->id;
                }
            }

            if (!empty($filters['phase'])) {
                $filename .= '_' . $filters['phase'];
            }

            if (!empty($filters['status'])) {
                $filename .= '_' . $filters['status'];
            }

            $filename .= '.xlsx';

            return Excel::download(
                new InovChallengeSubmissionsExport($filters),
                $filename
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat export: ' . $e->getMessage());
        }
    }

    /**
     * Manually unlock a phase for a submission.
     * Useful when auto_unlock is disabled or for special cases.
     */
    public function unlockPhase(Request $request, InovChallengeSubmission $submission, $phase)
    {
        // Validate phase
        if (!in_array($phase, ['phase_1', 'phase_2', 'phase_3'])) {
            return back()->with('error', 'Phase tidak valid.');
        }

        $phaseStatusField = $phase . '_status';

        // Check if phase is already unlocked or in progress
        if (!in_array($submission->$phaseStatusField, [null, 'locked'])) {
            return back()->with('info', 'Phase sudah terbuka atau sudah diproses.');
        }

        try {
            DB::beginTransaction();

            // Unlock the phase
            $submission->update([
                $phaseStatusField => 'draft',
            ]);

            // Create notification
            InovChallengeNotification::createForUser(
                $submission->user_id,
                $submission->id,
                'phase_unlocked',
                "{$phase} telah dibuka secara manual oleh admin dan siap untuk diisi."
            );

            DB::commit();

            return back()->with('success', "{$phase} berhasil dibuka.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuka phase: ' . $e->getMessage());
        }
    }

    /**
     * Get phase approval status summary.
     * Useful for dashboard or quick overview.
     */
    public function getPhaseStatus(InovChallengeSubmission $submission)
    {
        $phases = ['phase_1', 'phase_2', 'phase_3'];
        $status = [];

        foreach ($phases as $phase) {
            $phaseStatusField = $phase . '_status';
            $reviewCount = $submission->reviewsByPhase($phase)->count();
            $averageScore = $submission->getAverageScoreForPhase($phase);
            $minReviewers = config('inov_challenge.min_reviewers_per_phase', 2);
            $minScore = config('inov_challenge.min_score_for_approval', 70);

            $status[$phase] = [
                'status' => $submission->$phaseStatusField,
                'review_count' => $reviewCount,
                'average_score' => $averageScore,
                'meets_min_reviews' => $reviewCount >= $minReviewers,
                'meets_min_score' => $averageScore >= $minScore,
                'can_approve' => $submission->$phaseStatusField === 'reviewed'
                    && $reviewCount >= $minReviewers
                    && $averageScore >= $minScore,
            ];
        }

        return response()->json([
            'submission_id' => $submission->id,
            'final_status' => $submission->final_status,
            'phases' => $status,
        ]);
    }
}
