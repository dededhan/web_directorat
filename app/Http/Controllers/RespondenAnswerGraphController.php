<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RespondenAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RespondenAnswerGraphController extends Controller
{

    public function index()
    {
 
        $years = RespondenAnswer::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');


        $faculties = \App\Models\User::where('role', 'fakultas')
            ->select('name')
            ->distinct()
            ->pluck('name')
            ->map(function ($name) {
                return strtoupper($name);
            })
            ->sort()
            ->values();

        $user = \Illuminate\Support\Facades\Auth::user();
        $viewName = $user->role === 'admin_pemeringkatan' ? 'admin_pemeringkatan.responden-report.graph' : 'admin.responden_graph';
        return view($viewName, compact('years', 'faculties'));
    }


    public function getGraphData(Request $request)
    {
        $query = RespondenAnswer::with('responden.user');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $data = $query->get();


        $sumberInput = $data->groupBy(function ($item) {
            if (optional(optional($item->responden)->user)->role === 'admin_direktorat') {
                return 'Direktorat';
            }
            return 'Fakultas & Prodi';
        })->map->count();


        $kategori = $data->groupBy(function ($item) {
            $category = strtolower($item->category);
            if (in_array($category, ['employer', 'employee'])) {
                return 'Employee';
            }
            return 'Academic';
        })->map->count();



        $tren = $data->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m');
        })->map(function ($group) {
            return $group->count();
        })->sortKeys();


        $perFakultas = $data->filter(function ($item) {
            return optional(optional($item->responden)->user)->role === 'fakultas' || optional(optional($item->responden)->user)->role === 'prodi';
        })->groupBy(function ($item) {
            $userName = optional(optional($item->responden)->user)->name;
            if (Str::contains($userName, '-')) {
                return strtoupper(Str::before($userName, '-'));
            }
            return strtoupper($userName);
        })->map->count()->sortKeys();

        $prodiPerFakultas = $data->filter(function ($item) {
            return optional(optional($item->responden)->user)->role === 'prodi';
        })->groupBy(function ($item) {
            $userName = optional(optional($item->responden)->user)->name;
            if (Str::contains($userName, '-')) {
                $faculty = strtoupper(Str::before($userName, '-'));
                $prodi = strtoupper(Str::after($userName, '-'));
                return $faculty . '|' . $prodi;
            }
            return null;
        })->filter()->map->count();

        $formattedProdiData = [];
        foreach ($prodiPerFakultas as $key => $count) {
            [$faculty, $prodi] = explode('|', $key);
            if (!isset($formattedProdiData[$faculty])) {
                $formattedProdiData[$faculty] = [];
            }
            $formattedProdiData[$faculty][$prodi] = $count;
        }

        return response()->json([
            'sumberInput' => $sumberInput,
            'kategori' => $kategori,
            'tren' => $tren,
            'perFakultas' => $perFakultas,
            'prodiPerFakultas' => $formattedProdiData,
        ]);
    }
}
