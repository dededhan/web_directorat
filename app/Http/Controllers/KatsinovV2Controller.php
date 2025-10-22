<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Katsinov;
use App\Models\KatsinovBerita;
use App\Models\KatsinovInformasi;
use App\Models\KatsinovInformasiCollection;
use App\Models\KatsinovNote;
use App\Models\KatsinovInovasi;
use App\Models\FormRecordHasilPengukuran;
use Illuminate\Http\Request;
use App\Models\KatsinovScore;
use App\Models\KatsinovLampiran;
use App\Models\KatsinovResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class KatsinovV2Controller extends Controller
{
    /**
     * Get view path based on user role
     */
    private function getViewPath($view)
    {
        $role = Auth::user()->role ?? 'admin';
        $prefix = ($role === 'admin_inovasi') ? 'admin_inovasi' : 'admin';
        return "{$prefix}.katsinov_v2.{$view}";
    }

    /**
     * Get route prefix based on user role
     */
    private function getRoutePrefix()
    {
        $role = Auth::user()->role ?? 'admin';
        return ($role === 'admin_inovasi') ? 'admin_inovasi' : 'admin';
    }

    public function index()
    {
        $role = Auth::user()->role;
        $user = Auth::user();

        $katsinovsQuery = Katsinov::with('scores', 'user', 'reviewer');

        if (in_array($role, ['dosen', 'mahasiswa', 'registered_user'])) {
            $katsinovs = $user->katsinovs()->with('scores', 'user', 'reviewer')->latest()->paginate(20);
        } elseif ($role === 'validator') {
            $katsinovs = $katsinovsQuery->where('reviewer_id', $user->id)->latest()->paginate(20);
        } else {
            $katsinovs = $katsinovsQuery->latest()->paginate(20);
        }

        $reviewers = User::whereIn('role', ['validator'])->get();

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov_v2.index',
            'admin_inovasi' => 'admin_inovasi.katsinov_v2.index',
            'dosen' => 'subdirektorat-inovasi.dosen.katsinov_v2.index',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.katsinov_v2.index',
            'validator' => 'subdirektorat-inovasi.validator.katsinov_v2.index',
            'registered_user' => 'subdirektorat-inovasi.registered_user.katsinov_v2.index',
        };

        return view($view, compact('katsinovs', 'reviewers'));
    }

    public function create()
    {
        $view = match (Auth::user()->role) {
            'admin_direktorat' => 'admin.katsinov_v2.form_main',
            'admin_inovasi' => 'admin_inovasi.katsinov_v2.form_main',
            'dosen' => 'subdirektorat-inovasi.dosen.katsinov_v2.form_main',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.katsinov_v2.form_main',
            'validator' => 'subdirektorat-inovasi.validator.katsinov_v2.form_main',
            'registered_user' => 'subdirektorat-inovasi.registered_user.katsinov_v2.form_main',
        };

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

        return view($view, [
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

    public function edit($id)
    {
        $katsinov = Katsinov::with(['responses', 'notes'])->findOrFail($id);
        
        // Check permission
        if ($katsinov->user_id !== Auth::id() && !in_array(Auth::user()->role, ['admin_direktorat', 'admin_inovasi', 'validator'])) {
            abort(403, 'Unauthorized');
        }
        
        // Group responses by indicator
        $indicatorOne = $katsinov->responses()->where('indicator_number', 1)->get();
        $indicatorTwo = $katsinov->responses()->where('indicator_number', 2)->get();
        $indicatorThree = $katsinov->responses()->where('indicator_number', 3)->get();
        $indicatorFour = $katsinov->responses()->where('indicator_number', 4)->get();
        $indicatorFive = $katsinov->responses()->where('indicator_number', 5)->get();
        $indicatorSix = $katsinov->responses()->where('indicator_number', 6)->get();
        
        $view = match (Auth::user()->role) {
            'admin_direktorat' => 'admin.katsinov_v2.form_main',
            'admin_inovasi' => 'admin_inovasi.katsinov_v2.form_main',
            'dosen' => 'subdirektorat-inovasi.dosen.katsinov_v2.form_main',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.katsinov_v2.form_main',
            'validator' => 'subdirektorat-inovasi.validator.katsinov_v2.form_main',
            'registered_user' => 'subdirektorat-inovasi.registered_user.katsinov_v2.form_main',
        };

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

        // Get indicator status with threshold info
        $indicatorStatus = $this->getIndicatorStatus($id);

        return view($view, [
            'katsinov' => $katsinov,
            'indicatorOne' => $indicatorOne,
            'indicatorTwo' => $indicatorTwo,
            'indicatorThree' => $indicatorThree,
            'indicatorFour' => $indicatorFour,
            'indicatorFive' => $indicatorFive,
            'indicatorSix' => $indicatorSix,
            'thresholds' => $thresholds,
            'indicatorStatus' => $indicatorStatus,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'sometimes|nullable|integer|exists:katsinovs,id',
            'title' => 'required|string|max:255',
            'focus_area' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string',
            'assessment_date' => 'required|string',
            'responses' => 'sometimes|nullable|array', // Allow empty for draft
            'responses.*.indicator' => 'required|integer|min:1|max:6',
            'responses.*.row' => 'required|integer',
            'responses.*.aspect' => 'required|string|in:T,O,R,M,P,Mf,I',
            'responses.*.score' => 'required|integer|min:0|max:5',
            'responses.*.dropdown' => 'nullable|string|in:A,B,C,D,E,F',
            'notes' => 'nullable',
            'save_as_draft' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $katsinov = null;
            if (!empty($validated['id'])) {
                $katsinov = Katsinov::findOrFail($validated['id']);
                $katsinov->update([
                    'title' => $validated['title'],
                    'focus_area' => $validated['focus_area'],
                    'project_name' => $validated['project_name'],
                    'institution' => $validated['institution'],
                    'address' => $validated['address'],
                    'contact' => $validated['contact'],
                    'assessment_date' => $validated['assessment_date'],
                ]);

                $katsinov->responses()->delete();
                $katsinov->scores()->delete();
                $katsinov->notes()->delete();
            } else {
                $status = $request->input('save_as_draft', false) ? 'draft' : 'submitted';
                
                $katsinov = Katsinov::create([
                    'title' => $validated['title'],
                    'focus_area' => $validated['focus_area'],
                    'project_name' => $validated['project_name'],
                    'institution' => $validated['institution'],
                    'address' => $validated['address'],
                    'contact' => $validated['contact'],
                    'assessment_date' => $validated['assessment_date'],
                    'user_id' => Auth::user()->id,
                    'status' => $status,
                    'submitted_at' => $status === 'submitted' ? now() : null,
                ]);
            }

            if (!empty($validated['responses'])) {
                foreach ($validated['responses'] as $response) {
                    KatsinovResponse::create([
                        'katsinov_id' => $katsinov->id,
                        'indicator_number' => $response['indicator'],
                        'row_number' => $response['row'],
                        'aspect' => $response['aspect'],
                        'score' => $response['score'],
                        'dropdown_value' => $response['dropdown'] ?? null,
                    ]);
                }
                $this->processAndSaveScores($katsinov->id, $validated['responses']);
            }

            // Save notes - handle both array and object format from JavaScript
            if (!empty($validated['notes'])) {
                $notesData = $validated['notes'];
                
                // If notes is an object (from JavaScript), convert to array
                if (is_object($notesData)) {
                    $notesData = (array) $notesData;
                }
                
                foreach ($notesData as $indicatorNumber => $noteText) {
                    if (!empty(trim($noteText))) {
                        KatsinovNote::create([
                            'katsinov_id' => $katsinov->id,
                            'indicator_number' => (int) $indicatorNumber,
                            'notes' => $noteText,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'message' => isset($validated['id']) ? 'Data berhasil diupdate' : 'Data berhasil disimpan',
                'id' => $katsinov->id,
                'status' => $katsinov->status
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    private function processAndSaveScores($katsinovId, $responses)
    {
        $groupedResponses = [];
        foreach ($responses as $response) {
            $indicator = $response['indicator'];
            if (!isset($groupedResponses[$indicator])) {
                $groupedResponses[$indicator] = [];
            }
            $groupedResponses[$indicator][] = $response;
        }

        $aspectMap = [
            'T' => 'technology',
            'O' => 'organization',
            'R' => 'risk',
            'M' => 'market',
            'P' => 'partnership',
            'Mf' => 'manufacturing',
            'I' => 'investment'
        ];

        foreach ($groupedResponses as $indicator => $indicatorResponses) {
            $aspectScores = [];

            foreach ($aspectMap as $code => $field) {
                $aspectScores[$field] = [
                    'total' => 0,
                    'count' => 0
                ];
            }

            foreach ($indicatorResponses as $response) {
                $aspect = $response['aspect'];
                $field = $aspectMap[$aspect] ?? null;

                if ($field) {
                    $aspectScores[$field]['total'] += $response['score'];
                    $aspectScores[$field]['count']++;
                }
            }

            $calculatedScores = [
                'katsinov_id' => $katsinovId,
                'indicator_number' => $indicator
            ];

            foreach ($aspectScores as $field => $data) {
                $maxPossible = $data['count'] * 5;
                $percentage = $maxPossible > 0 ? ($data['total'] / $maxPossible) * 100 : 0;
                $calculatedScores[$field] = $percentage;
            }

            KatsinovScore::create($calculatedScores);
        }
    }

    public function show($id)
    {
        $katsinov = Katsinov::where('id', $id)
            ->with(['scores', 'responses', 'notes', 'reviewer'])
            ->firstOrFail();

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

        $role = Auth::user()->role;
        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov_v2.show',
            'admin_inovasi' => 'admin_inovasi.katsinov_v2.show',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.katsinov_v2.show',
            'validator' => 'subdirektorat-inovasi.validator.katsinov_v2.show',
            'registered_user' => 'subdirektorat-inovasi.registered_user.katsinov_v2.show',
            'dosen' => 'subdirektorat-inovasi.dosen.katsinov_v2.show',
            default => 'admin.katsinov_v2.show',
        };

        return view($view, $data);
    }

    public function assignReviewer(Request $request, $id)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id'
        ]);

        $katsinov = Katsinov::findOrFail($id);
        $katsinov->update([
            'reviewer_id' => $request->reviewer_id,
            'status' => 'assigned'
        ]);

        return response()->json(['success' => true, 'message' => 'Reviewer berhasil ditugaskan']);
    }

    public function startReview($id)
    {
        $katsinov = Katsinov::findOrFail($id);
        
        if ($katsinov->reviewer_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $katsinov->update(['status' => 'under_review']);

        return response()->json(['success' => true, 'message' => 'Review dimulai']);
    }

    public function completeReview(Request $request, $id)
    {
        $request->validate([
            'reviewer_notes' => 'nullable|string'
        ]);

        $katsinov = Katsinov::findOrFail($id);
        
        if ($katsinov->reviewer_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $katsinov->update([
            'status' => 'completed',
            'reviewed_at' => now(),
            'reviewer_notes' => $request->reviewer_notes
        ]);

        return response()->json(['success' => true, 'message' => 'Review selesai']);
    }

    public function submitForReview($id)
    {
        $katsinov = Katsinov::findOrFail($id);
        
        if ($katsinov->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $katsinov->update([
            'status' => 'submitted',
            'submitted_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil disubmit untuk review']);
    }

    public function formInovasiIndex($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);
        $inovasi = $katsinov->katsinovInovasis()->first();
        
        $role = Auth::user()->role;
        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov_v2.form_inovasi',
            'admin_inovasi' => 'admin_inovasi.katsinov_v2.form_inovasi',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.katsinov_v2.form_inovasi',
            'dosen' => 'subdirektorat-inovasi.dosen.katsinov_v2.form_inovasi',
            'validator' => 'subdirektorat-inovasi.validator.katsinov_v2.form_inovasi',
            'registered_user' => 'subdirektorat-inovasi.registered_user.katsinov_v2.form_inovasi',
            default => 'admin.katsinov_v2.form_inovasi',
        };

        return view($view, compact('katsinov', 'inovasi'));
    }

    public function formInovasiStore(Request $request, $katsinov_id)
    {
        $isDraft = $request->has('save_as_draft');
        
        $validatedData = $request->validate([
            'judul' => $isDraft ? 'nullable|string' : 'required|string',
            'sub_judul' => $isDraft ? 'nullable|string' : 'required|string',
            'pendahuluan' => $isDraft ? 'nullable|string' : 'required|string',
            'produk_teknologi' => $isDraft ? 'nullable|string' : 'required|string',
            'keunggulan' => $isDraft ? 'nullable|string' : 'required|string',
            'paten' => $isDraft ? 'nullable|string' : 'required|string',
            'kesiapan_teknologi' => $isDraft ? 'nullable|string' : 'required|string',
            'kesiapan_pasar' => $isDraft ? 'nullable|string' : 'required|string',
            'nama' => $isDraft ? 'nullable|string' : 'required|string',
            'phone' => $isDraft ? 'nullable' : 'required',
            'mobile' => $isDraft ? 'nullable' : 'required',
            'fax' => $isDraft ? 'nullable' : 'required',
            'email' => $isDraft ? 'nullable|email:rfc,dns' : 'required|email:rfc,dns',
        ]);

        $data = [
            'title' => $validatedData['judul'] ?? '',
            'sub_title' => $validatedData['sub_judul'] ?? '',
            'introduction' => $validatedData['pendahuluan'] ?? '',
            'tech_product' => $validatedData['produk_teknologi'] ?? '',
            'supremacy' => $validatedData['keunggulan'] ?? '',
            'patent' => $validatedData['paten'] ?? '',
            'tech_preparation' => $validatedData['kesiapan_teknologi'] ?? '',
            'market_preparation' => $validatedData['kesiapan_pasar'] ?? '',
            'name' => $validatedData['nama'] ?? '',
            'phone' => $validatedData['phone'] ?? '',
            'mobile' => $validatedData['mobile'] ?? '',
            'fax' => $validatedData['fax'] ?? '',
            'email' => $validatedData['email'] ?? '',
            'katsinov_id' => $katsinov_id
        ];

        $inovasi = KatsinovInovasi::where('katsinov_id', $katsinov_id)->first();

        if ($inovasi) {
            $inovasi->update($data);
            $message = $isDraft ? 'Draft berhasil disimpan' : 'Data inovasi berhasil diperbarui!';
        } else {
            KatsinovInovasi::create($data);
            $message = $isDraft ? 'Draft berhasil disimpan' : 'Data inovasi berhasil disimpan!';
        }

        $role = Auth::user()->role;
        $route = match ($role) {
            'admin_direktorat' => 'admin.katsinov-v2.show',
            'admin_inovasi' => 'admin_inovasi.katsinov-v2.show',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.katsinov-v2.show',
            'dosen' => 'subdirektorat-inovasi.dosen.katsinov-v2.show',
            'validator' => 'subdirektorat-inovasi.validator.katsinov-v2.show',
            'registered_user' => 'subdirektorat-inovasi.registered_user.katsinov-v2.show',
            default => 'admin.katsinov-v2.show',
        };

        return redirect()->route($route, $katsinov_id)->with('success', $message);
    }

    public function formLampiranIndex($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);
        $lampiran = KatsinovLampiran::where('katsinov_id', $katsinov_id)->get();
        
        $groupedLampiran = [];
        foreach ($lampiran as $file) {
            $groupedLampiran[$file->type][$file->category] = $file;
        }
        
        $role = Auth::user()->role;
        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov_v2.form_lampiran',
            'admin_inovasi' => 'admin_inovasi.katsinov_v2.form_lampiran',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.katsinov_v2.form_lampiran',
            'dosen' => 'subdirektorat-inovasi.dosen.katsinov_v2.form_lampiran',
            'validator' => 'subdirektorat-inovasi.validator.katsinov_v2.form_lampiran',
            'registered_user' => 'subdirektorat-inovasi.registered_user.katsinov_v2.form_lampiran',
            default => 'admin.katsinov_v2.form_lampiran',
        };

        return view($view, compact('katsinov', 'lampiran', 'groupedLampiran'));
    }

    public function formLampiranStore(Request $request, $katsinov_id)
    {
        $isDraft = $request->has('save_as_draft');
        
        // All fields nullable to support draft and partial upload
        $files = $request->validate([
            'aspek_teknologi' => ['nullable', 'array'],
            'aspek_teknologi.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'aspek_pasar' => ['nullable', 'array'],
            'aspek_pasar.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'aspek_organisasi' => ['nullable', 'array'],
            'aspek_organisasi.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'aspek_mitra' => ['nullable', 'array'],
            'aspek_mitra.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'aspek_risiko' => ['nullable', 'array'],
            'aspek_risiko.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'aspek_manufaktur' => ['nullable', 'array'],
            'aspek_manufaktur.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'aspek_investasi' => ['nullable', 'array'],
            'aspek_investasi.*' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $basePath = 'lampiran_katsinov';
        $now = now();
        $data_files = [];

        foreach ($files as $aspect => $categories) {
            if (!is_array($categories)) continue;
            
            foreach ($categories as $category => $file) {
                if ($file && $file instanceof \Illuminate\Http\UploadedFile && $file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "{$aspect}_{$category}_{$now->timestamp}.{$extension}";

                    $path = $file->storeAs(
                        "$basePath/$aspect",
                        $fileName,
                        'public'
                    );

                    $existingFile = KatsinovLampiran::where([
                        'katsinov_id' => $katsinov_id,
                        'type' => $aspect,
                        'category' => $category
                    ])->first();

                    if ($existingFile) {
                        \Storage::disk('public')->delete($existingFile->path);
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

        if (!empty($data_files)) {
            KatsinovLampiran::insert($data_files);
        }

        $role = Auth::user()->role;
        $route = match ($role) {
            'admin_direktorat' => 'admin.katsinov-v2.show',
            'admin_inovasi' => 'admin_inovasi.katsinov-v2.show',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.katsinov-v2.show',
            'dosen' => 'subdirektorat-inovasi.dosen.katsinov-v2.show',
            'validator' => 'subdirektorat-inovasi.validator.katsinov-v2.show',
            'registered_user' => 'subdirektorat-inovasi.registered_user.katsinov-v2.show',
            default => 'admin.katsinov-v2.show',
        };

        $message = $isDraft ? 'Draft berhasil disimpan' : 'Lampiran berhasil diunggah';
        return redirect()->route($route, $katsinov_id)->with('success', $message);
    }

    // Form Informasi Dasar
    public function formInformasiDasarIndex($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);
        $informasi = KatsinovInformasi::where('katsinov_id', $katsinov_id)->first();
        
        // Get collection data
        $informasiCollection = null;
        $groupedData = [];
        
        if ($informasi) {
            $informasiCollection = \App\Models\KatsinovInformasiCollection::where('katsinov_informasi_id', $informasi->id)
                ->get(['field', 'index', 'attribute', 'value'])
                ->toArray();
            
            foreach ($informasiCollection as $item) {
                $field = $item['field'];
                $index = $item['index'];
                
                if (!isset($groupedData[$field][$index])) {
                    $groupedData[$field][$index] = [];
                }
                $groupedData[$field][$index][$item['attribute']] = $item['value'];
            }
        }
        
        $role = Auth::user()->role;
        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov_v2.form_informasi_dasar',
            'admin_inovasi' => 'admin_inovasi.katsinov_v2.form_informasi_dasar',
            default => 'admin.katsinov_v2.form_informasi_dasar',
        };

        return view($view, [
            'katsinov' => $katsinov,
            'informasi' => $informasi,
            'informasi_team' => $groupedData['team'] ?? null,
            'informasi_program' => $groupedData['program_implementation'] ?? null,
            'informasi_partner' => $groupedData['innovation_partner'] ?? null,
            'informasi_tech' => $groupedData['information_tech'] ?? null,
            'informasi_market' => $groupedData['information_market'] ?? null,
        ]);
    }

    public function formInformasiDasarStore(Request $request, $katsinov_id)
    {
        // Check if draft or final
        $isDraft = $request->has('save_as_draft');
        
        // Conditional validation based on draft status
        $rules = [
            'person_in_charge' => $isDraft ? 'nullable|string' : 'required|string',
            'pic_institution' => $isDraft ? 'nullable|string' : 'required|string',
            'pic_address' => $isDraft ? 'nullable|string' : 'required|string',
            'pic_phone' => $isDraft ? 'nullable|string' : 'required|string',
            'pic_fax' => 'nullable|string',
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

        // Save main informasi
        $informasiData = [
            'pic' => $validated['person_in_charge'] ?? '',
            'institution' => $validated['pic_institution'] ?? '',
            'address' => $validated['pic_address'] ?? '',
            'phone' => $validated['pic_phone'] ?? '',
            'fax' => $validated['pic_fax'] ?? '',
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
        
        $informasi = \App\Models\KatsinovInformasi::updateOrCreate(
            ['katsinov_id' => $katsinov_id],
            $informasiData
        );

        // Save collection data (team, tech, market, etc.)
        if ($informasi) {
            // Delete old collection data
            \App\Models\KatsinovInformasiCollection::where('katsinov_informasi_id', $informasi->id)->delete();
            
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
                \App\Models\KatsinovInformasiCollection::insert($collectionData);
            }
        }

        $message = $isDraft ? 'Draft berhasil disimpan' : 'Informasi Dasar berhasil disimpan';
        
        $role = \Auth::user()->role;
        $route = match ($role) {
            'admin_direktorat' => 'admin.katsinov-v2.show',
            'admin_inovasi' => 'admin_inovasi.katsinov-v2.show',
            default => 'admin.katsinov-v2.show',
        };
        
        return redirect()->route($route, $katsinov_id)->with('success', $message);
    }

    // Form Berita Acara
    public function formBeritaAcaraIndex($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);
        $beritaAcara = KatsinovBerita::where('katsinov_id', $katsinov_id)->first();
        
        $role = Auth::user()->role;
        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov_v2.form_berita_acara',
            'admin_inovasi' => 'admin_inovasi.katsinov_v2.form_berita_acara',
            default => 'admin.katsinov_v2.form_berita_acara',
        };

        return view($view, compact('katsinov', 'beritaAcara'));
    }

    public function formBeritaAcaraStore(Request $request, $katsinov_id)
    {
        $isDraft = $request->has('save_as_draft');
        
        $validated = $request->validate([
            'day' => $isDraft ? 'nullable|string' : 'required|string',
            'date' => $isDraft ? 'nullable|string' : 'required|string',
            'month' => $isDraft ? 'nullable|string' : 'required|string',
            'year' => $isDraft ? 'nullable|string' : 'required|string',
            'yearfull' => $isDraft ? 'nullable|string' : 'required|string',
            'place' => $isDraft ? 'nullable|string' : 'required|string',
            'decree' => $isDraft ? 'nullable|string' : 'required|string',
            'title' => $isDraft ? 'nullable|string' : 'required|string',
            'type' => $isDraft ? 'nullable|string' : 'required|string',
            'tki' => $isDraft ? 'nullable|numeric' : 'required|numeric',
            'opinion' => $isDraft ? 'nullable|string' : 'required|string',
            'sign_date' => $isDraft ? 'nullable|date' : 'required|date',
            'penanggungjawab' => $isDraft ? 'nullable|string' : 'required|string',
            'ketua' => $isDraft ? 'nullable|string' : 'required|string',
            'anggota1' => $isDraft ? 'nullable|string' : 'required|string',
            'anggota2' => $isDraft ? 'nullable|string' : 'required|string',
            'penanggungjawab_signature' => 'nullable|string',
            'ketua_signature' => 'nullable|string',
            'anggota1_signature' => 'nullable|string',
            'anggota2_signature' => 'nullable|string',
            'penanggungjawab_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'ketua_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'anggota1_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'anggota2_pdf' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Handle digital signatures (base64 to image)
        $members = ['penanggungjawab', 'ketua', 'anggota1', 'anggota2'];
        foreach ($members as $member) {
            $signatureField = $member . '_signature';
            if ($request->has($signatureField) && !empty($request->$signatureField)) {
                // Remove data:image/png;base64, prefix
                $signatureData = $request->$signatureField;
                if (preg_match('/^data:image\/(\w+);base64,/', $signatureData, $type)) {
                    $signatureData = substr($signatureData, strpos($signatureData, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                    
                    // Decode base64
                    $signatureData = base64_decode($signatureData);
                    
                    if ($signatureData !== false) {
                        // Generate unique filename
                        $filename = 'signature_' . $member . '_' . time() . '.png';
                        $path = 'berita_acara/signatures/' . $filename;
                        
                        // Save to storage
                        \Storage::disk('public')->put($path, $signatureData);
                        $validated[$signatureField] = $path;
                    }
                }
            }
        }

        // Handle PDF uploads
        if ($request->hasFile('penanggungjawab_pdf')) {
            $validated['penanggungjawab_pdf'] = $request->file('penanggungjawab_pdf')->store('berita_acara/pdf', 'public');
        }
        if ($request->hasFile('ketua_pdf')) {
            $validated['ketua_pdf'] = $request->file('ketua_pdf')->store('berita_acara/pdf', 'public');
        }
        if ($request->hasFile('anggota1_pdf')) {
            $validated['anggota1_pdf'] = $request->file('anggota1_pdf')->store('berita_acara/pdf', 'public');
        }
        if ($request->hasFile('anggota2_pdf')) {
            $validated['anggota2_pdf'] = $request->file('anggota2_pdf')->store('berita_acara/pdf', 'public');
        }

        $validated['katsinov_id'] = $katsinov_id;
        KatsinovBerita::updateOrCreate(
            ['katsinov_id' => $katsinov_id],
            $validated
        );

        $message = $isDraft ? 'Draft berhasil disimpan' : 'Berita Acara berhasil disimpan';
        return redirect()->route('admin.katsinov-v2.show', $katsinov_id)->with('success', $message);
    }

    // Form Record Hasil
    public function formRecordHasilIndex($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);
        $recordHasil = FormRecordHasilPengukuran::where('katsinov_id', $katsinov_id)->first();
        
        $role = Auth::user()->role;
        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov_v2.form_record_hasil',
            'admin_inovasi' => 'admin_inovasi.katsinov_v2.form_record_hasil',
            default => 'admin.katsinov_v2.form_record_hasil',
        };

        return view($view, compact('katsinov', 'recordHasil'));
    }

    public function formRecordHasilStore(Request $request, $katsinov_id)
    {
        $isDraft = $request->has('save_as_draft');
        
        $rules = [
            'nama_penanggung_jawab' => $isDraft ? 'nullable|string' : 'required|string',
            'institusi' => $isDraft ? 'nullable|string' : 'required|string',
            'judul_inovasi' => $isDraft ? 'nullable|string' : 'required|string',
            'jenis_inovasi' => $isDraft ? 'nullable|string' : 'required|string',
            'alamat_kontak' => $isDraft ? 'nullable|string' : 'required|string',
            'phone' => $isDraft ? 'nullable|string' : 'required|string',
            'fax' => 'nullable|string',
            'tanggal_penilaian' => $isDraft ? 'nullable|date' : 'required|date',
        ];

        // Add validation for 5 rows
        for ($i = 1; $i <= 5; $i++) {
            $rules["aspek_$i"] = $isDraft ? 'nullable|string' : 'required|string';
            $rules["aktivitas_$i"] = $isDraft ? 'nullable|string' : 'required|string';
            $rules["capaian_$i"] = $isDraft ? 'nullable|integer' : 'required|integer';
            $rules["keterangan_$i"] = $isDraft ? 'nullable|string' : 'required|string';
            $rules["catatan_$i"] = 'nullable|string';
        }

        $validated = $request->validate($rules);
        $validated['katsinov_id'] = $katsinov_id;

        FormRecordHasilPengukuran::updateOrCreate(
            ['katsinov_id' => $katsinov_id],
            $validated
        );

        $message = $isDraft ? 'Draft berhasil disimpan' : 'Record Hasil Pengukuran berhasil disimpan';
        return redirect()->route('admin.katsinov-v2.show', $katsinov_id)->with('success', $message);
    }

    // Change Status (Admin only)
    public function changeStatus(Request $request, $id)
    {
        $katsinov = Katsinov::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:draft,submitted,assigned,in_review,completed'
        ]);
        
        $katsinov->status = $validated['status'];
        $katsinov->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah menjadi ' . $validated['status']
        ]);
    }

    // Get Review Notes
    public function getReview($id)
    {
        $katsinov = Katsinov::findOrFail($id);
        
        if (!$katsinov->reviewer_notes) {
            return response()->json([
                'success' => false,
                'message' => 'Review notes not found'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'notes' => $katsinov->reviewer_notes,
            'reviewer' => $katsinov->reviewer->name ?? 'Unknown',
            'reviewed_at' => $katsinov->reviewed_at ? $katsinov->reviewed_at->format('d M Y H:i') : null
        ]);
    }

    // Print Proposal
    public function printProposal($katsinov_id)
    {
        $katsinov = Katsinov::with(['responses', 'notes', 'user'])->findOrFail($katsinov_id);
        
        // Load all related data
        $inovasi = KatsinovInovasi::where('katsinov_id', $katsinov_id)->first();
        $informasi = KatsinovInformasi::where('katsinov_id', $katsinov_id)->first();
        $beritaAcara = KatsinovBerita::where('katsinov_id', $katsinov_id)->first();
        $recordHasil = FormRecordHasilPengukuran::where('katsinov_id', $katsinov_id)->first();
        $lampiran = KatsinovLampiran::where('katsinov_id', $katsinov_id)->get();
        
        // Calculate scores
        $totalRowsPerIndicator = [1 => 22, 2 => 21, 3 => 21, 4 => 22, 5 => 24, 6 => 14];
        $indicatorScores = [];
        
        for ($i = 1; $i <= 6; $i++) {
            $responses = $katsinov->responses()->where('indicator_number', $i)->get();
            $totalScore = $responses->sum('score');
            $totalRows = $totalRowsPerIndicator[$i];
            $percentage = $totalRows > 0 ? ($totalScore / ($totalRows * 5)) * 100 : 0;
            $indicatorScores[$i] = [
                'score' => $totalScore,
                'percentage' => $percentage,
                'total_rows' => $totalRows,
                'responses' => $responses
            ];
        }
        
        $overallAverage = collect($indicatorScores)->avg('percentage');
        
        // Group responses by indicator for detailed view
        $indicatorOne = $katsinov->responses()->where('indicator_number', 1)->get();
        $indicatorTwo = $katsinov->responses()->where('indicator_number', 2)->get();
        $indicatorThree = $katsinov->responses()->where('indicator_number', 3)->get();
        $indicatorFour = $katsinov->responses()->where('indicator_number', 4)->get();
        $indicatorFive = $katsinov->responses()->where('indicator_number', 5)->get();
        $indicatorSix = $katsinov->responses()->where('indicator_number', 6)->get();
        
        return view($this->getViewPath('print'), compact(
            'katsinov',
            'inovasi',
            'informasi',
            'beritaAcara',
            'recordHasil',
            'lampiran',
            'indicatorScores',
            'overallAverage',
            'indicatorOne',
            'indicatorTwo',
            'indicatorThree',
            'indicatorFour',
            'indicatorFive',
            'indicatorSix'
        ));
    }

    // Generate Certificate
    public function generateCertificate($katsinov_id)
    {
        $katsinov = Katsinov::with(['user', 'reviewer'])->findOrFail($katsinov_id);
        
        // Check if completed
        if ($katsinov->status !== 'completed') {
            return redirect()->back()->with('error', 'Sertifikat hanya tersedia untuk status completed');
        }
        
        // Calculate overall score
        $totalRowsPerIndicator = [1 => 22, 2 => 21, 3 => 21, 4 => 22, 5 => 24, 6 => 14];
        $indicatorScores = [];
        
        for ($i = 1; $i <= 6; $i++) {
            $responses = $katsinov->responses()->where('indicator_number', $i)->get();
            $totalScore = $responses->sum('score');
            $totalRows = $totalRowsPerIndicator[$i];
            $percentage = $totalRows > 0 ? ($totalScore / ($totalRows * 5)) * 100 : 0;
            $indicatorScores[$i] = $percentage;
        }
        
        $overallScore = collect($indicatorScores)->avg();
        
        // Determine grade
        if ($overallScore >= 90) {
            $grade = 'A - Excellent';
            $predicate = 'Sangat Layak';
        } elseif ($overallScore >= 80) {
            $grade = 'B - Good';
            $predicate = 'Layak';
        } elseif ($overallScore >= 70) {
            $grade = 'C - Fair';
            $predicate = 'Cukup Layak';
        } else {
            $grade = 'D - Poor';
            $predicate = 'Perlu Perbaikan';
        }
        
        // Load informasi for certificate
        $informasi = KatsinovInformasi::where('katsinov_id', $katsinov_id)->first();
        
        return view($this->getViewPath('certificate'), compact(
            'katsinov',
            'informasi',
            'overallScore',
            'grade',
            'predicate',
            'indicatorScores'
        ));
    }

    /**
     * Download Report Pengukuran (Word Document)
     */
    public function downloadReport($katsinov_id)
    {
        $katsinov = Katsinov::with(['user', 'reviewer', 'responses'])->findOrFail($katsinov_id);
        
        // Load template from public path
        $templatePath = public_path('templates/report-pengukuran-katsinovmeter.docx');
        
        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'Template report tidak ditemukan. Silakan hubungi administrator.');
        }
        
        $fileName = 'Report_Pengukuran_' . $katsinov->title . '_' . date('Y-m-d') . '.docx';
        
        return response()->download($templatePath, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    /**
     * Show summary page with full Chart.js visualization
     */
    public function showSummary($katsinov_id)
    {
        $katsinov = Katsinov::with(['responses', 'notes', 'reviewer'])->findOrFail($katsinov_id);
        
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
        
        return view($this->getViewPath('summary'), compact(
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

    /**
     * Print summary page
     */
    public function printSummary($katsinov_id)
    {
        $katsinov = Katsinov::with(['responses', 'notes', 'reviewer'])->findOrFail($katsinov_id);
        
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
        
        // Calculate aspect scores
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
        
        // Calculate indicator-aspect scores - ONLY for indicators with data
        $indicatorAspectScores = [];
        foreach ($indicatorScores as $i => $data) {
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
        
        // Calculate question scores with texts - ONLY for indicators with data
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
        
        // Aspect names for chart labels
        $aspectNames = [
            'technology' => ['label' => 'Technology (T)', 'icon' => '⚙️', 'color' => 'rgb(255, 99, 132)'],
            'market' => ['label' => 'Market (M)', 'icon' => '📊', 'color' => 'rgb(54, 162, 235)'],
            'organization' => ['label' => 'Organization (O)', 'icon' => '🏢', 'color' => 'rgb(255, 206, 86)'],
            'manufacturing' => ['label' => 'Manufacturing (Mf)', 'icon' => '🏭', 'color' => 'rgb(75, 192, 192)'],
            'partnership' => ['label' => 'Partnership (P)', 'icon' => '🤝', 'color' => 'rgb(153, 102, 255)'],
            'investment' => ['label' => 'Investment (I)', 'icon' => '💰', 'color' => 'rgb(255, 159, 64)'],
            'risk' => ['label' => 'Risk (R)', 'icon' => '⚠️', 'color' => 'rgb(70, 150, 130)'],
        ];
        
        return view($this->getViewPath('print_summary'), compact(
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
            'aspectNames'
        ));
    }

    /**
     * Full Report - Admin Only
     * Show all form data including main form and supporting forms
     */
    public function fullReport($katsinov_id)
    {
        // Check if user is admin
        if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_inovasi', 'validator'])) {
            abort(403, 'Unauthorized - Admin only');
        }

        $katsinov = Katsinov::with([
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
        ])->findOrFail($katsinov_id);
        
        // Load questions data
        $allQuestions = include(resource_path('views/admin/katsinov_v2/includes/indicator_questions.php'));
        
        // Get all responses grouped by indicator
        $responsesByIndicator = [];
        for ($i = 1; $i <= 6; $i++) {
            $responses = $katsinov->responses()
                ->where('indicator_number', $i)
                ->orderBy('row_number')
                ->get();
            
            if ($responses->count() > 0) {
                $responsesByIndicator[$i] = $responses;
            }
        }
        
        // Get informasi dasar
        $informasi = $katsinov->katsinovInformasis->first();
        
        // Get lampiran
        $lampiran = $katsinov->katsinovLampirans;
        
        // Get berita acara
        $beritaAcara = $katsinov->katsinovBeritas->first();
        
        // Get record hasil
        $recordHasil = $katsinov->formRecordHasilPengukuran;
        
        // Get informasi inovasi (if exists from old system)
        $inovasiInfo = $katsinov->katsinovInovasis->first();
        
        return view($this->getViewPath('full_report'), compact(
            'katsinov',
            'allQuestions',
            'responsesByIndicator',
            'informasi',
            'lampiran',
            'beritaAcara',
            'recordHasil',
            'inovasiInfo'
        ));
    }

    /**
     * Settings page for threshold configuration
     */
    public function settings()
    {
        $settings = Setting::first();
        
        if (!$settings) {
            $settings = Setting::create([
                'key' => 'katsinov_v2_thresholds',
                'value' => 'Threshold settings for KATSINOV V2',
                'threshold_indicator_1' => 0,
                'threshold_indicator_2' => 0,
                'threshold_indicator_3' => 0,
                'threshold_indicator_4' => 0,
                'threshold_indicator_5' => 0,
                'threshold_indicator_6' => 0,
            ]);
        }
        
        return view($this->getViewPath('settings'), compact('settings'));
    }

    /**
     * Update threshold settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'threshold_indicator_1' => 'required|numeric|min:0|max:100',
            'threshold_indicator_2' => 'required|numeric|min:0|max:100',
            'threshold_indicator_3' => 'required|numeric|min:0|max:100',
            'threshold_indicator_4' => 'required|numeric|min:0|max:100',
            'threshold_indicator_5' => 'required|numeric|min:0|max:100',
            'threshold_indicator_6' => 'required|numeric|min:0|max:100',
        ]);

        $settings = Setting::first();
        
        if (!$settings) {
            $settings = Setting::create([
                'key' => 'katsinov_v2_thresholds',
                'value' => 'Threshold settings for KATSINOV V2',
            ]);
        }

        $settings->update($validated);

        $routePrefix = $this->getRoutePrefix();
        return redirect()->route("{$routePrefix}.katsinov-v2.settings")
            ->with('success', 'Pengaturan threshold berhasil disimpan!');
    }

    /**
     * Check if user can access next indicator based on threshold
     */
    private function canAccessIndicator($katsinovId, $indicatorNumber)
    {
        if ($indicatorNumber == 1) {
            return true; // Always can access indicator 1
        }

        $settings = Setting::first();
        if (!$settings) {
            return true; // If no settings, allow access
        }

        // Get previous indicator number
        $prevIndicator = $indicatorNumber - 1;
        $thresholdField = "threshold_indicator_{$prevIndicator}";
        $threshold = $settings->$thresholdField ?? 0;

        if ($threshold == 0) {
            return true; // No threshold set, allow access
        }

        // Calculate average score for previous indicator
        $responses = KatsinovResponse::where('katsinov_id', $katsinovId)
            ->where('indicator_number', $prevIndicator)
            ->get();

        if ($responses->isEmpty()) {
            return false; // Previous indicator not filled yet
        }

        $totalScore = $responses->sum('score');
        $maxScore = $responses->count() * 4; // Assuming max score is 4 per question
        $percentage = ($totalScore / $maxScore) * 100;

        return $percentage >= $threshold;
    }

    /**
     * Get indicator status with threshold info
     */
    private function getIndicatorStatus($katsinovId)
    {
        $settings = Setting::first();
        $status = [];

        for ($i = 1; $i <= 6; $i++) {
            $canAccess = $this->canAccessIndicator($katsinovId, $i);
            $threshold = $settings ? $settings->{"threshold_indicator_" . ($i - 1)} ?? 0 : 0;
            
            $responses = KatsinovResponse::where('katsinov_id', $katsinovId)
                ->where('indicator_number', $i)
                ->get();

            $completed = $responses->count() > 0;
            
            if ($completed) {
                $totalScore = $responses->sum('score');
                $maxScore = $responses->count() * 4;
                $percentage = ($totalScore / $maxScore) * 100;
            } else {
                $percentage = 0;
            }

            $status[$i] = [
                'can_access' => $canAccess,
                'threshold' => $i > 1 ? $threshold : null,
                'completed' => $completed,
                'percentage' => round($percentage, 2),
            ];
        }

        return $status;
    }

    /**
     * Delete Katsinov - Draft only
     */
    public function destroy($id)
    {
        // Check authorization - only admin_direktorat and admin_inovasi
        if (!in_array(Auth::user()->role, ['admin_direktorat', 'admin_inovasi'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Admin only'
            ], 403);
        }

        $katsinov = Katsinov::findOrFail($id);

        // Check if status is draft
        if ($katsinov->status !== 'draft') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya proposal dengan status DRAFT yang dapat dihapus'
            ], 400);
        }

        try {
            // Delete related records
            $katsinov->responses()->delete();
            $katsinov->notes()->delete();
            $katsinov->scores()->delete();
            $katsinov->katsinovInovasis()->delete();
            $katsinov->katsinovLampirans()->delete();
            $katsinov->katsinovInformasis()->delete();
            $katsinov->katsinovBeritas()->delete();
            
            // Delete form record hasil if exists
            if ($katsinov->formRecordHasilPengukuran) {
                $katsinov->formRecordHasilPengukuran->delete();
            }

            // Delete main record
            $katsinov->delete();

            return response()->json([
                'success' => true,
                'message' => 'Proposal berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus proposal: ' . $e->getMessage()
            ], 500);
        }
    }
}
