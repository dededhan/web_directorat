<?php

namespace App\Http\Controllers\InovChalenge\AdminPanel;

use App\Http\Controllers\InovChalenge\SubmissionAdminController as BaseController;
use App\Models\InovChalengeSession;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeFieldValue;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Submission admin controller for Admin InovChallenge panel.
 * Extends the original SubmissionAdminController but returns admin_inovchalenge views.
 */
class SubmissionAdminController extends BaseController
{
    public function index(Request $request, InovChalengeSession $session)
    {
        $query = InovChalengeSubmission::with(['user', 'submissionTahap.tahap', 'members', 'reviewers'])
            ->withCount('reviewers')
            ->where('inov_chalenge_session_id', $session->id);

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

        return view('admin_inovchalenge.inovchalenge.submissions.index', compact('submissions', 'session', 'hasReviewerMap'));
    }

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
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        foreach ($submission->submissionTahap as $st) {
            $st->loadedFieldValues = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
                ->where('inov_chalenge_tahap_id', $st->inov_chalenge_tahap_id)
                ->get()
                ->keyBy('inov_chalenge_tahap_field_id');
        }

        $availableReviewers = User::where('role', 'reviewer_inovchalenge')
            ->orderBy('name')
            ->get();

        $hasReviewer = $submission->reviewers->isNotEmpty();

