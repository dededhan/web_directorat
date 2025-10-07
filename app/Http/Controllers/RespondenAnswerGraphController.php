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
        //filter map
        $years = RespondenAnswer::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // send help i study mapping for this
        $faculties = \App\Models\User::where('role', 'fakultas')
            ->select('name')
            ->distinct()
            ->pluck('name')
            ->map(function ($name) {
                $facultyCode = Str::before($name, '-');
                return strtoupper($facultyCode);
            })
            ->unique()
            ->sort()
            ->values();


        return view('admin.responden_graph', compact('years', 'faculties'));
    }


    public function getGraphData(Request $request)
    {
        $query = RespondenAnswer::with('responden.user');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        

        if ($request->filled('fakultas')) {
             $selectedFakultas = $request->fakultas;
             $query->whereHas('responden.user', function ($q) use ($selectedFakultas) {
                 $q->where('name', 'LIKE', $selectedFakultas . '%');
             });
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

            return in_array(optional(optional($item->responden)->user)->role, ['fakultas', 'prodi']);
        })->groupBy(function ($item) {

            $userName = optional(optional($item->responden)->user)->name;
            if (Str::contains($userName, '-')) {
                return strtoupper(Str::before($userName, '-'));
            }
            return strtoupper($userName);
        })->map->count()->sortKeys();

        // typo, ini gegara datanya kgk jelas jink
        $renamedPerFakultas = $perFakultas->mapWithKeys(function ($value, $key) {
            $replacements = [
                'FE' => 'FEB',
                'FPPSI' => 'FPSI',
                'FIS' => 'FISH',
            ];
            return [data_get($replacements, $key, $key) => $value];
        });


        $perProdi = collect();
        if ($request->filled('fakultas')) {
            $selectedFakultas = $request->fakultas;

            $perProdi = $data->filter(function ($item) use ($selectedFakultas) {
                $user = optional($item->responden)->user;
                if (!$user || $user->role !== 'prodi') { 
                    return false;
                }
                $userName = $user->name;
                return Str::startsWith(strtoupper($userName), strtoupper($selectedFakultas) . '-');
            })->groupBy(function ($item) {
                $userName = optional(optional($item->responden)->user)->name;
                return strtoupper(Str::after($userName, '-'));
            })->map->count()->sortKeys();
        }


        return response()->json([
            'sumberInput' => $sumberInput,
            'kategori' => $kategori,
            'tren' => $tren,
            'perFakultas' => $renamedPerFakultas,
            'perProdi' => $perProdi,
        ]);
    }
}
