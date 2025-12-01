<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;

use App\Models\Responden;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminRespondenReportController extends Controller
{
    private function getUserFacultyInfo(User $user)
    {
        $userFaculty = null;
        if ($user->role === 'fakultas') {
            $userFaculty = strtolower($user->name);
        } elseif ($user->role === 'prodi') {
            $parts = explode('-', $user->name, 2);
            if (count($parts) === 2) {
                $userFaculty = strtolower($parts[0]);
            } else {
                Log::warning('Responden: Unexpected name format for prodi user: ' . $user->name, ['user_id' => $user->id]);
                $userFaculty = strtolower($user->name);
            }
        }
        return ['faculty_code' => $userFaculty];
    }

    public function laporan()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin_direktorat', 'admin_pemeringkatan'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Tidak ada akses');
        }
        $faculties = Responden::query()
            ->select('fakultas')
            ->whereNotNull('fakultas')
            ->where('fakultas', '!=', '')
            ->distinct()
            ->orderBy('fakultas')
            ->get()
            ->map(function ($item) {
                $item->fakultas_cleaned = $this->normalizeFacultyName($item->fakultas);
                return $item;
            })
            ->pluck('fakultas_cleaned', 'fakultas_cleaned')
            ->sort()
            ->unique();
        
        $viewName = $user->role === 'admin_pemeringkatan' ? 'admin_pemeringkatan.responden-report.laporan' : 'admin.responden_laporan';
        return view($viewName, compact('faculties'));
    }

    public function laporanFakultas()
    {
        if (Auth::user()->role !== 'fakultas') {
            return redirect()->back()->with('error', 'Tidak ada akses');
        }
        return view('fakultas.responden_laporan');
    }

    public function getFacultyReportData(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'fakultas') {
                return response()->json(['error' => 'Akses ditolak'], 403);
            }

            $userInfo = $this->getUserFacultyInfo($user);
            $facultyCode = $userInfo['faculty_code'];
            if (!$facultyCode) {
                 return response()->json(['error' => 'Kode fakultas tidak ditemukan'], 400);
            }

            $facultyUserIds = User::where('name', $facultyCode)
                                  ->orWhere('name', 'like', $facultyCode . '-%')
                                  ->pluck('id');

            $query = Responden::whereIn('user_id', $facultyUserIds);

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            if ($request->filled('category') && in_array($request->category, ['academic', 'employer', 'employee'])) {
                $normalizedCategory = $this->normalizeCategoryName($request->category);
                if ($normalizedCategory === 'academic') {
                    $query->whereIn('category', ['academic', 'researcher', 'reseracher']);
                } else {
                    $query->whereIn('category', ['employer', 'employeer', 'industri', 'employee']);
                }
            }

            $respondens = $query->with('user')->get();

            $baseUsers = User::whereIn('id', $facultyUserIds)->get();
            $getLabel = function($userName) {
                if (Str::contains($userName, '-')) {
                    $prodiName = trim(Str::after($userName, '-'));
                    return empty($prodiName) ? 'Prodi Tanpa Nama (' . $userName . ')' : ucwords($prodiName);
                }
                return 'Input Fakultas (' . strtoupper($userName) . ')';
            };

            $prodiTotals = [];
            foreach ($baseUsers as $baseUser) {
                $prodiTotals[$getLabel($baseUser->name)] = 0;
            }

            foreach ($respondens as $responden) {
                if ($responden->user) {
                    $label = $getLabel($responden->user->name);
                    if (isset($prodiTotals[$label])) {
                        $prodiTotals[$label]++;
                    }
                }
            }

            $categoryTotals = $respondens->groupBy(function ($r) {
                return $this->normalizeCategoryName($r->category);
            })->map->count();


            return response()->json([
                'byProdi' => collect($prodiTotals)->sortKeys(),
                'byCategory' => $categoryTotals,
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching faculty report data: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Gagal mengambil data laporan fakultas'], 500);
        }
    }

    private function normalizeFacultyName($faculty)
    {
        $faculty = strtolower(trim($faculty));
        if (strpos($faculty, 'fe-') === 0) return 'feb';
        $map = ['teknik' => 'ft', 'fpbs' => 'fbs', 'fkip' => 'fip', 'fis' => 'fish', 'fish' => 'fish', 'fe'  => 'feb', 'feb' => 'feb', 'fppsi' => 'fpsi', 'fpsi' => 'fpsi'];
        if (array_key_exists($faculty, $map)) return $map[$faculty];
        if (empty($faculty)) return 'tidak terdefinisi';
        return $faculty;
    }

    private function normalizeCategoryName($category)
    {
        $category = strtolower(trim($category));
        $academicKeywords = ['academic', 'researcher', 'reseracher'];
        $employerKeywords = ['employer', 'employeer', 'industri', 'employee'];
        foreach ($academicKeywords as $keyword) {
            if (Str::contains($category, $keyword)) return 'academic';
        }
        foreach ($employerKeywords as $keyword) {
            if (Str::contains($category, $keyword)) return 'employee';
        }
        if (empty($category)) return 'lainnya';
        return 'lainnya';
    }

    private function getFacultyColors()
    {
        return ['fbs' => '#3B82F6', 'feb' => '#10B981', 'fip' => '#F59E0B', 'fish' => '#8B5CF6', 'fik' => '#EF4444', 'fmipa' => '#14B8A6', 'fpsi' => '#EC4899', 'ft' => '#6366F1', 'pascasarjana' => '#6B7280', 'tidak terdefinisi' => '#9CA3AF'];
    }

    public function getChartSummaryData(Request $request)
    {
        try {
            $query = Responden::with('user');

            if ($request->filled('start_date') && $request->filled('end_date')) {
                try {
                    $startDate = Carbon::parse($request->start_date)->startOfDay();
                    $endDate = Carbon::parse($request->end_date)->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    Log::warning('Invalid date format for chart summary', ['error' => $e->getMessage()]);
                }
            }

            if ($request->filled('fakultas') && $request->fakultas !== 'semua') {
                $query->where('fakultas', $request->fakultas);
            }

            $allRespondens = $query->get();
            $dataSource = $request->input('data_source', 'non_admin');
            $category = $request->input('category');
            
            $filteredRespondens = $allRespondens->filter(function ($responden) use ($dataSource) {
                $effectiveRole = $responden->user ? $responden->user->role : 'admin_direktorat';

                if ($dataSource === 'all') {
                    return true;
                }
                if ($dataSource === 'non_admin') {
                    return $effectiveRole !== 'admin_direktorat';
                }
                if ($dataSource === 'admin_only') {
                    return $effectiveRole === 'admin_direktorat';
                }
                return false;
            });

            $forFacultyCalculation = $filteredRespondens;
            $forSummaryCalculation = $filteredRespondens;

            if ($category && in_array($category, ['academic', 'employer', 'employee'])) {
                $normalizedCategory = $this->normalizeCategoryName($category);
                $forFacultyCalculation = $forFacultyCalculation->filter(function ($responden) use ($normalizedCategory) {
                    return $this->normalizeCategoryName($responden->category) === $normalizedCategory;
                });
            }

            $byFaculty = $forFacultyCalculation
                ->groupBy(function ($responden) {
                    return $this->normalizeFacultyName($responden->fakultas);
                })
                ->map(function ($respondensInFaculty) {
                    $categoryCounts = $respondensInFaculty->groupBy(function ($r) {
                        return $this->normalizeCategoryName($r->category);
                    })->map->count();
                    
                    return [
                        'academic' => $categoryCounts->get('academic', 0),
                        'employee' => $categoryCounts->get('employee', 0),
                    ];
                });


            $byFacultySorted = $byFaculty->sortKeys();
            if ($byFacultySorted->has('tidak terdefinisi')) {
                $undefined = $byFacultySorted->pull('tidak terdefinisi');
                $byFacultySorted->put('tidak terdefinisi', $undefined);
            }

            $byCategory = $forSummaryCalculation->groupBy(function ($r) {
                return $this->normalizeCategoryName($r->category);
            })->map->count();
            $byStatus = $forSummaryCalculation->groupBy('status')->map->count();

            return response()->json([
                'byFaculty' => $byFacultySorted,
                'facultyColors' => $this->getFacultyColors(),
                'byCategory' => $byCategory,
                'byStatus' => $byStatus,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching chart summary data: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return response()->json(['error' => 'Failed to fetch chart data'], 500);
        }
    }

    public function getProdiChartData(Request $request)
    {
        $request->validate([
            'fakultas' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category' => 'nullable|string|in:academic,employer,employee',
            'data_source' => 'nullable|string|in:all,non_admin,admin_only'
        ]);
        try {
            $facultyCode = $request->input('fakultas');
            $user = Auth::user();

            if (empty($facultyCode) && $user->role === 'fakultas') {
                $userInfo = $this->getUserFacultyInfo($user);
                $facultyCode = $userInfo['faculty_code'];
            }

            $dataSource = $request->input('data_source', 'non_admin');

            $query = Responden::with('user');

            if ($request->filled('category')) {
                $normalizedCategory = $this->normalizeCategoryName($request->category);
                if ($normalizedCategory === 'academic') {
                    $query->whereIn('category', ['academic', 'researcher', 'reseracher']);
                } else {
                    $query->whereIn('category', ['employer', 'employeer', 'industri', 'employee']);
                }
            }
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $allRespondens = $query->get();
            $filteredRespondens = $allRespondens->filter(function ($responden) use ($dataSource) {
                $effectiveRole = $responden->user ? $responden->user->role : 'admin_direktorat';
                if ($dataSource === 'all') {
                    return true;
                }
                if ($dataSource === 'non_admin') {
                    return $effectiveRole !== 'admin_direktorat';
                }
                if ($dataSource === 'admin_only') {
                    return $effectiveRole === 'admin_direktorat';
                }
                return false;
            });

            if (empty($facultyCode) || $facultyCode === 'semua') {
                $allFaculties = User::where('role', 'fakultas')->pluck('name')->map(function ($name) {
                    return $this->normalizeFacultyName($name);
                })->unique();
                $facultyTotals = $allFaculties->flip()->map(fn() => 0)->toArray();

                foreach ($filteredRespondens as $responden) {
                    if ($responden->user && in_array($responden->user->role, ['fakultas', 'prodi'])) {
                        $facultyName = Str::contains($responden->user->name, '-') ? Str::before($responden->user->name, '-') : $responden->user->name;
                        $normalizedFaculty = $this->normalizeFacultyName($facultyName);
                        if (isset($facultyTotals[$normalizedFaculty])) {
                            $facultyTotals[$normalizedFaculty]++;
                        }
                    }
                }
                $data = collect($facultyTotals)->mapWithKeys(fn($count, $faculty) => [strtoupper($faculty) => $count])->sortKeys();
            } else {
                $normalizationMap = ['fis' => 'fish', 'fe' => 'feb', 'fppsi' => 'fpsi'];
                $aliases = array_unique(array_merge([$facultyCode], array_keys($normalizationMap, $facultyCode, true)));

                $baseUsers = User::where(function ($q) use ($aliases) {
                    $q->where('role', 'fakultas')->whereIn('name', $aliases);
                })->orWhere(function ($q) use ($aliases) {
                    $q->where('role', 'prodi')->where(function ($subq) use ($aliases) {
                        foreach ($aliases as $alias) {
                            $subq->orWhere('name', 'like', $alias . '-%');
                        }
                    });
                })->get();
                
                $getLabel = function($userName) {
                    if (Str::contains($userName, '-')) {
                        $prodiName = trim(Str::after($userName, '-'));
                        if (empty($prodiName)) {
                            return 'Prodi Tanpa Nama (' . $userName . ')';
                        }
                        return ucwords($prodiName);
                    }
                    return 'Input Fakultas (' . strtoupper($userName) . ')';
                };

                $prodiTotals = [];
                foreach ($baseUsers as $user) {
                    $label = $getLabel($user->name);
                    $prodiTotals[$label] = 0;
                }
                
                $userIdToLabelMap = [];
                foreach($baseUsers as $user) {
                    $userIdToLabelMap[$user->id] = $getLabel($user->name);
                }

                $facultyUserIds = $baseUsers->pluck('id');
                $respondensInFaculty = $filteredRespondens->whereIn('user_id', $facultyUserIds);
                
                $countsByUserId = $respondensInFaculty->groupBy('user_id')->map->count();

                foreach ($countsByUserId as $userId => $count) {
                    if (isset($userIdToLabelMap[$userId])) {
                        $label = $userIdToLabelMap[$userId];
                        $prodiTotals[$label] = $count;
                    }
                }
                
                $data = collect($prodiTotals)->sortKeys();
            }

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error fetching prodi chart data: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to fetch prodi chart data'], 500);
        }
    }
}
