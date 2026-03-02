<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSession;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeSubmissionMember;
use App\Models\InovChalengeSubmissionTahap;
use App\Models\InovChalengeFieldValue;
use App\Models\InovChalengeReview;
use App\Models\InovChalengeStatusLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionAdminController extends Controller
{
    /**
     * List submissions for a specific session.
     */
    public function index(Request $request, InovChalengeSession $session)
    {
        $query = InovChalengeSubmission::with(['user', 'submissionTahap.tahap', 'members', 'reviewers'])
            ->withCount('reviewers')
            ->where('inov_chalenge_session_id', $session->id);

        // Search by user name
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $submissions = $query->latest()->paginate(15)->withQueryString();

        $session->load('tahap');
        $hasReviewerMap = [];
        foreach ($submissions as $sub) {
            $hasReviewerMap[$sub->id] = $sub->reviewers->isNotEmpty();
        }

        return view('admin_inovasi.inovchalenge.submissions.index', compact('submissions', 'session', 'hasReviewerMap'));
    }

    /**
     * Show submission detail — per-Tahap accordion with field values, anggota, reviews.
     */
    public function show(InovChalengeSession $session, InovChalengeSubmission $submission)
    {
        abort_if($submission->inov_chalenge_session_id !== $session->id, 404);

        $submission->load([
            'session',
            'user',
            'submissionTahap.tahap.fields',
            'submissionTahap.tahap.sections.fields',
            'submissionTahap.tahap.unsectionedFields',
            'members.user',
            'reviewers',
            'reviews.reviewer',
            'reviews.tahap',
            'identitas',
        ]);

        // Load field values per submission_tahap
        foreach ($submission->submissionTahap as $st) {
            $st->loadedFieldValues = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
                ->where('inov_chalenge_tahap_id', $st->inov_chalenge_tahap_id)
                ->get()
                ->keyBy('inov_chalenge_tahap_field_id');
        }

        // Available reviewers for assignment
        $availableReviewers = User::where('role', 'reviewer_inovchalenge')
            ->orderBy('name')
            ->get();

        $hasReviewer = $submission->reviewers->isNotEmpty();

        return view('admin_inovasi.inovchalenge.submissions.show', compact('submission', 'availableReviewers', 'session', 'hasReviewer'));
    }

    /**
     * Assign / sync reviewers to a submission.
     */
    public function assignReviewer(Request $request, InovChalengeSession $session, InovChalengeSubmission $submission)
    {
        $request->validate([
            'reviewer_ids' => 'required|array',
            'reviewer_ids.*' => 'exists:users,id',
        ]);

        $newIds = collect($request->reviewer_ids)->map(fn($id) => (int) $id);
        $currentIds = $submission->reviewers()->pluck('users.id');

        // Check if any being removed have existing reviews
        $removedIds = $currentIds->diff($newIds);
        if ($removedIds->isNotEmpty()) {
            $hasReviews = InovChalengeReview::where('inov_chalenge_submission_id', $submission->id)
                ->whereIn('reviewer_id', $removedIds)
                ->exists();

            if ($hasReviews) {
                return back()->with('error', 'Tidak dapat menghapus reviewer yang sudah memberikan review.');
            }
        }

        $submission->reviewers()->sync($newIds);

        // Log reviewer assignment
        InovChalengeStatusLog::logSubmissionStatus(
            $submission->id,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            'sedang_direview',
            'Reviewer diassign oleh admin',
            Auth::id(),
            'admin'
        );

        return back()->with('success', 'Reviewer berhasil diperbarui.');
    }

    /**
     * Update overall submission status.
     */
    public function updateStatus(Request $request, InovChalengeSession $session, InovChalengeSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:draft,diajukan,menunggu_direview,sedang_direview,perbaikan_diperlukan,proses_tahap_selanjutnya,selesai',
        ]);

        $oldStatus = is_object($submission->status) ? $submission->status->value : $submission->status;
        $submission->update(['status' => $request->status]);

        InovChalengeStatusLog::logSubmissionStatus(
            $submission->id,
            $oldStatus,
            $request->status,
            'Status submission diubah oleh admin',
            Auth::id(),
            'admin'
        );

        return back()->with('success', 'Status submission berhasil diperbarui.');
    }

    /**
     * Update per-Tahap admin_status + catatan_admin + nominal_evaluasi.
     */
    public function updateTahapStatus(Request $request, InovChalengeSubmissionTahap $submissionTahap)
    {
        $request->validate([
            'admin_status' => 'required|in:menunggu,disetujui,perbaikan,selesai',
            'catatan_admin' => 'nullable|string|max:2000',
            'nominal_evaluasi' => 'nullable|numeric|min:0',
        ]);

        $oldAdminStatus = $submissionTahap->admin_status;
        $tahapKe = $submissionTahap->tahap->tahap_ke ?? '?';

        $submissionTahap->update([
            'admin_status' => $request->admin_status,
            'catatan_admin' => $request->catatan_admin,
            'nominal_evaluasi' => $request->nominal_evaluasi,
        ]);

        // Log: admin changed tahap status
        $keterangan = 'Status Tahap ' . $tahapKe . ' diubah menjadi ' . ucfirst($request->admin_status) . ' oleh admin';
        if ($request->catatan_admin) {
            $keterangan .= ': ' . $request->catatan_admin;
        }
        InovChalengeStatusLog::logTahapStatus(
            $submissionTahap->inov_chalenge_submission_id,
            $submissionTahap->inov_chalenge_tahap_id,
            $oldAdminStatus,
            $request->admin_status,
            $keterangan,
            Auth::id(),
            'admin'
        );

        // If set to perbaikan, also reset dosen status to draft so they can re-edit
        if ($request->admin_status === 'perbaikan') {
            $submissionTahap->update(['status' => 'draft']);
        }

        return back()->with('success', 'Status tahap berhasil diperbarui.');
    }

    /**
     * Approve a pending team member.
     */
    public function approveMember(InovChalengeSession $session, InovChalengeSubmission $submission, InovChalengeSubmissionMember $member)
    {
        abort_if($member->inov_chalenge_submission_id !== $submission->id, 404);
        abort_if($member->approval_status !== 'pending', 422, 'Anggota ini tidak dalam status pending.');

        $member->update([
            'approval_status' => 'approved',
            'responded_at' => now(),
        ]);

        InovChalengeStatusLog::logSubmissionStatus(
            $submission->id,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            "Anggota {$member->nama_lengkap} ({$member->getTipeLabel()}) disetujui oleh admin",
            Auth::id(),
            'admin'
        );

        return back()->with('success', "Anggota {$member->nama_lengkap} berhasil disetujui.");
    }

    /**
     * Reject a pending team member.
     */
    public function rejectMember(InovChalengeSession $session, InovChalengeSubmission $submission, InovChalengeSubmissionMember $member)
    {
        abort_if($member->inov_chalenge_submission_id !== $submission->id, 404);
        abort_if($member->approval_status !== 'pending', 422, 'Anggota ini tidak dalam status pending.');

        $member->update([
            'approval_status' => 'rejected',
            'responded_at' => now(),
        ]);

        InovChalengeStatusLog::logSubmissionStatus(
            $submission->id,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            "Anggota {$member->nama_lengkap} ({$member->getTipeLabel()}) ditolak oleh admin",
            Auth::id(),
            'admin'
        );

        return back()->with('success', "Anggota {$member->nama_lengkap} berhasil ditolak.");
    }
}
