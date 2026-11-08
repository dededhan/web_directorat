<?php

namespace App\Http\Controllers\Hackaton\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackatonSession;
use App\Models\HackatonSubmission;
use App\Models\HackatonSubmissionMember;
use App\Models\HackatonSubmissionTahap;
use App\Models\HackatonSubmissionFieldValue;
use App\Models\HackatonReview;
use App\Models\HackatonStatusLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionAdminController extends Controller
{
    /**
     * Build filtered query for session submissions (shared by index & export).
     */
    protected function buildFilteredSubmissionsQuery(Request $request, HackatonSession $session)
    {
        $query = HackatonSubmission::with([
            'user.profile.fakultas',
            'identitas',
            'submissionTahap.tahap',
            'members',
            'reviewers',
            'reviews',
        ])
            ->withCount('reviewers')
            ->where('hackaton_session_id', $session->id);

        // Search by user name, email, product name, bidang, or member name
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('identitas', function ($iq) use ($search) {
                    $iq->where('nama_produk', 'like', "%{$search}%")
                        ->orWhere('bidang_utama_produk', 'like', "%{$search}%");
                })
                ->orWhereHas('members', function ($mq) use ($search) {
                    $mq->where('nama_lengkap', 'like', "%{$search}%");
                });
            });
        }

        // Filter by category (d-farm / d-marc / d-tech)
        if ($request->filled('kategori')) {
            $kategori = $request->kategori;
            $query->where(function ($q) use ($kategori) {
                if ($kategori === 'd-farm') {
                    $q->where('kategori', 'd-farm')
                      ->orWhere('tema', 'like', '%D-FARM%');
                } else {
                    $q->whereIn('kategori', ['d-tech', 'd-marc'])
                      ->orWhere('tema', 'like', '%D-MARC%')
                      ->orWhere('tema', 'like', '%D-TECH%');
                }
            });
        }

        // Filter by submission status (including 'submitted' shortcut for non-draft/submitted proposals)
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'submitted') {
                $query->where(function ($q) {
                    $q->where('status', '!=', 'draft')
                      ->orWhereHas('submissionTahap', function ($tq) {
                          $tq->where('status', 'diajukan');
                      });
                });
            } else {
                $query->where('status', $status);
            }
        }

        // Filter by Ketua / Pengusul role
        if ($request->filled('role')) {
            $role = $request->role;
            $roleMatches = match ($role) {
                'hackaton_dosen' => ['hackaton_dosen', 'dosen'],
                'hackaton_tendik' => ['hackaton_tendik', 'tendik'],
                default => [$role],
            };
            $query->whereHas('user', function ($uq) use ($roleMatches) {
                $uq->whereIn('role', $roleMatches);
            });
        }

        // Filter by Skema Inovasi
        if ($request->filled('skema')) {
            $skema = $request->skema;
            $query->whereHas('identitas', function ($iq) use ($skema) {
                $iq->where('skema_inovasi', $skema);
            });
        }

        // Filter by Tahap & Tahap Status
        if ($request->filled('tahap_id') || $request->filled('tahap_status')) {
            $tahapId = $request->tahap_id;
            $tahapStatus = $request->tahap_status;

            $query->whereHas('submissionTahap', function ($tq) use ($tahapId, $tahapStatus) {
                if ($tahapId) {
                    $tq->where('hackaton_tahap_id', $tahapId);
                }
                if ($tahapStatus) {
                    match ($tahapStatus) {
                        'diajukan' => $tq->where('status', 'diajukan'),
                        'draft' => $tq->where('status', 'draft'),
                        'belum_diisi' => $tq->where('status', 'belum_diisi'),
                        'lolos' => $tq->whereIn('admin_status', ['disetujui', 'selesai']),
                        'perbaikan' => $tq->where('admin_status', 'perbaikan'),
                        'menunggu_admin' => $tq->where('status', 'diajukan')->where('admin_status', 'menunggu'),
                        default => null,
                    };
                }
            });
        }

        // Filter by Reviewer assignment
        if ($request->filled('reviewer_status')) {
            $revStatus = $request->reviewer_status;
            if ($revStatus === 'assigned') {
                $query->has('reviewers');
            } elseif ($revStatus === 'unassigned') {
                $query->doesntHave('reviewers');
            } elseif (is_numeric($revStatus)) {
                $query->whereHas('reviewers', function ($rq) use ($revStatus) {
                    $rq->where('users.id', (int) $revStatus);
                });
            }
        }

        return $query;
    }

    /**
     * List submissions for a specific session.
     */
    public function index(Request $request, HackatonSession $session)
    {
        $query = $this->buildFilteredSubmissionsQuery($request, $session);

        $submissions = $query->latest()->paginate(15)->withQueryString();

        $dFarmCount = HackatonSubmission::where('hackaton_session_id', $session->id)
            ->where(fn($q) => $q->where('kategori', 'd-farm')->orWhere('tema', 'like', '%D-FARM%'))
            ->count();
        $dMarcCount = HackatonSubmission::where('hackaton_session_id', $session->id)
            ->where(fn($q) => $q->whereIn('kategori', ['d-tech', 'd-marc'])->orWhere('tema', 'like', '%D-TECH%')->orWhere('tema', 'like', '%D-MARC%'))
            ->count();
        $dTechCount = $dMarcCount;

        $session->load('tahap');
        $hasReviewerMap = [];
        foreach ($submissions as $sub) {
            $hasReviewerMap[$sub->id] = $sub->reviewers->isNotEmpty();
        }

        $skemaList = \App\Models\HackatonSubmissionIdentitas::whereHas('submission', function ($q) use ($session) {
            $q->where('hackaton_session_id', $session->id);
        })
            ->whereNotNull('skema_inovasi')
            ->where('skema_inovasi', '!=', '')
            ->distinct()
            ->pluck('skema_inovasi');

        $availableReviewers = User::whereIn('role', ['reviewer_hackaton', 'reviewer_inovchalenge', 'admin_hackaton'])
            ->orderBy('name')
            ->get();

        return view('admin_hackaton.submissions.index', compact(
            'submissions',
            'session',
            'hasReviewerMap',
            'dFarmCount',
            'dTechCount',
            'dMarcCount',
            'skemaList',
            'availableReviewers'
        ));
    }

    /**
     * Export filtered submissions list to Excel.
     */
    public function exportSubmissions(Request $request, HackatonSession $session)
    {
        $submissions = $this->buildFilteredSubmissionsQuery($request, $session)
            ->latest()
            ->get();

        $slug = \Illuminate\Support\Str::slug($session->nama_sesi);
        $fileName = "Proposal-Hackaton-{$slug}-" . now()->format('Ymd-His') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\Hackaton\SubmissionsExport($session, $submissions),
            $fileName
        );
    }

    /**
     * Export a single submitted proposal detail to Excel.
     */
    public function exportSingleSubmission(HackatonSession $session, HackatonSubmission $submission)
    {
        abort_if($submission->hackaton_session_id !== $session->id, 404);

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

        foreach ($submission->submissionTahap as $st) {
            $st->loadedFieldValues = HackatonSubmissionFieldValue::where('hackaton_submission_id', $submission->id)
                ->where('hackaton_tahap_id', $st->hackaton_tahap_id)
                ->get()
                ->keyBy('hackaton_tahap_field_id');
        }

        $produkSlug = \Illuminate\Support\Str::slug($submission->identitas?->nama_produk ?: ($submission->user?->name ?: 'proposal'));
        $fileName = "Detail-Proposal-{$produkSlug}-" . now()->format('Ymd-His') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\Hackaton\SingleSubmissionExport($submission),
            $fileName
        );
    }

    /**
     * Show submission detail — per-Tahap accordion with field values, anggota, reviews.
     */
    public function show(HackatonSession $session, HackatonSubmission $submission)
    {
        abort_if($submission->hackaton_session_id !== $session->id, 404);

        // Ensure all session tahap have a corresponding HackatonSubmissionTahap record
        $session->load('tahap');
        $existingTahapIds = $submission->submissionTahap()->pluck('hackaton_tahap_id')->all();
        foreach ($session->tahap as $thp) {
            if (!in_array($thp->id, $existingTahapIds)) {
                HackatonSubmissionTahap::create([
                    'hackaton_submission_id' => $submission->id,
                    'hackaton_tahap_id'      => $thp->id,
                    'status'                 => 'belum_diisi',
                    'admin_status'           => 'menunggu',
                ]);
            }
        }

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
            'katsinovAssessment',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        foreach ($submission->submissionTahap as $st) {
            $st->loadedFieldValues = HackatonSubmissionFieldValue::where('hackaton_submission_id', $submission->id)
                ->where('hackaton_tahap_id', $st->hackaton_tahap_id)
                ->get()
                ->keyBy('hackaton_tahap_field_id');
        }

        $availableReviewers = User::whereIn('role', ['reviewer_hackaton', 'reviewer_inovchalenge', 'admin_hackaton'])
            ->orderBy('name')
            ->get();

        $hasReviewer = $submission->reviewers->isNotEmpty();

        return view('admin_hackaton.submissions.show', compact('submission', 'availableReviewers', 'session', 'hasReviewer'));
    }

    /**
     * Assign / sync reviewers to a submission.
     */
    public function assignReviewer(Request $request, HackatonSession $session, HackatonSubmission $submission)
    {
        $request->validate([
            'reviewer_ids' => 'required|array',
            'reviewer_ids.*' => 'exists:users,id',
        ]);

        $newIds = collect($request->reviewer_ids)->map(fn($id) => (int) $id);
        $currentIds = $submission->reviewers()->pluck('users.id');

        $removedIds = $currentIds->diff($newIds);
        if ($removedIds->isNotEmpty()) {
            $hasReviews = HackatonReview::where('hackaton_submission_id', $submission->id)
                ->whereIn('reviewer_id', $removedIds)
                ->exists();

            if ($hasReviews) {
                return back()->with('error', 'Tidak dapat menghapus reviewer yang sudah memberikan review.');
            }
        }

        $submission->reviewers()->sync($newIds);

        HackatonStatusLog::logSubmissionStatus(
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
    public function updateStatus(Request $request, HackatonSession $session, HackatonSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:draft,diajukan,menunggu_direview,sedang_direview,perbaikan_diperlukan,proses_tahap_selanjutnya,selesai',
        ]);

        $oldStatus = is_object($submission->status) ? $submission->status->value : $submission->status;
        $submission->update(['status' => $request->status]);

        HackatonStatusLog::logSubmissionStatus(
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
    public function updateTahapStatus(Request $request, HackatonSubmissionTahap $submissionTahap)
    {
        $request->validate([
            'admin_status'     => 'required|in:menunggu,disetujui,perbaikan,selesai',
            'catatan_admin'    => 'nullable|string|max:2000',
            'nominal_evaluasi' => 'nullable|numeric|min:0',
        ]);

        $oldAdminStatus = $submissionTahap->admin_status;
        $tahapKe = $submissionTahap->tahap->tahap_ke ?? '?';
        $submissionId = $submissionTahap->hackaton_submission_id;
        $tahapId = $submissionTahap->hackaton_tahap_id;

        $submissionTahap->update([
            'admin_status'     => $request->admin_status,
            'catatan_admin'    => $request->catatan_admin,
            'nominal_evaluasi' => $request->has('nominal_evaluasi') ? $request->nominal_evaluasi : $submissionTahap->nominal_evaluasi,
        ]);

        $keterangan = 'Status Tahap ' . $tahapKe . ' diubah menjadi ' . ucfirst($request->admin_status) . ' oleh admin';
        if ($request->catatan_admin) {
            $keterangan .= ': ' . $request->catatan_admin;
        }
        HackatonStatusLog::logTahapStatus(
            $submissionId,
            $tahapId,
            $oldAdminStatus,
            $request->admin_status,
            $keterangan,
            Auth::id(),
            'admin'
        );

        if ($request->admin_status === 'perbaikan') {
            $submissionTahap->update(['status' => 'draft']);

            HackatonStatusLog::logTahapStatus(
                $submissionId,
                $tahapId,
                $oldAdminStatus,
                'perbaikan',
                "Tahap {$tahapKe} memerlukan perbaikan. Silakan revisi dan submit ulang.",
                Auth::id(),
                'admin'
            );
        }

        if (in_array($request->admin_status, ['disetujui', 'selesai'])) {
            $sessionId = $submissionTahap->tahap->hackaton_session_id;
            $nextTahap = \App\Models\HackatonTahap::where('hackaton_session_id', $sessionId)
                ->where('tahap_ke', $tahapKe + 1)
                ->first();

            if ($nextTahap) {
                $notifMsg = "Selamat! Anda dinyatakan lolos Tahap {$tahapKe}. Silakan lanjutkan ke Tahap " . ($tahapKe + 1) . ".";
            } else {
                $notifMsg = "Selamat! Anda dinyatakan lolos Tahap {$tahapKe}. Semua tahap telah selesai.";
            }

            HackatonStatusLog::logTahapStatus(
                $submissionId,
                $tahapId,
                $oldAdminStatus,
                $request->admin_status,
                $notifMsg,
                Auth::id(),
                'admin'
            );
        }

        return back()->with('success', 'Status tahap berhasil diperbarui.');
    }

    /**
     * Score ranking page.
     */
    public function scores(HackatonSession $session)
    {
        $session->load('tahap');
        $tahapList = $session->tahap;

        $submissions = HackatonSubmission::with([
            'user',
            'reviews' => fn($q) => $q->select('hackaton_submission_id', 'hackaton_tahap_id', 'reviewer_id', 'skor'),
            'reviewers',
            'identitas',
        ])
            ->withCount('reviewers')
            ->where('hackaton_session_id', $session->id)
            ->get();

        $scoreMap = [];
        foreach ($submissions as $sub) {
            $tahapScores = [];
            foreach ($tahapList as $tahap) {
                $tahapReviews = $sub->reviews->where('hackaton_tahap_id', $tahap->id)
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

        return view('admin_hackaton.submissions.scores', compact('session', 'tahapList', 'submissions', 'scoreMap'));
    }

    public function exportExcel(HackatonSession $session)
    {
        $session->load('tahap');
        $tahapList = $session->tahap;

        $submissions = HackatonSubmission::with([
            'user',
            'reviews' => fn($q) => $q->select('hackaton_submission_id', 'hackaton_tahap_id', 'reviewer_id', 'skor'),
            'reviewers',
            'identitas',
        ])
            ->withCount('reviewers')
            ->where('hackaton_session_id', $session->id)
            ->get();

        $scoreMap = [];
        foreach ($submissions as $sub) {
            $tahapScores = [];
            foreach ($tahapList as $tahap) {
                $tahapReviews = $sub->reviews->where('hackaton_tahap_id', $tahap->id)
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

        $fileName = 'Scores-Hackaton-' . now()->format('Ymd-His') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\Hackaton\ScoresExport($session, $tahapList, $submissions, $scoreMap), $fileName);
    }

    /**
     * Delete a submission (admin only).
     */
    public function destroy(HackatonSession $session, HackatonSubmission $submission)
    {
        abort_if($submission->hackaton_session_id !== $session->id, 404);

        $submission->delete();

        return back()->with('success', 'Submission berhasil dihapus.');
    }

    /**
     * Approve a pending team member.
     */
    public function approveMember(HackatonSession $session, HackatonSubmission $submission, HackatonSubmissionMember $member)
    {
        abort_if($member->hackaton_submission_id !== $submission->id, 404);
        abort_if($member->approval_status !== 'pending', 422, 'Anggota ini tidak dalam status pending.');

        $member->update([
            'approval_status' => 'approved',
            'responded_at'    => now(),
        ]);

        HackatonStatusLog::logSubmissionStatus(
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
    public function rejectMember(HackatonSession $session, HackatonSubmission $submission, HackatonSubmissionMember $member)
    {
        abort_if($member->hackaton_submission_id !== $submission->id, 404);
        abort_if($member->approval_status !== 'pending', 422, 'Anggota ini tidak dalam status pending.');

        $member->update([
            'approval_status' => 'rejected',
            'responded_at'    => now(),
        ]);

        HackatonStatusLog::logSubmissionStatus(
            $submission->id,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            is_object($submission->status) ? $submission->status->value : $submission->status,
            "Anggota {$member->nama_lengkap} ({$member->getTipeLabel()}) ditolak oleh admin",
            Auth::id(),
            'admin'
        );

        return back()->with('success', "Anggota {$member->nama_lengkap} berhasil ditolak.");
    }

    /**
     * Admin adds a team member.
     */
    public function storeMember(Request $request, HackatonSession $session, HackatonSubmission $submission)
    {
        abort_if($submission->hackaton_session_id !== $session->id, 404);

        $tipeOptions = implode(',', HackatonSubmissionMember::TIPE_OPTIONS);
        $peranIcOptions = implode(',', HackatonSubmissionMember::PERAN_IC_OPTIONS);

        $validated = $request->validate([
            'tipe_anggota'       => "required|in:{$tipeOptions}",
            'nama_lengkap'       => 'required|string|max:255',
            'nik_nim_nip'        => 'required|string|max:100',
            'institusi_fakultas' => 'nullable|string|max:255',
            'user_id'            => 'nullable|exists:users,id',
            'peran_ic'           => "required|in:{$peranIcOptions}",
            'deskripsi_peran'    => 'required|string|max:1000',
        ]);

        if (!empty($validated['user_id'])) {
            $already = HackatonSubmissionMember::where('user_id', $validated['user_id'])
                ->where('hackaton_submission_id', $submission->id)
                ->exists();
            if ($already) {
                return back()->with('error', 'User ini sudah terdaftar di tim ini.');
            }
        }

        $submission->members()->create([
            'user_id'            => $validated['user_id'] ?? null,
            'peran'              => 'Anggota',
            'peran_ic'           => $validated['peran_ic'],
            'deskripsi_peran'    => $validated['deskripsi_peran'],
            'tipe_anggota'       => $validated['tipe_anggota'],
            'nama_lengkap'       => $validated['nama_lengkap'],
            'nik_nim_nip'        => $validated['nik_nim_nip'] ?? null,
            'institusi_fakultas' => $validated['institusi_fakultas'] ?? null,
            'approval_status'    => 'approved',
            'responded_at'       => now(),
        ]);

        return back()->with('success', 'Anggota berhasil ditambahkan oleh Admin.');
    }

    /**
     * Admin updates a team member.
     */
    public function updateMember(Request $request, HackatonSession $session, HackatonSubmission $submission, HackatonSubmissionMember $member)
    {
        abort_if($member->hackaton_submission_id !== $submission->id, 404);

        $peranIcOptions = implode(',', HackatonSubmissionMember::PERAN_IC_OPTIONS);

        $validated = $request->validate([
            'nama_lengkap'       => 'required|string|max:255',
            'nik_nim_nip'        => 'nullable|string|max:100',
            'institusi_fakultas' => 'nullable|string|max:255',
            'peran_ic'           => "required|in:{$peranIcOptions}",
            'deskripsi_peran'    => 'nullable|string|max:1000',
        ]);

        $member->update($validated);

        return back()->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Admin deletes a team member.
     */
    public function destroyMember(HackatonSession $session, HackatonSubmission $submission, HackatonSubmissionMember $member)
    {
        abort_if($member->hackaton_submission_id !== $submission->id, 404);
        abort_if($member->peran === 'Ketua', 403, 'Ketua tidak dapat dihapus.');

        $nama = $member->nama_lengkap;
        $member->delete();

        return back()->with('success', "Anggota {$nama} berhasil dihapus.");
    }

    /**
     * Search users for member autocomplete.
     */
    public function searchUsers(Request $request)
    {
        $q = $request->query('q', '');
        $tipe = $request->query('tipe', '');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $targetRole = HackatonSubmissionMember::TIPE_TO_ROLE[$tipe] ?? null;

        $query = User::with('profile.fakultas', 'profile.prodi')
            ->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            });

        if ($targetRole) {
            $possibleRoles = array_unique(array_filter([$targetRole, strtolower($tipe), 'hackaton_' . strtolower($tipe)]));
            $query->whereIn('role', $possibleRoles);
        }

        $users = $query->limit(10)->get()->map(function ($u) {
            $institusi = null;
            if ($u->profile?->fakultas) {
                $institusi = $u->profile->fakultas->name;
                if ($u->profile->prodi) {
                    $institusi .= ' / ' . $u->profile->prodi->name;
                }
            } elseif ($u->profile?->institusi) {
                $institusi = $u->profile->institusi;
            }

            return [
                'id'                 => $u->id,
                'name'               => $u->name,
                'email'              => $u->email,
                'role'               => $u->role,
                'identifier_number'  => $u->profile?->identifier_number,
                'institusi_fakultas' => $institusi,
            ];
        });

        return response()->json($users);
    }
}
