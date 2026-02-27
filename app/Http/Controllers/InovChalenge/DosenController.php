<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSession;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeSubmissionTahap;
use App\Models\InovChalengeFieldValue;
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
            ->with(['session', 'submissionTahap.tahap'])
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
        ]);

        return view('subdirektorat-inovasi.dosen.inovchalenge.submissions.show', compact('submission'));
    }

    /**
     * Show tahap form for filling.
     */
    public function showTahap(InovChalengeSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submissionTahap = InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->firstOrFail();

        $submissionTahap->load('tahap.fields');

        // Load existing field values keyed by field_id
        $fieldValues = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
            ->where('inov_chalenge_tahap_id', $tahapId)
            ->get()
            ->keyBy('inov_chalenge_tahap_field_id');

        // Load members only for Tahap 1 (has_anggota)
        $members = null;
        if ($submissionTahap->tahap->has_anggota) {
            $members = $submission->members()->with('user')->get();
        }

        $submission->load('session');

        return view('subdirektorat-inovasi.dosen.inovchalenge.submissions.tahap', compact(
            'submission',
            'submissionTahap',
            'fieldValues',
            'members'
        ));
    }

    /**
     * Save tahap form as draft.
     */
    public function saveTahap(Request $request, InovChalengeSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

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
                $submissionTahap->update(['status' => 'draft']);
            }

            // If returning from perbaikan, reset to draft
            if ($submissionTahap->admin_status === 'perbaikan') {
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

            $submissionTahap->update([
                'status' => 'diajukan',
                'submitted_at' => now(),
            ]);

            // Check if all tahap are submitted → update overall status
            $allSubmitted = InovChalengeSubmissionTahap::where('inov_chalenge_submission_id', $submission->id)
                ->where('status', '!=', 'diajukan')
                ->doesntExist();

            if ($allSubmitted) {
                $submission->update(['status' => 'diajukan']);
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
        return empty($value->value_text);
    }
}
