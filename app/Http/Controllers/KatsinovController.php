<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Katsinov;
use App\Models\KatsinovResponse;
use App\Models\KatsinovScore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KatsinovController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $katsinovs = Katsinov::with('scores')->latest()->paginate(10);
        if(in_array($role, ['dosen', 'mahasiswa'])){
            $katsinovs = auth()->user()->katsinovs()->paginate();
        }

        $view = match ($role) {
            'admin_direktorat' => 'admin.katsinov.TableKatsinov',
            'dosen' => 'Inovasi.dosen.tablekasitnov',
            'admin_hilirisasi' => 'Inovasi.admin_hilirisasi.tablekatsinov',
            'validator' => 'Inovasi.validator.tablekatsinov',
            'registered_user' => 'Inovasi.registered_user.TableKatsinov',
        };

        return view($view, [
            'katsinovs' => $katsinovs
        ]);
    }
    
    public function create()
    {
        $view = match (Auth::user()->role) {
            'admin_direktorat' => 'admin.katsinov.form_katsinov',
            'dosen' => 'Inovasi.dosen.form_katsinov',
            'admin_hilirisasi' => 'Inovasi.admin_hilirisasi.form_katsinov',
            'validator' => 'Inovasi.validator.form_katsinov',
            'registered_user' => 'Inovasi.registered_user.form_katsinov',
        };

        return view($view, [
            'katsinov' => collect([]),
            'indicatorOne' =>  collect([]),
            'indicatorTwo' =>  collect([]),
            'indicatorThree' =>collect([]),
            'indicatorFour' => collect([]),
            'indicatorFive' => collect([]),
            'indicatorSix' =>  collect([]),
        ]);
    }

    public function store(Request $request)
    {
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
            
        if (!$katsinov) {
            return redirect()->back()->with('error', 'Data KATSINOV tidak ditemukan');
        }
        
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
}