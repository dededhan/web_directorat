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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KatsinovLampiran;
use App\Models\KatsinovResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KatsinovController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $users = User::whereIn('role', ['validator'])->get();

        // Base query with common relationships
        $katsinovsQuery = Katsinov::with('scores', 'user');

        // Filter based on role
        if (in_array($role, ['dosen', 'mahasiswa', 'registered_user'])) {
            // For these roles, only show their own katsinovs
            $katsinovs = auth()->user()->katsinovs()->with('scores', 'user')->latest()->paginate(100);
        } elseif ($role === 'validator') {
            // For validator role, only show katsinovs assigned to them
            $katsinovs = $katsinovsQuery->where('moreuser_id', Auth::id())->latest()->paginate(100);
        } else {
            // For admin roles, show all katsinovs
            $katsinovs = $katsinovsQuery->latest()->paginate(100);
        }

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.TableKatsinov',
            'dosen' => 'subdirektorat-inovasi.dosen.tablekatsinov',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.tablekatsinov',
            'validator' => 'subdirektorat-inovasi.validator.tablekatsinov',
            'registered_user' => 'subdirektorat-inovasi.registered_user.tablekatsinov',
        };

        return view($view, [
            'katsinovs' => $katsinovs,
            'users' => $users // Pass users to view
        ]);
    }
    public function create()
    {
        $view = match (Auth::user()->role) {
            'admin_direktorat' => 'admin.katsinov.form_katsinov',
            'dosen' => 'subdirektorat-inovasi.dosen.form_katsinov',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.form_katsinov',
            'validator' => 'subdirektorat-inovasi.validator.form_katsinov',
            'registered_user' => 'subdirektorat-inovasi.registered_user.form_katsinov',
        };

        return view($view, [
            'katsinov' => collect([]),
            'indicatorOne' =>  collect([]),
            'indicatorTwo' =>  collect([]),
            'indicatorThree' => collect([]),
            'indicatorFour' => collect([]),
            'indicatorFive' => collect([]),
            'indicatorSix' =>  collect([]),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the basic katsinov data
        $validated = $request->validate([
            'id' => 'sometimes|nullable|integer|exists:katsinovs,id',
            'title' => 'required|string|max:255',
            'focus_area' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string',
            'assessment_date' => 'required|string',
            'responses' => 'required|array',
            'responses.*.indicator' => 'required|integer|min:1|max:6',
            'responses.*.row' => 'required|integer',
            'responses.*.aspect' => 'required|string|in:T,O,R,M,P,Mf,I',
            'responses.*.score' => 'required|integer|min:0|max:5',
            'responses.*.dropdown' => 'nullable|string|in:A,B,C,D,E,F',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string',
        ]);

        // Start transaction to ensure all related data is saved or rolled back together
        DB::beginTransaction();
        try {
            $katsinov = null;
            if (!empty($validated['id'])) { // Check if ID is present and not empty for update
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
                $katsinov->notes()->delete(); // Delete existing notes
            } else {
                // Create the main Katsinov record
                $katsinov = Katsinov::create([
                    'title' => $validated['title'],
                    'focus_area' => $validated['focus_area'],
                    'project_name' => $validated['project_name'],
                    'institution' => $validated['institution'],
                    'address' => $validated['address'],
                    'contact' => $validated['contact'],
                    'assessment_date' => $validated['assessment_date'],
                    'user_id' => Auth::user()->id,
                    'moreuser_id' => null,
                ]);
            }

            // Store each individual response
            if (!empty($validated['responses'])) {
                foreach ($validated['responses'] as $response) {
                    KatsinovResponse::create([
                        'katsinov_id' => $katsinov->id,
                        'indicator_number' => $response['indicator'],
                        'row_number' => $response['row'], // Ensure this maps correctly
                        'aspect' => $response['aspect'],
                        'score' => $response['score'],
                        'dropdown_value' => $response['dropdown'] ?? null,
                    ]);
                }
                // Process and store the aggregated scores only if there are responses
                $this->processAndSaveScores($katsinov->id, $validated['responses']);
            }


            // Store notes
            if (!empty($validated['notes'])) {
                foreach ($validated['notes'] as $indicatorNumber => $noteText) {
                    if (!empty(trim($noteText))) { // Check if note text is not just whitespace
                        KatsinovNote::create([
                            'katsinov_id' => $katsinov->id,
                            'indicator_number' => $indicatorNumber,
                            'notes' => $noteText, // Assuming your column is 'notes'
                        ]);
                    }
                }
            }



            // Process and store the aggregated scores
            $this->processAndSaveScores($katsinov->id, $validated['responses']);

            if (isset($validated['notes'])) {
                foreach ($validated['notes'] as $indicatorNumber => $noteText) {
                    if (!empty($noteText)) {
                        KatsinovNote::create([
                            'katsinov_id' => $katsinov->id,
                            'indicator_number' => $indicatorNumber,
                            'notes' => $noteText,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'message' => isset($validated['id']) ? 'Data berhasil diupdate' : 'Data berhasil disimpan',
                'id' => $katsinov->id
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function getNotes($katsinovId)
    {
        $notes = KatsinovNote::where('katsinov_id', $katsinovId)
            ->orderBy('indicator_number')
            ->get()
            ->pluck('notes', 'indicator_number')
            ->toArray();

        return $notes;
    }

    /**
     * Process the responses and calculate scores for each aspect across all indicators
     */
    private function processAndSaveScores($katsinovId, $responses)
    {
        // Group responses by indicator
        $groupedResponses = [];
        foreach ($responses as $response) {
            $indicator = $response['indicator'];
            if (!isset($groupedResponses[$indicator])) {
                $groupedResponses[$indicator] = [];
            }
            $groupedResponses[$indicator][] = $response;
        }

        // Define aspect mapping
        $aspectMap = [
            'T' => 'technology',
            'O' => 'organization',
            'R' => 'risk',
            'M' => 'market',
            'P' => 'partnership',
            'Mf' => 'manufacturing',
            'I' => 'investment'
        ];

        // Process each indicator
        foreach ($groupedResponses as $indicator => $indicatorResponses) {
            $aspectScores = [];

            // Initialize all aspects with zeros
            foreach ($aspectMap as $code => $field) {
                $aspectScores[$field] = [
                    'total' => 0,
                    'count' => 0
                ];
            }

            // Sum up scores for each aspect
            foreach ($indicatorResponses as $response) {
                $aspect = $response['aspect'];
                $field = $aspectMap[$aspect] ?? null;

                if ($field) {
                    $aspectScores[$field]['total'] += $response['score'];
                    $aspectScores[$field]['count']++;
                }
            }

            // Calculate percentages
            $calculatedScores = [
                'katsinov_id' => $katsinovId,
                'indicator_number' => $indicator
            ];

            foreach ($aspectScores as $field => $data) {
                $maxPossible = $data['count'] * 5; // Max score is 5 per question
                $percentage = $maxPossible > 0 ? ($data['total'] / $maxPossible) * 100 : 0;
                $calculatedScores[$field] = $percentage;
            }

            // Save the scores for this indicator
            KatsinovScore::create($calculatedScores);
        }
    }

    public function show(Request $request)
    {
        $katsinov = Katsinov::where('id', '=', $request->id)
            ->with(['scores', 'responses', 'notes'])
            ->first();
        // dump($katsinov->toArray());

        if (!$katsinov) {
            return redirect()->back()->with('error', 'Data KATSINOV tidak ditemukan');
        }
        $notes = $katsinov->notes->pluck('notes', 'indicator_number')->toArray();

        $data = [
            'katsinov' => $katsinov,
            'indicatorOne' =>  $katsinov->responses()->where('indicator_number', '=', 1)->get(),
            'indicatorTwo' =>  $katsinov->responses()->where('indicator_number', '=', 2)->get(),
            'indicatorThree' =>  $katsinov->responses()->where('indicator_number', '=', 3)->get(),
            'indicatorFour' =>  $katsinov->responses()->where('indicator_number', '=', 4)->get(),
            'indicatorFive' =>  $katsinov->responses()->where('indicator_number', '=', 5)->get(),
            'indicatorSix' =>  $katsinov->responses()->where('indicator_number', '=', 6)->get(),
            'notes' => $notes
        ];

        $role = Auth::user()->role;
        $formview = match ($role) {
            'admin_direktorat' => 'admin.katsinov.form_katsinov',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.form_katsinov',
            'validator' => 'subdirektorat-inovasi.validator.form_katsinov',
            'registered_user' => 'subdirektorat-inovasi.registered_user.form_katsinov',
            default => null,
        };

        return view($formview, $data);
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'katsinov_id' => 'required|exists:katsinovs,id',
            'moreuser_id' => 'nullable|exists:users,id' // Update kolom moreuser_id
        ]);

        $katsinov = Katsinov::findOrFail($request->katsinov_id);
        $katsinov->update(['moreuser_id' => $request->moreuser_id]); // Update moreuser_id, bukan user_id

        return response()->json(['success' => true]);
    }

    public function downloadPDF()
    {
        $katsinovs = auth()->user()->katsinovs()->with('scores')->get();

        $pdf = PDF::loadView('inovasi.katsinov.pdf', compact('katsinovs'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->download('katsinov-report.pdf');
    }

    public function latest()
    {
        $latestRecord = Katsinov::with(['scores', 'responses'])
            ->latest()
            ->first();

        if (!$latestRecord) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($latestRecord);
    }

    public function edit(Katsinov $katsinov)
    {
        $katsinov->load(['responses', 'scores']);

        $data = [
            'katsinov' => $katsinov,
            'indicatorOne' =>  $katsinov->scores()->where('indicator_number', '=', 1)->get(),
            'indicatorTwo' =>  $katsinov->scores()->where('indicator_number', '=', 2)->get(),
            'indicatorThree' =>  $katsinov->scores()->where('indicator_number', '=', 3)->get(),
            'indicatorFour' =>  $katsinov->scores()->where('indicator_number', '=', 4)->get(),
            'indicatorFive' =>  $katsinov->scores()->where('indicator_number', '=', 5)->get(),
            'indicatorSix' =>  $katsinov->scores()->where('indicator_number', '=', 6)->get(),
        ];

        return view('admin.katsinov.form_katsinov', $data);
    }

    public function update(Request $request, Katsinov $katsinov)
    {
        // Similar validation as store method
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'focus_area' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string',
            'assessment_date' => 'required|date',
            'responses' => 'required|array',
            'responses.*.indicator' => 'required|integer|min:1|max:6',
            'responses.*.row' => 'required|integer',
            'responses.*.aspect' => 'required|string|in:T,O,R,M,P,Mf,I',
            'responses.*.score' => 'required|integer|min:0|max:5',
            'responses.*.dropdown' => 'nullable|string|in:A,B,C,D,E,F',
        ]);

        DB::beginTransaction();
        try {
            // Update the main record
            $katsinov->update([
                'title' => $validated['title'],
                'focus_area' => $validated['focus_area'],
                'project_name' => $validated['project_name'],
                'institution' => $validated['institution'],
                'address' => $validated['address'],
                'contact' => $validated['contact'],
                'assessment_date' => $validated['assessment_date'],
            ]);

            // Delete old responses and scores
            KatsinovResponse::where('katsinov_id', $katsinov->id)->delete();
            KatsinovScore::where('katsinov_id', $katsinov->id)->delete();

            // Add new responses
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

            // Process and save the updated scores
            $this->processAndSaveScores($katsinov->id, $validated['responses']);

            DB::commit();
            Log::info('Katsinov data successfully updated', ['id' => $katsinov->id]);

            return response()->json(['message' => 'Data berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating Katsinov data: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Katsinov $katsinov)
    {
        try {
            // Delete all related records first
            KatsinovResponse::where('katsinov_id', $katsinov->id)->delete();
            KatsinovScore::where('katsinov_id', $katsinov->id)->delete();

            // Delete the main record
            $katsinov->delete();

            return redirect()->back()->with('success', 'Data KATSINOV berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting Katsinov: ' . $e->getMessage(), ['id' => $katsinov->id]);
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function lampiranIndex($katsinov_id = null)
    {
        $katsinov = Katsinov::find($katsinov_id);

        if (!$katsinov) {
            return redirect()->back()->with('error', 'Katsinov data not found');
        }

        $lampiran = KatsinovLampiran::where('katsinov_id', $katsinov_id)->get();

        // Kelompokkan lampiran berdasarkan type dan category
        $groupedLampiran = [];
        foreach ($lampiran as $file) {
            $groupedLampiran[$file->type][$file->category] = $file;
        }


        $role = Auth::user()->role;


        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.lampiran',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.lampiran',
            'dosen' => 'subdirektorat-inovasi.dosen.lampiran',
            'validator' => 'subdirektorat-inovasi.validator.lampiran',
            'registered_user' => 'subdirektorat-inovasi.registered_user.lampiran',
            default => null,
        };


        $deleteRoute = match ($role) {
            'admin_direktorat' => 'admin.katsinov.document.delete',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.document.delete',
            'dosen' => 'subdirektorat-inovasi.dosen.document.delete',
            'validator' => 'subdirektorat-inovasi.validator.document.delete',
            'registered_user' => 'subdirektorat-inovasi.registered_user.document.delete',
            default => null,
        };

        return view($view, [
            'id' => $katsinov->id,
            'lampiran' => $groupedLampiran,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function lampiranStore(Request $request, $katsinov_id)
    {
        $files = $request->validate([
            'aspek_teknologi' => ['array', 'min:1'],
            'aspek_teknologi.*' => ['file', 'mimes:pdf,doc,docx'],
            'aspek_pasar' => ['array', 'min:1'],
            'aspek_pasar.*' => ['file', 'mimes:pdf,doc,docx'],
            'aspek_organisasi' => ['array', 'min:1'],
            'aspek_organisasi.*' => ['file', 'mimes:pdf,doc,docx'],
            'aspek_mitra' => ['array', 'min:1'],
            'aspek_mitra.*' => ['file', 'mimes:pdf,doc,docx'],
            'aspek_risiko' => ['array', 'min:1'],
            'aspek_risiko.*' => ['file', 'mimes:pdf,doc,docx'],
            'aspek_manufaktur' => ['array', 'min:1'],
            'aspek_manufaktur.*' => ['file', 'mimes:pdf,doc,docx'],
            'aspek_investasi' => ['array', 'min:1'],
            'aspek_investasi.*' => ['file', 'mimes:pdf,doc,docx'],
        ]);

        $basePath = 'lampiran_katsinov';
        $now = now();
        $data_files = [];

        // the max file uploads now at 50
        // this process 47 file uploads simultaneuosly
        foreach ($files as $aspect => $categories) {
            foreach ($categories as $category => $file) {
                if ($file && $file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "{$aspect}_{$category}_{$now->timestamp}.{$extension}";

                    // Simpan file
                    $path = $file->storeAs(
                        "$basePath/$aspect",
                        $fileName,
                        'public' // Pastikan menggunakan disk 'public'
                    );

                    // Hapus file lama jika ada
                    $existingFile = KatsinovLampiran::where([
                        'katsinov_id' => $katsinov_id,
                        'type' => $aspect,
                        'category' => $category
                    ])->first();

                    if ($existingFile) {
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

        KatsinovLampiran::insert($data_files);

        // which page role should I redirect into? ¯\_(ツ)_/¯
        // its not my job to decide which page is should be switched to
        // may the team able to solve such chaos

        //problem solved

        $role = Auth::user()->role;

        $route = match ($role) {
            'admin_direktorat' => 'admin.katsinov.TableKatsinov',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.tablekatsinov',
            'dosen' => 'subdirektorat-inovasi.dosen.tablekatsinov',
            'validator' => 'subdirektorat-inovasi.validator.tablekatsinov',
            'registered_user' => 'subdirektorat-inovasi.registered_user.tablekatsinov',
            default => 'admin.katsinov.TableKatsinov',
        };

        return redirect()->route($route)->with('success', 'Data informasi berhasil disimpan');
    }

    public function lampiranShow($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);
        $lampiran = $katsinov->katsinovLampirans()->get();

        // Kelompokkan lampiran berdasarkan type (aspek)
        $groupedLampiran = $lampiran->groupBy('type');

        $role = Auth::user()->role;

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.lampiran_show',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.lampiran_show',
            'dosen' => 'subdirektorat-inovasi.dosen.lampiran_show',
            'validator' => 'subdirektorat-inovasi.validator.lampiran_show',
            'registered_user' => 'subdirektorat-inovasi.registered_user.lampiran_show',
            default => 'admin.katsinov.lampiran_show',
        };

        $deleteRoute = 'admin.katsinov.document.delete';

        return view($view, [
            'id' => $katsinov_id,
            'lampiran' => $groupedLampiran,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function viewDocument($id)
    {
        $lampiran = KatsinovLampiran::findOrFail($id);
        $path = storage_path('app/public/' . $lampiran->path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
    }

    public function destroyDocument($id)
    {
        try {
            $lampiran = KatsinovLampiran::findOrFail($id);
            // Delete file from storage
            if (Storage::disk('public')->exists($lampiran->path)) {
                Storage::disk('public')->delete($lampiran->path);
            }
            // Delete record
            $lampiran->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function inovasiIndex($katsinov_id = null)
    {
        $katsinov = Katsinov::find($katsinov_id);

        if (!$katsinov) {
            return redirect()->back()->with('error', 'Katsinov data not found');
        }

        $inovasi = $katsinov->katsinovInovasis()->first();
        $role = Auth::user()->role;

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.formjudul',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.formjudul',
            'dosen' => 'subdirektorat-inovasi.dosen.formjudul',
            'validator' => 'subdirektorat-inovasi.validator.formjudul',
            'registered_user' => 'subdirektorat-inovasi.registered_user.formjudul',
            default => 'admin.katsinov.formjudul',
        };

        return view($view, [
            'id' => $katsinov->id,
            'inovasi' => $inovasi
        ]);
    }

    public function inovasiStore(Request $request, $katsinov_id)
    {
        $validatedData = $request->validate([
            'judul' => ['required', 'string'],
            'sub_judul' => ['required', 'string'],
            'pendahuluan' => ['required', 'string'],
            'produk_teknologi' => ['required', 'string'],
            'keunggulan' => ['required', 'string'],
            'paten' => ['required', 'string'],
            'kesiapan_teknologi' => ['required', 'string'],
            'kesiapan_pasar' => ['required', 'string'],
            'nama' => ['required', 'string'],
            'phone' => ['required'],
            'mobile' => ['required'],
            'fax' => ['required'],
            'email' => ['required', 'email:rfc:dns'],
        ]);
        $data = [
            'title' => $validatedData['judul'],
            'sub_title' => $validatedData['sub_judul'],
            'introduction' => $validatedData['pendahuluan'],
            'tech_product' => $validatedData['produk_teknologi'],
            'supremacy' => $validatedData['keunggulan'],
            'patent' => $validatedData['paten'],
            'tech_preparation' => $validatedData['kesiapan_teknologi'],
            'market_preparation' => $validatedData['kesiapan_pasar'],
            'name' => $validatedData['nama'],
            'phone' => $validatedData['phone'],
            'mobile' => $validatedData['mobile'],
            'fax' => $validatedData['fax'],
            'email' => $validatedData['email'],
            'katsinov_id' => $katsinov_id
        ];
        $inovasi = KatsinovInovasi::where('katsinov_id', $katsinov_id)->first();



        if ($inovasi) {
            // Update existing record
            $inovasi->update($data);
            $message = 'Data inovasi berhasil diperbarui!';
        } else {
            // Create new record
            KatsinovInovasi::create($data);
            $message = 'Data inovasi berhasil disimpan!';
        }

        $role = Auth::user()->role;

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.TableKatsinov',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.tablekatsinov',
            'dosen' => 'subdirektorat-inovasi.dosen.tablekatsinov',
            'validator' => 'subdirektorat-inovasi.validator.tablekatsinov',
            'registered_user' => 'subdirektorat-inovasi.registered_user.tablekatsinov',
            default => 'admin.katsinov.tablekatsinov',
        };

        return redirect(route($view))->with('success', $message);
    }

    public function informationIndex($katsinov_id = null)
    {
        $katsinov = Katsinov::find($katsinov_id);
        if (!$katsinov) {
            return redirect()->back()->with('error', 'Katsinov data not found');
        }

        $role = Auth::user()->role;
        $informasi = $katsinov->katsinovInformasis()->first();
        $informasiCollection = null;

        if (!is_null($informasi)) {
            $informasiCollection = KatsinovInformasiCollection::where('katsinov_informasi_id', $informasi->id)->get([
                'field',
                'index',
                'attribute',
                'value'
            ])->toArray();
        }

        $groupedData = [];

        if (!is_null($informasiCollection)) {
            foreach ($informasiCollection as $item) {
                $field = $item['field'];
                $index = $item['index'];

                if (!isset($groupedData[$field][$index])) {
                    $groupedData[$field][$index] = [];
                }
                $groupedData[$field][$index][$item['attribute']] = $item['value'];
            }
        }

        // Determine the view based on user role
        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.forminformasidasar',
            'dosen' => 'subdirektorat-inovasi.dosen.forminformasidasar',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.forminformasidasar',
            'validator' => 'subdirektorat-inovasi.validator.forminformasidasar',
            'registered_user' => 'subdirektorat-inovasi.registered_user.forminformasidasar',
            default => 'admin.katsinov.forminformasidasar',
        };

        return view($view, [
            'id' => $katsinov->id,
            'informasi' => $informasi ?? null,
            'informasi_team' => $groupedData['team'] ?? null,
            'informasi_program' => $groupedData['program_implementation'] ?? null,
            'informasi_partner' => $groupedData['innovation_partner'] ?? null,
            'informasi_tech' => $groupedData['information_tech'] ?? null,
            'informasi_market' => $groupedData['information_market'] ?? null,
        ]);
    }

    public function informationStore(Request $request, $katsinov_id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'person_in_charge' => ['required'],
            'pic_institution' => ['required'],
            'pic_address' => ['required'],
            'pic_phone' => ['required'],
            'pic_fax' => ['required'],
            'innovation_title' => ['required'],
            'innovation_name' => ['required'],
            'innovation_type' => ['required'],
            'innovation_field' => ['required'],
            'innovation_application' => ['required'],
            'innovation_duration' => ['required'],
            'innovation_year' => ['required'],
            'innovation_summary' => ['required'],
            'innovation_novelty' => ['required'],
            'innovation_supremacy' => ['required'],
            'team' => ['required', 'array', 'min:1'],
            'program_implementation' => ['required', 'array', 'min:1'],
            'innovation_partner' => ['required', 'array', 'min:1'],
            'information_tech' => ['required', 'array', 'min:1'],
            'information_market' => ['required', 'array', 'min:1'],
        ]);

        $informasi = KatsinovInformasi::where('katsinov_id', $katsinov_id)->first();
        if ($informasi) {
            // Update existing record
            $informasi->update([
                'pic' => $validatedData['person_in_charge'],
                'address' => $validatedData['pic_address'],
                'institution' => $validatedData['pic_institution'],
                'phone' => $validatedData['pic_phone'],
                'fax' => $validatedData['pic_fax'],
                'innovation_title' => $validatedData['innovation_title'],
                'innovation_name'  => $validatedData['innovation_name'],
                'innovation_type'  => $validatedData['innovation_type'],
                'innovation_field'  => $validatedData['innovation_field'],
                'innovation_application'  => $validatedData['innovation_application'],
                'innovation_duration'  => $validatedData['innovation_duration'],
                'innovation_year'  => $validatedData['innovation_year'],
                'innovation_summary'  => $validatedData['innovation_summary'],
                'innovation_supremacy'  => $validatedData['innovation_supremacy'],
                'innovation_novelty'  => $validatedData['innovation_novelty'],
                'katsinov_id' => $katsinov_id
            ]);
        } else {
            $informasi =  KatsinovInformasi::create([
                'pic' => $validatedData['person_in_charge'],
                'address' => $validatedData['pic_address'],
                'institution' => $validatedData['pic_institution'],
                'phone' => $validatedData['pic_phone'],
                'fax' => $validatedData['pic_fax'],
                'innovation_title' => $validatedData['innovation_title'],
                'innovation_name'  => $validatedData['innovation_name'],
                'innovation_type'  => $validatedData['innovation_type'],
                'innovation_field'  => $validatedData['innovation_field'],
                'innovation_application'  => $validatedData['innovation_application'],
                'innovation_duration'  => $validatedData['innovation_duration'],
                'innovation_year'  => $validatedData['innovation_year'],
                'innovation_summary'  => $validatedData['innovation_summary'],
                'innovation_supremacy'  => $validatedData['innovation_supremacy'],
                'innovation_novelty'  => $validatedData['innovation_novelty'],
                'katsinov_id' => $katsinov_id
            ]);
        }
        // Delete existing related collections to avoid duplicates
        if ($informasi) {
            $informasi->katsinovInformasiCollections()->delete();
        }

        $now = now();
        $collections = [];
        // there must be a better way to do this, I just do this several foreach to get the thing done faster
        // processing of array input
        foreach ($request->team as $index => $array) {
            foreach ($array as $key => $value) {
                $collections[] = [
                    'field' => 'team',
                    'index' => $index,
                    'attribute' => $key,
                    'value' => $value,
                    'katsinov_informasi_id' => $informasi->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        foreach ($request->program_implementation as $index => $array) {
            foreach ($array as $key => $value) {
                $collections[] = [
                    'field' => 'program_implementation',
                    'index' => $index,
                    'attribute' => $key,
                    'value' => $value,
                    'katsinov_informasi_id' => $informasi->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        foreach ($request->innovation_partner as $index => $array) {
            foreach ($array as $key => $value) {
                $collections[] = [
                    'field' => 'innovation_partner',
                    'index' => $index,
                    'attribute' => $key,
                    'value' => $value,
                    'katsinov_informasi_id' => $informasi->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        foreach ($request->information_tech as $index => $array) {
            foreach ($array as $key => $value) {
                $collections[] = [
                    'field' => 'information_tech',
                    'index' => $index,
                    'attribute' => $key,
                    'value' => $value,
                    'katsinov_informasi_id' => $informasi->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        foreach ($request->information_market as $index => $array) {
            foreach ($array as $key => $value) {
                $collections[] = [
                    'field' => 'information_market',
                    'index' => $index,
                    'attribute' => $key,
                    'value' => $value,
                    'katsinov_informasi_id' => $informasi->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        KatsinovInformasiCollection::insert($collections);


        // Create or update the record

        $role = Auth::user()->role;

        $route = match ($role) {
            'admin_direktorat' => 'admin.katsinov.TableKatsinov',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.tablekatsinov',
            'dosen' => 'subdirektorat-inovasi.dosen.tablekatsinov',
            'validator' => 'subdirektorat-inovasi.validator.tablekatsinov',
            'registered_user' => 'subdirektorat-inovasi.registered_user.tablekatsinov',
            default => 'admin.katsinov.TableKatsinov',
        };
        // return redirect(route($route))->with('success', $message);
        return redirect()->route($route)->with('success', 'Data informasi berhasil ' . ($informasi ? 'diperbarui' : 'disimpan'));
    }



    public function beritaIndex($katsinov_id = null)
    {
        $katsinov = Katsinov::find($katsinov_id);
        // dd($berita->day);

        if (!$katsinov) {
            return redirect()->back()->with('error', 'Katsinov data not found');
        }

        $berita = $katsinov->katsinovBeritas()->first();
        $role = Auth::user()->role;

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.formberitaacara',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.formberitaacara',
            'dosen' => 'subdirektorat-inovasi.dosen.formberitaacara',
            'validator' => 'subdirektorat-inovasi.validator.formberitaacara',
            'registered_user' => 'subdirektorat-inovasi.registered_user.formberitaacara',
            default => 'admin.katsinov.formberitaacara',
        };


        return view($view, [
            'id' => $katsinov->id,
            'berita' => $berita,
        ]);
    }

    public function beritaStore(Request $request, $katsinov_id)
    {
        try { // dd($request->all());
            $validatedData = $request->validate([
                'text_day' => ['required', 'string'],
                'text_date' => ['required', 'string'],
                'text_month' => ['required', 'string'],
                'text_year' => ['required', 'string'],
                'text_yearfull' => ['required', 'string'],
                'text_decree' => ['required', 'string'],
                'text_place' => ['required', 'string'],
                'innovation_title' => ['required', 'string'],
                'innovation_type' => ['required', 'string'],
                'innovation_tki' => ['required', 'string'],
                'innovation_opinion' => ['required', 'string'],
                'innovation_date' => ['required', 'string'],
                'penanggungjawab' => ['required', 'string'],
                'ketua' => ['required', 'string'],
                'anggota1' => ['required', 'string'],
                'anggota2' => ['required', 'string'],
                'penanggungjawab_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
                'ketua_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
                'anggota1_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
                'anggota2_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            ]);

            $berita = KatsinovBerita::where('katsinov_id', $katsinov_id)->first();

            $pdfFields = [
                'penanggungjawab_pdf',
                'ketua_pdf',
                'anggota1_pdf',
                'anggota2_pdf'
            ];

            $pdfPaths = [];

            foreach ($pdfFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();

                    // Store file in public disk under signatures directory
                    $path = $file->storeAs('signatures', $filename, 'public');
                    $pdfPaths[$field] = $filename;

                    \Log::info("File stored: {$path}");
                } elseif ($berita && $berita->{$field}) {
                    // Keep existing file if no new file is uploaded
                    $pdfPaths[$field] = $berita->{$field};
                }
            }

            $beritaData = [
                'day' => $validatedData['text_day'],
                'date' => $validatedData['text_date'],
                'month' => $validatedData['text_month'],
                'year' => $validatedData['text_year'],
                'yearfull' => $validatedData['text_yearfull'],
                'decree' => $validatedData['text_decree'],
                'place' => $validatedData['text_place'],
                'title' => $validatedData['innovation_title'],
                'type' => $validatedData['innovation_type'],
                'tki' => $validatedData['innovation_tki'],
                'opinion' => $validatedData['innovation_opinion'],
                'sign_date' => $validatedData['innovation_date'],
                'penanggungjawab' => $validatedData['penanggungjawab'],
                'ketua' => $validatedData['ketua'],
                'anggota1' => $validatedData['anggota1'],
                'anggota2' => $validatedData['anggota2'],
                'penanggungjawab_pdf' => $pdfPaths['penanggungjawab_pdf'] ?? null,
                'ketua_pdf' => $pdfPaths['ketua_pdf'] ?? null,
                'anggota1_pdf' => $pdfPaths['anggota1_pdf'] ?? null,
                'anggota2_pdf' => $pdfPaths['anggota2_pdf'] ?? null,
                'katsinov_id' => $katsinov_id,
            ];

            // Create or update the record
            if ($berita) {
                $berita->update($beritaData);
                $message = 'Berita acara berhasil diperbarui';
                \Log::info('Berita updated:', $berita->toArray());
            } else {
                $berita = KatsinovBerita::create($beritaData);
                $message = 'Berita acara berhasil disimpan';
                \Log::info('Berita created:', $berita->toArray());
            }
            $role = Auth::user()->role;

            $view = match ($role) {
                'admin_direktorat' => 'admin.katsinov.TableKatsinov',
                'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.tablekatsinov',
                'dosen' => 'subdirektorat-inovasi.dosen.tablekatsinov',
                'validator' => 'subdirektorat-inovasi.validator.tablekatsinov',
                'registered_user' => 'subdirektorat-inovasi.registered_user.tablekatsinov',
                default => 'admin.katsinov.tablekatsinov',
            };

            return redirect(route($view))->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Error storing berita: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function viewSignature($id, $type)
    {
        $berita = KatsinovBerita::findOrFail($id);

        $fieldMap = [
            'penanggungjawab' => 'penanggungjawab_pdf',
            'ketua' => 'ketua_pdf',
            'anggota1' => 'anggota1_pdf',
            'anggota2' => 'anggota2_pdf'
        ];

        if (!array_key_exists($type, $fieldMap)) {
            abort(404, 'Jenis tanda tangan tidak valid');
        }

        $filename = $berita->{$fieldMap[$type]};

        if (!$filename) {
            abort(404, 'Dokumen tanda tangan tidak ditemukan');
        }

        $path = storage_path('app/public/signatures/' . $filename);

        if (!file_exists($path)) {
            \Log::error("Signature file not found: {$path}");
            abort(404, 'File tanda tangan tidak ditemukan di server');
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function recordIndex($katsinov_id = null)
    {
        $katsinov = Katsinov::find($katsinov_id);
        $record = $katsinov->formRecordHasilPengukuran()->first();

        $role = Auth::user()->role;

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.formrecordhasilpengukuran',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.formrecordhasilpengukuran',
            'dosen' => 'subdirektorat-inovasi.dosen.formrecordhasilpengukuran',
            'validator' => 'subdirektorat-inovasi.validator.formrecordhasilpengukuran',
            'registered_user' => 'subdirektorat-inovasi.registered_user.formrecordhasilpengukuran',
            default => 'admin.katsinov.formrecordhasilpengukuran',
        };

        return view($view, [
            'id' => $katsinov->id, // Pastikan variabel ini dikirim
            'katsinov' => $katsinov, // Optional: kirim full object jika diperlukan
            'record' => $record,
        ]);
    }

    public function recordStore(Request $request, $katsinov_id)
    {
        $validationRules = [
            'nama_penanggung_jawab' => 'required|string|max:255',
            'institusi' => 'required|string|max:255',
            'judul_inovasi' => 'required|string|max:255',
            'jenis_inovasi' => 'required|string|max:255',
            'alamat_kontak' => 'required|string',
            'phone' => 'required|string|max:20',
            'fax' => 'required|string|max:20',
            'tanggal_penilaian' => 'required|string',
        ];

        // Generate rules untuk 5 aspek
        for ($i = 1; $i <= 5; $i++) {
            $validationRules["aspek_$i"] = 'required|string|max:255';
            $validationRules["aktivitas_$i"] = 'required|string|max:255';
            $validationRules["capaian_$i"] = 'required|integer|min:0|max:100';
            $validationRules["keterangan_$i"] = 'required|string|max:255';
            $validationRules["catatan_$i"] = 'required|string|max:255';
        }

        $validatedData = $request->validate($validationRules);

        try {
            // Simpan ke database
            FormRecordHasilPengukuran::updateOrCreate(
                ['katsinov_id' => $katsinov_id],
                array_merge($validatedData, ['katsinov_id' => $katsinov_id])
            );

            $role = Auth::user()->role;
            $view = match ($role) {
                'admin_direktorat' => 'admin.katsinov.TableKatsinov',
                'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.tablekatsinov',
                'dosen' => 'subdirektorat-inovasi.dosen.tablekatsinov',
                'validator' => 'subdirektorat-inovasi.validator.tablekatsinov',
                'registered_user' => 'subdirektorat-inovasi.registered_user.tablekatsinov',
                default => 'admin.katsinov.tablekatsinov',
            };

            return redirect()->route($view)
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
    public function recordShow($katsinov_id)
    {
        try {
            // Load Katsinov dengan eager loading relasi scores
            $katsinov = Katsinov::with(['scores', 'responses', 'formRecordHasilPengukuran'])->findOrFail($katsinov_id);

            // Logging untuk debug
            \Log::info('Katsinov data loaded', [
                'id' => $katsinov->id,
                'has_scores' => $katsinov->scores->count() > 0,
                'scores_count' => $katsinov->scores->count(),
                'raw_scores' => $katsinov->scores->toArray() // Log data skor mentah untuk inspeksi
            ]);

            // Get record jika ada, atau buat instance baru
            $record = $katsinov->formRecordHasilPengukuran ?? new FormRecordHasilPengukuran([
                'katsinov_id' => $katsinov_id,
                'judul_inovasi' => $katsinov->title,
                'rekomendasi' => '' // Default empty recommendation
            ]);

            // Hitung skor rata-rata dengan fallback value (default value)
            // dan tambahkan debugging untuk setiap aspek
            $aspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores, 'technology'),
                'organization' => $this->getAverageScore($katsinov->scores, 'organization'),
                'risk' => $this->getAverageScore($katsinov->scores, 'risk'),
                'market' => $this->getAverageScore($katsinov->scores, 'market'),
                'partnership' => $this->getAverageScore($katsinov->scores, 'partnership'),
                'manufacturing' => $this->getAverageScore($katsinov->scores, 'manufacturing'),
                'investment' => $this->getAverageScore($katsinov->scores, 'investment')
            ];

            // Log skor hasil kalkulasi untuk debugging
            \Log::info('Calculated aspect scores', $aspectScores);

            // Jika semua nilai masih 0, gunakan data dummy untuk testing
            $allZeros = array_sum(array_values($aspectScores)) == 0;
            if ($allZeros) {
                \Log::warning('All aspect scores are zero, check KatsinovScore records for this Katsinov');

                // Opsi: Gunakan nilai dummy untuk testing tampilan chart
                // Uncomment baris di bawah untuk menggunakan data dummy
                /*
            $aspectScores = [
                'technology' => 75,
                'organization' => 60,
                'risk' => 45,
                'market' => 85,
                'partnership' => 50,
                'manufacturing' => 70,
                'investment' => 55
            ];
            */
            }

            return view('admin.katsinov.summarykatsinov', compact('katsinov', 'record', 'aspectScores'));
        } catch (\Exception $e) {
            \Log::error('Error in recordShow: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'Data tidak dapat ditampilkan: ' . $e->getMessage());
        }
    }

    // Helper method untuk menghitung rata-rata dengan debugging
    private function getAverageScore($scores, $field)
    {
        if ($scores->isEmpty()) {
            \Log::warning("No scores found for field: {$field}");
            return 0;
        }

        $values = $scores->pluck($field)->filter()->toArray();
        $count = count($values);

        if ($count === 0) {
            \Log::warning("Field {$field} has no valid values");
            return 0;
        }

        $sum = array_sum($values);
        $avg = $sum / $count;

        \Log::info("Field {$field} calculation", [
            'values' => $values,
            'count' => $count,
            'sum' => $sum,
            'average' => $avg
        ]);

        return $avg;
    }
    public function summaryIndicatorOne($katsinov_id)
    {
        try {
            $katsinov = Katsinov::with(['scores', 'responses', 'formRecordHasilPengukuran'])->findOrFail($katsinov_id);

            // Get all responses for Indicator 1
            $indicator1Responses = $katsinov->responses()->where('indicator_number', 1)->get();

            // Group the responses by aspect
            $aspectResponses = [];
            $aspectCodes = ['T', 'M', 'O', 'Mf', 'P', 'I', 'R'];

            foreach ($aspectCodes as $code) {
                $aspectResponses[$code] = $indicator1Responses->where('aspect', $code)->values();
            }

            // Calculate overall aspect scores
            $aspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores->where('indicator_number', 1), 'technology'),
                'market' => $this->getAverageScore($katsinov->scores->where('indicator_number', 1), 'market'),
                'organization' => $this->getAverageScore($katsinov->scores->where('indicator_number', 1), 'organization'),
                'manufacturing' => $this->getAverageScore($katsinov->scores->where('indicator_number', 1), 'manufacturing'),
                'partnership' => $this->getAverageScore($katsinov->scores->where('indicator_number', 1), 'partnership'),
                'investment' => $this->getAverageScore($katsinov->scores->where('indicator_number', 1), 'investment'),
                'risk' => $this->getAverageScore($katsinov->scores->where('indicator_number', 1), 'risk')
            ];

            // Calculate categories for all aspects
            $categories = [];
            foreach ($aspectScores as $key => $score) {
                $categories[$key] = $this->getScoreCategory($score);
            }

            // Prepare question-level scores for each aspect
            $questionScores = [
                'technology' => [],
                'market' => [],
                'organization' => [],
                'manufacturing' => [],
                'partnership' => [],
                'investment' => [],
                'risk' => []
            ];

            // Map the aspect codes to keys
            $aspectMap = [
                'T' => 'technology',
                'M' => 'market',
                'O' => 'organization',
                'Mf' => 'manufacturing',
                'P' => 'partnership',
                'I' => 'investment',
                'R' => 'risk'
            ];

            // Fill the question scores array
            foreach ($indicator1Responses as $response) {
                $aspect = $aspectMap[$response->aspect] ?? null;
                if ($aspect) {
                    // Map row numbers to question indices (0-based for JavaScript arrays)
                    $questionIndex = $response->row_number - 1;
                    $questionScores[$aspect][$questionIndex] = $response->score;
                }
            }

            $record = $katsinov->formRecordHasilPengukuran ?? new FormRecordHasilPengukuran([
                'katsinov_id' => $katsinov_id,
                'rekomendasi' => ''
            ]);

            return view('admin.katsinov.summary_indicator_one', compact(
                'katsinov',
                'aspectScores',
                'questionScores',
                'record',
                'categories',
                'aspectResponses'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in summaryIndicatorOne: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data tidak dapat ditampilkan: ' . $e->getMessage());
        }
    }


    public function summaryIndicatorTwo($katsinov_id)
    {
        try {
            $katsinov = Katsinov::with(['scores', 'responses', 'formRecordHasilPengukuran'])->findOrFail($katsinov_id);

            // Get all responses for Indicator 2
            $indicator2Responses = $katsinov->responses()->where('indicator_number', 2)->get();

            // Group the responses by aspect
            $aspectResponses = [];
            $aspectCodes = ['T', 'M', 'O', 'Mf', 'P', 'I', 'R'];

            foreach ($aspectCodes as $code) {
                $aspectResponses[$code] = $indicator2Responses->where('aspect', $code)->values();
            }

            // Calculate overall aspect scores
            $aspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores->where('indicator_number', 2), 'technology'),
                'market' => $this->getAverageScore($katsinov->scores->where('indicator_number', 2), 'market'),
                'organization' => $this->getAverageScore($katsinov->scores->where('indicator_number', 2), 'organization'),
                'manufacturing' => $this->getAverageScore($katsinov->scores->where('indicator_number', 2), 'manufacturing'),
                'partnership' => $this->getAverageScore($katsinov->scores->where('indicator_number', 2), 'partnership'),
                'investment' => $this->getAverageScore($katsinov->scores->where('indicator_number', 2), 'investment'),
                'risk' => $this->getAverageScore($katsinov->scores->where('indicator_number', 2), 'risk')
            ];

            // Calculate categories for all aspects
            $categories = [];
            foreach ($aspectScores as $key => $score) {
                $categories[$key] = $this->getScoreCategory($score);
            }

            // Prepare question-level scores for each aspect
            $questionScores = [
                'technology' => [],
                'market' => [],
                'organization' => [],
                'manufacturing' => [],
                'partnership' => [],
                'investment' => [],
                'risk' => []
            ];

            // Map the aspect codes to keys
            $aspectMap = [
                'T' => 'technology',
                'M' => 'market',
                'O' => 'organization',
                'Mf' => 'manufacturing',
                'P' => 'partnership',
                'I' => 'investment',
                'R' => 'risk'
            ];

            // Fill the question scores array
            foreach ($indicator2Responses as $response) {
                $aspect = $aspectMap[$response->aspect] ?? null;
                if ($aspect) {
                    // Map row numbers to question indices (0-based for JavaScript arrays)
                    $questionIndex = $response->row_number - 1;
                    $questionScores[$aspect][$questionIndex] = $response->score;
                }
            }

            $record = $katsinov->formRecordHasilPengukuran ?? new FormRecordHasilPengukuran([
                'katsinov_id' => $katsinov_id,
                'rekomendasi' => ''
            ]);

            return view('admin.katsinov.summary_indicator_two', compact(
                'katsinov',
                'aspectScores',
                'questionScores',
                'record',
                'categories',
                'aspectResponses'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in summaryIndicatorTwo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data tidak dapat ditampilkan: ' . $e->getMessage());
        }
    }
    public function summaryIndicatorThree($katsinov_id)
    {
        try {
            $katsinov = Katsinov::with(['scores', 'responses', 'formRecordHasilPengukuran'])->findOrFail($katsinov_id);

            // Get all responses for Indicator 3
            $indicator3Responses = $katsinov->responses()->where('indicator_number', 3)->get();

            // Group the responses by aspect
            $aspectResponses = [];
            $aspectCodes = ['T', 'M', 'O', 'Mf', 'P', 'I', 'R'];

            foreach ($aspectCodes as $code) {
                $aspectResponses[$code] = $indicator3Responses->where('aspect', $code)->values();
            }

            // Calculate overall aspect scores
            $aspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores->where('indicator_number', 3), 'technology'),
                'market' => $this->getAverageScore($katsinov->scores->where('indicator_number', 3), 'market'),
                'organization' => $this->getAverageScore($katsinov->scores->where('indicator_number', 3), 'organization'),
                'manufacturing' => $this->getAverageScore($katsinov->scores->where('indicator_number', 3), 'manufacturing'),
                'partnership' => $this->getAverageScore($katsinov->scores->where('indicator_number', 3), 'partnership'),
                'investment' => $this->getAverageScore($katsinov->scores->where('indicator_number', 3), 'investment'),
                'risk' => $this->getAverageScore($katsinov->scores->where('indicator_number', 3), 'risk')
            ];

            // Calculate categories for all aspects
            $categories = [];
            foreach ($aspectScores as $key => $score) {
                $categories[$key] = $this->getScoreCategory($score);
            }

            // Prepare question-level scores for each aspect
            $questionScores = [
                'technology' => [],
                'market' => [],
                'organization' => [],
                'manufacturing' => [],
                'partnership' => [],
                'investment' => [],
                'risk' => []
            ];

            // Map the aspect codes to keys
            $aspectMap = [
                'T' => 'technology',
                'M' => 'market',
                'O' => 'organization',
                'Mf' => 'manufacturing',
                'P' => 'partnership',
                'I' => 'investment',
                'R' => 'risk'
            ];

            // Fill the question scores array
            foreach ($indicator3Responses as $response) {
                $aspect = $aspectMap[$response->aspect] ?? null;
                if ($aspect) {
                    // Map row numbers to question indices (0-based for JavaScript arrays)
                    $questionIndex = $response->row_number - 1;
                    $questionScores[$aspect][$questionIndex] = $response->score;
                }
            }

            $record = $katsinov->formRecordHasilPengukuran ?? new FormRecordHasilPengukuran([
                'katsinov_id' => $katsinov_id,
                'rekomendasi' => ''
            ]);

            return view('admin.katsinov.summary_indicator_three', compact(
                'katsinov',
                'aspectScores',
                'questionScores',
                'record',
                'categories',
                'aspectResponses'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in summaryIndicatorThree: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data tidak dapat ditampilkan: ' . $e->getMessage());
        }
    }
    public function summaryIndicatorFour($katsinov_id)
    {
        try {
            $katsinov = Katsinov::with(['scores', 'responses', 'formRecordHasilPengukuran'])->findOrFail($katsinov_id);

            // Get all responses for Indicator 4
            $indicator4Responses = $katsinov->responses()->where('indicator_number', 4)->get();

            // Group the responses by aspect
            $aspectResponses = [];
            $aspectCodes = ['T', 'M', 'O', 'Mf', 'P', 'I', 'R'];

            foreach ($aspectCodes as $code) {
                $aspectResponses[$code] = $indicator4Responses->where('aspect', $code)->values();
            }

            // Calculate overall aspect scores
            $aspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores->where('indicator_number', 4), 'technology'),
                'market' => $this->getAverageScore($katsinov->scores->where('indicator_number', 4), 'market'),
                'organization' => $this->getAverageScore($katsinov->scores->where('indicator_number', 4), 'organization'),
                'manufacturing' => $this->getAverageScore($katsinov->scores->where('indicator_number', 4), 'manufacturing'),
                'partnership' => $this->getAverageScore($katsinov->scores->where('indicator_number', 4), 'partnership'),
                'investment' => $this->getAverageScore($katsinov->scores->where('indicator_number', 4), 'investment'),
                'risk' => $this->getAverageScore($katsinov->scores->where('indicator_number', 4), 'risk')
            ];

            // Calculate categories for all aspects
            $categories = [];
            foreach ($aspectScores as $key => $score) {
                $categories[$key] = $this->getScoreCategory($score);
            }

            // Prepare question-level scores for each aspect
            $questionScores = [
                'technology' => [],
                'market' => [],
                'organization' => [],
                'manufacturing' => [],
                'partnership' => [],
                'investment' => [],
                'risk' => []
            ];

            // Map the aspect codes to keys
            $aspectMap = [
                'T' => 'technology',
                'M' => 'market',
                'O' => 'organization',
                'Mf' => 'manufacturing',
                'P' => 'partnership',
                'I' => 'investment',
                'R' => 'risk'
            ];

            // Fill the question scores array
            foreach ($indicator4Responses as $response) {
                $aspect = $aspectMap[$response->aspect] ?? null;
                if ($aspect) {
                    // Map row numbers to question indices (0-based for JavaScript arrays)
                    $questionIndex = $response->row_number - 1;
                    $questionScores[$aspect][$questionIndex] = $response->score;
                }
            }

            $record = $katsinov->formRecordHasilPengukuran ?? new FormRecordHasilPengukuran([
                'katsinov_id' => $katsinov_id,
                'rekomendasi' => ''
            ]);

            return view('admin.katsinov.summary_indicator_four', compact(
                'katsinov',
                'aspectScores',
                'questionScores',
                'record',
                'categories',
                'aspectResponses'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in summaryIndicatorFour: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data tidak dapat ditampilkan: ' . $e->getMessage());
        }
    }
    public function summaryIndicatorFive($katsinov_id)
    {
        try {
            $katsinov = Katsinov::with(['scores', 'responses', 'formRecordHasilPengukuran'])->findOrFail($katsinov_id);

            // Get all responses for Indicator 5
            $indicator5Responses = $katsinov->responses()->where('indicator_number', 5)->get();

            // Group the responses by aspect
            $aspectResponses = [];
            $aspectCodes = ['T', 'M', 'O', 'Mf', 'P', 'I', 'R'];

            foreach ($aspectCodes as $code) {
                $aspectResponses[$code] = $indicator5Responses->where('aspect', $code)->values();
            }

            // Calculate overall aspect scores
            $aspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores->where('indicator_number', 5), 'technology'),
                'market' => $this->getAverageScore($katsinov->scores->where('indicator_number', 5), 'market'),
                'organization' => $this->getAverageScore($katsinov->scores->where('indicator_number', 5), 'organization'),
                'manufacturing' => $this->getAverageScore($katsinov->scores->where('indicator_number', 5), 'manufacturing'),
                'partnership' => $this->getAverageScore($katsinov->scores->where('indicator_number', 5), 'partnership'),
                'investment' => $this->getAverageScore($katsinov->scores->where('indicator_number', 5), 'investment'),
                'risk' => $this->getAverageScore($katsinov->scores->where('indicator_number', 5), 'risk')
            ];

            // Calculate categories for all aspects
            $categories = [];
            foreach ($aspectScores as $key => $score) {
                $categories[$key] = $this->getScoreCategory($score);
            }

            // Prepare question-level scores for each aspect
            $questionScores = [
                'technology' => [],
                'market' => [],
                'organization' => [],
                'manufacturing' => [],
                'partnership' => [],
                'investment' => [],
                'risk' => []
            ];

            // Map the aspect codes to keys
            $aspectMap = [
                'T' => 'technology',
                'M' => 'market',
                'O' => 'organization',
                'Mf' => 'manufacturing',
                'P' => 'partnership',
                'I' => 'investment',
                'R' => 'risk'
            ];

            // Fill the question scores array
            foreach ($indicator5Responses as $response) {
                $aspect = $aspectMap[$response->aspect] ?? null;
                if ($aspect) {
                    // For Indicator 5, map row numbers to indices based on the specific structure
                    $rowToIndexMap = [
                        // Technology questions
                        1 => ['technology', 0],
                        2 => ['technology', 1],
                        3 => ['technology', 2],
                        4 => ['technology', 3],
                        // Market questions
                        5 => ['market', 0],
                        6 => ['market', 1],
                        7 => ['market', 2],
                        8 => ['market', 3],
                        // Organization questions
                        9 => ['organization', 0],
                        10 => ['organization', 1],
                        11 => ['organization', 2],
                        12 => ['organization', 3],
                        // Manufacturing questions
                        13 => ['manufacturing', 0],
                        14 => ['manufacturing', 1],
                        15 => ['manufacturing', 2],
                        16 => ['manufacturing', 3],
                        // Investment questions
                        17 => ['investment', 0],
                        18 => ['investment', 1],
                        // Partnership questions
                        19 => ['partnership', 0],
                        20 => ['partnership', 1],
                        21 => ['partnership', 2],
                        // Risk questions
                        22 => ['risk', 0],
                        23 => ['risk', 1],
                        24 => ['risk', 2]
                    ];

                    if (isset($rowToIndexMap[$response->row_number])) {
                        list($mappedAspect, $questionIndex) = $rowToIndexMap[$response->row_number];
                        $questionScores[$mappedAspect][$questionIndex] = $response->score;
                    }
                }
            }

            $record = $katsinov->formRecordHasilPengukuran ?? new FormRecordHasilPengukuran([
                'katsinov_id' => $katsinov_id,
                'rekomendasi' => ''
            ]);

            return view('admin.katsinov.summary_indicator_five', compact(
                'katsinov',
                'aspectScores',
                'questionScores',
                'record',
                'categories',
                'aspectResponses'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in summaryIndicatorFive: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data tidak dapat ditampilkan: ' . $e->getMessage());
        }
    }
    public function summaryIndicatorSix($katsinov_id)
    {
        try {
            $katsinov = Katsinov::with(['scores', 'responses', 'formRecordHasilPengukuran'])->findOrFail($katsinov_id);

            // Get all responses for Indicator 6
            $indicator6Responses = $katsinov->responses()->where('indicator_number', 6)->get();

            // Group the responses by aspect
            $aspectResponses = [];
            $aspectCodes = ['T', 'M', 'O', 'Mf', 'P', 'I', 'R'];

            foreach ($aspectCodes as $code) {
                $aspectResponses[$code] = $indicator6Responses->where('aspect', $code)->values();
            }

            // Calculate overall aspect scores
            $aspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores->where('indicator_number', 6), 'technology'),
                'market' => $this->getAverageScore($katsinov->scores->where('indicator_number', 6), 'market'),
                'organization' => $this->getAverageScore($katsinov->scores->where('indicator_number', 6), 'organization'),
                'manufacturing' => $this->getAverageScore($katsinov->scores->where('indicator_number', 6), 'manufacturing'),
                'partnership' => $this->getAverageScore($katsinov->scores->where('indicator_number', 6), 'partnership'),
                'investment' => $this->getAverageScore($katsinov->scores->where('indicator_number', 6), 'investment'),
                'risk' => $this->getAverageScore($katsinov->scores->where('indicator_number', 6), 'risk')
            ];

            // Calculate categories for all aspects
            $categories = [];
            foreach ($aspectScores as $key => $score) {
                $categories[$key] = $this->getScoreCategory($score);
            }

            // Prepare question-level scores for each aspect
            $questionScores = [
                'technology' => [],
                'market' => [],
                'organization' => [],
                'manufacturing' => [],
                'partnership' => [],
                'investment' => [],
                'risk' => []
            ];

            // Map the aspect codes to keys
            $aspectMap = [
                'T' => 'technology',
                'M' => 'market',
                'O' => 'organization',
                'Mf' => 'manufacturing',
                'P' => 'partnership',
                'I' => 'investment',
                'R' => 'risk'
            ];

            // Question index mapping for Indicator 6
            $questionIndexMap = [
                'technology' => [0, 1, 2],
                'market' => [3, 4, 5, 6],
                'organization' => [7, 8],
                'manufacturing' => [9],
                'partnership' => [11, 12],
                'investment' => [10],
                'risk' => [13]
            ];

            // Fill the question scores array
            foreach ($indicator6Responses as $response) {
                $aspect = $aspectMap[$response->aspect] ?? null;
                if ($aspect) {
                    // Map row numbers to question indices
                    $questionIndex = $response->row_number - 1;
                    $questionScores[$aspect][$questionIndex] = $response->score;
                }
            }

            $record = $katsinov->formRecordHasilPengukuran ?? new FormRecordHasilPengukuran([
                'katsinov_id' => $katsinov_id,
                'rekomendasi' => ''
            ]);

            return view('admin.katsinov.summary_indicator_six', compact(
                'katsinov',
                'aspectScores',
                'questionScores',
                'record',
                'categories',
                'aspectResponses'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in summaryIndicatorSix: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data tidak dapat ditampilkan: ' . $e->getMessage());
        }
    }

    // Existing getScoreCategory method (if not already present)
    private function getScoreCategory($score)
    {
        if ($score >= 80) {
            return 'Sangat Siap';
        } elseif ($score >= 60) {
            return 'Siap';
        } elseif ($score >= 40) {
            return 'Cukup Siap';
        } elseif ($score >= 20) {
            return 'Kurang Siap';
        } else {
            return 'Tidak Siap';
        }
    }
    public function summaryAspects($katsinov_id)
    {
        try {
            // Define aspects
            $aspects = [
                'technology' => 'Teknologi (T)',
                'market' => 'Pasar (M)',
                'organization' => 'Organisasi (O)',
                'manufacturing' => 'Manufaktur (Mf)',
                'partnership' => 'Kemitraan (P)',
                'investment' => 'Investasi (I)',
                'risk' => 'Risiko (R)'
            ];

            // Define aspect colors
            $aspectColors = [
                'technology' => 'rgb(255, 99, 132)',
                'market' => 'rgb(54, 162, 235)',
                'organization' => 'rgb(255, 206, 86)',
                'manufacturing' => 'rgb(75, 192, 192)',
                'partnership' => 'rgb(153, 102, 255)',
                'investment' => 'rgb(255, 159, 64)',
                'risk' => 'rgb(70, 150, 130)'
            ];

            // Prepare data structure for the chart
            $aspectData = [];
            foreach ($aspects as $key => $name) {
                $aspectData[$key] = [
                    'name' => $name,
                    'color' => $aspectColors[$key],
                    'data' => [] // Will be filled with scores for each indicator
                ];
            }

            // Get average scores for each aspect and indicator
            for ($indicator = 1; $indicator <= 6; $indicator++) {
                // Get average scores for this indicator across all katsinovs
                $scores = KatsinovScore::where('indicator_number', $indicator)
                    ->select(
                        DB::raw('AVG(technology) as technology'),
                        DB::raw('AVG(market) as market'),
                        DB::raw('AVG(organization) as organization'),
                        DB::raw('AVG(manufacturing) as manufacturing'),
                        DB::raw('AVG(partnership) as partnership'),
                        DB::raw('AVG(investment) as investment'),
                        DB::raw('AVG(risk) as risk')
                    )
                    ->first();

                // If no data, use zeros
                if (!$scores) {
                    foreach ($aspects as $key => $name) {
                        $aspectData[$key]['data'][] = 0;
                    }
                    continue;
                }

                // Add scores to each aspect's data array
                foreach ($aspects as $key => $name) {
                    $aspectData[$key]['data'][] = round($scores->$key, 1);
                }
            }

            // Prepare data for the table view
            $tableData = [];
            for ($i = 0; $i < 6; $i++) {
                $row = ['indicator' => 'KATSINOV ' . ($i + 1)];
                foreach ($aspects as $key => $name) {
                    $row[$key] = $aspectData[$key]['data'][$i];
                }
                $tableData[] = $row;
            }

            // Calculate averages for each aspect
            $averages = [];
            foreach ($aspects as $key => $name) {
                $averages[$key] = round(array_sum($aspectData[$key]['data']) / count($aspectData[$key]['data']), 1);
            }





            return view('admin.katsinov.summary', [
                'aspects' => $aspects,
                'aspectData' => $aspectData,
                'tableData' => $tableData,
                'averages' => $averages
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in summaryAspects: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function summaryAll($katsinov_id)
    {
        try {
            // Load Katsinov with all related data
            $katsinov = Katsinov::with([
                'scores',
                'responses',
                'formRecordHasilPengukuran'
            ])->findOrFail($katsinov_id);

            // Prepare overall aspect scores
            $overallAspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores, 'technology'),
                'market' => $this->getAverageScore($katsinov->scores, 'market'),
                'organization' => $this->getAverageScore($katsinov->scores, 'organization'),
                'manufacturing' => $this->getAverageScore($katsinov->scores, 'manufacturing'),
                'partnership' => $this->getAverageScore($katsinov->scores, 'partnership'),
                'investment' => $this->getAverageScore($katsinov->scores, 'investment'),
                'risk' => $this->getAverageScore($katsinov->scores, 'risk')
            ];

            // Prepare indicator-specific aspect scores
            $indicatorAspectScores = [];
            for ($indicator = 1; $indicator <= 6; $indicator++) {
                $indicatorScores = $katsinov->scores->where('indicator_number', $indicator);
                $indicatorAspectScores[$indicator] = [
                    'technology' => $this->getAverageScore($indicatorScores, 'technology'),
                    'market' => $this->getAverageScore($indicatorScores, 'market'),
                    'organization' => $this->getAverageScore($indicatorScores, 'organization'),
                    'manufacturing' => $this->getAverageScore($indicatorScores, 'manufacturing'),
                    'partnership' => $this->getAverageScore($indicatorScores, 'partnership'),
                    'investment' => $this->getAverageScore($indicatorScores, 'investment'),
                    'risk' => $this->getAverageScore($indicatorScores, 'risk')
                ];
            }

            // Prepare question scores
            $questionScores = [];
            for ($indicator = 1; $indicator <= 6; $indicator++) {
                $indicatorResponses = $katsinov->responses()->where('indicator_number', $indicator)->get();

                $aspectScores = [
                    'technology' => $this->extractQuestionScores($indicatorResponses, 'T'),
                    'market' => $this->extractQuestionScores($indicatorResponses, 'M'),
                    'organization' => $this->extractQuestionScores($indicatorResponses, 'O'),
                    'manufacturing' => $this->extractQuestionScores($indicatorResponses, 'Mf'),
                    'partnership' => $this->extractQuestionScores($indicatorResponses, 'P'),
                    'investment' => $this->extractQuestionScores($indicatorResponses, 'I'),
                    'risk' => $this->extractQuestionScores($indicatorResponses, 'R')
                ];

                $questionScores[$indicator] = $aspectScores;
            }

            // Calculate average score
            $avgScore = array_sum($overallAspectScores) / count($overallAspectScores);
            $role = Auth::user()->role;
            $view = match ($role) {
                'admin_direktorat' => 'admin.katsinov.summary_all',
                'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.summary_all',
                'dosen' => 'subdirektorat-inovasi.dosen.summary_all',
                'validator' => 'subdirektorat-inovasi.validator.summary_all',
                'registered_user' => 'subdirektorat-inovasi.registered_user.summary_all',
                default => null,
            };

            return view($view, [
                'katsinov' => $katsinov,
                'overallAspectScores' => $overallAspectScores,
                'indicatorAspectScores' => $indicatorAspectScores,
                'questionScores' => $questionScores,
                'avgScore' => $avgScore,
                // Add JSON-encoded versions for JavaScript
                'overallAspectScoresJson' => json_encode($overallAspectScores),
                'indicatorAspectScoresJson' => json_encode($indicatorAspectScores),
                'questionScoresJson' => json_encode($questionScores)
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in summaryAll: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data tidak dapat ditampilkan: ' . $e->getMessage());
        }
    }

    // Helper method to extract question scores for an aspect
    private function extractQuestionScores($responses, $aspect)
    {
        return $responses
            ->where('aspect', $aspect)
            ->sortBy('row_number')
            ->pluck('score')
            ->toArray();
    }



    //download pdf
    public function downloadDetailPDF($id)
    {
        try {
            // Load KATSINOV with all relationships
            $katsinov = Katsinov::with([
                'scores',
                'responses',
                'formRecordHasilPengukuran',
                'katsinovInovasis',
                'katsinovBeritas',
                'katsinovInformasis',
                'katsinovLampirans',
                'user'
            ])->findOrFail($id);

            // Calculate aspect scores
            $aspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores, 'technology'),
                'organization' => $this->getAverageScore($katsinov->scores, 'organization'),
                'risk' => $this->getAverageScore($katsinov->scores, 'risk'),
                'market' => $this->getAverageScore($katsinov->scores, 'market'),
                'partnership' => $this->getAverageScore($katsinov->scores, 'partnership'),
                'manufacturing' => $this->getAverageScore($katsinov->scores, 'manufacturing'),
                'investment' => $this->getAverageScore($katsinov->scores, 'investment')
            ];

            // Prepare data for individual indicators
            $indicatorData = [];
            $chartImages = [];

            // Create folder for chart images if it doesn't exist
            $chartDir = public_path('storage/chart_images');
            if (!file_exists($chartDir)) {
                mkdir($chartDir, 0755, true);
            }

            // Generate main chart image
            $mainChartFilename = 'katsinov_' . $id . '_main_chart.png';
            $this->generateChartImage($aspectScores, $mainChartFilename);
            $chartImages['main'] = asset('storage/chart_images/' . $mainChartFilename);

            for ($i = 1; $i <= 6; $i++) {
                $indicatorAspectScores = [
                    'technology' => $this->getAverageScore($katsinov->scores->where('indicator_number', $i), 'technology'),
                    'organization' => $this->getAverageScore($katsinov->scores->where('indicator_number', $i), 'organization'),
                    'risk' => $this->getAverageScore($katsinov->scores->where('indicator_number', $i), 'risk'),
                    'market' => $this->getAverageScore($katsinov->scores->where('indicator_number', $i), 'market'),
                    'partnership' => $this->getAverageScore($katsinov->scores->where('indicator_number', $i), 'partnership'),
                    'manufacturing' => $this->getAverageScore($katsinov->scores->where('indicator_number', $i), 'manufacturing'),
                    'investment' => $this->getAverageScore($katsinov->scores->where('indicator_number', $i), 'investment')
                ];

                // Generate chart for this indicator
                $indicatorChartFilename = 'katsinov_' . $id . '_indicator_' . $i . '_chart.png';
                $this->generateChartImage($indicatorAspectScores, $indicatorChartFilename);
                $chartImages['indicator_' . $i] = asset('storage/chart_images/' . $indicatorChartFilename);

                $indicatorData[$i] = [
                    'responses' => $katsinov->responses()->where('indicator_number', '=', $i)->get(),
                    'scores' => $katsinov->scores()->where('indicator_number', '=', $i)->first(),
                    'aspectScores' => $indicatorAspectScores
                ];
            }

            $data = [
                'katsinov' => $katsinov,
                'aspectScores' => $aspectScores,
                'indicatorData' => $indicatorData,
                'record' => $katsinov->formRecordHasilPengukuran ?? new FormRecordHasilPengukuran(['katsinov_id' => $id]),
                'categories' => $this->calculateCategories($aspectScores),
                'chartImages' => $chartImages
            ];

            // Generate PDF
            $pdf = PDF::loadView('admin.katsinov.print_katsinov', $data)
                ->setPaper('a4')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'sans-serif',
                    'enable_javascript' => false, // Don't need JavaScript since we're using image charts
                    'javascript_delay' => 0
                ]);

            // Create a sanitized filename with PDF extension explicitly added
            $baseFilename = 'KATSINOV_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $katsinov->title) . '_' . date('Y-m-d');
            $filename = $baseFilename . '.pdf';

            // Download PDF
            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage(), [
                'katsinov_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to calculate categories for all aspects
     */
    private function calculateCategories($aspectScores)
    {
        $categories = [];
        foreach ($aspectScores as $key => $score) {
            $categories[$key] = $this->getScoreCategory($score);
        }
        return $categories;
    }


    private function generateChartImage($aspectScores, $filename)
    {
        $width = 600;
        $height = 400;
        $image = imagecreatetruecolor($width, $height);

        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        $textColor = imagecolorallocate($image, 51, 51, 51);

        $title = "KATSINOV Assessment Chart";
        imagestring($image, 5, 220, 20, $title, $textColor);

        $centerX = $width / 2;
        $centerY = $height / 2;
        $radius = 150;

        $aspects = [
            'Technology' => $aspectScores['technology'],
            'Organization' => $aspectScores['organization'],
            'Risk' => $aspectScores['risk'],
            'Market' => $aspectScores['market'],
            'Partnership' => $aspectScores['partnership'],
            'Manufacturing' => $aspectScores['manufacturing'],
            'Investment' => $aspectScores['investment']
        ];

        $green = imagecolorallocate($image, 23, 99, 105);
        $lightGreen = imagecolorallocate($image, 100, 200, 200);

        $numAxes = count($aspects);
        $angleStep = 2 * M_PI / $numAxes;

        for ($r = $radius / 4; $r <= $radius; $r += $radius / 4) {
            imagearc($image, $centerX, $centerY, $r * 2, $r * 2, 0, 360, $lightGreen);
        }
        $i = 0;
        $points = [];
        foreach ($aspects as $aspect => $score) {
            $angle = $i * $angleStep - M_PI / 2;
            $endX = $centerX + $radius * cos($angle);
            $endY = $centerY + $radius * sin($angle);
            imageline($image, $centerX, $centerY, $endX, $endY, $textColor);
            $labelX = $centerX + ($radius + 20) * cos($angle);
            $labelY = $centerY + ($radius + 20) * sin($angle);
            imagestring($image, 2, $labelX - 20, $labelY - 10, $aspect, $textColor);
            $scoreRatio = $score / 100;
            $pointX = $centerX + $radius * $scoreRatio * cos($angle);
            $pointY = $centerY + $radius * $scoreRatio * sin($angle);
            $points[] = [$pointX, $pointY];

            $i++;
        }
        for ($i = 0; $i < count($points); $i++) {
            $j = ($i + 1) % count($points);
            imageline($image, $points[$i][0], $points[$i][1], $points[$j][0], $points[$j][1], $green);
        }

        imagefilledpolygon($image, array_merge(...$points), count($points), imagecolorallocatealpha($image, 23, 99, 105, 80));
        $i = 0;
        foreach ($aspects as $aspect => $score) {
            $angle = $i * $angleStep - M_PI / 2;
            $scoreRatio = $score / 100;
            $pointX = $centerX + $radius * $scoreRatio * cos($angle);
            $pointY = $centerY + $radius * $scoreRatio * sin($angle);
            imagefilledellipse($image, $pointX, $pointY, 8, 8, $green);
            $scoreText = number_format($score, 1) . '%';
            imagestring($image, 2, $pointX - 15, $pointY - 5, $scoreText, $textColor);

            $i++;
        }
        $outputPath = public_path('storage/chart_images/' . $filename);

        $directory = dirname($outputPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        imagepng($image, $outputPath);
        imagedestroy($image);

        return $outputPath;
    }

    public function printForm(Request $request)
    {
        $katsinov = Katsinov::where('id', '=', $request->id)
            ->with(['scores', 'responses'])
            ->first();

        if (!$katsinov) {
            return redirect()->back()->with('error', 'Data KATSINOV tidak ditemukan');
        }

        $data = [
            'katsinov' => $katsinov,
            'indicatorOne' =>  $katsinov->responses()->where('indicator_number', '=', 1)->get(),
            'indicatorTwo' =>  $katsinov->responses()->where('indicator_number', '=', 2)->get(),
            'indicatorThree' =>  $katsinov->responses()->where('indicator_number', '=', 3)->get(),
            'indicatorFour' =>  $katsinov->responses()->where('indicator_number', '=', 4)->get(),
            'indicatorFive' =>  $katsinov->responses()->where('indicator_number', '=', 5)->get(),
            'indicatorSix' =>  $katsinov->responses()->where('indicator_number', '=', 6)->get(),
            'printMode' => true, // Flag to indicate print mode
        ];

        // Use the same view as the normal form, but add the print=true parameter to trigger printing
        $role = Auth::user()->role;

        $route = match ($role) {
            'admin_direktorat' => 'admin.katsinov.show',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.show',
            'dosen' => 'subdirektorat-inovasi.dosen.show',
            'validator' => 'subdirektorat-inovasi.validator.show',
            'registered_user' => 'subdirektorat-inovasi.registered_user.show',
            default => 'admin.katsinov.show',
        };
        return redirect()->route($route, ['id' => $request->id, 'print' => 'true']);
        // return redirect()->route('admin.katsinov.show', ['id' => $request->id, 'print' => 'true']);
    }

    // Add this method to the KatsinovController class
    public function printSummary($katsinov_id)
    {
        try {
            // Load Katsinov with all related data (same as summaryAll method)
            $katsinov = Katsinov::with([
                'scores',
                'responses',
                'formRecordHasilPengukuran'
            ])->findOrFail($katsinov_id);

            // Prepare overall aspect scores
            $overallAspectScores = [
                'technology' => $this->getAverageScore($katsinov->scores, 'technology'),
                'market' => $this->getAverageScore($katsinov->scores, 'market'),
                'organization' => $this->getAverageScore($katsinov->scores, 'organization'),
                'manufacturing' => $this->getAverageScore($katsinov->scores, 'manufacturing'),
                'partnership' => $this->getAverageScore($katsinov->scores, 'partnership'),
                'investment' => $this->getAverageScore($katsinov->scores, 'investment'),
                'risk' => $this->getAverageScore($katsinov->scores, 'risk')
            ];

            // Prepare indicator-specific aspect scores
            $indicatorAspectScores = [];
            for ($indicator = 1; $indicator <= 6; $indicator++) {
                $indicatorScores = $katsinov->scores->where('indicator_number', $indicator);
                $indicatorAspectScores[$indicator] = [
                    'technology' => $this->getAverageScore($indicatorScores, 'technology'),
                    'market' => $this->getAverageScore($indicatorScores, 'market'),
                    'organization' => $this->getAverageScore($indicatorScores, 'organization'),
                    'manufacturing' => $this->getAverageScore($indicatorScores, 'manufacturing'),
                    'partnership' => $this->getAverageScore($indicatorScores, 'partnership'),
                    'investment' => $this->getAverageScore($indicatorScores, 'investment'),
                    'risk' => $this->getAverageScore($indicatorScores, 'risk')
                ];
            }

            // Prepare question scores
            $questionScores = [];
            for ($indicator = 1; $indicator <= 6; $indicator++) {
                $indicatorResponses = $katsinov->responses()->where('indicator_number', $indicator)->get();

                $aspectScores = [
                    'technology' => $this->extractQuestionScores($indicatorResponses, 'T'),
                    'market' => $this->extractQuestionScores($indicatorResponses, 'M'),
                    'organization' => $this->extractQuestionScores($indicatorResponses, 'O'),
                    'manufacturing' => $this->extractQuestionScores($indicatorResponses, 'Mf'),
                    'partnership' => $this->extractQuestionScores($indicatorResponses, 'P'),
                    'investment' => $this->extractQuestionScores($indicatorResponses, 'I'),
                    'risk' => $this->extractQuestionScores($indicatorResponses, 'R')
                ];

                $questionScores[$indicator] = $aspectScores;
            }

            // Calculate average score
            $avgScore = array_sum($overallAspectScores) / count($overallAspectScores);

            // Generate PDF using the appropriate view based on role
            $role = Auth::user()->role;
            $view = match ($role) {
                'admin_direktorat' => 'admin.katsinov.print_summary',
                'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.print_summary',
                'dosen' => 'subdirektorat-inovasi.dosen.print_summary',
                'validator' => 'subdirektorat-inovasi.validator.print_summary',
                'registered_user' => 'subdirektorat-inovasi.registered_user.print_summary',
                default => 'admin.katsinov.print_summary',
            };

            $pdf = PDF::loadView($view, [
                'katsinov' => $katsinov,
                'overallAspectScores' => $overallAspectScores,
                'indicatorAspectScores' => $indicatorAspectScores,
                'questionScores' => $questionScores,
                'avgScore' => $avgScore,
                'overallAspectScoresJson' => json_encode($overallAspectScores),
                'indicatorAspectScoresJson' => json_encode($indicatorAspectScores),
                'questionScoresJson' => json_encode($questionScores)
            ])
                ->setPaper('a4')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'sans-serif'
                ]);

            // Create a sanitized filename
            $filename = 'KATSINOV_Summary_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $katsinov->title) . '_' . date('Y-m-d') . '.pdf';

            return $pdf->stream($filename);
        } catch (\Exception $e) {
            \Log::error('Error in printSummary: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    public function downloadPengukuranHasilReport(Request $request, $katsinov_id)
    {
        try {
            $katsinov = Katsinov::with([
                'user',
                'scores',
                'katsinovInovasis', // Assuming 'JUDUL INOVASI' might be here if not on katsinov model directly
                'katsinovBeritas' // For 'LEMBAR PENGESAHAN'
            ])->findOrFail($katsinov_id);

            $data = [];

            // General Info
            $data['judul_inovasi'] = $katsinov->title ?? 'Mobil Pedesaan'; // [cite: 2]
            $data['bidang_inovasi'] = $katsinov->focus_area ?? 'Teknologi Transportasi'; // [cite: 2]
            $data['lembaga_instansi'] = $katsinov->institution ?? 'Universitas Negeri Semarang (Unnes)'; // [cite: 2]
            $data['alamat_kontak'] = ($katsinov->address && $katsinov->contact) ? ($katsinov->address . ', Phone: ' . $katsinov->contact) : 'Jalan Sekaran, Sekaran, Gunung Pati, Kota Semarang, Jawa Tengah 50229, Phone: (024) 8508092'; // [cite: 2]
            $data['tahun_laporan'] = '2017'; // As per document [cite: 3]

            // Lembar Pengesahan Info
            // Assuming the first katsinovBeritas record is relevant
            $beritaAcara = $katsinov->katsinovBeritas->first();
            if ($beritaAcara) {
                $data['pengesahan_tempat_tanggal'] = ($beritaAcara->place ?? '(Tempat)') . ', ' . ($beritaAcara->sign_date ? date('d-m-Y', strtotime($beritaAcara->sign_date)) : 'D-M-Y'); // [cite: 5]
                // Mapping based on typical roles, adjust NIP source as needed
                $data['penanggung_jawab_pengukuran'] = $beritaAcara->penanggungjawab ?? 'Nama Penanggung Jawab';
                $data['penanggung_jawab_nip'] = 'NIP. ' . ($beritaAcara->penanggungjawab_nip ?? '.........................'); // Assuming NIP field exists or add one
                $data['ketua_tim_pelaksana'] = $beritaAcara->ketua ?? 'Nama Ketua Tim';
                $data['ketua_tim_pelaksana_nip'] = 'NIP. ' . ($beritaAcara->ketua_nip ?? '.........................'); // Assuming NIP field exists
                // Tim Pengendali Pengukuran might be one of the 'anggota' or a separate field. Placeholder for now.
                $data['tim_pengendali_pengukuran'] = $beritaAcara->anggota1 ?? 'Nama Tim Pengendali'; // Example mapping
                $data['tim_pengendali_nip'] = 'NIP. ' . ($beritaAcara->anggota1_nip ?? '.........................'); // Assuming NIP field exists [cite: 5]
            } else {
                $data['pengesahan_tempat_tanggal'] = '(Tempat, D-M-Y)'; // [cite: 5]
                $data['penanggung_jawab_pengukuran'] = 'Nama Penanggung Jawab';
                $data['penanggung_jawab_nip'] = 'NIP. .........................';
                $data['ketua_tim_pelaksana'] = 'Nama Ketua Tim';
                $data['ketua_tim_pelaksana_nip'] = 'NIP. .........................';
                $data['tim_pengendali_pengukuran'] = 'Nama Tim Pengendali';
                $data['tim_pengendali_nip'] = 'NIP. .........................'; // [cite: 5]
            }


            // Katsinov Levels Data
            $katsinov_levels_data = [];
            $aspect_keys = ['technology', 'market', 'organization', 'manufacturing', 'partnership', 'investment', 'risk'];
            $level_descriptions = [
                1 => "Level Katsinov 1 merupakan Tahap Konsep, yaitu prinsip-prinsip ilmiah dasar dari inovasi telah diamati dan dilaporkan, dan fungsi kritikal dan/atau karakteristik telah dikonfirmasi melalui kegiatan eksperimen di laboratorium.", // [cite: 7, 21]
                2 => "Pada level Katsinov 2 ini merupakan tahap validasi komponen, yaitu komponen telah dikembangkan dan divalidasi, dan prototipe telah dikembangkan dalam rangka mendemonstrasikan teknologi di lingkungan yang relevan.", // [cite: 22]
                3 => "Level Katsinov 3 merupakan Tahap Penyelesaian, yaitu pengembangan teknologi telah diselesaikan dan seluruh fungsi sistem telah terbukti di lapangan melalui demonstrasi di lingkungan yang sebenarnya." // [cite: 36, 46]
            ];

            for ($level_num = 1; $level_num <= 3; $level_num++) {
                $score_record = $katsinov->scores->where('indicator_number', $level_num)->first();
                $current_level_data = ['level_deskripsi' => $level_descriptions[$level_num] ?? 'Deskripsi Level ' . $level_num];
                $current_level_data['aspek_scores'] = [];

                if ($score_record) {
                    $total_score_sum = 0;
                    $valid_aspect_count = 0;
                    foreach ($aspect_keys as $key) {
                        $aspect_score = $score_record->$key ?? 0;
                        $current_level_data['aspek_scores'][ucfirst($key)] = $aspect_score;
                        $total_score_sum += $aspect_score;
                        if (isset($score_record->$key)) { // only count aspects that are set
                            $valid_aspect_count++;
                        }
                    }
                    $current_level_data['total_kesiapan_level'] = $valid_aspect_count > 0 ? ($total_score_sum / $valid_aspect_count) : 0;
                } else {
                    $current_level_data['total_kesiapan_level'] = 0; // Default if no score record
                    foreach ($aspect_keys as $key) {
                        $current_level_data['aspek_scores'][ucfirst($key)] = 0;
                    }
                }

                $current_level_data['batas_kesiapan'] = 80; // [cite: 8, 23, 37]
                $current_level_data['memenuhi_kesiapan'] = $current_level_data['total_kesiapan_level'] >= $current_level_data['batas_kesiapan'];

                // Specific explanations based on document
                if ($level_num == 1 && $score_record) {
                    // Example: if total_kesiapan_level is 96.36 as in doc [cite: 8]
                    // This is already handled by the general text construction using 'memenuhi_kesiapan'
                }
                if ($level_num == 2 && $score_record) {
                    $manufaktur_score = $current_level_data['aspek_scores']['Manufaktur'] ?? 0;
                    $investment_score = $current_level_data['aspek_scores']['Investment'] ?? 0;
                    if ($manufaktur_score == 100 && $investment_score == 100) {
                        $current_level_data['penjelasan_capaian_level_2_manufaktur_investment'] = "Jika melihat Gambar 7, aspek yang telah memenuhi capaian 100% adalah manufaktur dan investment;"; // [cite: 25]
                    }
                    // This part is more complex as it refers to a "Gambar 7" and general conditions
                    $other_aspects_gt_80 = [];
                    $risk_is_80 = false;
                    foreach (['Teknologi', 'Partnership', 'Organisasi', 'Pasar'] as $aspect_name) {
                        if (($current_level_data['aspek_scores'][$aspect_name] ?? 0) > 80) {
                            $other_aspects_gt_80[] = strtolower($aspect_name);
                        }
                    }
                    if (!empty($other_aspects_gt_80)) {
                        $current_level_data['penjelasan_capaian_level_2_lainnya'] = "untuk aspek " . implode(', ', $other_aspects_gt_80) . " capaiannya > 80%; ";
                    }
                    if (($current_level_data['aspek_scores']['Risiko'] ?? 0) == 80) {
                        $current_level_data['penjelasan_capaian_level_2_lainnya'] = ($current_level_data['penjelasan_capaian_level_2_lainnya'] ?? '') . "sedangkan untuk aspek penanganan risiko capaiannya 80%."; // [cite: 26]
                    }
                }
                if ($level_num == 3 && $score_record) {
                    $above_80_aspects = [];
                    $below_80_aspects = [];
                    foreach ($current_level_data['aspek_scores'] as $name => $score) {
                        if (in_array($name, ['Organisasi', 'Pasar', 'Partnership', 'Risiko'])) { // Based on doc [cite: 38]
                            if ($score >= 80) $above_80_aspects[] = $name;
                        }
                        if (in_array($name, ['Investment', 'Manufaktur', 'Teknologi'])) { // Based on doc [cite: 39]
                            if ($score < 80) $below_80_aspects[] = $name;
                        }
                    }
                    $current_level_data['penjelasan_capaian_level_3']['above_80'] = !empty($above_80_aspects) ? "Aspek yang memiliki capaian diatas atau sama dengan 80% adalah " . implode(", ", $above_80_aspects) . "." : ""; // [cite: 38]
                    $current_level_data['penjelasan_capaian_level_3']['below_80'] = !empty($below_80_aspects) ? "Sedangkan aspek yang memiliki capaian dibawah 80% adalah " . implode(", ", $below_80_aspects) . "." : ""; // [cite: 39]
                }


                $katsinov_levels_data[$level_num] = $current_level_data;
            }
            $data['katsinov_levels_data'] = $katsinov_levels_data;

            // Rekomendasi Data (Static placeholders as per "Empty" document)
            $data['rekomendasi_teknis'] = [ // [cite: 48, 50, 51, 52]
                ['aspek' => 'Teknologi', 'rekomendasi_new_armada' => 'Segera menyelesaikan prototipe mobil pedesaan yang baru (yang menggunakan pendanaan dari Kemenristekdikti).'],
                ['aspek' => 'Pasar', 'rekomendasi_new_armada' => 'Mendukung analisis pasar yang dilakukan oleh Unnes melalui dukungan data pasar yang dimiliki.'],
                ['aspek' => 'Organisasi', 'rekomendasi_new_armada' => 'Melaksanakan lingkup pekerjaan, tanggungjawab dan output sesuai organisasi WBS (Work Breakdown Structure) atau PBS (Product Breakdown Structure).'],
                ['aspek' => 'Organisasi', 'rekomendasi_new_armada' => 'Bersama dengan mitra lain menyusun dan menetapkan strategi inovasi.'], // Note: "Organisasi" appears twice in source [cite: 48, 50]
                ['aspek' => 'Organisasi', 'rekomendasi_new_armada' => 'Bersama dengan mitra lain menyusun Business Plan.'],
                ['aspek' => 'Manufaktur', 'rekomendasi_new_armada' => 'Meningkatkan kesiapan produksi mobil 0.'], // [cite: 50]
                ['aspek' => 'Partnership', 'rekomendasi_new_armada' => 'Merubah kerjasama yang sifatnya kontraktual menuju kerjasama yang formal, dimana ada sharing pendanaan dan risiko.'], // [cite: 50]
                ['aspek' => 'Partnership', 'rekomendasi_new_armada' => 'Memformalkan kerjasama dengan mitra lain, serta menyusun rencana dan mengimplementasikan kerjasama.'], // [cite: 52]
                ['aspek' => 'Investment', 'rekomendasi_new_armada' => 'Memperkuat Market Value Proposition (MVP) mobil pedesaan level 0.'], // [cite: 52]
                ['aspek' => 'Investment', 'rekomendasi_new_armada' => 'Melakukan identifikasi dan validasi terhadap IKU (Indikator Kinerja Utama) dan target targetnya di manufaktur mobil pedesaan level 0.'],
                ['aspek' => 'Risiko', 'rekomendasi_new_armada' => 'Melaksanakan rencana pengendalian risiko secara komprehensif di manufaktur mobil pedesaan level 0.'], // [cite: 52]
            ];
            $data['rekomendasi_kebijakan'] = [ // [cite: 54, 56]
                ['bentuk_rekomendasi' => '', 'lembaga_bertanggung_jawab' => 'Kemenristekdikti, Sekretaris Kabinet'],
                ['bentuk_rekomendasi' => '', 'lembaga_bertanggung_jawab' => 'Kemenristekdikti, Kemenkeu'],
                ['bentuk_rekomendasi' => '', 'lembaga_bertanggung_jawab' => 'Kemenristekdikti, Kemperin'],
                ['bentuk_rekomendasi' => '', 'lembaga_bertanggung_jawab' => 'Kemenprind, Kemenristekdikti'], // Typo Kemenprind likely Kemendag or Kemenperin
                ['bentuk_rekomendasi' => '', 'lembaga_bertanggung_jawab' => 'Kemenristekdikti'],
                ['bentuk_rekomendasi' => '', 'lembaga_bertanggung_jawab' => 'Kemenhub, Polri'], // [cite: 56]
            ];


            $data['logo_base64'] = 'iVBORw0KGgoAAAANSUhEUgAAANkAAAA5CAYAAAC2ESFFAAACsklEQVR4nO3cv2sTcRzH8e85bN3GugkIghBcXJxFwcHFQXAQ3LqIoKCbi0sVwcHBydFJcXNxUFHBXUHBwcEFByf+A8TJs2kvJ5LgcUq/9A2BvHo/eHkfPtl7uXe3AAQBEEQBEEQBEEQBEEQBEEQBEEQBEEQBEEQBEEQBEEQBEEQBEEQBEHw/4F9sxNRAmCxbLld7XY7P/p6R8NiscxmI0xWKyvbKqIirP9tH8xms63uX7/fL4vFkscqI28CSM4iKkLK5XI6nU4mk0IsJ8uV+bXb7YbFYkELsX/a4POf3MZuNptOp5NCoRDw8fn5iZPEeb0GAEBRXL7356MIAlGkMeDG12IAgOJa7h+fnx9/LhaLpVKpoN0uIuXz+eoXGUL0pRpA0fT7/UmS5Hq9vj6fDwIgPjg4ACCAauAAYQIQJwDqAJYAFAAYAMqA5IHkQPIgeRA8SD4kH0oLJAfSg5ID6UHJgfKg5ER6UHLSg5ID+aGkQHJQwigZkAxIBiQDEkCSAUmAZDAyQDIgGXgcSARkIMJBZCBdEBlIFIgsRDaIDSQLIgOSA0mBNCApkB5IAqQAEgBJgLSAZEBCIBmQAEgGJAOSAkgaIAmQDEgGJAOSg8hAskByIDmQDMgYyIAkQNrALCDSAcgBIADyQPQkYyACIAEgAxIi7ZkAyYAsQBoQZSASkDxIBiQDEgZIAiQDEgZIAqQMkDJAGSAJkAxIMkDJAEkaIAmQNEACJAUgKZAeSAqkJ5BMSAGkAIJASgAkASQFUgYpA5QCUmA8kDyQPADy/AEgKZAeSAqkARJgMgAZIAmQNEACYAmQAJgCXgMyQCkAyYAUQNEAJACKQE0AHIAkADIAkAAIAMgAyADYAEgAyADQAJAAiADoAEgAyADIAAgCQIAkCAIAiCIAiCIAiCIAiCIAiCIAiCIAiCIAiC+A9+AWgMEfaQRjNqAAAAAElFTkSuQmCC'; // [cite: 1]

            // Load view and generate PDF
            $pdf = Pdf::loadView('admin.katsinov.report_pengukuran_hasil_pdf', $data);
            return $pdf->stream('Laporan_Pengukuran_Kesiapan_Inovasi_(' . $katsinov->title . ').pdf');
        } catch (\Exception $e) {
            Log::error('Error generating Pengukuran Hasil Report PDF: ' . $e->getMessage(), ['katsinov_id' => $katsinov_id, 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Gagal membuat laporan PDF: ' . $e->getMessage());
        }
    }
     public function downloadCertificate($id)
    {
        $katsinov = Katsinov::with('user')->findOrFail($id);

        // --- Base64 Encoded Images ---
        // Replace these with your actual Base64 strings
        // Option 1: Store them in .env or config (better for large strings)
        // $logoTutWuriBase64 = config('app.logo_tut_wuri_base64');
        // $logoUnjBase64 = config('app.logo_unj_base64');
        // $certificateBackgroundBase64 = config('app.certificate_background_base64');

        // Option 2: Define directly (for smaller strings or quick testing)
        // It's highly recommended to get the actual Base64 string of your certificate image
        // For example: $certificateBackgroundBase64 = file_get_contents(public_path('path_to_your_screenshot_image.jpg'));
        // And then base64_encode($certificateBackgroundBase64) if it's not already encoded.
        // However, for dompdf, providing the image path to CSS `url()` is often better for background.
        // But if you want a fully self-contained HTML for PDF, base64 is the way.

        // Example: How to get base64 of an image in public path
        // $imagePath = public_path('images/certificate_bg.jpg'); // Make sure this image exists
        // $imageData = '';
        // if (file_exists($imagePath)) {
        //     $imageData = base64_encode(file_get_contents($imagePath));
        // } else {
        //     // Handle error: background image not found
        //     // For now, let's use a placeholder or expect it to be in the view
        // }
        // $certificateBackgroundBase64 = $imageData; // Assign to variable

        // For simplicity in this example, I'll assume you'll paste the very long Base64 string
        // of your certificate background directly into the certificate_template.blade.php
        // or load it here as shown above.
        // For this example to run, let's define a placeholder.
        // YOU MUST REPLACE THIS WITH THE ACTUAL BASE64 OF YOUR CERTIFICATE IMAGE
        $certificateBackgroundBase64 = "PASTE_YOUR_CERTIFICATE_BACKGROUND_IMAGE_BASE64_STRING_HERE";
        // $logoTutWuriBase64 = "PASTE_LOGO_TUT_WURI_BASE64_STRING_HERE";
        // $logoUnjBase64 = "PASTE_LOGO_UNJ_BASE64_STRING_HERE";


        $data = [
            'katsinov' => $katsinov,
            'certificateBackgroundBase64' => $certificateBackgroundBase64,
            // 'logoTutWuriBase64' => $logoTutWuriBase64, // Uncomment if using separate logos
            // 'logoUnjBase64' => $logoUnjBase64,          // Uncomment if using separate logos
        ];

        $pdf = PDF::loadView('admin.katsinov.certificate_template', $data)
                    ->setPaper('a4', 'landscape');

        $filename = 'Sertifikat_Katsinov_' . preg_replace('/[^A-Za-z0-9\-]/', '', $katsinov->user->name) . '_' . $katsinov->id . '.pdf';

        return $pdf->download($filename);
    }
    public function showRatingSummary($katsinov_id)
{
    try {
        // Ambil data Katsinov beserta relasi scores dan responses
        $katsinov = Katsinov::with(['scores', 'responses'])->findOrFail($katsinov_id);

        // Inisialisasi array untuk menyimpan nilai dropdown
        $dropdownValues = [];

        // Mapping dari kode aspek ke nama aspek yang digunakan di view
        $aspectMap = [
            'T' => 'technology',
            'M' => 'market',
            'O' => 'organization',
            'Mf' => 'manufacturing',
            'P' => 'partnership',
            'I' => 'investment',
            'R' => 'risk'
        ];

        // --- START OF CORRECTION ---
        // Group responses by indicator and then by aspect code
        $groupedResponses = $katsinov->responses->groupBy(['indicator_number', 'aspect']);

        // Loop through the grouped data to build the correctly indexed array
        foreach ($groupedResponses as $indicator => $aspects) {
            if (!isset($dropdownValues[$indicator])) {
                $dropdownValues[$indicator] = [];
            }
            foreach ($aspects as $aspectCode => $responses) {
                $aspectKey = $aspectMap[$aspectCode] ?? null;
                if ($aspectKey) {
                    if (!isset($dropdownValues[$indicator][$aspectKey])) {
                        $dropdownValues[$indicator][$aspectKey] = [];
                    }

                    // Sort responses by their original row number to ensure the correct order
                    // Then, use ->values() to reset the keys to be a 0-based index
                    $sortedResponses = $responses->sortBy('row_number')->values();

                    // Now the loop index ($qIndex) will be 0, 1, 2... for each aspect group, matching the view
                    foreach ($sortedResponses as $qIndex => $response) {
                        $dropdownValues[$indicator][$aspectKey][$qIndex] = $response->dropdown_value;
                    }
                }
            }
        }
        // --- END OF CORRECTION ---


        // Hitung skor rata-rata per aspek untuk ditampilkan di chart (menggunakan logika yang sama dengan summaryAll)
        $overallAspectScores = [
            'technology' => $this->getAverageScore($katsinov->scores, 'technology'),
            'market' => $this->getAverageScore($katsinov->scores, 'market'),
            'organization' => $this->getAverageScore($katsinov->scores, 'organization'),
            'manufacturing' => $this->getAverageScore($katsinov->scores, 'manufacturing'),
            'partnership' => $this->getAverageScore($katsinov->scores, 'partnership'),
            'investment' => $this->getAverageScore($katsinov->scores, 'investment'),
            'risk' => $this->getAverageScore($katsinov->scores, 'risk')
        ];
        
        // Menentukan view berdasarkan role pengguna
        $role = Auth::user()->role;
        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.summary_rating',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.summary_rating',
            'dosen' => 'subdirektorat-inovasi.dosen.summary_rating',
            'validator' => 'subdirektorat-inovasi.validator.summary_rating',
            'registered_user' => 'subdirektorat-inovasi.registered_user.summary_rating',
            default => 'admin.katsinov.summary_rating', 
        };


        // Kirim semua data yang dibutuhkan ke view
        return view($view, [
            'katsinov' => $katsinov,
            'dropdownValues' => $dropdownValues, // Variabel ini sekarang sudah terisi dengan benar
            'overallAspectScores' => $overallAspectScores, // Untuk data chart
            'overallAspectScoresJson' => json_encode($overallAspectScores) // Untuk JavaScript
        ]);

    } catch (\Exception $e) {
        \Log::error('Error in showRatingSummary: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal menampilkan halaman Summary Rating: ' . $e->getMessage());
    }
}
}
