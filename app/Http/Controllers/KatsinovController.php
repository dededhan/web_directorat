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
            'dosen' => 'inovasi.dosen.tablekasitnov',
            'admin_hilirisasi' => 'inovasi.admin_hilirisasi.tablekatsinov',
            'validator' => 'inovasi.validator.tablekatsinov',
        };
        // if (Auth::user()->role === 'admin_direktorat') {
        //     return view('admin.katsinov.TableKatsinov', compact('katsinovs'));
        // } else if (Auth::user()->role === 'dosen') {
        //     return view('inovasi.dosen.tablekasitnov', compact('katsinovs'));
        // } else if (Auth::user()->role === 'admin_hilirisasi') {
        //     return view('inovasi.admin_hilirisasi.tablekatsinov', compact('katsinovs'));
        // } else if (Auth::user()->role === 'validator') {
        //     return view('inovasi.validator.tablekatsinov', compact('katsinovs'));
        // }
        return view($view, [
            'katsinovs' => $katsinovs
        ]);
    }
    public function create()
    {
        // return view('admin.katsinov.form_katsinov');
        // return view('inovasi.kasinov.form');

        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.katsinov.form_katsinov');
        } else if (Auth::user()->role === 'dosen') {
            return view('inovasi.dosen.form_katsinov');
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            return view('inovasi.admin_hilirisasi.form_katsinov');
        } else if (Auth::user()->role === 'validator') {
            return view('inovasi.validator.form_katsinov');
        }
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
