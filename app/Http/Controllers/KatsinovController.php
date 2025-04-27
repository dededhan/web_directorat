<?php

namespace App\Http\Controllers;

use App\Models\Katsinov;
use App\Models\KatsinovBerita;
use App\Models\KatsinovInformasi;
use App\Models\KatsinovInformasiCollection;
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
        $katsinovs = Katsinov::with('scores')->latest()->paginate(100);
        if (in_array($role, ['dosen', 'mahasiswa','registered_user'])) {
            $katsinovs = auth()->user()->katsinovs()->paginate();
        }

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.TableKatsinov',
            'dosen' => 'subdirektorat-inovasi.dosen.tablekatsinov',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.tablekatsinov',
            'validator' => 'subdirektorat-inovasi.validator.tablekatsinov',
            'registered_user' => 'subdirektorat-inovasi.registered_user.tablekatsinov',
        };

        return view($view, [
            'katsinovs' => $katsinovs
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

        // Start transaction to ensure all related data is saved or rolled back together
        DB::beginTransaction();
        try {
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
            ]);

            // Store each individual response
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

            // Process and store the aggregated scores
            $this->processAndSaveScores($katsinov->id, $validated['responses']);

            DB::commit();
            Log::info('Katsinov data successfully saved', ['id' => $katsinov->id]);

            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving Katsinov data: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
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
            ->with(['scores', 'responses'])
            ->first();
        // dump($katsinov->toArray());

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
        ];

        return view('admin.katsinov.form_katsinov', $data);
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
            default => 'admin.katsinov.lampiran',
        };

        return view($view, [
            'id' => $katsinov->id,
            'lampiran' => $groupedLampiran
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

        $role = Auth::user()->role;

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.TableKatsinov',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.tablekatsinov',
            'dosen' => 'subdirektorat-inovasi.dosen.tablekatsinov',
            'validator' => 'subdirektorat-inovasi.validator.tablekatsinov',
            'registered_user' => 'subdirektorat-inovasi.registered_user.tablekatsinov',
            default => 'admin.katsinov.tablekatsinov',
        };

        return redirect(route($view));
    }

    public function lampiranShow($katsinov_id)
    {
        $katsinov = Katsinov::findOrFail($katsinov_id);
        $lampiran = $katsinov->katsinovLampirans()->get();

        // Kelompokkan lampiran berdasarkan type (aspek)
        $groupedLampiran = $lampiran->groupBy('type');

        return view('admin.katsinov.lampiran_show', [
            'id' => $katsinov_id,
            'lampiran' => $groupedLampiran
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
        $now = now();
        $information =  KatsinovInformasi::create([
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
                    'katsinov_informasi_id' => $information->id,
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
                    'katsinov_informasi_id' => $information->id,
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
                    'katsinov_informasi_id' => $information->id,
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
                    'katsinov_informasi_id' => $information->id,
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
                    'katsinov_informasi_id' => $information->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        $information->katsinovInformasiCollections()->insert($collections);

        // Create or update the record
        $role = Auth::user()->role;

        $route = match ($role) {
            'admin_direktorat' => 'admin.Katsinov.TableKatsinov',
            'admin_hilirisasi' => 'subdirektorat-inovasi.admin_hilirisasi.tablekatsinov',
            'dosen' => 'subdirektorat-inovasi.dosen.tablekatsinov',
            'validator' => 'subdirektorat-inovasi.validator.tablekatsinov',
            'registered_user' => 'subdirektorat-inovasi.registered_user.tablekatsinov',
            default => 'admin.Katsinov.TableKatsinov',
        };
    
        return redirect()->route($route)->with('success', 'Data informasi berhasil disimpan');
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
            'tanggal_penilaian' => 'required|date',
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
}
