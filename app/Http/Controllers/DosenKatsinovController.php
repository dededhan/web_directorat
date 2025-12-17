<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Katsinov;
use App\Models\KatsinovInformasi;
use App\Models\KatsinovInformasiCollection;
use App\Models\KatsinovInovasi;
use App\Models\KatsinovLampiran;
use App\Models\KatsinovNote;
use Illuminate\Http\Request;
use App\Models\KatsinovScore;
use App\Models\KatsinovResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class DosenKatsinovController extends Controller
{
    /**
     * Display a listing of the resource - DOSEN ONLY SEE THEIR OWN
     */
    public function index()
    {
        $user = Auth::user();
        $katsinovs = $user->katsinovs()->with('scores', 'user', 'reviewer')->latest()->paginate(20);
        $reviewers = User::whereIn('role', ['validator'])->get();

        return view('subdirektorat-inovasi.dosen.katsinov_v2.index', compact('katsinovs', 'reviewers'));
    }

    /**
     * Show the form for creating a new resource - DOSEN CAN CREATE
     */
    public function create()
    {
        $setting = Setting::first();
        
        $thresholds = [
            1 => $setting ? $setting->threshold_indicator_1 : 80.0,
            2 => $setting ? $setting->threshold_indicator_2 : 80.0,
            3 => $setting ? $setting->threshold_indicator_3 : 80.0,
            4 => $setting ? $setting->threshold_indicator_4 : 80.0,
            5 => $setting ? $setting->threshold_indicator_5 : 80.0,
            6 => $setting ? $setting->threshold_indicator_6 : 80.0,
        ];

        return view('subdirektorat-inovasi.dosen.katsinov_v2.form_main', [
            'katsinov' => null,
            'indicatorOne' => collect([]),
            'indicatorTwo' => collect([]),
            'indicatorThree' => collect([]),
            'indicatorFour' => collect([]),
            'indicatorFive' => collect([]),
            'indicatorSix' => collect([]),
            'thresholds' => $thresholds,
        ]);
    }

    /**
     * Store a newly created resource in storage - DOSEN CAN STORE
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'project_name' => 'nullable|string|max:255',
                'focus_area' => 'nullable|string|max:255',
                'institution' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'contact' => 'nullable|string|max:255',
                'assessment_date' => 'nullable|string',
                'responses' => 'sometimes|nullable|array',
                'responses.*.indicator' => 'required|integer|min:1|max:6',
                'responses.*.row' => 'required|integer',
                'responses.*.aspect' => 'required|string',
                'responses.*.score' => 'required|integer|min:0|max:5',
                'responses.*.dropdown' => 'nullable|string',
                'notes' => 'nullable',
                'save_as_draft' => 'nullable|boolean',
            ]);

            $user = Auth::user();
            
            // Set default values for required fields if not provided
            $validated['user_id'] = $user->id;
            $validated['status'] = 'draft';
            $validated['institution'] = $validated['institution'] ?? '-';
            $validated['address'] = $validated['address'] ?? '-';
            $validated['contact'] = $validated['contact'] ?? '-';
            $validated['assessment_date'] = $validated['assessment_date'] ?? now()->format('Y-m-d');

            $katsinov = Katsinov::create($validated);

            // Process form responses if any
            if ($request->has('responses')) {
                $this->saveResponses($katsinov, $request->input('responses'));
                $this->calculateScores($katsinov);
            }

            DB::commit();

            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'id' => $katsinov->id,
                    'message' => 'Katsinov berhasil dibuat. Status: DRAFT'
                ]);
            }

            return redirect()
                ->route('subdirektorat-inovasi.dosen.katsinov-v2.show', $katsinov->id)
                ->with('success', 'Katsinov berhasil dibuat. Status: DRAFT');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating katsinov: ' . $e->getMessage());
            
            // Return JSON error for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat katsinov: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()->with('error', 'Gagal membuat katsinov: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource - DOSEN CAN VIEW THEIR OWN
     */
    public function show($id)
    {
        $katsinov = Katsinov::where('id', $id)
            ->with(['scores', 'responses', 'notes', 'reviewer', 'user'])
            ->firstOrFail();

        // Check if this katsinov belongs to the current user
        if ($katsinov->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notes = $katsinov->notes->pluck('notes', 'indicator_number')->toArray();
        $setting = Setting::where('key', 'katsinov_threshold')->first();
        $minPercentage = $setting ? $setting->value : 80.0;

        $data = [
            'katsinov' => $katsinov,
            'indicatorOne' => $katsinov->responses()->where('indicator_number', 1)->get(),
            'indicatorTwo' => $katsinov->responses()->where('indicator_number', 2)->get(),
            'indicatorThree' => $katsinov->responses()->where('indicator_number', 3)->get(),
            'indicatorFour' => $katsinov->responses()->where('indicator_number', 4)->get(),
            'indicatorFive' => $katsinov->responses()->where('indicator_number', 5)->get(),
            'indicatorSix' => $katsinov->responses()->where('indicator_number', 6)->get(),
            'notes' => $notes,
            'min_percentage_js' => $minPercentage
        ];

        return view('subdirektorat-inovasi.dosen.katsinov_v2.show', $data);
    }

    /**
     * Show the form for editing - ONLY FOR DRAFT STATUS
     */
    public function edit($id)
    {
        $katsinov = Katsinov::with(['responses', 'notes'])->findOrFail($id);

        // Check ownership and draft status
        if ($katsinov->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($katsinov->status !== 'draft') {
            return redirect()
                ->route('subdirektorat-inovasi.dosen.katsinov-v2.show', $id)
                ->with('error', 'Hanya Katsinov dengan status DRAFT yang dapat diedit.');
        }

        // Group responses by indicator
        $indicatorOne = $katsinov->responses()->where('indicator_number', 1)->get();
        $indicatorTwo = $katsinov->responses()->where('indicator_number', 2)->get();
        $indicatorThree = $katsinov->responses()->where('indicator_number', 3)->get();
        $indicatorFour = $katsinov->responses()->where('indicator_number', 4)->get();
        $indicatorFive = $katsinov->responses()->where('indicator_number', 5)->get();
        $indicatorSix = $katsinov->responses()->where('indicator_number', 6)->get();

        $setting = Setting::first();
        
        // Get thresholds per indicator
        $thresholds = [
            1 => $setting ? $setting->threshold_indicator_1 : 80.0,
            2 => $setting ? $setting->threshold_indicator_2 : 80.0,
            3 => $setting ? $setting->threshold_indicator_3 : 80.0,
            4 => $setting ? $setting->threshold_indicator_4 : 80.0,
            5 => $setting ? $setting->threshold_indicator_5 : 80.0,
            6 => $setting ? $setting->threshold_indicator_6 : 80.0,
        ];

        return view('subdirektorat-inovasi.dosen.katsinov_v2.form_main', [
            'katsinov' => $katsinov,
            'indicatorOne' => $indicatorOne,
            'indicatorTwo' => $indicatorTwo,
            'indicatorThree' => $indicatorThree,
            'indicatorFour' => $indicatorFour,
            'indicatorFive' => $indicatorFive,
            'indicatorSix' => $indicatorSix,
            'thresholds' => $thresholds,
        ]);
    }

    /**
     * Update the specified resource - ONLY FOR DRAFT
     */
    public function update(Request $request, $id)
    {
        try {
            $katsinov = Katsinov::findOrFail($id);

            // Check ownership and draft status
            if ($katsinov->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            if ($katsinov->status !== 'draft') {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Hanya Katsinov dengan status DRAFT yang dapat diedit.'
                    ], 403);
                }
                return back()->with('error', 'Hanya Katsinov dengan status DRAFT yang dapat diedit.');
            }

            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'project_name' => 'nullable|string|max:255',
                'focus_area' => 'nullable|string|max:255',
                'institution' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'contact' => 'nullable|string|max:255',
                'assessment_date' => 'nullable|string',
                'responses' => 'sometimes|nullable|array',
                'responses.*.indicator' => 'required|integer|min:1|max:6',
                'responses.*.row' => 'required|integer',
                'responses.*.aspect' => 'required|string',
                'responses.*.score' => 'required|integer|min:0|max:5',
                'responses.*.dropdown' => 'nullable|string',
                'notes' => 'nullable',
                'save_as_draft' => 'nullable|boolean',
            ]);
            
            // Set default values for required fields if not provided
            $validated['institution'] = $validated['institution'] ?? $katsinov->institution ?? '-';
            $validated['address'] = $validated['address'] ?? $katsinov->address ?? '-';
            $validated['contact'] = $validated['contact'] ?? $katsinov->contact ?? '-';
            $validated['assessment_date'] = $validated['assessment_date'] ?? $katsinov->assessment_date ?? now()->format('Y-m-d');

            $katsinov->update($validated);

            if ($request->has('responses')) {
                KatsinovResponse::where('katsinov_id', $katsinov->id)->delete();
                $this->saveResponses($katsinov, $request->input('responses'));
                $this->calculateScores($katsinov);
            }

            DB::commit();

            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'id' => $katsinov->id,
                    'message' => 'Katsinov berhasil diperbarui'
                ]);
            }

            return redirect()
                ->route('subdirektorat-inovasi.dosen.katsinov-v2.show', $katsinov->id)
                ->with('success', 'Katsinov berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating katsinov: ' . $e->getMessage());
            
            // Return JSON error for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui katsinov: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()->with('error', 'Gagal memperbarui katsinov: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource - ONLY FOR DRAFT
     */
    public function destroy($id)
    {
        try {
            $katsinov = Katsinov::findOrFail($id);

            // Check ownership and draft status
            if ($katsinov->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            if ($katsinov->status !== 'draft') {
                return back()->with('error', 'Hanya Katsinov dengan status DRAFT yang dapat dihapus.');
            }

            $katsinov->delete();

            return redirect()
                ->route('subdirektorat-inovasi.dosen.katsinov-v2.index')
                ->with('success', 'Katsinov berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Error deleting katsinov: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus katsinov: ' . $e->getMessage());
        }
    }

    /**
     * FORM PENDUKUNG - Form Inovasi (Judul)
     */
    public function formInovasiIndex($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);

        if ($katsinov->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $inovasi = $katsinov->katsinovInovasis()->first();

        return view('subdirektorat-inovasi.dosen.katsinov_v2.form_inovasi', compact('katsinov', 'inovasi'));
    }

    public function formInovasiStore(Request $request, $katsinov_id)
    {
        try {
            $katsinov = Katsinov::findOrFail($katsinov_id);

            if ($katsinov->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $isDraft = $request->has('save_as_draft');
        
            $validatedData = $request->validate([
                'title' => $isDraft ? 'nullable|string' : 'required|string',
                'sub_title' => $isDraft ? 'nullable|string' : 'required|string',
                'introduction' => $isDraft ? 'nullable|string' : 'required|string',
                'tech_product' => $isDraft ? 'nullable|string' : 'required|string',
                'supremacy' => $isDraft ? 'nullable|string' : 'required|string',
                'patent' => $isDraft ? 'nullable|string' : 'required|string',
                'tech_preparation' => $isDraft ? 'nullable|string' : 'required|string',
                'market_preparation' => $isDraft ? 'nullable|string' : 'required|string',
                'name' => $isDraft ? 'nullable|string' : 'required|string',
                'phone' => $isDraft ? 'nullable|string' : 'required|string',
                'mobile' => $isDraft ? 'nullable|string' : 'required|string',
                'fax' => $isDraft ? 'nullable|string' : 'required|string',
                'email' => $isDraft ? 'nullable|email' : 'required|email',
            ]);

            KatsinovInovasi::updateOrCreate(
                ['katsinov_id' => $katsinov_id],
                $validatedData
            );

            return redirect()
                ->route('subdirektorat-inovasi.dosen.katsinov-v2.show', $katsinov_id)
                ->with('success', 'Form Inovasi berhasil disimpan');

        } catch (\Exception $e) {
            Log::error('Error saving form inovasi: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * FORM PENDUKUNG - Form Lampiran
     */
    public function formLampiranIndex($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);

        if ($katsinov->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $lampiranFiles = KatsinovLampiran::where('katsinov_id', $katsinov_id)->get();
        
        // Group lampiran by type and category for easier access in view
        $lampiran = [];
        foreach ($lampiranFiles as $file) {
            $lampiran[$file->type][$file->category] = $file;
        }

        return view('subdirektorat-inovasi.dosen.katsinov_v2.form_lampiran', compact('katsinov', 'lampiran'));
    }

    public function formLampiranStore(Request $request, $katsinov_id)
    {
        try {
            $katsinov = Katsinov::findOrFail($katsinov_id);

            if ($katsinov->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            // Validate with optional files (not required)
            $request->validate([
                'aspek_teknologi' => ['nullable', 'array'],
                'aspek_teknologi.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:51200'],
                'aspek_pasar' => ['nullable', 'array'],
                'aspek_pasar.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:51200'],
                'aspek_organisasi' => ['nullable', 'array'],
                'aspek_organisasi.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:51200'],
                'aspek_mitra' => ['nullable', 'array'],
                'aspek_mitra.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:51200'],
                'aspek_risiko' => ['nullable', 'array'],
                'aspek_risiko.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:51200'],
                'aspek_manufaktur' => ['nullable', 'array'],
                'aspek_manufaktur.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:51200'],
                'aspek_investasi' => ['nullable', 'array'],
                'aspek_investasi.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:51200'],
            ]);

            DB::beginTransaction();

            $basePath = 'lampiran_katsinov';
            $now = now();
            $data_files = [];

            $aspekTypes = [
                'aspek_teknologi',
                'aspek_pasar',
                'aspek_organisasi',
                'aspek_mitra',
                'aspek_risiko',
                'aspek_manufaktur',
                'aspek_investasi',
            ];

            foreach ($aspekTypes as $aspect) {
                if ($request->has($aspect) && is_array($request->file($aspect))) {
                    $categories = $request->file($aspect);
                    
                    foreach ($categories as $category => $file) {
                        if ($file && $file->isValid()) {
                            $extension = $file->getClientOriginalExtension();
                            $fileName = "{$aspect}_{$category}_{$now->timestamp}.{$extension}";

                            // Store file
                            $path = $file->storeAs(
                                "$basePath/$aspect",
                                $fileName,
                                'public'
                            );

                            // Delete old file if exists
                            $existingFile = KatsinovLampiran::where([
                                'katsinov_id' => $katsinov_id,
                                'type' => $aspect,
                                'category' => $category
                            ])->first();

                            if ($existingFile && Storage::disk('public')->exists($existingFile->path)) {
                                Storage::disk('public')->delete($existingFile->path);
                                $existingFile->delete();
                            }

                            $data_files[] = [
                                'path' => $path,
                                'category' => $category,
                                'type' => $aspect,
                                'katsinov_id' => $katsinov_id,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }
                }
            }

            // Bulk insert
            if (!empty($data_files)) {
                KatsinovLampiran::insert($data_files);
            }

            DB::commit();

            return redirect()
                ->route('subdirektorat-inovasi.dosen.katsinov-v2.show', $katsinov_id)
                ->with('success', 'Form Lampiran berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving form lampiran: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Delete a specific lampiran file
     */
    public function deleteLampiran($katsinov_id, $lampiran_id)
    {
        try {
            $katsinov = Katsinov::findOrFail($katsinov_id);

            if ($katsinov->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            $lampiran = KatsinovLampiran::where('id', $lampiran_id)
                ->where('katsinov_id', $katsinov_id)
                ->firstOrFail();

            // Delete file from storage
            if (Storage::disk('public')->exists($lampiran->path)) {
                Storage::disk('public')->delete($lampiran->path);
            }

            // Delete database record
            $lampiran->delete();

            return response()->json([
                'success' => true,
                'message' => 'File berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting lampiran: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Preview a lampiran file (display PDF inline)
     */
    public function previewLampiran($katsinov_id, $lampiran_id)
    {
        try {
            // Simple authorization check
            $user = Auth::user();
            if (!$user) {
                abort(403, 'Not authenticated');
            }

            // Get lampiran
            $lampiran = KatsinovLampiran::findOrFail($lampiran_id);
            
            // Build file path
            $filePath = storage_path('app/public/' . $lampiran->path);
            
            // Check if file exists
            if (!file_exists($filePath)) {
                // Return debug info
                return response()->json([
                    'error' => 'File not found',
                    'path' => $lampiran->path,
                    'full_path' => $filePath,
                    'directory_exists' => is_dir(dirname($filePath)),
                    'directory_contents' => is_dir(dirname($filePath)) ? scandir(dirname($filePath)) : []
                ], 404);
            }

            // Get file info
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $mimeType = mime_content_type($filePath);
            
            // Return file
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => ($extension === 'pdf' ? 'inline' : 'attachment') . '; filename="' . basename($filePath) . '"'
            ]);

        } catch (\Exception $e) {
            // Return error details
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => explode("\n", $e->getTraceAsString())
            ], 500);
        }
    }

    /**
     * FORM PENDUKUNG - Form Informasi Dasar
     */
    public function formInformasiDasarIndex($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);

        if ($katsinov->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $informasi = KatsinovInformasi::where('katsinov_id', $katsinov_id)->first();
        
        // Load additional data from collections
        $informasi_team = null;
        $informasi_program = null;
        $informasi_partner = null;
        $informasi_tech = [];
        $informasi_market = [];

        if ($informasi) {
            $collections = KatsinovInformasiCollection::where('katsinov_informasi_id', $informasi->id)->get();
            
            // Group collections by field and index
            $grouped = [];
            foreach ($collections as $collection) {
                $grouped[$collection->field][$collection->index][$collection->attribute] = $collection->value;
            }
            
            // Map grouped data to view variables
            if (isset($grouped['team'])) {
                $informasi_team = array_values($grouped['team']);
            }
            if (isset($grouped['program_implementation'])) {
                $informasi_program = array_values($grouped['program_implementation']);
            }
            if (isset($grouped['innovation_partner'])) {
                $informasi_partner = array_values($grouped['innovation_partner']);
            }
            if (isset($grouped['information_tech'])) {
                $informasi_tech = $grouped['information_tech'];
            }
            if (isset($grouped['information_market'])) {
                $informasi_market = $grouped['information_market'];
            }
        }

        return view('subdirektorat-inovasi.dosen.katsinov_v2.form_informasi_dasar', compact('katsinov', 'informasi', 'informasi_team', 'informasi_program', 'informasi_partner', 'informasi_tech', 'informasi_market'));
    }

    public function formInformasiDasarStore(Request $request, $katsinov_id)
    {
        try {
            $katsinov = Katsinov::findOrFail($katsinov_id);

            if ($katsinov->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            // Check if draft or final
            $isDraft = $request->has('save_as_draft');
            
            // Conditional validation based on draft status
            $rules = [
                'pic' => $isDraft ? 'nullable|string' : 'required|string',
                'institution' => $isDraft ? 'nullable|string' : 'required|string',
                'address' => $isDraft ? 'nullable|string' : 'required|string',
                'phone' => $isDraft ? 'nullable|string' : 'required|string',
                'fax' => 'nullable|string',
                'innovation_title' => $isDraft ? 'nullable|string' : 'required|string',
                'innovation_name' => $isDraft ? 'nullable|string' : 'required|string',
                'innovation_type' => $isDraft ? 'nullable|string' : 'required|string',
                'innovation_field' => $isDraft ? 'nullable|string' : 'required|string',
                'innovation_application' => $isDraft ? 'nullable|string' : 'required|string',
                'innovation_duration' => 'nullable|string',
                'innovation_year' => 'nullable|string',
                'innovation_summary' => 'nullable|string',
                'innovation_novelty' => 'nullable|string',
                'innovation_supremacy' => 'nullable|string',
                'team' => 'nullable|array',
                'program_implementation' => 'nullable|array',
                'innovation_partner' => 'nullable|array',
                'information_tech' => 'nullable|array',
                'information_market' => 'nullable|array',
            ];
            
            $validated = $request->validate($rules);

            DB::beginTransaction();

            // Save main informasi data
            $informasiData = [
                'pic' => $validated['pic'] ?? '',
                'institution' => $validated['institution'] ?? '',
                'address' => $validated['address'] ?? '',
                'phone' => $validated['phone'] ?? '',
                'fax' => $validated['fax'] ?? '',
                'innovation_title' => $validated['innovation_title'] ?? '',
                'innovation_name' => $validated['innovation_name'] ?? '',
                'innovation_type' => $validated['innovation_type'] ?? '',
                'innovation_field' => $validated['innovation_field'] ?? '',
                'innovation_application' => $validated['innovation_application'] ?? '',
                'innovation_duration' => $validated['innovation_duration'] ?? '',
                'innovation_year' => $validated['innovation_year'] ?? '',
                'innovation_summary' => $validated['innovation_summary'] ?? '',
                'innovation_novelty' => $validated['innovation_novelty'] ?? '',
                'innovation_supremacy' => $validated['innovation_supremacy'] ?? '',
                'katsinov_id' => $katsinov_id,
            ];

            $informasi = KatsinovInformasi::updateOrCreate(
                ['katsinov_id' => $katsinov_id],
                $informasiData
            );

            // Save collection data (team, tech, market, etc.)
            if ($informasi) {
                // Delete old collection data
                KatsinovInformasiCollection::where('katsinov_informasi_id', $informasi->id)->delete();
                
                $collectionData = [];
                $collectionFields = ['team', 'program_implementation', 'innovation_partner', 'information_tech', 'information_market'];
                
                foreach ($collectionFields as $field) {
                    if (isset($validated[$field]) && is_array($validated[$field])) {
                        foreach ($validated[$field] as $index => $items) {
                            if (is_array($items)) {
                                foreach ($items as $attribute => $value) {
                                    if (!empty($value)) {
                                        $collectionData[] = [
                                            'katsinov_informasi_id' => $informasi->id,
                                            'field' => $field,
                                            'index' => $index,
                                            'attribute' => $attribute,
                                            'value' => $value,
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ];
                                    }
                                }
                            }
                        }
                    }
                }
                
                if (!empty($collectionData)) {
                    KatsinovInformasiCollection::insert($collectionData);
                }
            }

            DB::commit();

            $message = $isDraft ? 'Draft berhasil disimpan' : 'Form Informasi Dasar berhasil disimpan';

            return redirect()
                ->route('subdirektorat-inovasi.dosen.katsinov-v2.show', $katsinov_id)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving form informasi dasar: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Submit for Review - Change status from DRAFT to SUBMITTED
     */
    public function submitForReview(Request $request, $id)
    {
        try {
            $katsinov = Katsinov::findOrFail($id);

            if ($katsinov->user_id !== Auth::id()) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized action.'
                    ], 403);
                }
                abort(403, 'Unauthorized action.');
            }

            if ($katsinov->status !== 'draft') {
                $message = 'Hanya Katsinov dengan status DRAFT yang dapat disubmit.';
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                return back()->with('error', $message);
            }

            // Check if required forms are filled
            $inovasi = KatsinovInovasi::where('katsinov_id', $id)->first();
            $lampiran = KatsinovLampiran::where('katsinov_id', $id)->first();
            $informasi = KatsinovInformasi::where('katsinov_id', $id)->first();

            if (!$inovasi || !$lampiran || !$informasi) {
                $message = 'Mohon lengkapi semua form pendukung (Inovasi, Lampiran, Informasi Dasar) sebelum submit.';
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                return back()->with('error', $message);
            }

            $katsinov->update([
                'status' => 'submitted',
                'submitted_at' => now()
            ]);

            $message = 'Katsinov berhasil disubmit untuk review. Status: SUBMITTED';
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()
                ->route('subdirektorat-inovasi.dosen.katsinov-v2.show', $id)
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Error submitting katsinov: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal submit katsinov: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal submit katsinov: ' . $e->getMessage());
        }
    }

    /**
     * View Full Report - READ ONLY
     */
    public function fullReport($katsinov_id)
    {
        $katsinov = Katsinov::with(['scores', 'user', 'reviewer', 'responses', 'notes'])
            ->findOrFail($katsinov_id);

        if ($katsinov->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $setting = Setting::first();
        $thresholds = [
            1 => $setting ? $setting->threshold_indicator_1 : 80.0,
            2 => $setting ? $setting->threshold_indicator_2 : 80.0,
            3 => $setting ? $setting->threshold_indicator_3 : 80.0,
            4 => $setting ? $setting->threshold_indicator_4 : 80.0,
            5 => $setting ? $setting->threshold_indicator_5 : 80.0,
            6 => $setting ? $setting->threshold_indicator_6 : 80.0,
        ];

        $indicatorOne = $katsinov->responses->where('indicator_number', 1);
        $indicatorTwo = $katsinov->responses->where('indicator_number', 2);
        $indicatorThree = $katsinov->responses->where('indicator_number', 3);
        $indicatorFour = $katsinov->responses->where('indicator_number', 4);
        $indicatorFive = $katsinov->responses->where('indicator_number', 5);
        $indicatorSix = $katsinov->responses->where('indicator_number', 6);
        
        // Group responses by indicator for easier display
        $responsesByIndicator = $katsinov->responses->groupBy('indicator_number');
        
        // Load all questions for reference
        $allQuestions = include(resource_path('views/admin/katsinov_v2/includes/indicator_questions.php'));
        
        // Load form pendukung data
        $lampiran = KatsinovLampiran::where('katsinov_id', $katsinov_id)->get();
        $inovasiInfo = KatsinovInovasi::where('katsinov_id', $katsinov_id)->first();
        $informasi = KatsinovInformasi::where('katsinov_id', $katsinov_id)->first();
        $beritaAcara = KatsinovBeritaAcara::where('katsinov_id', $katsinov_id)->first();
        $recordHasil = KatsinovRecordHasil::where('katsinov_id', $katsinov_id)->first();

        return view('subdirektorat-inovasi.dosen.katsinov_v2.full_report', compact(
            'katsinov',
            'indicatorOne',
            'indicatorTwo',
            'indicatorThree',
            'indicatorFour',
            'indicatorFive',
            'indicatorSix',
            'thresholds',
            'responsesByIndicator',
            'allQuestions',
            'lampiran',
            'inovasiInfo',
            'informasi',
            'beritaAcara',
            'recordHasil'
        ));
    }

    /**
     * View Summary - READ ONLY
     */
    public function showSummary($katsinov_id)
    {
        $katsinov = Katsinov::with(['responses', 'notes', 'reviewer'])->findOrFail($katsinov_id);

        if ($katsinov->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Load questions data
        $allQuestions = include(resource_path('views/admin/katsinov_v2/includes/indicator_questions.php'));
        
        // Total rows per indicator
        $totalRowsPerIndicator = [1 => 22, 2 => 21, 3 => 21, 4 => 22, 5 => 24, 6 => 14];
        
        // Calculate indicator scores - ONLY for indicators with data
        $indicatorScores = [];
        for ($i = 1; $i <= 6; $i++) {
            $responses = $katsinov->responses()->where('indicator_number', $i)->get();
            
            // Skip if no data for this indicator
            if ($responses->count() === 0) {
                continue;
            }
            
            $totalScore = $responses->sum('score');
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
            $totalScore = $responses->sum('score');
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
                $totalScore = $responses->sum('score');
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
                $aspectQuestions = collect($allQuestions[$i] ?? [])->filter(function($q) use ($code) {
                    return $q['aspect'] === $code;
                })->values();
                
                $questionScores[$i][$name] = $responses->pluck('score')->toArray();
                $questionTexts[$i][$name] = $aspectQuestions->pluck('desc')->toArray();
            }
        }
        
        // Convert to JSON for JavaScript
        $overallAspectScoresJson = json_encode($overallAspectScores);
        $indicatorAspectScoresJson = json_encode($indicatorAspectScores);
        $questionScoresJson = json_encode($questionScores);
        
        $setting = Setting::first();
        $thresholds = [
            1 => $setting ? $setting->threshold_indicator_1 : 80.0,
            2 => $setting ? $setting->threshold_indicator_2 : 80.0,
            3 => $setting ? $setting->threshold_indicator_3 : 80.0,
            4 => $setting ? $setting->threshold_indicator_4 : 80.0,
            5 => $setting ? $setting->threshold_indicator_5 : 80.0,
            6 => $setting ? $setting->threshold_indicator_6 : 80.0,
        ];

        return view('subdirektorat-inovasi.dosen.katsinov_v2.summary', compact(
            'katsinov',
            'indicatorScores',
            'overallAverage',
            'overallAspectScores',
            'indicatorAspectScores',
            'questionScores',
            'questionTexts',
            'overallAspectScoresJson',
            'indicatorAspectScoresJson',
            'questionScoresJson',
            'thresholds'
        ));
    }

    /**
     * Print Summary
     */
    public function printSummary($katsinov_id)
    {
        $katsinov = Katsinov::with(['scores', 'user', 'reviewer'])
            ->findOrFail($katsinov_id);

        if ($katsinov->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $setting = Setting::first();
        $thresholds = [
            1 => $setting ? $setting->threshold_indicator_1 : 80.0,
            2 => $setting ? $setting->threshold_indicator_2 : 80.0,
            3 => $setting ? $setting->threshold_indicator_3 : 80.0,
            4 => $setting ? $setting->threshold_indicator_4 : 80.0,
            5 => $setting ? $setting->threshold_indicator_5 : 80.0,
            6 => $setting ? $setting->threshold_indicator_6 : 80.0,
        ];

        return view('subdirektorat-inovasi.dosen.katsinov_v2.print_summary', compact('katsinov', 'thresholds'));
    }

    /**
     * Generate Certificate - ONLY WHEN STATUS = COMPLETED
     */
    public function generateCertificate($katsinov_id)
    {
        $katsinov = Katsinov::with(['scores', 'user'])
            ->findOrFail($katsinov_id);

        if ($katsinov->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($katsinov->status !== 'completed') {
            return back()->with('error', 'Sertifikat hanya tersedia untuk Katsinov dengan status COMPLETED.');
        }

        return view('subdirektorat-inovasi.dosen.katsinov_v2.certificate', compact('katsinov'));
    }

    // =============== HELPER METHODS ===============

    private function saveResponses($katsinov, $responses)
    {
        foreach ($responses as $response) {
            KatsinovResponse::create([
                'katsinov_id' => $katsinov->id,
                'indicator_number' => $response['indicator'],
                'row_number' => $response['row'],
                'aspect' => $response['aspect'],
                'score' => $response['score'],
                'dropdown_value' => $response['dropdown'] ?? null,
            ]);
        }
    }

    private function calculateScores($katsinov)
    {
        $responses = KatsinovResponse::where('katsinov_id', $katsinov->id)->get();

        $aspectMap = [
            'T' => 'technology',
            'O' => 'organization',
            'R' => 'risk',
            'M' => 'market',
            'P' => 'partnership',
            'Mf' => 'manufacturing',
            'I' => 'investment'
        ];

        for ($indicator = 1; $indicator <= 6; $indicator++) {
            $indicatorResponses = $responses->where('indicator_number', $indicator);
            
            if ($indicatorResponses->isEmpty()) {
                continue;
            }

            // Group by aspect
            $aspectScores = [];
            foreach ($aspectMap as $code => $field) {
                $aspectScores[$field] = [
                    'total' => 0,
                    'count' => 0
                ];
            }

            foreach ($indicatorResponses as $response) {
                $aspect = $response->aspect;
                $field = $aspectMap[$aspect] ?? null;

                if ($field) {
                    $aspectScores[$field]['total'] += $response->score;
                    $aspectScores[$field]['count']++;
                }
            }

            // Calculate percentage for each aspect
            $calculatedScores = [
                'katsinov_id' => $katsinov->id,
                'indicator_number' => $indicator
            ];

            foreach ($aspectScores as $field => $data) {
                $maxPossible = $data['count'] * 5;
                $percentage = $maxPossible > 0 ? ($data['total'] / $maxPossible) * 100 : 0;
                $calculatedScores[$field] = round($percentage, 2);
            }

            KatsinovScore::create($calculatedScores);
        }
    }
}
