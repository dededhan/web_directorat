<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSession;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeSubmissionIdentitas;
use App\Models\InovChalengeSubmissionTahap;
use App\Models\InovChalengeFieldValue;
use App\Models\InovChalengeStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        // Check if dosen already has a submission for this session
        $existingSubmission = InovChalengeSubmission::where('inov_chalenge_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->first();

        return view('subdirektorat-inovasi.dosen.inovchalenge.sessions.show', compact('session', 'existingSubmission'));
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

        // Check duplicate
        $existing = InovChalengeSubmission::where('inov_chalenge_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', $existing)
                ->with('error', 'Anda sudah memiliki submission untuk sesi ini.');
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

            // Auto-add dosen as Ketua member
            $user = Auth::user();
            $submission->members()->create([
                'user_id' => $user->id,
                'peran' => 'Ketua',
                'tipe_anggota' => 'dosen',
                'nama_lengkap' => $user->name,
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

        $user = Auth::user()->load('profile.fakultas');
        $submission->load(['session', 'identitas', 'members.user']);

        $fakultasName = $user->profile?->fakultas?->name ?? '-';
        $ketuaName    = $user->name;

        $skemaOptions = [
            'Hilirisasi Produk Riset Inovasi',
            'Hilirisasi Produk Kolaborasi Dosen dan Alumni',
        ];

        return view(
            'subdirektorat-inovasi.dosen.inovchalenge.submissions.identitas',
            compact('submission', 'fakultasName', 'ketuaName', 'skemaOptions')
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
            'skema_inovasi'       => 'required|in:Hilirisasi Produk Riset Inovasi,Hilirisasi Produk Kolaborasi Dosen dan Alumni',
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
}
