<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Katsinov;
use App\Models\KatsinovResponse;
use Illuminate\Support\Facades\Auth;

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
            'registered_user' => 'Inovasi.registered_user.tablekatsinov',
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
            $katsinov = Katsinov::create([
                ...$validated,
                'user_id' => Auth::user()->id,
            ]);

            foreach ($validated['responses'] as $response) {
                KatsinovResponse::create([
                    'katsinov_id' => $katsinov->id,
                    'indicator_number' => $response['indicator'],
                    'row_number' => $response['row'],
                    'aspect' => $response['aspect'],
                    'score' => $response['score'],
                ]);
            }
            
            DB::commit();
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function show(Request $request){
        $katsinov = Katsinov::where('id', '=', $request->id)->with('scores')->first();
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
        $latestRecord = Katsinov::with('scores')
            ->latest()
            ->first();
    
        if (!$latestRecord) {
            return response()->json(['message' => 'No records found'], 404);
        }
    
        return response()->json($latestRecord);
    }

    public function edit(Katsinov $katsinov)
    {
        $katsinov->load('responses');
        return view('admin.katsinov.form_katsinov', compact('katsinov'));
    }

}
