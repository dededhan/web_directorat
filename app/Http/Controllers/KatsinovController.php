<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Katsinov;
use App\Models\KatsinovScore;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KatsinovController extends Controller
{
    public function index()
    {
        // $katsinovs = Katsinov::with('scores')->get();
        // return view('admin.tabelkasinov', compact('katsinovs'));
        $katsinovs = Katsinov::with('scores')->latest()->paginate(10);

        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.tabelkasinov', compact('katsinovs'));
        } else if (Auth::user()->role === 'dosen') {
            return view('inovasi.dosen.tablekasitnov', compact('katsinovs'));
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            return view('inovasi.admin_hilirisasi.tablekatsinov', compact('katsinovs'));
        }

    }
    public function create()
    {
        return view('inovasi.kasinov.form');
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
            'indicators' => 'required|array',
            'indicators.*.indicator_number' => 'required|integer|min:1|max:6',
            'indicators.*.technology' => 'required|numeric|between:0,100',
            'indicators.*.organization' => 'required|numeric|between:0,100',
            'indicators.*.risk' => 'required|numeric|between:0,100',
            'indicators.*.market' => 'required|numeric|between:0,100',
            'indicators.*.partnership' => 'required|numeric|between:0,100',
            'indicators.*.manufacturing' => 'required|numeric|between:0,100',
            'indicators.*.investment' => 'required|numeric|between:0,100',
        ]);

        DB::beginTransaction();
        try {
            $katsinov = Katsinov::create($validated);
            
            foreach ($validated['indicators'] as $indicator) {
                KatsinovScore::create([
                    'katsinov_id' => $katsinov->id,
                    'indicator_number' => $indicator['indicator_number'],
                    'technology' => $indicator['technology'],
                    'organization' => $indicator['organization'],
                    'risk' => $indicator['risk'],
                    'market' => $indicator['market'],
                    'partnership' => $indicator['partnership'],
                    'manufacturing' => $indicator['manufacturing'],
                    'investment' => $indicator['investment']
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
        $katsinovs = Katsinov::with('scores')->get();
        
        $pdf = PDF::loadView('inovasi.katsinov.pdf', compact('katsinovs'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);
        
        return $pdf->download('katsinov-report.pdf');
    }

}
