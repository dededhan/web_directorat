<?php

namespace App\Http\Controllers\Hackaton;

use App\Http\Controllers\Controller;
use App\Models\HackatonKatsinovAssessment;
use App\Models\HackatonSubmission;
use App\Services\HackatonKatsinovService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KatsinovAssessmentController extends Controller
{
    /**
     * Display listing / entry hub for Katsinov Self-Assessments.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $isAdmin = in_array(Auth::user()->role ?? '', ['admin_hackaton', 'superadmin']);

        // Find submissions where user is Ketua or active Member
        $submissions = HackatonSubmission::with(['session', 'identitas', 'members.user', 'katsinovAssessment'])
            ->where(function ($query) use ($userId, $isAdmin) {
                if ($isAdmin) {
                    return;
                }
                $query->where('user_id', $userId)
                    ->orWhereHas('members', function ($m) use ($userId) {
                        $m->where('user_id', $userId)
                            ->whereIn('approval_status', ['approved', 'not_required']);
                    });
            })
            ->latest()
            ->get();

        // Also get standalone assessments created by this user
        $assessments = HackatonKatsinovAssessment::with(['submission.session', 'user'])
            ->where(function ($query) use ($userId, $submissions, $isAdmin) {
                if ($isAdmin) {
                    return;
                }
                $submissionIds = $submissions->pluck('id')->toArray();
                $query->where('user_id', $userId)
                    ->orWhereIn('hackaton_submission_id', $submissionIds);
            })
            ->latest()
            ->get();

        // If a specific submission_id is queried
        $selectedSubmission = null;
        if ($request->filled('submission_id')) {
            $selectedSubmission = $submissions->firstWhere('id', (int) $request->submission_id);
            if ($selectedSubmission && $selectedSubmission->katsinovAssessment) {
                return redirect()->route('hackaton.katsinov.edit', $selectedSubmission->katsinovAssessment->id);
            }
        }

        return view('subdirektorat-inovasi.hackaton.katsinov.index', compact('submissions', 'assessments', 'selectedSubmission'));
    }

    /**
     * Show form to create new Katsinov Self-Assessment.
     */
    public function create(Request $request)
    {
        $userId = Auth::id();
        $isAdmin = in_array(Auth::user()->role ?? '', ['admin_hackaton', 'superadmin']);

        $submission = null;
        if ($request->filled('submission_id')) {
            $submission = HackatonSubmission::with(['session', 'identitas', 'members.user', 'user'])->findOrFail($request->submission_id);
            abort_unless($submission->canUserEdit($userId) || $isAdmin, 403, 'Anda tidak memiliki hak akses ke proposal ini.');

            // If an assessment already exists for this submission, redirect to edit
            $existing = HackatonKatsinovAssessment::where('hackaton_submission_id', $submission->id)->first();
            if ($existing) {
                return redirect()->route('hackaton.katsinov.edit', $existing->id);
            }
        }

        $questions = HackatonKatsinovService::getQuestions();
        $aspects = HackatonKatsinovService::getAspects();
        $assessment = new HackatonKatsinovAssessment();

        // Pre-fill defaults
        if ($submission) {
            $assessment->hackaton_submission_id = $submission->id;
            $assessment->judul_inovasi = $submission->identitas?->nama_produk ?? $submission->tema_label ?? '';
            $assessment->fokus_bidang = $submission->identitas?->bidang_utama_produk ?? $submission->tema_label ?? '';
            $assessment->nama_tim = $submission->identitas?->nama_tim ?? '';
            $assessment->institusi = 'Universitas Negeri Jakarta';
            $assessment->kontak = $submission->user?->email . ($submission->user?->phone ? ' / ' . $submission->user->phone : '');
            $assessment->alamat = 'Kampus A UNJ, Jl. Rawamangun Muka, Jakarta Timur';
            $assessment->assessment_date = now();
        } else {
            $assessment->institusi = 'Universitas Negeri Jakarta';
            $assessment->assessment_date = now();
        }

        return view('subdirektorat-inovasi.hackaton.katsinov.form', [
            'assessment' => $assessment,
            'submission' => $submission,
            'questions' => $questions,
            'aspects' => $aspects,
            'isEdit' => false,
        ]);
    }

    /**
     * Edit existing Katsinov Self-Assessment.
     */
    public function edit(HackatonKatsinovAssessment $katsinov)
    {
        $userId = Auth::id();
        $isAdmin = in_array(Auth::user()->role ?? '', ['admin_hackaton', 'superadmin']);

        if ($katsinov->hackaton_submission_id) {
            $katsinov->load('submission.members.user', 'submission.user', 'submission.identitas', 'submission.session');
            abort_unless($katsinov->submission->canUserEdit($userId) || $isAdmin, 403, 'Akses ditolak.');
            $submission = $katsinov->submission;
        } else {
            abort_unless($katsinov->user_id === $userId || $isAdmin, 403, 'Akses ditolak.');
            $submission = null;
        }

        $questions = HackatonKatsinovService::getQuestions();
        $aspects = HackatonKatsinovService::getAspects();

        return view('subdirektorat-inovasi.hackaton.katsinov.form', [
            'assessment' => $katsinov,
            'submission' => $submission,
            'questions' => $questions,
            'aspects' => $aspects,
            'isEdit' => true,
        ]);
    }

    /**
     * Store or update Katsinov Self-Assessment and calculate results.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $isAdmin = in_array(Auth::user()->role ?? '', ['admin_hackaton', 'superadmin']);

        $validated = $request->validate([
            'assessment_id' => 'nullable|integer|exists:hackaton_katsinov_assessments,id',
            'submission_id' => 'nullable|integer|exists:hackaton_submissions,id',
            'judul_inovasi' => 'required|string|max:255',
            'fokus_bidang' => 'nullable|string|max:255',
            'nama_tim' => 'nullable|string|max:255',
            'institusi' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'kontak' => 'nullable|string|max:255',
            'assessment_date' => 'required|date',
            'responses' => 'nullable|array',
            'notes' => 'nullable|array',
        ], [
            'judul_inovasi.required' => 'Nama / Judul Inovasi wajib diisi.',
            'assessment_date.required' => 'Tanggal pengukuran wajib diisi.',
            'assessment_date.date' => 'Format tanggal pengukuran tidak valid.',
        ]);

        $submission = null;
        if (!empty($validated['submission_id'])) {
            $submission = HackatonSubmission::findOrFail($validated['submission_id']);
            abort_unless($submission->canUserEdit($userId) || $isAdmin, 403, 'Akses ke proposal ini ditolak.');
        }

        $responses = $validated['responses'] ?? [];
        $notes = $validated['notes'] ?? [];

        // Calculate scores using service
        $calc = HackatonKatsinovService::calculate($responses);

        $assessment = null;
        if (!empty($validated['assessment_id'])) {
            $assessment = HackatonKatsinovAssessment::findOrFail($validated['assessment_id']);
            if ($assessment->hackaton_submission_id) {
                abort_unless($assessment->submission->canUserEdit($userId) || $isAdmin, 403);
            } else {
                abort_unless($assessment->user_id === $userId || $isAdmin, 403);
            }

            $assessment->update([
                'judul_inovasi' => $validated['judul_inovasi'],
                'fokus_bidang' => $validated['fokus_bidang'] ?? null,
                'nama_tim' => $validated['nama_tim'] ?? null,
                'institusi' => $validated['institusi'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'kontak' => $validated['kontak'] ?? null,
                'assessment_date' => $validated['assessment_date'],
                'achieved_level' => $calc['achieved_level'],
                'overall_percentage' => $calc['overall_percentage'],
                'aspect_scores' => $calc['aspect_scores'],
                'indicator_scores' => $calc['indicator_scores'],
                'responses' => $responses,
                'notes' => $notes,
            ]);
        } else {
            // Check if assessment already exists for this submission to avoid duplicate records
            if ($submission) {
                $assessment = HackatonKatsinovAssessment::where('hackaton_submission_id', $submission->id)->first();
            }

            if ($assessment) {
                $assessment->update([
                    'judul_inovasi' => $validated['judul_inovasi'],
                    'fokus_bidang' => $validated['fokus_bidang'] ?? null,
                    'nama_tim' => $validated['nama_tim'] ?? null,
                    'institusi' => $validated['institusi'] ?? null,
                    'alamat' => $validated['alamat'] ?? null,
                    'kontak' => $validated['kontak'] ?? null,
                    'assessment_date' => $validated['assessment_date'],
                    'achieved_level' => $calc['achieved_level'],
                    'overall_percentage' => $calc['overall_percentage'],
                    'aspect_scores' => $calc['aspect_scores'],
                    'indicator_scores' => $calc['indicator_scores'],
                    'responses' => $responses,
                    'notes' => $notes,
                ]);
            } else {
                $assessment = HackatonKatsinovAssessment::create([
                    'hackaton_submission_id' => $submission?->id,
                    'user_id' => $userId,
                    'judul_inovasi' => $validated['judul_inovasi'],
                    'fokus_bidang' => $validated['fokus_bidang'] ?? null,
                    'nama_tim' => $validated['nama_tim'] ?? null,
                    'institusi' => $validated['institusi'] ?? null,
                    'alamat' => $validated['alamat'] ?? null,
                    'kontak' => $validated['kontak'] ?? null,
                    'assessment_date' => $validated['assessment_date'],
                    'achieved_level' => $calc['achieved_level'],
                    'overall_percentage' => $calc['overall_percentage'],
                    'aspect_scores' => $calc['aspect_scores'],
                    'indicator_scores' => $calc['indicator_scores'],
                    'responses' => $responses,
                    'notes' => $notes,
                ]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Self-Assessment KATSINOV berhasil disimpan!',
                'id' => $assessment->id,
                'achieved_level' => $calc['achieved_level'],
                'overall_percentage' => $calc['overall_percentage'],
                'aspect_scores' => $calc['aspect_scores'],
                'indicator_scores' => $calc['indicator_scores'],
                'download_url' => route('hackaton.katsinov.download_pdf', $assessment->id),
            ]);
        }

        return redirect()->route('hackaton.katsinov.edit', $assessment->id)
            ->with('success', 'Self-Assessment KATSINOV berhasil disimpan!');
    }

    /**
     * Download Katsinov Self-Assessment Report as PDF.
     */
    public function downloadPdf(HackatonKatsinovAssessment $katsinov)
    {
        $userId = Auth::id();
        $isAdmin = in_array(Auth::user()->role ?? '', ['admin_hackaton', 'superadmin']);

        if ($katsinov->hackaton_submission_id) {
            $katsinov->load('submission.members.user', 'submission.user', 'submission.identitas', 'submission.session');
            abort_unless($katsinov->submission->canUserView($userId) || $isAdmin, 403, 'Akses ditolak.');
            $submission = $katsinov->submission;
            $ketua = $submission->user;
            $members = $submission->members()->with('user')->get();
        } else {
            abort_unless($katsinov->user_id === $userId || $isAdmin, 403, 'Akses ditolak.');
            $submission = null;
            $ketua = $katsinov->user;
            $members = collect([]);
        }

        $aspects = HackatonKatsinovService::getAspects();
        $questions = HackatonKatsinovService::getQuestions();

        $data = [
            'assessment' => $katsinov,
            'submission' => $submission,
            'ketua' => $ketua,
            'members' => $members,
            'aspects' => $aspects,
            'questions' => $questions,
            'achieved_level' => $katsinov->achieved_level,
            'overall_percentage' => $katsinov->overall_percentage,
            'aspect_scores' => $katsinov->aspect_scores ?? [],
            'indicator_scores' => $katsinov->indicator_scores ?? [],
            'responses' => $katsinov->responses ?? [],
            'dateFormatted' => $katsinov->assessment_date ? $katsinov->assessment_date->translatedFormat('d F Y') : now()->translatedFormat('d F Y'),
        ];

        $pdf = Pdf::loadView('subdirektorat-inovasi.hackaton.katsinov.pdf', $data);
        $pdf->setPaper('a4', 'portrait');

        $safeTitle = Str::slug($katsinov->judul_inovasi ?: 'katsinov-self-assessment');
        $filename = "Katsinov_Self_Assessment_{$safeTitle}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Save digital or uploaded signature for the assessment.
     */
    public function saveSignature(Request $request, HackatonKatsinovAssessment $katsinov)
    {
        $userId = Auth::id();
        $isAdmin = in_array(Auth::user()->role ?? '', ['admin_hackaton', 'superadmin']);

        if ($katsinov->hackaton_submission_id) {
            abort_unless($katsinov->submission->canUserEdit($userId) || $isAdmin, 403, 'Akses ditolak.');
        } else {
            abort_unless($katsinov->user_id === $userId || $isAdmin, 403, 'Akses ditolak.');
        }

        $request->validate([
            'signature_data' => 'nullable|string',
            'signature_file' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $signatureImage = null;

        if ($request->hasFile('signature_file')) {
            $file = $request->file('signature_file');
            $mime = $file->getMimeType();
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            $signatureImage = "data:{$mime};base64,{$base64}";
        } elseif ($request->filled('signature_data')) {
            $signatureImage = $request->signature_data;
        }

        if (!$signatureImage) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan bubuhkan tanda tangan langsung pada area yang disediakan atau unggah berkas gambar tanda tangan Anda.',
            ], 422);
        }

        if (empty($katsinov->share_token)) {
            $katsinov->share_token = Str::random(32);
        }

        $katsinov->signature_image = $signatureImage;
        $katsinov->signed_at = now();
        $katsinov->save();

        $shareUrl = route('hackaton.katsinov.show_public', $katsinov->share_token);
        $downloadUrl = route('hackaton.katsinov.download_pdf', $katsinov->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Tanda tangan berhasil disimpan! Dokumen KATSINOV Anda telah siap diunduh.',
            'signature_image' => $signatureImage,
            'signed_at' => $katsinov->signed_at->translatedFormat('d F Y H:i'),
            'share_url' => $shareUrl,
            'download_url' => $downloadUrl,
            'achieved_level' => $katsinov->achieved_level,
            'overall_percentage' => $katsinov->overall_percentage,
        ]);
    }

    /**
     * Public verification view for a Katsinov Assessment via share_token.
     */
    public function showPublic($token)
    {
        $katsinov = HackatonKatsinovAssessment::with(['submission.session', 'submission.user', 'submission.members.user', 'user'])
            ->where('share_token', $token)
            ->firstOrFail();

        $aspects = HackatonKatsinovService::getAspects();
        $questions = HackatonKatsinovService::getQuestions();

        return view('subdirektorat-inovasi.hackaton.katsinov.public_view', [
            'assessment' => $katsinov,
            'submission' => $katsinov->submission,
            'ketua' => $katsinov->submission ? $katsinov->submission->user : $katsinov->user,
            'members' => $katsinov->submission ? $katsinov->submission->members : collect([]),
            'aspects' => $aspects,
            'questions' => $questions,
        ]);
    }

    /**
     * Delete an assessment.
     */
    public function destroy(HackatonKatsinovAssessment $katsinov)
    {
        $userId = Auth::id();
        $isAdmin = in_array(Auth::user()->role ?? '', ['admin_hackaton', 'superadmin']);

        if ($katsinov->hackaton_submission_id) {
            abort_unless($katsinov->submission->user_id === $userId || $isAdmin, 403, 'Hanya Ketua Tim atau Admin yang dapat menghapus assessment ini.');
        } else {
            abort_unless($katsinov->user_id === $userId || $isAdmin, 403, 'Akses ditolak.');
        }

        $katsinov->delete();

        return redirect()->route('hackaton.katsinov.index')
            ->with('success', 'Self-Assessment KATSINOV berhasil dihapus.');
    }
}