        return view('admin_inovchalenge.inovchalenge.submissions.show', compact('submission', 'availableReviewers', 'session', 'hasReviewer'));
    }

    public function scores(InovChalengeSession $session)
    {
        $session->load('tahap');
        $tahapList = $session->tahap;

        $submissions = InovChalengeSubmission::with([
            'user',
            'reviews' => fn($q) => $q->select('inov_chalenge_submission_id', 'inov_chalenge_tahap_id', 'reviewer_id', 'skor'),
            'reviewers',
            'identitas',
        ])
            ->withCount('reviewers')
            ->where('inov_chalenge_session_id', $session->id)
            ->get();

        $scoreMap = [];
        foreach ($submissions as $sub) {
            $tahapScores = [];
            foreach ($tahapList as $tahap) {
                $tahapReviews = $sub->reviews->where('inov_chalenge_tahap_id', $tahap->id)
                    ->whereNotNull('skor');
                $tahapScores[$tahap->id] = $tahapReviews->count() > 0
                    ? round($tahapReviews->avg('skor'), 1)
                    : null;
            }
            $allScores = collect($tahapScores)->filter(fn($v) => $v !== null);
            $scoreMap[$sub->id] = [
                'per_tahap' => $tahapScores,
                'total'     => $allScores->count() > 0 ? round($allScores->avg(), 1) : null,
                'reviewed'  => $sub->reviews->whereNotNull('skor')->count() > 0,
            ];
        }

        $submissions = $submissions->sortByDesc(function ($sub) use ($scoreMap) {
            return $scoreMap[$sub->id]['total'] ?? -1;
        })->values();

        return view('admin_inovchalenge.inovchalenge.submissions.scores', compact('session', 'tahapList', 'submissions', 'scoreMap'));
    }

    public function exportExcel(InovChalengeSession $session)
    {
        $session->load('tahap');
        $tahapList = $session->tahap;

        $submissions = InovChalengeSubmission::with([
            'user',
            'reviews' => fn($q) => $q->select('inov_chalenge_submission_id', 'inov_chalenge_tahap_id', 'reviewer_id', 'skor'),
            'reviewers',
            'identitas',
        ])
            ->withCount('reviewers')
            ->where('inov_chalenge_session_id', $session->id)
            ->get();

        $scoreMap = [];
        foreach ($submissions as $sub) {
            $tahapScores = [];
            foreach ($tahapList as $tahap) {
                $tahapReviews = $sub->reviews->where('inov_chalenge_tahap_id', $tahap->id)
                    ->whereNotNull('skor');
                $tahapScores[$tahap->id] = $tahapReviews->count() > 0
                    ? round($tahapReviews->avg('skor'), 1)
                    : null;
            }
            $allScores = collect($tahapScores)->filter(fn($v) => $v !== null);
            $scoreMap[$sub->id] = [
                'per_tahap' => $tahapScores,
                'total'     => $allScores->count() > 0 ? round($allScores->avg(), 1) : null,
                'reviewed'  => $sub->reviews->whereNotNull('skor')->count() > 0,
            ];
        }

        $submissions = $submissions->sortByDesc(function ($sub) use ($scoreMap) {
            return $scoreMap[$sub->id]['total'] ?? -1;
        })->values();

        $fileName = 'Scores-Innovation-Challenge-' . now()->format('Ymd-His') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\InovChalenge\ScoresExport($session, $tahapList, $submissions, $scoreMap), $fileName);
    }

    /**
     * Add a team member (admin panel).
     */
    public function storeMember(Request $request, InovChalengeSession $session, InovChalengeSubmission $submission)
    {
        abort_if($submission->inov_chalenge_session_id !== $session->id, 404);

        $tipeOptions = implode(',', \App\Models\InovChalengeSubmissionMember::TIPE_OPTIONS);
        $peranIcOptions = implode(',', \App\Models\InovChalengeSubmissionMember::PERAN_IC_OPTIONS);

        $validated = $request->validate([
            'tipe_anggota'      => "required|in:{$tipeOptions}",
            'nama_lengkap'      => 'required|string|max:255',
            'nik_nim_nip'       => 'required|string|max:100',
            'institusi_fakultas' => 'nullable|string|max:255',
            'user_id'           => 'nullable|exists:users,id',
            'peran_ic'          => "required|in:{$peranIcOptions}",
            'deskripsi_peran'   => 'required|string|max:1000',
        ]);

        if ($session->max_anggota) {
            $currentCount = $submission->members()->count();
            if ($currentCount >= $session->max_anggota) {
                return back()->with('error', "Jumlah anggota sudah mencapai batas maksimal ({$session->max_anggota}).");
            }
        }

        // Admin adds member -> automatically approved
        $approvalStatus = 'approved';

        if (!empty($validated['user_id'])) {
            $alreadyInSubmission = \App\Models\InovChalengeSubmissionMember::where('user_id', $validated['user_id'])
                ->where('inov_chalenge_submission_id', $submission->id)
                ->exists();

            if ($alreadyInSubmission) {
                return back()->with('error', 'User ini sudah terdaftar di tim ini.');
            }

            $user = User::with('profile.fakultas', 'profile.prodi')->find($validated['user_id']);
            if ($user) {
                $validated['nama_lengkap'] = $user->name;
                if (empty($validated['nik_nim_nip']) && $user->profile?->identifier_number) {
                    $validated['nik_nim_nip'] = $user->profile->identifier_number;
                }
                if (empty($validated['institusi_fakultas']) && $user->profile?->fakultas) {
                    $fakName = $user->profile->fakultas->name;
                    $prodiName = $user->profile->prodi?->name;
                    $validated['institusi_fakultas'] = $prodiName ? "{$fakName} / {$prodiName}" : $fakName;
                }
            }
        }

        $submission->members()->create([
            'user_id'           => $validated['user_id'] ?? null,
            'peran'             => 'Anggota',
            'peran_ic'          => $validated['peran_ic'],
            'deskripsi_peran'   => $validated['deskripsi_peran'],
            'tipe_anggota'      => $validated['tipe_anggota'],
            'nama_lengkap'      => $validated['nama_lengkap'],
            'nik_nim_nip'       => $validated['nik_nim_nip'] ?? null,
            'institusi_fakultas' => $validated['institusi_fakultas'] ?? null,
            'approval_status'   => $approvalStatus,
            'responded_at'      => now(),
        ]);

        \App\Models\InovChalengeStatusLog::logSubmissionStatus(
            $submission->id,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            "Anggota {$validated['nama_lengkap']} ({$validated['tipe_anggota']}) ditambahkan oleh admin",
            \Illuminate\Support\Facades\Auth::id(),
            'admin'
        );

        return back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Update a team member (admin panel).
     */
    public function updateMember(Request $request, InovChalengeSession $session, InovChalengeSubmission $submission, \App\Models\InovChalengeSubmissionMember $member)
    {
        abort_if($submission->inov_chalenge_session_id !== $session->id, 404);
        abort_if($member->inov_chalenge_submission_id !== $submission->id, 404);
        abort_if($member->peran === 'Ketua', 403, 'Ketua tidak dapat diubah.');

        $peranIcOptions = implode(',', \App\Models\InovChalengeSubmissionMember::PERAN_IC_OPTIONS);

        $validated = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'nik_nim_nip'       => 'nullable|string|max:100',
            'institusi_fakultas' => 'nullable|string|max:255',
            'peran_ic'          => "required|in:{$peranIcOptions}",
            'deskripsi_peran'   => 'required|string|max:1000',
        ]);

        $member->update($validated);

        \App\Models\InovChalengeStatusLog::logSubmissionStatus(
            $submission->id,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            "Data anggota {$member->nama_lengkap} diperbarui oleh admin",
            \Illuminate\Support\Facades\Auth::id(),
            'admin'
        );

        return back()->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove a team member (admin panel).
     */
    public function destroyMember(InovChalengeSession $session, InovChalengeSubmission $submission, \App\Models\InovChalengeSubmissionMember $member)
    {
        abort_if($submission->inov_chalenge_session_id !== $session->id, 404);
        abort_if($member->inov_chalenge_submission_id !== $submission->id, 404);
        abort_if($member->peran === 'Ketua', 403, 'Ketua tidak dapat dihapus.');

        $nama = $member->nama_lengkap;
        $member->delete();

        \App\Models\InovChalengeStatusLog::logSubmissionStatus(
            $submission->id,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            "Anggota {$nama} dihapus oleh admin",
            \Illuminate\Support\Facades\Auth::id(),
            'admin'
        );

        return back()->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * Search users for adding members (admin panel).
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'dosen');

        if (!in_array($type, \App\Models\InovChalengeSubmissionMember::TIPE_SEARCHABLE)) {
            return response()->json([]);
        }

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $role = \App\Models\InovChalengeSubmissionMember::TIPE_TO_ROLE[$type] ?? $type;

        $users = User::where('role', $role)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            })
            ->with(['profile.fakultas', 'profile.prodi'])
            ->select('id', 'name', 'email')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'identifier_number' => $user->profile?->identifier_number ?? '',
                    'fakultas'          => $user->profile?->fakultas?->name ?? '',
                    'prodi'             => $user->profile?->prodi?->name ?? '',
                    'institusi'         => $user->profile?->institusi ?? '',
                ];
            });

        return response()->json($users);
    }
}
