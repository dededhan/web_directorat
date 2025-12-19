<?php

namespace App\Http\Controllers;

use App\Models\Katsinov;
use App\Models\KatsinovResponse;
use App\Models\KatsinovNote;
use App\Models\KatsinovBerita;
use App\Models\KatsinovLampiran;
use App\Models\FormRecordHasilPengukuran;
use App\Models\KatsinovCategory;
use App\Models\KatsinovIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ValidatorController extends Controller
{
    /**
     * Display list of forms assigned to validator
     */
    public function index()
    {
        $validator = Auth::user();

        // Get katsinovs assigned to this validator (use katsinovs table, not innovator_forms)
        $forms = \App\Models\Katsinov::where('reviewer_id', $validator->id)
            ->with(['user', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()
            ->view('validator.index', compact('forms'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Display single page assessment view
     */
    public function assess($formId)
    {
        $validator = Auth::user();
        $form = \App\Models\Katsinov::with(['user', 'responses', 'katsinovInformasis', 'katsinovInovasis', 'katsinovLampirans'])->findOrFail($formId);

        // Check if validator is assigned to this form
        if ($form->reviewer_id !== $validator->id) {
            abort(403, 'Unauthorized access');
        }

        // Update ValidatorProgress status to 'in_review' when opening the form for the first time
        $validatorProgress = \App\Models\ValidatorProgress::firstOrCreate(
            [
                'form_id' => $formId,
                'validator_id' => Auth::id(),
            ],
            [
                'status' => 'in_review',
                'started_at' => now(),
            ]
        );

        // If status is still 'assigned', update to 'in_review'
        if ($validatorProgress->status === 'assigned') {
            $validatorProgress->update([
                'status' => 'in_review',
                'started_at' => $validatorProgress->started_at ?? now(),
            ]);
        }

        // Get existing responses (nilai dosen dari katsinov_responses table)
        // indicator_number di table ini adalah integer (1, 2, 3...) yang merepresentasikan kategori IRL
        $assessments = \App\Models\KatsinovResponse::where('katsinov_id', $formId)
            ->get()
            ->groupBy('indicator_number'); // Group by IRL number (1=IRL1, 2=IRL2, etc)

        // Get notes (comments per category)
        $categoryComments = \App\Models\KatsinovNote::where('katsinov_id', $formId)
            ->get()
            ->keyBy('indicator_number');

        // Only show categories that have been filled by dosen
        // Validator can only assess IRLs that dosen has completed
        $filledIRLNumbers = $assessments->keys()->toArray(); // e.g., [1, 2] untuk IRL1 dan IRL2

        if (!empty($filledIRLNumbers)) {
            // Get categories where the numeric part matches filled IRL numbers
            $categories = KatsinovCategory::with('indicators')
                ->get()
                ->filter(function ($category) use ($filledIRLNumbers) {
                    // Extract number from category code (IRL1 -> 1, IRL2 -> 2, K1 -> 1, etc)
                    $categoryNumber = (int)str_replace(['IRL', 'K'], '', $category->code);
                    return in_array($categoryNumber, $filledIRLNumbers);
                })
                ->values();
        } else {
            // If no data filled by dosen, show empty collection
            $categories = collect();
        }

        // Agreement - load from katsinov table
        $agreement = (object)[
            'signature' => $form->validator_agreement_signature,
            'signed_at' => $form->validator_agreement_date,
        ];

        // Get berita acara from katsinov_beritas
        $beritaAcara = \App\Models\KatsinovBerita::where('katsinov_id', $formId)->first();

        // Get validator record (form record hasil pengukuran)
        $validatorRecord = \App\Models\FormRecordHasilPengukuran::where('katsinov_id', $formId)->first();

        $isReadOnly = ($form->status === 'completed');

        // Build progress object with all required properties for view
        $progress = (object)[
            'status' => $form->status ?? 'assigned',
            'started_at' => $form->created_at,
            'agreement_completed' => $form->status === 'under_review' || $form->status === 'completed',
            'assessment_completed' => $assessments->count() > 0,
            'berita_acara_completed' => $beritaAcara !== null,
            'record_completed' => $validatorRecord !== null,
        ];

        return view('validator.assess-v2', compact(
            'form',
            'progress',
            'categories',
            'assessments',
            'categoryComments',
            'agreement',
            'beritaAcara',
            'validatorRecord',
            'isReadOnly'
        ));
    }

    /**
     * Save agreement signature
     */
    public function saveAgreement(Request $request, $formId)
    {
        $request->validate([
            'signature' => 'required|string',
        ]);

        $validator = Auth::user();
        $form = Katsinov::findOrFail($formId);

        // Check read-only status
        if ($form->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Penilaian sudah final dan tidak dapat diubah',
            ], 403);
        }

        // Save signature and update status to under_review
        $form->update([
            'status' => 'under_review',
            'validator_agreement_signature' => $request->signature,
            'validator_agreement_date' => now(),
        ]);

        // Get existing progress to preserve started_at
        $existingProgress = \App\Models\ValidatorProgress::where('form_id', $formId)
            ->where('validator_id', Auth::id())
            ->first();

        // Update ValidatorProgress - keep status as in_review, don't change to in_progress
        $progress = \App\Models\ValidatorProgress::updateOrCreate(
            [
                'form_id' => $formId,
                'validator_id' => Auth::id(),
            ],
            [
                'agreement_completed' => true,
                'status' => $existingProgress && $existingProgress->status !== 'assigned' ? $existingProgress->status : 'in_review',
                'started_at' => $existingProgress->started_at ?? now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Persetujuan berhasil disimpan',
        ]);
    }

    /**
     * Save assessment for specific category
     */
    public function saveAssessment(Request $request, $formId)
    {
        $validator = Auth::user();
        $form = Katsinov::findOrFail($formId);

        // Check read-only status
        if ($form->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Penilaian sudah final dan tidak dapat diubah',
            ], 403);
        }

        $categoryId = $request->category_id;
        $indicators = $request->indicators; // Array of indicator assessments
        $categoryComment = $request->category_comment;

        try {
            DB::beginTransaction();

            // Get IRL number from category (K1 = 1, K2 = 2, etc)
            $irlNumber = (int)str_replace('K', '', 'K' . $categoryId);

            // Save validator assessments to dropdown_value column
            // Do NOT overwrite dosen's score - validator uses separate dropdown_value field
            foreach ($indicators as $indicatorData) {
                // Map validator score (0-5) to dropdown value (A-F)
                $dropdownMapping = [0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D', 4 => 'E', 5 => 'F'];
                $dropdownValue = $dropdownMapping[$indicatorData['validator_score']] ?? null;

                KatsinovResponse::updateOrCreate(
                    [
                        'katsinov_id' => $formId,
                        'indicator_number' => $irlNumber,
                        'row_number' => $indicatorData['row_number'],
                    ],
                    [
                        'dropdown_value' => $dropdownValue,
                        // Keep dosen's score unchanged
                    ]
                );
            }

            // Save category comment
            if ($categoryComment) {
                KatsinovNote::updateOrCreate(
                    [
                        'katsinov_id' => $formId,
                        'indicator_number' => $irlNumber,
                    ],
                    [
                        'notes' => $categoryComment,
                    ]
                );
            }

            // Get existing progress to preserve started_at
            $existingProgress = \App\Models\ValidatorProgress::where('form_id', $formId)
                ->where('validator_id', Auth::id())
                ->first();

            // Update ValidatorProgress - keep status as in_review
            $progress = \App\Models\ValidatorProgress::updateOrCreate(
                [
                    'form_id' => $formId,
                    'validator_id' => Auth::id(),
                ],
                [
                    'status' => $existingProgress && $existingProgress->status !== 'assigned' ? $existingProgress->status : 'in_review',
                    'started_at' => $existingProgress->started_at ?? now(),
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Penilaian berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving assessment: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan penilaian',
            ], 500);
        }
    }

    /**
     * Save Berita Acara
     */
    public function saveBeritaAcara(Request $request, $formId)
    {
        $validator = Auth::user();
        $form = Katsinov::findOrFail($formId);

        // Check read-only status
        if ($form->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Penilaian sudah final dan tidak dapat diubah',
            ], 403);
        }

        try {
            DB::beginTransaction();

            // Map to katsinov_beritas table structure - sesuai dengan format V1
            $signDate = \Carbon\Carbon::parse($request->innovation_date);

            $data = [
                'day' => $request->text_day,
                'date' => $request->text_date,
                'month' => $request->text_month,
                'year' => $request->text_year,
                'yearfull' => $request->text_yearfull,
                'place' => $request->text_place,
                'decree' => $request->text_decree,
                'title' => $request->innovation_title,
                'type' => $request->innovation_type,
                'tki' => $request->innovation_tki,
                'opinion' => $request->innovation_opinion,
                'sign_date' => $signDate,
                'penanggungjawab' => $request->penanggungjawab,
                'ketua' => $request->ketua,
                'anggota1' => $request->anggota1,
                'anggota2' => $request->anggota2,
            ];

            // Handle signature data (base64)
            if ($request->has('penanggungjawab_signature')) {
                $data['penanggungjawab_signature'] = $request->penanggungjawab_signature;
            }

            if ($request->has('ketua_signature')) {
                $data['ketua_signature'] = $request->ketua_signature;
            }

            if ($request->has('anggota1_signature')) {
                $data['anggota1_signature'] = $request->anggota1_signature;
            }

            if ($request->has('anggota2_signature')) {
                $data['anggota2_signature'] = $request->anggota2_signature;
            }

            $beritaAcara = \App\Models\KatsinovBerita::updateOrCreate(
                ['katsinov_id' => $formId],
                $data
            );

            // Get existing progress to preserve started_at
            $existingProgress = \App\Models\ValidatorProgress::where('form_id', $formId)
                ->where('validator_id', Auth::id())
                ->first();

            // Update ValidatorProgress - keep status as in_review
            $progress = \App\Models\ValidatorProgress::updateOrCreate(
                [
                    'form_id' => $formId,
                    'validator_id' => Auth::id(),
                ],
                [
                    'berita_acara_completed' => true,
                    'status' => $existingProgress && $existingProgress->status !== 'assigned' ? $existingProgress->status : 'in_review',
                    'started_at' => $existingProgress->started_at ?? now(),
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berita Acara berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving berita acara: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan berita acara: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * View signature PDF
     */
    public function viewSignature($formId, $type)
    {
        $beritaAcara = \App\Models\KatsinovBerita::where('katsinov_id', $formId)->firstOrFail();

        $filename = null;
        switch ($type) {
            case 'penanggungjawab':
                $filename = $beritaAcara->penanggungjawab_pdf;
                break;
            case 'ketua':
                $filename = $beritaAcara->ketua_pdf;
                break;
            case 'anggota1':
                $filename = $beritaAcara->anggota1_pdf;
                break;
            case 'anggota2':
                $filename = $beritaAcara->anggota2_pdf;
                break;
        }

        if (!$filename) {
            abort(404, 'File tidak ditemukan');
        }

        $path = storage_path('app/public/katsinov/signatures/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file($path);
    }

    /**
     * Save Validator Record (Record Hasil Pengukuran)
     */
    public function saveValidatorRecord(Request $request, $formId)
    {
        $validator = Auth::user();
        $form = Katsinov::findOrFail($formId);

        // Check read-only status
        if ($form->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Penilaian sudah final dan tidak dapat diubah',
            ], 403);
        }

        try {
            DB::beginTransaction();

            $data = [
                'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
                'institusi' => $request->institusi,
                'judul_inovasi' => $request->judul_inovasi,
                'jenis_inovasi' => $request->jenis_inovasi,
                'alamat_kontak' => $request->alamat_kontak,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'tanggal_penilaian' => $request->tanggal_penilaian,
            ];

            // Add detail data dynamically (up to 5 rows)
            for ($i = 1; $i <= 5; $i++) {
                $data["aspek_$i"] = $request->{"aspek_$i"} ?? '';
                $data["aktivitas_$i"] = $request->{"aktivitas_$i"} ?? '';
                $data["capaian_$i"] = $request->{"capaian_$i"} ?? 0;
                $data["keterangan_$i"] = $request->{"keterangan_$i"} ?? '';
                $data["catatan_$i"] = $request->{"catatan_$i"} ?? '';
            }

            $validatorRecord = \App\Models\FormRecordHasilPengukuran::updateOrCreate(
                ['katsinov_id' => $formId],
                $data
            );

            // Get existing progress to preserve started_at
            $existingProgress = \App\Models\ValidatorProgress::where('form_id', $formId)
                ->where('validator_id', Auth::id())
                ->first();

            // Update ValidatorProgress - keep status as in_review
            $progress = \App\Models\ValidatorProgress::updateOrCreate(
                [
                    'form_id' => $formId,
                    'validator_id' => Auth::id(),
                ],
                [
                    'record_completed' => true,
                    'status' => $existingProgress && $existingProgress->status !== 'assigned' ? $existingProgress->status : 'in_review',
                    'started_at' => $existingProgress->started_at ?? now(),
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Record Hasil Pengukuran berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving validator record: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan record: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get progress status
     */
    public function getProgress($formId)
    {
        $validator = Auth::user();
        $form = Katsinov::findOrFail($formId);

        $assessments = KatsinovResponse::where('katsinov_id', $formId)->count();
        $beritaAcara = KatsinovBerita::where('katsinov_id', $formId)->exists();
        $record = FormRecordHasilPengukuran::where('katsinov_id', $formId)->exists();

        return response()->json([
            'success' => true,
            'data' => [
                'agreement_completed' => $form->status === 'under_review' || $form->status === 'completed',
                'assessment_completed' => $assessments > 0,
                'berita_acara_completed' => $beritaAcara,
                'record_completed' => $record,
                'all_completed' => $form->status === 'completed',
                'can_submit' => $assessments > 0 && $beritaAcara && $record,
                'is_read_only' => $form->status === 'completed',
                'status' => $form->status,
            ],
        ]);
    }

    /**
     * Submit final assessment
     */
    public function submit(Request $request, $formId)
    {
        $validator = Auth::user();
        $form = Katsinov::findOrFail($formId);

        // Check if already submitted
        if ($form->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Penilaian sudah disubmit sebelumnya',
            ], 400);
        }

        // Check if can submit
        $assessments = KatsinovResponse::where('katsinov_id', $formId)->count();
        $beritaAcara = KatsinovBerita::where('katsinov_id', $formId)->exists();
        $record = FormRecordHasilPengukuran::where('katsinov_id', $formId)->exists();
        $hasAgreement = !empty($form->validator_agreement_signature);

        if ($assessments === 0 || !$beritaAcara || !$record || !$hasAgreement) {
            return response()->json([
                'success' => false,
                'message' => 'Lengkapi semua bagian sebelum submit',
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Update form status to completed
            $form->update([
                'status' => 'completed',
                'reviewed_at' => now(),
            ]);

            // Get existing progress to preserve started_at
            $existingProgress = \App\Models\ValidatorProgress::where('form_id', $formId)
                ->where('validator_id', Auth::id())
                ->first();

            // Determine started_at value
            $startedAt = now(); // Default to now
            if ($existingProgress && $existingProgress->started_at) {
                $startedAt = $existingProgress->started_at;
            }

            // Update ValidatorProgress to completed
            $progress = \App\Models\ValidatorProgress::updateOrCreate(
                [
                    'form_id' => $formId,
                    'validator_id' => Auth::id(),
                ],
                [
                    'agreement_completed' => true,
                    'assessment_completed' => true,
                    'berita_acara_completed' => true,
                    'record_completed' => true,
                    'all_completed' => true,
                    'status' => 'completed',
                    'submitted_at' => now(),
                    'started_at' => $startedAt,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Penilaian berhasil disubmit. Semua data sekarang dalam mode read-only.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submitting assessment: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal submit penilaian: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Save draft (auto-save)
     */
    public function saveDraft(Request $request, $formId)
    {
        $validator = Auth::user();
        $form = Katsinov::findOrFail($formId);

        // Check read-only status
        if ($form->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Penilaian sudah final dan tidak dapat diubah',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Draft disimpan',
        ]);
    }

    /**
     * Preview lampiran file
     */
    public function previewLampiran($formId, $lampiranId)
    {
        $validator = Auth::user();
        $form = Katsinov::findOrFail($formId);

        // Check if validator is assigned to this form
        if ($form->reviewer_id !== $validator->id) {
            abort(403, 'Unauthorized access');
        }

        $lampiran = KatsinovLampiran::where('id', $lampiranId)
            ->where('katsinov_id', $formId)
            ->firstOrFail();

        // Try different path formats
        $possiblePaths = [
            storage_path('app/public/' . $lampiran->path),
            storage_path('app/' . $lampiran->path),
            public_path('storage/' . $lampiran->path),
        ];

        $filePath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $filePath = $path;
                break;
            }
        }

        if (!$filePath) {
            Log::error('File not found for lampiran', [
                'lampiran_id' => $lampiranId,
                'path' => $lampiran->path,
                'tried_paths' => $possiblePaths
            ]);
            abort(404, 'File not found: ' . basename($lampiran->path));
        }

        $mimeType = mime_content_type($filePath);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($lampiran->path) . '"'
        ]);
    }

    /**
     * Display full report of validator assessment
     */
    public function fullReport($formId)
    {
        $validator = Auth::user();
        $form = Katsinov::with([
            'responses',
            'notes',
            'reviewer',
            'user',
            'scores',
            'katsinovInovasis',
            'katsinovLampirans',
            'katsinovInformasis',
            'katsinovBeritas',
            'formRecordHasilPengukuran'
        ])->findOrFail($formId);

        // Check if validator is assigned to this form OR user is admin_inovasi
        if ($form->reviewer_id !== $validator->id && !in_array($validator->role, ['admin_inovasi', 'admin_direktorat'])) {
            abort(403, 'Unauthorized access');
        }

        // Load questions data for displaying indicator descriptions
        $allQuestions = include(resource_path('views/admin/katsinov_v2/includes/indicator_questions.php'));

        // Get all responses grouped by indicator (IRL/KATSINOV number)
        $responsesByIndicator = [];
        for ($i = 1; $i <= 6; $i++) {
            $responses = $form->responses()
                ->where('indicator_number', $i)
                ->orderBy('row_number')
                ->get();

            if ($responses->count() > 0) {
                $responsesByIndicator[$i] = $responses;
            }
        }

        // Get validator assessment data (grouped by IRL categories)
        $categories = KatsinovCategory::with('indicators')->get();
        
        // Get assessments grouped by IRL number
        $assessments = KatsinovResponse::where('katsinov_id', $formId)
            ->get()
            ->groupBy('indicator_number');

        // Get category comments
        $categoryComments = KatsinovNote::where('katsinov_id', $formId)
            ->get()
            ->keyBy('indicator_number');

        // Get informasi dasar
        $informasi = $form->katsinovInformasis->first();

        // Get informasi collection data (team, program, partners, etc.)
        $informasiCollection = [];
        if ($informasi) {
            $collectionData = \App\Models\KatsinovInformasiCollection::where('katsinov_informasi_id', $informasi->id)
                ->get(['field', 'index', 'attribute', 'value'])
                ->toArray();

            foreach ($collectionData as $item) {
                $field = $item['field'];
                $index = $item['index'];

                if (!isset($informasiCollection[$field][$index])) {
                    $informasiCollection[$field][$index] = [];
                }
                $informasiCollection[$field][$index][$item['attribute']] = $item['value'];
            }
        }

        // Get lampiran
        $lampiran = $form->katsinovLampirans;

        // Get berita acara
        $beritaAcara = $form->katsinovBeritas->first();

        // Get record hasil pengukuran
        $recordHasil = $form->formRecordHasilPengukuran;

        // Get informasi inovasi
        $inovasiInfo = $form->katsinovInovasis->first();

        // Get validator record
        $validatorRecord = FormRecordHasilPengukuran::where('katsinov_id', $formId)->first();

        return view('validator.full_report_validator', compact(
            'form',
            'allQuestions',
            'responsesByIndicator',
            'categories',
            'assessments',
            'categoryComments',
            'informasi',
            'informasiCollection',
            'lampiran',
            'beritaAcara',
            'recordHasil',
            'inovasiInfo',
            'validatorRecord'
        ));
    }

    /**
     * Show validator summary with charts
     */
    public function validatorSummary($formId)
    {
        $validator = Auth::user();
        $katsinov = Katsinov::with(['responses', 'notes', 'reviewer'])->findOrFail($formId);

        // Check if validator is assigned to this form OR user is admin_inovasi
        if ($katsinov->reviewer_id !== $validator->id && !in_array($validator->role, ['admin_inovasi', 'admin_direktorat'])) {
            abort(403, 'Unauthorized access');
        }

        // Load questions data
        $allQuestions = include(resource_path('views/admin/katsinov_v2/includes/indicator_questions.php'));

        // Total rows per indicator
        $totalRowsPerIndicator = [1 => 22, 2 => 21, 3 => 21, 4 => 22, 5 => 24, 6 => 14];

        // Dropdown to score mapping
        $dropdownMap = [
            'A' => 0,
            'B' => 1,
            'C' => 2,
            'D' => 3,
            'E' => 4,
            'F' => 5,
        ];

        // Calculate indicator scores - ONLY for indicators with data
        $indicatorScores = [];
        for ($i = 1; $i <= 6; $i++) {
            $responses = $katsinov->responses()->where('indicator_number', $i)->get();

            // Skip if no data for this indicator
            if ($responses->count() === 0) {
                continue;
            }

            // Convert dropdown_value to score and sum
            $totalScore = 0;
            foreach ($responses as $response) {
                $score = $dropdownMap[$response->dropdown_value] ?? 0;
                $totalScore += $score;
            }

            $totalRows = $totalRowsPerIndicator[$i];
            $maxScore = $totalRows * 5;
            $percentage = $totalRows > 0 ? ($totalScore / $maxScore) * 100 : 0;

            $indicatorScores[$i] = [
                'score' => $totalScore,
                'max_score' => $maxScore,
                'percentage' => $percentage,
                'total_rows' => $totalRows,
                'status' => $percentage >= 80 ? 'excellent' : ($percentage >= 60 ? 'good' : 'poor')
            ];
        }

        // Calculate overall average
        $overallAverage = collect($indicatorScores)->avg('percentage');

        // Calculate aspect scores (for overall chart)
        $aspectMap = [
            'T' => 'technology',
            'M' => 'market',
            'O' => 'organization',
            'Mf' => 'manufacturing',
            'P' => 'partnership',
            'I' => 'investment',
            'R' => 'risk'
        ];

        $overallAspectScores = [];
        foreach ($aspectMap as $code => $name) {
            $responses = $katsinov->responses()->where('aspect', $code)->get();
            
            // Convert dropdown_value to score and sum
            $totalScore = 0;
            foreach ($responses as $response) {
                $score = $dropdownMap[$response->dropdown_value] ?? 0;
                $totalScore += $score;
            }
            
            $totalRows = $responses->count();
            $maxScore = $totalRows * 5;
            $percentage = $totalRows > 0 ? ($totalScore / $maxScore) * 100 : 0;
            $overallAspectScores[$name] = round($percentage, 2);
        }

        // Calculate indicator-aspect scores (for spider charts)
        $indicatorAspectScores = [];
        for ($i = 1; $i <= 6; $i++) {
            $indicatorAspectScores[$i] = [];
            foreach ($aspectMap as $code => $name) {
                $responses = $katsinov->responses()
                    ->where('indicator_number', $i)
                    ->where('aspect', $code)
                    ->get();
                
                // Convert dropdown_value to score and sum
                $totalScore = 0;
                foreach ($responses as $response) {
                    $score = $dropdownMap[$response->dropdown_value] ?? 0;
                    $totalScore += $score;
                }
                
                $totalRows = $responses->count();
                $maxScore = $totalRows * 5;
                $percentage = $totalRows > 0 ? ($totalScore / $maxScore) * 100 : 0;
                $indicatorAspectScores[$i][$name] = round($percentage, 2);
            }
        }

        // Calculate question scores (for detailed view) with question texts
        $questionScores = [];
        $questionTexts = [];
        foreach ($indicatorScores as $i => $data) {
            $questionScores[$i] = [];
            $questionTexts[$i] = [];

            foreach ($aspectMap as $code => $name) {
                $responses = $katsinov->responses()
                    ->where('indicator_number', $i)
                    ->where('aspect', $code)
                    ->orderBy('row_number')
                    ->get();

                // Get question texts for this indicator and aspect
                $aspectQuestions = collect($allQuestions[$i] ?? [])->filter(function ($q) use ($code) {
                    return $q['aspect'] === $code;
                })->values();

                // Convert dropdown_value to score for each question
                $scores = [];
                foreach ($responses as $response) {
                    $score = $dropdownMap[$response->dropdown_value] ?? 0;
                    $scores[] = $score;
                }

                $questionScores[$i][$name] = $scores;
                $questionTexts[$i][$name] = $aspectQuestions->pluck('desc')->toArray();
            }
        }

        // Convert to JSON for JavaScript
        $overallAspectScoresJson = json_encode($overallAspectScores);
        $indicatorAspectScoresJson = json_encode($indicatorAspectScores);
        $questionScoresJson = json_encode($questionScores);

        return view('validator.summaryvalidator', compact(
            'katsinov',
            'indicatorScores',
            'overallAverage',
            'overallAspectScores',
            'indicatorAspectScores',
            'questionScores',
            'questionTexts',
            'overallAspectScoresJson',
            'indicatorAspectScoresJson',
            'questionScoresJson'
        ));
    }
}
