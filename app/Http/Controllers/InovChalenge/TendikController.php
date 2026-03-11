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

class TendikController extends Controller
{
    /**
     * Active sessions list for tendik.
     */
    public function sessions()
    {
        $sessions = InovChalengeSession::where('status', 'active')
            ->with('tahap')
            ->withCount('submissions')
            ->latest()
            ->paginate(12);

        return view('subdirektorat-inovasi.tendik.inovchalenge.sessions.index', compact('sessions'));
    }

    /**
     * Show session detail with 3 Tahap overview.
     */
    public function showSession(InovChalengeSession $session)
    {
        abort_if($session->status !== 'active', 404);

        $session->load('tahap.fields');

        $existingSubmission = InovChalengeSubmission::where('inov_chalenge_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->first();

        $existingMembership = null;
        if (!$existingSubmission) {
            $existingMembership = InovChalengeSubmissionMember::where('user_id', Auth::id())
                ->whereHas('submission', fn($q) => $q->where('inov_chalenge_session_id', $session->id))
                ->with('submission')
                ->first();
        }

        return view('subdirektorat-inovasi.tendik.inovchalenge.sessions.show', compact('session', 'existingSubmission', 'existingMembership'));
    }

    /**
     * List tendik's own submissions across all sessions.
     */
    public function mySubmissions()
    {
        $submissions = InovChalengeSubmission::where('user_id', Auth::id())
            ->with(['session', 'submissionTahap.tahap', 'reviewers', 'members'])
            ->latest()
            ->paginate(10);

        return view('subdirektorat-inovasi.tendik.inovchalenge.submissions.index', compact('submissions'));
    }

    /**
     * List submissions where the current tendik is a team member (Anggota, not Ketua).
     */
    public function memberSubmissions()
    {
        $memberOf = InovChalengeSubmissionMember::where('user_id', Auth::id())
            ->where('tipe_anggota', 'tendik')
            ->where('peran', '!=', 'Ketua')
            ->with(['submission.session', 'submission.submissionTahap.tahap', 'submission.user', 'submission.members'])
            ->latest()
            ->paginate(10);

        return view('subdirektorat-inovasi.tendik.inovchalenge.submissions.member-index', compact('memberOf'));
    }

    /**
     * Show a submission read-only for a tendik who is a team member (Anggota).
     */
    public function showMemberSubmission(InovChalengeSubmission $submission)
    {
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
            'reviews.reviewer',
            'reviews.tahap',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        $hasReviewer = $submission->reviewers->isNotEmpty();

        return view('subdirektorat-inovasi.tendik.inovchalenge.submissions.member-show', compact('submission', 'hasReviewer'));
    }

    /**
     * Show a tahap read-only for a tendik team member (Anggota).
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

        return view('subdirektorat-inovasi.tendik.inovchalenge.submissions.tahap', [
            'submission'      => $submission,
            'submissionTahap' => $submissionTahap,
            'fieldValues'     => $fieldValues,
            'isReadOnly'      => true,
        ]);
    }

    /**
     * Store new submission + auto-create submission_tahap rows.
     */
    public function store(Request $request, InovChalengeSession $session)
    {
        abort_if($session->status !== 'active', 404);

        $existing = InovChalengeSubmission::where('inov_chalenge_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return redirect()
                ->route('subdirektorat-inovasi.tendik.inovchalenge.submissions.show', $existing)
                ->with('error', 'Anda sudah memiliki submission untuk sesi ini.');
        }

        $isMember = InovChalengeSubmissionMember::where('user_id', Auth::id())
            ->whereHas('submission', fn($q) => $q->where('inov_chalenge_session_id', $session->id))
            ->exists();

        if ($isMember) {
            return redirect()
                ->route('subdirektorat-inovasi.tendik.inovchalenge.sessions.show', $session)
                ->with('error', 'Anda sudah terdaftar sebagai anggota tim di sesi ini. Tidak dapat mengajukan submission baru.');
        }

        $submission = DB::transaction(function () use ($session) {
            $submission = InovChalengeSubmission::create([
                'inov_chalenge_session_id' => $session->id,
                'user_id'                  => Auth::id(),
                'status'                   => 'draft',
            ]);

            foreach ($session->tahap as $tahap) {
                InovChalengeSubmissionTahap::create([
                    'inov_chalenge_submission_id' => $submission->id,
                    'inov_chalenge_tahap_id'      => $tahap->id,
                    'status'                      => 'belum_diisi',
                    'admin_status'                => 'menunggu',
                ]);
            }

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
                'user_id'           => $user->id,
                'peran'             => 'Ketua',
                'tipe_anggota'      => 'tendik',
                'nama_lengkap'      => $user->name,
                'nik_nim_nip'       => $user->profile?->identifier_number,
                'institusi_fakultas' => $institusi,
                'approval_status'   => 'not_required',
            ]);

            InovChalengeStatusLog::logSubmissionStatus(
                $submission->id,
                null,
                'draft',
                'Submission baru dibuat',
                $user->id,
                'tendik'
            );

            return $submission;
        });

