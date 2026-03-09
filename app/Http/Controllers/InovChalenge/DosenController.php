<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSession;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeSubmissionIdentitas;
use App\Models\InovChalengeSubmissionMember;
use App\Models\InovChalengeSubmissionTahap;
use App\Models\InovChalengeFieldValue;
use App\Models\InovChalengeStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    /**
     * Active sessions list for dosen.
     */
    public function sessions()
    {
        $sessions = InovChalengeSession::where('status', 'active')
            ->with('tahap')
            ->withCount('submissions')
            ->latest()
            ->paginate(12);

        return view('subdirektorat-inovasi.dosen.inovchalenge.sessions.index', compact('sessions'));
    }

    /**
     * Show session detail with 3 Tahap overview.
     */
    public function showSession(InovChalengeSession $session)
    {
        abort_if($session->status !== 'active', 404);

        $session->load('tahap.fields');

        // Check if dosen already has a submission (as ketua) for this session
        $existingSubmission = InovChalengeSubmission::where('inov_chalenge_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->first();

        // Check if dosen is already a member of any submission in this session
        $existingMembership = null;
        if (!$existingSubmission) {
            $existingMembership = InovChalengeSubmissionMember::where('user_id', Auth::id())
                ->whereHas('submission', fn($q) => $q->where('inov_chalenge_session_id', $session->id))
                ->with('submission')
                ->first();
        }

        return view('subdirektorat-inovasi.dosen.inovchalenge.sessions.show', compact('session', 'existingSubmission', 'existingMembership'));
    }

    /**
     * List dosen's own submissions across all sessions.
     */
    public function mySubmissions()
    {
        $submissions = InovChalengeSubmission::where('user_id', Auth::id())
            ->with(['session', 'submissionTahap.tahap', 'reviewers', 'members'])
            ->latest()
            ->paginate(10);

        return view('subdirektorat-inovasi.dosen.inovchalenge.submissions.index', compact('submissions'));
    }

    /**
     * List submissions where the current dosen is a team member (Anggota, not Ketua).
     */
    public function memberSubmissions()
    {
        $memberOf = InovChalengeSubmissionMember::where('user_id', Auth::id())
            ->where('tipe_anggota', 'dosen')
            ->where('peran', '!=', 'Ketua')
            ->with(['submission.session', 'submission.submissionTahap.tahap', 'submission.user', 'submission.members'])
            ->latest()
            ->paginate(10);

        return view('subdirektorat-inovasi.dosen.inovchalenge.submissions.member-index', compact('memberOf'));
    }

    /**
     * Show a submission read-only for a dosen who is a team member (Anggota).
     * They can see all data but cannot edit/fill/submit any forms.
     */
    public function showMemberSubmission(InovChalengeSubmission $submission)
    {
        // Verify current user is a member of this submission
        $member = InovChalengeSubmissionMember::where('inov_chalenge_submission_id', $submission->id)
            ->where('user_id', Auth::id())
            ->where('peran', '!=', 'Ketua')
            ->first();

        abort_if(!$member, 403, 'Anda bukan anggota tim dari submission ini.');
        abort_if($member->approval_status === 'pending', 403, 'Anda belum menerima undangan perkumpulan ini.');
        abort_if($member->approval_status === 'rejected', 403, 'Anda sudah menolak undangan ini.');

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

        return view('subdirektorat-inovasi.dosen.inovchalenge.submissions.member-show', compact('submission', 'hasReviewer'));
    }

    /**
     * Show a tahap read-only for a dosen team member (Anggota).
     */
    public function showMemberTahap(InovChalengeSubmission $submission, $tahapId)
    {
        $member = InovChalengeSubmissionMember::where('inov_chalenge_submission_id', $submission->id)
            ->where('user_id', Auth::id())
            ->where('peran', '!=', 'Ketua')
            ->first();

        abort_if(!$member, 403, 'Anda bukan anggota tim dari submission ini.');
        abort_if(!in_array($member->approval_status, ['approved', 'not_required']), 403, 'Anda belum memiliki akses ke submission ini.');

        $submissionTahap = InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->firstOrFail();

        $submissionTahap->load(['tahap.sections.fields', 'tahap.unsectionedFields']);

        $fieldValues = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->get()
            ->keyBy('inov_chalenge_tahap_field_id');

        $submission->load('session');

        // Force read-only by passing isReadOnly = true
        return view('subdirektorat-inovasi.dosen.inovchalenge.submissions.tahap', [
            'submission' => $submission,
            'submissionTahap' => $submissionTahap,
            'fieldValues' => $fieldValues,
            'isReadOnly' => true,
        ]);
    }

    /**
     * Show the create submission page (confirm before creating).
     */
    public function create(InovChalengeSession $session)
    {
        abort_if($session->status !== 'active', 404);

        // Check duplicate
        $existing = InovChalengeSubmission::where('inov_chalenge_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $existing)
                ->with('error', 'Anda sudah memiliki submission untuk sesi ini.');
        }

        // Check if already a member (anggota) of another submission in this session
        $isMember = InovChalengeSubmissionMember::where('user_id', Auth::id())
            ->whereHas('submission', fn($q) => $q->where('inov_chalenge_session_id', $session->id))
            ->exists();

        if ($isMember) {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.sessions.show', $session)
                ->with('error', 'Anda sudah terdaftar sebagai anggota tim di sesi ini. Tidak dapat mengajukan submission baru.');
        }

        return view('subdirektorat-inovasi.dosen.inovchalenge.sessions.show', [
            'session' => $session->load('tahap.fields'),
            'existingSubmission' => null,
            'confirmCreate' => true,
        ]);
    }

    /**
     * Store new submission + auto-create 3 submission_tahap rows.
     */
    public function store(Request $request, InovChalengeSession $session)
    {
        abort_if($session->status !== 'active', 404);

        // Check duplicate (own submission)
        $existing = InovChalengeSubmission::where('inov_chalenge_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $existing)
                ->with('error', 'Anda sudah memiliki submission untuk sesi ini.');
        }

        // Check if already a member of another submission in this session
        $isMember = InovChalengeSubmissionMember::where('user_id', Auth::id())
            ->whereHas('submission', fn($q) => $q->where('inov_chalenge_session_id', $session->id))
            ->exists();

        if ($isMember) {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.sessions.show', $session)
                ->with('error', 'Anda sudah terdaftar sebagai anggota tim di sesi ini. Tidak dapat mengajukan submission baru.');
        }

        $submission = DB::transaction(function () use ($session) {
            $submission = InovChalengeSubmission::create([
                'inov_chalenge_session_id' => $session->id,
                'user_id' => Auth::id(),
                'status' => 'draft',
            ]);

            // Auto-create submission_tahap for every tahap in the session
            foreach ($session->tahap as $tahap) {
                InovChalengeSubmissionTahap::create([
                    'inov_chalenge_submission_id' => $submission->id,
                    'inov_chalenge_tahap_id' => $tahap->id,
                    'status' => 'belum_diisi',
                    'admin_status' => 'menunggu',
                ]);
            }

            // Auto-add dosen as Ketua member with profile data
            $user = Auth::user();
            $user->load('profile.fakultas', 'profile.prodi');

            $institusi = null;
            if ($user->profile?->fakultas) {
                $institusi = $user->profile->fakultas->name;
                if ($user->profile->prodi) {
                    $institusi .= ' / ' . $user->profile->prodi->name;
                }
            }

            $submission->members()->create([
                'user_id' => $user->id,
                'peran' => 'Ketua',
                'tipe_anggota' => 'dosen',
                'nama_lengkap' => $user->name,
                'nik_nim_nip' => $user->profile?->identifier_number,
                'institusi_fakultas' => $institusi,
                'approval_status' => 'not_required',
            ]);

            // Log: submission created
            InovChalengeStatusLog::logSubmissionStatus(
                $submission->id,
                null,
                'draft',
                'Submission baru dibuat',
                $user->id,
                'dosen'
            );

            return $submission;
        });

        return redirect()
            ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $submission)
            ->with('success', 'Submission berhasil dibuat. Silakan isi tiap tahap.');
    }

    /**
     * Show submission detail with 3-Tahap progress tracker.
     */
    public function showSubmission(InovChalengeSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submission->load([
            'session',
            'submissionTahap.tahap',
            'members.user',
            'identitas',
            'reviewers',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        // Pre-compute whether this submission has assigned reviewers
        $hasReviewer = $submission->reviewers->isNotEmpty();

        return view('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', compact('submission', 'hasReviewer'));
    }

    /**
     * Show the Identitas Tim & Status Produk form (gate step).
     */
    public function showIdentitas(InovChalengeSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $user = Auth::user()->load('profile.fakultas', 'profile.prodi');
        $submission->load(['session', 'identitas', 'members.user.profile.fakultas', 'members.user.profile.prodi']);

        $fakultasName = $user->profile?->fakultas?->name ?? '-';
        $prodiName    = $user->profile?->prodi?->name ?? '-';
        $ketuaName    = $user->name;

        $session = $submission->session;
        $minAnggota = $session->min_anggota ?? 1;
        $maxAnggota = $session->max_anggota ?? 4;
        $currentCount = $submission->members->count();

        $skemaOptions = [
            'Hilirisasi Produk Riset Inovasi',
            'Hilirisasi Produk Kolaborasi Dosen dan Alumni',
            'Hibah Komersialisasi Produk / Jasa Kepakaran Dosen (Income generating)',
            'Kolaborasi DUDI (Industri)',
        ];

        return view(
            'subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas',
            compact('submission', 'fakultasName', 'prodiName', 'ketuaName', 'skemaOptions', 'minAnggota', 'maxAnggota', 'currentCount')
        );
    }

    /**
     * Save the Identitas Tim & Status Produk data.
     */
    public function saveIdentitas(Request $request, InovChalengeSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $request->validate([
            'nama_produk'         => 'required|string|max:255',
            'skema_inovasi'       => 'required|in:Hilirisasi Produk Riset Inovasi,Hilirisasi Produk Kolaborasi Dosen dan Alumni,Hibah Komersialisasi Produk / Jasa Kepakaran Dosen (Income generating),Kolaborasi DUDI (Industri)',
            'bidang_utama_produk' => 'required|string|max:255',
        ]);

        InovChalengeSubmissionIdentitas::updateOrCreate(
            ['inov_chalenge_submission_id' => $submission->id],
            [
                'nama_produk'         => $request->nama_produk,
                'skema_inovasi'       => $request->skema_inovasi,
                'bidang_utama_produk' => $request->bidang_utama_produk,
            ]
        );

        return redirect()
            ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas', $submission)
            ->with('success', 'Identitas tim berhasil disimpan.');
    }

    /**
     * Show tahap form for filling.
     * Gate: identitasIsComplete() must be true.
     */
    public function showTahap(InovChalengeSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        // Gate: identitas must be complete before accessing any tahap
        $submission->load('identitas');
        if (!$submission->identitasIsComplete()) {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas', $submission)
                ->with('error', 'Lengkapi Identitas Tim & Anggota terlebih dahulu sebelum mengisi tahap.');
        }

        $submissionTahap = InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->firstOrFail();

        $submissionTahap->load(['tahap.sections.fields', 'tahap.unsectionedFields']);

        // Check tahap timing — redirect if not yet open
        $tahapModel = $submissionTahap->tahap;
        if ($tahapModel->isUpcoming()) {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $submission)
                ->with('error', 'Tahap ' . $tahapModel->tahap_ke . ' belum dibuka. Periode dimulai ' . $tahapModel->periode_awal->format('d M Y H:i') . '.');
        }

        // Gate: previous tahap must be lolos before accessing this one (for tahap > 1)
        if (!$submissionTahap->isPreviousTahapLolos() && $tahapModel->tahap_ke > 1) {
            $prevTahapKe = $tahapModel->tahap_ke - 1;
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $submission)
                ->with('error', "Tahap {$tahapModel->tahap_ke} belum dapat diakses. Anda harus dinyatakan lolos Tahap {$prevTahapKe} terlebih dahulu.");
        }

        // Load existing field values keyed by field_id
        $fieldValues = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->get()
            ->keyBy('inov_chalenge_tahap_field_id');

        $submission->load('session');

        return view('subdirektorat-inovasi.dosen.inovchalenge.submissions.tahap', compact(
            'submission',
            'submissionTahap',
            'fieldValues'
        ));
    }

    /**
     * Save tahap form as draft.
     * Gate: identitasIsComplete() must be true.
     */
    public function saveTahap(Request $request, InovChalengeSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submission->load('identitas');
        if (!$submission->identitasIsComplete()) {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas', $submission)
                ->with('error', 'Lengkapi Identitas Tim & Anggota terlebih dahulu sebelum mengisi tahap.');
        }

        $submissionTahap = InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->firstOrFail();

        abort_if(!$submissionTahap->isEditable(), 403, 'Tahap ini tidak dapat diedit.');

        $tahap = $submissionTahap->tahap;
        $tahap->load('fields');

        DB::transaction(function () use ($request, $submission, $tahap, $submissionTahap) {
            foreach ($tahap->fields as $field) {
                $this->saveFieldValue($request, $submission->id, $tahap->id, $field);
            }

            // Update status to draft if belum_diisi
            if ($submissionTahap->status === 'belum_diisi') {
                InovChalengeStatusLog::logTahapStatus(
                    $submission->id,
                    $tahap->id,
                    'belum_diisi',
                    'draft',
                    'Tahap ' . $tahap->tahap_ke . ' mulai diisi',
                    Auth::id(),
                    'dosen'
                );
                $submissionTahap->update(['status' => 'draft']);
            }

            // If returning from perbaikan, reset to draft
            if ($submissionTahap->admin_status === 'perbaikan') {
                InovChalengeStatusLog::logTahapStatus(
                    $submission->id,
                    $tahap->id,
                    'perbaikan',
                    'draft',
                    'Tahap ' . $tahap->tahap_ke . ' diperbaiki oleh dosen',
                    Auth::id(),
                    'dosen'
                );
                $submissionTahap->update(['status' => 'draft']);
            }
        });

        return back()->with('success', 'Data berhasil disimpan sebagai draft.');
    }

    /**
     * Submit tahap (make it read-only).
     * Gate: identitasIsComplete() must be true.
     */
    public function submitTahap(Request $request, InovChalengeSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submission->load('identitas');
        if (!$submission->identitasIsComplete()) {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas', $submission)
                ->with('error', 'Lengkapi Identitas Tim & Anggota terlebih dahulu sebelum submit tahap.');
        }

        $submissionTahap = InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->firstOrFail();

        abort_if(!$submissionTahap->isEditable(), 403, 'Tahap ini tidak dapat disubmit.');

        $tahap = $submissionTahap->tahap;
        $tahap->load('fields');

        // Validate required fields
        $requiredFields = $tahap->fields->where('is_required', true);
        foreach ($requiredFields as $field) {
            $value = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
                ->where('inov_chalenge_tahap_field_id', $field->id)
                ->first();

            if (!$value || ($this->isFieldEmpty($field, $value))) {
                return back()->with('error', "Field \"{$field->field_label}\" wajib diisi sebelum submit.");
            }
        }

        // Save any pending form data first
        DB::transaction(function () use ($request, $submission, $tahap, $submissionTahap) {
            foreach ($tahap->fields as $field) {
                $this->saveFieldValue($request, $submission->id, $tahap->id, $field);
            }

            $oldStatus = $submissionTahap->status;
            $submissionTahap->update([
                'status' => 'diajukan',
                'submitted_at' => now(),
            ]);

            // Log: tahap submitted
            InovChalengeStatusLog::logTahapStatus(
                $submission->id,
                $tahap->id,
                $oldStatus,
                'diajukan',
                'Tahap ' . $tahap->tahap_ke . ' diajukan oleh dosen',
                Auth::id(),
                'dosen'
            );

            // Check if all tahap are submitted -> update overall status
            $allSubmitted = InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
                ->where('status', '!=', 'diajukan')
                ->doesntExist();

            if ($allSubmitted) {
                $oldOverall = is_object($submission->status) ? $submission->status->value : $submission->status;
                $submission->update(['status' => 'diajukan']);
                InovChalengeStatusLog::logSubmissionStatus(
                    $submission->id,
                    $oldOverall,
                    'diajukan',
                    'Semua tahap telah diajukan',
                    Auth::id(),
                    'dosen'
                );
            }
        });

        return redirect()
            ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $submission)
            ->with('success', 'Tahap berhasil disubmit.');
    }

    // ── Private helpers ──────────────────────────────────────────────────

    private function saveFieldValue(Request $request, int $submissionId, int $tahapId, $field): void
    {
        $fieldKey = 'field_' . $field->id;
        $data = [
            'inov_chalenge_submission_id' => $submissionId,
            'inov_chalenge_tahap_id' => $tahapId,
            'inov_chalenge_tahap_field_id' => $field->id,
        ];

        if ($field->field_type === 'file') {
            if ($request->hasFile($fieldKey)) {
                $file = $request->file($fieldKey);
                $path = $file->store(
                    "inovchalenge/submissions/{$submissionId}/tahap_{$tahapId}/{$field->id}",
                    'public'
                );
                $data['value_file_path'] = $path;
                $data['original_filename'] = $file->getClientOriginalName();
            } else {
                // Don't overwrite existing file if no new file uploaded
                $existing = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submissionId)
                    ->where('inov_chalenge_tahap_field_id', $field->id)
                    ->first();
                if ($existing) {
                    return; // Keep existing file
                }
            }
        } elseif ($field->field_type === 'url') {
            $data['value_url'] = $request->input($fieldKey);
        } elseif ($field->field_type === 'checkbox') {
            $selected = $request->input($fieldKey, []);
            $data['value_text'] = json_encode(array_values(array_filter((array) $selected)));
        } else {
            $data['value_text'] = $request->input($fieldKey);
        }

        InovChalengeFieldValue::updateOrCreate(
            [
                'inov_chalenge_submission_id' => $submissionId,
                'inov_chalenge_tahap_field_id' => $field->id,
            ],
            $data
        );
    }

    private function isFieldEmpty($field, $value): bool
    {
        if ($field->field_type === 'file') {
            return empty($value->value_file_path);
        }
        if ($field->field_type === 'url') {
            return empty($value->value_url);
        }
        if ($field->field_type === 'checkbox') {
            $decoded = json_decode($value->value_text ?? '', true);
            return empty($decoded);
        }
        return empty($value->value_text);
    }

    /**
     * Approve an invitation to join a team as Anggota.
     */
    public function approveInvitation(InovChalengeSubmissionMember $member)
    {
        abort_if($member->user_id !== Auth::id(), 403);
        abort_if($member->approval_status !== 'pending', 403, 'Undangan ini sudah direspon.');

        $member->update([
            'approval_status' => 'approved',
            'responded_at'    => now(),
        ]);

        return back()->with('success', 'Undangan berhasil diterima. Anda sekarang tergabung di tim.');
    }

    /**
     * Reject an invitation to join a team.
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
