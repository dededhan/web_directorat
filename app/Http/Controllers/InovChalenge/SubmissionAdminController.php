<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeSubmissionTahap;
use App\Models\InovChalengeFieldValue;
use App\Models\InovChalengeReview;
use App\Models\User;
use Illuminate\Http\Request;

class SubmissionAdminController extends Controller
{
    /**
     * List all submissions (filterable by session, status, search).
     */
    public function index(Request $request)
    {
        $query = InovChalengeSubmission::with(['session', 'user', 'submissionTahap.tahap'])
            ->withCount('reviewers');

        // Filter by session
        if ($request->filled('session_id')) {
            $query->where('inov_chalenge_session_id', $request->session_id);
        }

        // Filter by overall status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by user name
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $submissions = $query->latest()->paginate(15)->withQueryString();

        // Sessions for filter dropdown
        $sessions = \App\Models\InovChalengeSession::orderBy('nama_sesi')->get();

        return view('admin_inovasi.inovchalenge.submissions.index', compact('submissions', 'sessions'));
    }

    /**
     * Show submission detail — per-Tahap accordion with field values, anggota, reviews.
     */
    public function show(InovChalengeSubmission $submission)
    {
        $submission->load([
            'session',
            'user',
            'submissionTahap.tahap.fields',
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

        return view('admin_inovasi.inovchalenge.submissions.show', compact('submission', 'availableReviewers'));
    }

    /**
     * Assign / sync reviewers to a submission.
     */
    public function assignReviewer(Request $request, InovChalengeSubmission $submission)
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

        return back()->with('success', 'Reviewer berhasil diperbarui.');
    }

    /**
     * Update overall submission status.
     */
    public function updateStatus(Request $request, InovChalengeSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:draft,diajukan,menunggu_direview,sedang_direview,perbaikan_diperlukan,proses_tahap_selanjutnya,selesai',
        ]);

        $submission->update(['status' => $request->status]);

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

        $submissionTahap->update([
            'admin_status' => $request->admin_status,
            'catatan_admin' => $request->catatan_admin,
            'nominal_evaluasi' => $request->nominal_evaluasi,
        ]);

        // If set to perbaikan, also reset dosen status to draft so they can re-edit
        if ($request->admin_status === 'perbaikan') {
            $submissionTahap->update(['status' => 'draft']);
        }

        return back()->with('success', 'Status tahap berhasil diperbarui.');
    }
}