        return redirect()
            ->route('subdirektorat-inovasi.tendik.inovchalenge.submissions.show', $submission)
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
            'reviews.reviewer',
            'reviews.tahap',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        $hasReviewer = $submission->reviewers->isNotEmpty();

        return view('subdirektorat-inovasi.tendik.inovchalenge.submissions.show', compact('submission', 'hasReviewer'));
    }

    /**
     * Show the Identitas Tim & Status Produk form (gate step).
     */
    public function showIdentitas(InovChalengeSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $user = Auth::user()->load('profile.fakultas', 'profile.prodi');
        $submission->load(['session', 'identitas', 'members.user.profile.fakultas', 'members.user.profile.prodi']);

        $ketuaName   = $user->name;
        $ketuaMember = $submission->members->firstWhere('peran', 'Ketua');

        // Pre-fill from profile when member record fields are still empty
        if ($ketuaMember && !$ketuaMember->nik_nim_nip && $user->profile?->identifier_number) {
            $ketuaMember->nik_nim_nip = $user->profile->identifier_number;
        }
        if ($ketuaMember && !$ketuaMember->institusi_fakultas && $user->profile?->institusi) {
            $ketuaMember->institusi_fakultas = $user->profile->institusi;
        }

        $session    = $submission->session;
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
            'subdirektorat-inovasi.tendik.inovchalenge.submissions.identitas',
            compact('submission', 'ketuaName', 'ketuaMember', 'skemaOptions', 'minAnggota', 'maxAnggota', 'currentCount')
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
            'nip_ketua'           => 'required|string|max:50',
            'unit_kerja'          => 'required|string|max:255',
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

        // Also update ketua member record with editable biodata
        $ketuaMember = $submission->members()->where('peran', 'Ketua')->first();
        if ($ketuaMember) {
            $ketuaMember->update([
                'nik_nim_nip'        => $request->nip_ketua,
                'institusi_fakultas' => $request->unit_kerja,
            ]);
        }

        return redirect()
            ->route('subdirektorat-inovasi.tendik.inovchalenge.submissions.identitas', $submission)
            ->with('success', 'Identitas tim berhasil disimpan.');
    }

    /**
     * Show tahap form for filling.
     */
    public function showTahap(InovChalengeSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submission->load('identitas');
        if (!$submission->identitasIsComplete()) {
            return redirect()
                ->route('subdirektorat-inovasi.tendik.inovchalenge.submissions.identitas', $submission)
                ->with('error', 'Lengkapi Identitas Tim & Anggota terlebih dahulu sebelum mengisi tahap.');
        }

        $submissionTahap = InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->firstOrFail();

        $submissionTahap->load(['tahap.sections.fields', 'tahap.unsectionedFields']);

        $tahapModel = $submissionTahap->tahap;
        if ($tahapModel->isUpcoming()) {
            return redirect()
                ->route('subdirektorat-inovasi.tendik.inovchalenge.submissions.show', $submission)
                ->with('error', 'Tahap ' . $tahapModel->tahap_ke . ' belum dibuka. Periode dimulai ' . $tahapModel->periode_awal->format('d M Y H:i') . '.');
        }

        if (!$submissionTahap->isPreviousTahapLolos() && $tahapModel->tahap_ke > 1) {
            $prevTahapKe = $tahapModel->tahap_ke - 1;
            return redirect()
                ->route('subdirektorat-inovasi.tendik.inovchalenge.submissions.show', $submission)
                ->with('error', "Tahap {$tahapModel->tahap_ke} belum dapat diakses. Anda harus dinyatakan lolos Tahap {$prevTahapKe} terlebih dahulu.");
        }

        $fieldValues = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->get()
            ->keyBy('inov_chalenge_tahap_field_id');

        $submission->load('session');

        return view('subdirektorat-inovasi.tendik.inovchalenge.submissions.tahap', compact(
            'submission',
            'submissionTahap',
            'fieldValues'
        ));
    }

    /**
     * Save tahap form as draft.
     */
    public function saveTahap(Request $request, InovChalengeSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submission->load('identitas');
        if (!$submission->identitasIsComplete()) {
            return redirect()
                ->route('subdirektorat-inovasi.tendik.inovchalenge.submissions.identitas', $submission)
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

            if ($submissionTahap->status === 'belum_diisi') {
                InovChalengeStatusLog::logTahapStatus(
                    $submission->id,
                    $tahap->id,
                    'belum_diisi',
                    'draft',
                    'Tahap ' . $tahap->tahap_ke . ' mulai diisi',
                    Auth::id(),
                    'tendik'
                );
                $submissionTahap->update(['status' => 'draft']);
            }

            if ($submissionTahap->admin_status === 'perbaikan') {
                InovChalengeStatusLog::logTahapStatus(
                    $submission->id,
                    $tahap->id,
                    'perbaikan',
                    'draft',
                    'Tahap ' . $tahap->tahap_ke . ' diperbaiki oleh tendik',
                    Auth::id(),
                    'tendik'
                );
                $submissionTahap->update(['status' => 'draft']);
            }
        });

        return back()->with('success', 'Data berhasil disimpan sebagai draft.');
    }

    /**
     * Submit tahap (make it read-only).
     */
    public function submitTahap(Request $request, InovChalengeSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submission->load('identitas');
        if (!$submission->identitasIsComplete()) {
            return redirect()
                ->route('subdirektorat-inovasi.tendik.inovchalenge.submissions.identitas', $submission)
                ->with('error', 'Lengkapi Identitas Tim & Anggota terlebih dahulu sebelum submit tahap.');
        }

        $submissionTahap = InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->firstOrFail();

        abort_if(!$submissionTahap->isEditable(), 403, 'Tahap ini tidak dapat disubmit.');

        $tahap = $submissionTahap->tahap;
        $tahap->load('fields');

        $requiredFields = $tahap->fields->where('is_required', true);
        foreach ($requiredFields as $field) {
            $value = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
                ->where('inov_chalenge_tahap_field_id', $field->id)
                ->first();

            if (!$value || ($this->isFieldEmpty($field, $value))) {
                return back()->with('error', "Field \"{$field->field_label}\" wajib diisi sebelum submit.");
            }
        }

        DB::transaction(function () use ($request, $submission, $tahap, $submissionTahap) {
            foreach ($tahap->fields as $field) {
                $this->saveFieldValue($request, $submission->id, $tahap->id, $field);
            }

            $oldStatus = $submissionTahap->status;
            $submissionTahap->update([
                'status'       => 'diajukan',
                'submitted_at' => now(),
            ]);

            InovChalengeStatusLog::logTahapStatus(
                $submission->id,
                $tahap->id,
                $oldStatus,
                'diajukan',
                'Tahap ' . $tahap->tahap_ke . ' diajukan oleh tendik',
                Auth::id(),
                'tendik'
            );

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
                    'tendik'
                );
            }
        });

        return redirect()
            ->route('subdirektorat-inovasi.tendik.inovchalenge.submissions.show', $submission)
            ->with('success', 'Tahap berhasil disubmit.');
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

    // ── Private helpers ──────────────────────────────────────────────────

    private function saveFieldValue(Request $request, int $submissionId, int $tahapId, $field): void
    {
        $fieldKey = 'field_' . $field->id;
        $data = [
            'inov_chalenge_submission_id'  => $submissionId,
            'inov_chalenge_tahap_id'       => $tahapId,
            'inov_chalenge_tahap_field_id' => $field->id,
        ];

        if ($field->field_type === 'file') {
            if ($request->hasFile($fieldKey)) {
                $file = $request->file($fieldKey);
                $path = $file->store(
                    "inovchalenge/submissions/{$submissionId}/tahap_{$tahapId}/{$field->id}",
                    'public'
                );
                $data['value_file_path']    = $path;
                $data['original_filename']  = $file->getClientOriginalName();
            } else {
                $existing = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submissionId)
                    ->where('inov_chalenge_tahap_field_id', $field->id)
                    ->first();
                if ($existing) {
                    return;
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
                'inov_chalenge_submission_id'  => $submissionId,
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
}
