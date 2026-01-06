<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\RespondenAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

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
        try {
            // Task 5.1: Request Validation
            $validated = $request->validate([
                'start_date' => 'nullable|date|before_or_equal:today',
                'end_date' => 'nullable|date|after_or_equal:start_date|before_or_equal:today',
                'fakultas' => 'nullable|string|max:255',
            ], [
                'start_date.date' => 'Tanggal mulai harus berformat tanggal yang valid',
                'start_date.before_or_equal' => 'Tanggal mulai tidak boleh lebih dari hari ini',
                'end_date.date' => 'Tanggal akhir harus berformat tanggal yang valid',
                'end_date.after_or_equal' => 'Tanggal akhir harus lebih besar atau sama dengan tanggal mulai',
                'end_date.before_or_equal' => 'Tanggal akhir tidak boleh lebih dari hari ini',
                'fakultas.string' => 'Fakultas harus berupa teks',
                'fakultas.max' => 'Fakultas tidak boleh lebih dari 255 karakter',
            ]);

            // Task 5.2: Improved Error Handling - Build query
            $query = RespondenAnswer::with('responden.user');

            // Apply date filters
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = Carbon::parse($validated['start_date'])->startOfDay();
                $endDate = Carbon::parse($validated['end_date'])->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Apply faculty filter if provided
            if ($request->filled('fakultas')) {
                $query->whereHas('responden.user', function ($q) use ($validated) {
                    $fakultas = strtoupper($validated['fakultas']);
                    $q->where('name', 'like', $fakultas . '%');
                });
            }

            $data = $query->get();

            // Task 5.3: Data Validation - Handle empty datasets
            if ($data->isEmpty()) {
                return response()->json([
                    'sumberInput' => collect(['Direktorat' => 0, 'Fakultas & Prodi' => 0]),
                    'kategori' => collect(['Academic' => 0, 'Employee' => 0]),
                    'tren' => collect(),
                    'perFakultas' => collect(),
                    'prodiPerFakultas' => [],
                    'message' => 'Tidak ada data untuk filter yang dipilih',
                ]);
            }

            // Group by source (Direktorat vs Fakultas & Prodi)
            $sumberInput = $data->groupBy(function ($item) {
                // Task 5.3: Check for null relationships
                $userRole = optional(optional($item->responden)->user)->role;
                if (!$userRole) {
                    return 'Unknown';
                }
                if ($userRole === 'admin_direktorat') {
                    return 'Direktorat';
                }
                return 'Fakultas & Prodi';
            })->map->count();

            // Group by category (Academic vs Employee)
            $kategori = $data->groupBy(function ($item) {
                $category = strtolower($item->category ?? 'unknown');
                if (in_array($category, ['employer', 'employee'])) {
                    return 'Employee';
                }
                return 'Academic';
            })->map->count();

            // Group by month for trend analysis
            $tren = $data->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('Y-m');
            })->map(function ($group) {
                return $group->count();
            })->sortKeys();

            // Group by faculty (only fakultas and prodi roles)
            $perFakultas = $data->filter(function ($item) {
                $userRole = optional(optional($item->responden)->user)->role;
                return in_array($userRole, ['fakultas', 'prodi']);
            })->groupBy(function ($item) {
                $userName = optional(optional($item->responden)->user)->name;
                if (!$userName) {
                    return 'Unknown';
                }
                if (Str::contains($userName, '-')) {
                    return strtoupper(Str::before($userName, '-'));
                }
                return strtoupper($userName);
            })->map->count()->sortKeys();

            // Group by prodi within faculty
            $prodiPerFakultas = $data->filter(function ($item) {
                return optional(optional($item->responden)->user)->role === 'prodi';
            })->groupBy(function ($item) {
                $userName = optional(optional($item->responden)->user)->name;
                if (!$userName || !Str::contains($userName, '-')) {
                    return null;
                }
                $faculty = strtoupper(Str::before($userName, '-'));
                $prodi = strtoupper(Str::after($userName, '-'));
                return $faculty . '|' . $prodi;
            })->filter()->map->count();

            // Format prodi data by faculty
            $formattedProdiData = [];
            foreach ($prodiPerFakultas as $key => $count) {
                [$faculty, $prodi] = explode('|', $key);
                if (!isset($formattedProdiData[$faculty])) {
                    $formattedProdiData[$faculty] = [];
                }
                $formattedProdiData[$faculty][$prodi] = $count;
            }

            // Task 5.2: Return successful response with proper structure
            return response()->json([
                'sumberInput' => $sumberInput,
                'kategori' => $kategori,
                'tren' => $tren,
                'perFakultas' => $perFakultas,
                'prodiPerFakultas' => $formattedProdiData,
            ], 200);

        } catch (ValidationException $e) {
            // Task 5.2: Handle validation errors
            Log::warning('RespondenAnswer Graph: Validation failed', [
                'errors' => $e->errors(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'error' => 'Validasi gagal',
                'message' => 'Data yang dikirim tidak valid',
                'details' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // Task 5.2: Handle general errors with context logging
            Log::error('RespondenAnswer Graph: Error fetching data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'error' => 'Terjadi kesalahan server',
                'message' => 'Gagal mengambil data grafik. Silakan coba lagi atau hubungi administrator.',
            ], 500);
        }
    }
}
