<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Models\Responden;
use App\Models\QsSession;
use App\Models\QsSessionRespondent;
use App\Models\User;
use App\Exports\LegacyReportExport;
use App\Exports\SessionReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Roles considered as "Direktorat" accounts (inputer / unit label).
     */
    private const DIREKTORAT_ROLES = [
        'admin_pemeringkatan', 'admin_direktorat', 'super_admin', 'kepala_direktorat',
        'kepala_sub_direktorat', 'wr3', 'admin_hilirisasi', 'admin_inovasi',
    ];

    /**
     * Display the main Reports page with both tabs.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $accessibleUserIds = $user->getAccessibleUserIds();

        // 1. Available QS Sessions for dropdown
        $sessions = QsSession::orderBy('created_at', 'desc')->get();

        // 2. Legacy filters metadata using canonical helpers
        $legacyFaculties = $this->getAvailableFaculties($user);
        $legacyYears = $this->getAvailableLegacyYears($user);

        return view('admin_pemeringkatan.reports.index', compact(
            'sessions',
            'legacyYears',
            'legacyFaculties',
            'user'
        ));
    }

    /**
     * AJAX endpoint: Filtered Legacy Responden data with pagination & stats.
     */
    public function legacyData(Request $request)
    {
        $user = Auth::user();
        $isFinishedSubquery = $this->getIsFinishedSubquery();

        // Base query: role scope + date/year/fakultas/category/search (no status, no inputer)
        $baseQuery = $this->buildLegacyBaseQuery($request, $user);

        // Inputer breakdown follows all filters except Status & Penginput (hidden for Prodi)
        $inputerBreakdown = $user->isProdi() ? [] : $this->buildInputerBreakdown($baseQuery);

        $query = (clone $baseQuery)
            ->selectRaw("respondens.*, ($isFinishedSubquery) as is_finished")
            ->with('user:id,name,role');

        $this->applyLegacyInputerFilter($query, $request, $user);

        // Calculate summary stats on the filtered query (before status filter to know total vs finished)
        $statsBaseQuery = clone $query;
        $totalCount = $statsBaseQuery->count();
        $finishedCount = (clone $statsBaseQuery)->whereRaw("($isFinishedSubquery) = 1")->count();
        $pendingCount = $totalCount - $finishedCount;
        $finishRate = $totalCount > 0 ? round(($finishedCount / $totalCount) * 100, 1) : 0;

        // Apply status filter if specified
        $this->applyLegacyStatusFilter($query, $request);

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $direction = strtolower($request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';
        $allowedSorts = ['fullname', 'email', 'instansi', 'fakultas', 'category', 'created_at', 'is_finished'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy === 'is_finished' ? 'is_finished' : 'respondens.' . $sortBy, $direction);
        } else {
            $query->orderBy('respondens.created_at', 'desc');
        }

        $perPage = max(5, min(100, (int) $request->get('per_page', 15)));
        $paginator = $query->paginate($perPage);

        $paginator->getCollection()->transform(function ($item) {
            $item->fakultas = self::normalizeFacultyCode($item->fakultas) ?: ($item->fakultas ? strtoupper($item->fakultas) : '-');

            $inputer = self::describeInputer($item->user, $item->user_id);
            $item->inputer_name = $inputer['name'];
            $item->inputer_type = $inputer['type'];
            $item->inputer_type_label = $inputer['type_label'];
            $item->makeHidden('user');

            return $item;
        });

        return response()->json([
            'stats' => [
                'total' => $totalCount,
                'finished' => $finishedCount,
                'pending' => $pendingCount,
                'rate' => $finishRate,
            ],
            'inputer_breakdown' => $inputerBreakdown,
            'data' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
        ]);
    }

    /**
     * AJAX endpoint: Session aggregate overview, charts data, and session breakdown table.
     */
    public function sessionOverview(Request $request)
    {
        $user = Auth::user();
        $accessibleUserIds = $user->getAccessibleUserIds();

        $sessionId = $request->get('session_id', 'all');

        // Base query for session respondents
        $query = QsSessionRespondent::query()
            ->with(['session', 'bankRespondent', 'addedByUser']);

        if ($accessibleUserIds !== null) {
            $query->whereIn('added_by', $accessibleUserIds);
        }

        if ($sessionId !== 'all' && is_numeric($sessionId)) {
            $query->where('qs_session_id', $sessionId);
        }

        $respondents = $query->get();

        // 1. Overall Stats
        $totalRespondents = $respondents->count();
        $agreedCount = $respondents->where('consent_status', 'agreed')->count();
        $declinedCount = $respondents->where('consent_status', 'declined')->count();
        $pendingCount = $respondents->where('consent_status', 'pending')->count();
        $emailedCount = $respondents->whereNotNull('email_sent_at')->count();
        $notEmailedCount = $respondents->whereNull('email_sent_at')->count();
        $consentRate = $totalRespondents > 0 ? round(($agreedCount / $totalRespondents) * 100, 1) : 0.0;

        // 2. Status Distribution (Pie / Doughnut Chart)
        $consentDistribution = [
            'labels' => ['Setuju (Agreed)', 'Pending (Menunggu)', 'Belum Dikirim Email'],
            'datasets' => [
                [
                    'data' => [
                        $agreedCount,
                        $respondents->where('consent_status', 'pending')->whereNotNull('email_sent_at')->count(),
                        $notEmailedCount,
                    ],
                    'backgroundColor' => ['#10B981', '#F59E0B', '#9CA3AF'],
                    'hoverBackgroundColor' => ['#059669', '#D97706', '#6B7280'],
                    'borderWidth' => 2,
                    'borderColor' => '#FFFFFF',
                ]
            ],
        ];

        // 3. Fakultas Distribution (Bar Chart: Agreed vs Pending per Fakultas)
        $fakultasGroups = [];
        foreach ($respondents as $r) {
            $label = $this->resolveFacultyLabel($r->addedByUser);
            if (!isset($fakultasGroups[$label])) {
                $fakultasGroups[$label] = [
                    'unit' => $label,
                    'total' => 0,
                    'agreed' => 0,
                    'pending' => 0,
                    'not_emailed' => 0,
                ];
            }
            $fakultasGroups[$label]['total']++;
            if ($r->consent_status === 'agreed') {
                $fakultasGroups[$label]['agreed']++;
            } else {
                $fakultasGroups[$label]['pending']++;
            }
            if ($r->email_sent_at === null) {
                $fakultasGroups[$label]['not_emailed']++;
            }
        }
        ksort($fakultasGroups);

        $facultyLabels = array_keys($fakultasGroups);
        $facultyAgreed = array_map(fn($f) => $fakultasGroups[$f]['agreed'], $facultyLabels);
        $facultyPending = array_map(fn($f) => $fakultasGroups[$f]['pending'], $facultyLabels);

        $fakultasChart = [
            'labels' => $facultyLabels,
            'datasets' => [
                [
                    'label' => 'Setuju (Selesai)',
                    'data' => $facultyAgreed,
                    'backgroundColor' => '#10B981',
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Pending / Belum',
                    'data' => $facultyPending,
                    'backgroundColor' => '#F59E0B',
                    'borderRadius' => 4,
                ]
            ],
        ];

        // 4. Per-Session Summary List
        $sessionsQuery = QsSession::query();
        if ($sessionId !== 'all' && is_numeric($sessionId)) {
            $sessionsQuery->where('id', $sessionId);
        }
        $sessions = $sessionsQuery->orderBy('created_at', 'desc')->get();

        $sessionRows = [];
        foreach ($sessions as $s) {
            $sessionResp = $respondents->where('qs_session_id', $s->id);
            $sTotal = $sessionResp->count();
            $sAgreed = $sessionResp->where('consent_status', 'agreed')->count();
            $sPending = $sessionResp->where('consent_status', 'pending')->count();
            $sNotEmailed = $sessionResp->whereNull('email_sent_at')->count();
            $sRate = $sTotal > 0 ? round(($sAgreed / $sTotal) * 100, 1) : 0.0;

            $sessionRows[] = [
                'id' => $s->id,
                'name' => $s->name,
                'status' => $s->status,
                'mode' => $s->mode,
                'is_form_based' => $s->isFormBased(),
                'start_date' => $s->start_date ? $s->start_date->format('d M Y') : '-',
                'end_date' => $s->end_date ? $s->end_date->format('d M Y') : '-',
                'total_count' => $sTotal,
                'agreed_count' => $sAgreed,
                'pending_count' => $sPending,
                'not_emailed_count' => $sNotEmailed,
                'consent_rate' => $sRate,
            ];
        }

        return response()->json([
            'stats' => [
                'total_sessions' => count($sessions),
                'total_respondents' => $totalRespondents,
                'agreed_count' => $agreedCount,
                'pending_count' => $pendingCount,
                'not_emailed_count' => $notEmailedCount,
                'consent_rate' => $consentRate,
            ],
            'consent_chart' => $consentDistribution,
            'fakultas_chart' => $fakultasChart,
            'fakultas_summary' => array_values($fakultasGroups),
            'sessions' => $sessionRows,
        ]);
    }

    /**
     * AJAX endpoint: Detail breakdown per unit/fakultas for a specific session.
     */
    public function sessionDetail($sessionId)
    {
        $user = Auth::user();
        $accessibleUserIds = $user->getAccessibleUserIds();

        $session = QsSession::findOrFail($sessionId);
        $data = $this->computeSessionBreakdown($session, $accessibleUserIds);

        return response()->json([
            'session' => $data['stats'],
            'units' => $data['units'],
        ]);
    }

    /**
     * Dedicated Page: Full Breakdown Unit details with Academic vs Employee metrics.
     */
    public function sessionBreakdownPage(Request $request, $sessionId)
    {
        $user = Auth::user();
        $accessibleUserIds = $user->getAccessibleUserIds();

        $session = QsSession::findOrFail($sessionId);
        $data = $this->computeSessionBreakdown($session, $accessibleUserIds);

        return view('admin_pemeringkatan.reports.session_breakdown', [
            'session' => $session,
            'stats' => $data['stats'],
            'units' => $data['units'],
            'user' => $user,
        ]);
    }

    /**
     * Dedicated Page: Full Sebaran Penginput (Arsip Legacy) analytics & ranking per prodi/fakultas/direktorat.
     */
    public function inputerAnalyticsPage(Request $request)
    {
        $user = Auth::user();
        if ($user->isProdi()) {
            return redirect()->route('admin_pemeringkatan.reports.index', ['tab' => 'legacy'])
                ->with('error', 'Akses dibatasi. Halaman analisis penginput hanya untuk level Fakultas dan Direktorat.');
        }

        $accessibleUserIds = $user->getAccessibleUserIds();
        $baseQuery = $this->buildLegacyBaseQuery($request, $user);

        // Overall stats
        $finishedSql = $this->getIsFinishedSubquery();
        $academicSql = "CASE WHEN LOWER(TRIM(respondens.category)) IN ('academic', 'researcher', 'reseracher') THEN 1 ELSE 0 END";
        $employeeSql = "CASE WHEN LOWER(TRIM(respondens.category)) IN ('employer', 'employeer', 'industri', 'employee') THEN 1 ELSE 0 END";

        $statsRow = (clone $baseQuery)
            ->selectRaw("COUNT(*) as total, SUM($finishedSql) as finished, SUM($academicSql) as academic_total, SUM($employeeSql) as employee_total")
            ->first();

        $total = (int) ($statsRow->total ?? 0);
        $finished = (int) ($statsRow->finished ?? 0);
        $academicTotal = (int) ($statsRow->academic_total ?? 0);
        $employeeTotal = (int) ($statsRow->employee_total ?? 0);
        $pending = max(0, $total - $finished);
        $rate = $total > 0 ? round(($finished / $total) * 100, 1) : 0;

        // Breakdown groups
        $breakdown = $this->buildInputerBreakdown($baseQuery);

        // Extract Prodi list specifically for deep analytics & charts
        $prodiGroup = collect($breakdown)->firstWhere('type', 'prodi') ?? [
            'type' => 'prodi',
            'label' => 'Program Studi',
            'total' => 0,
            'finished' => 0,
            'rate' => 0,
            'inputers' => [],
        ];

        $prodiInputers = $prodiGroup['inputers'] ?? [];
        $prodiCount = count($prodiInputers);
        $prodiTotal = $prodiGroup['total'] ?? 0;
        $prodiFinished = $prodiGroup['finished'] ?? 0;
        $prodiAvg = $prodiCount > 0 ? round($prodiTotal / $prodiCount, 1) : 0;

        // Faculty options and years using consistent canonical helpers
        $fakultasOptions = $this->getAvailableFaculties($user);
        $years = $this->getAvailableLegacyYears($user);

        // Faculty-level breakdown for chart (when 'Semua Fakultas' is selected)
        $facultyRows = (clone $baseQuery)
            ->whereNotNull('respondens.fakultas')
            ->where('respondens.fakultas', '!=', '')
            ->selectRaw("LOWER(TRIM(respondens.fakultas)) as raw_fak, COUNT(*) as total, SUM($finishedSql) as finished, SUM($academicSql) as academic_total, SUM($employeeSql) as employee_total")
            ->groupBy(DB::raw("LOWER(TRIM(respondens.fakultas))"))
            ->toBase()
            ->get();

        $facultyChartMap = [];
        foreach ($facultyRows as $r) {
            $canon = self::normalizeFacultyCode($r->raw_fak);
            if (!$canon) continue;
            if (!isset($facultyChartMap[$canon])) {
                $facultyChartMap[$canon] = [
                    'name' => 'Fakultas ' . $canon,
                    'short_name' => $canon,
                    'id' => strtolower($canon),
                    'total' => 0,
                    'finished' => 0,
                    'pending' => 0,
                    'academic_total' => 0,
                    'employee_total' => 0,
                    'rate' => 0,
                ];
            }
            $facultyChartMap[$canon]['total'] += (int) $r->total;
            $facultyChartMap[$canon]['finished'] += (int) $r->finished;
            $facultyChartMap[$canon]['academic_total'] += (int) ($r->academic_total ?? 0);
            $facultyChartMap[$canon]['employee_total'] += (int) ($r->employee_total ?? 0);
        }

        foreach ($facultyChartMap as &$fc) {
            $fc['pending'] = max(0, $fc['total'] - $fc['finished']);
            $fc['rate'] = $fc['total'] > 0 ? round(($fc['finished'] / $fc['total']) * 100, 1) : 0;
        }
        unset($fc);

        $facultyChartList = array_values($facultyChartMap);
        usort($facultyChartList, fn($a, $b) => $b['total'] <=> $a['total']);

        return view('admin_pemeringkatan.reports.inputer_analytics', [
            'overallStats' => [
                'total' => $total,
                'finished' => $finished,
                'pending' => $pending,
                'academic_total' => $academicTotal,
                'employee_total' => $employeeTotal,
                'rate' => $rate,
            ],
            'prodiStats' => [
                'count' => $prodiCount,
                'total' => $prodiTotal,
                'finished' => $prodiFinished,
                'academic_total' => array_sum(array_column($prodiInputers, 'academic_total')),
                'employee_total' => array_sum(array_column($prodiInputers, 'employee_total')),
                'rate' => $prodiGroup['rate'] ?? 0,
                'avg' => $prodiAvg,
                'top' => !empty($prodiInputers) ? $prodiInputers[0] : null,
            ],
            'breakdown' => $breakdown,
            'prodiList' => $prodiInputers,
            'facultyList' => $facultyChartList,
            'fakultasOptions' => $fakultasOptions,
            'years' => $years,
            'filters' => [
                'year' => $request->query('year', 'all'),
                'fakultas' => $request->query('fakultas', 'all'),
                'start_date' => $request->query('start_date', ''),
                'end_date' => $request->query('end_date', ''),
            ],
            'user' => $user,
        ]);
    }

    /**
     * Compute session unit breakdown with separation between academic and employee respondents.
     */
    private function computeSessionBreakdown(QsSession $session, ?array $accessibleUserIds): array
    {
        $query = QsSessionRespondent::where('qs_session_id', $session->id)
            ->with(['bankRespondent', 'addedByUser']);

        if ($accessibleUserIds !== null) {
            $query->whereIn('added_by', $accessibleUserIds);
        }

        $respondents = $query->get();

        $totalRespondents = $respondents->count();
        $agreedTotal = 0;
        $pendingTotal = 0;
        $academicTotal = 0;
        $academicAgreed = 0;
        $employeeTotal = 0;
        $employeeAgreed = 0;

        $unitBreakdown = [];
        foreach ($respondents as $r) {
            $addedUser = $r->addedByUser;
            $unitLabel = $this->resolveFacultyLabel($addedUser);
            $specificName = $r->added_by_label;

            $rawCat = strtolower(trim($r->category ?: ($r->bankRespondent?->category ?: 'academic')));
            $isEmployee = in_array($rawCat, ['employer', 'employeer', 'employee', 'industri']);

            $key = $unitLabel;
            if (!isset($unitBreakdown[$key])) {
                $unitBreakdown[$key] = [
                    'unit' => $unitLabel,
                    'total' => 0,
                    'agreed' => 0,
                    'pending' => 0,
                    'not_emailed' => 0,
                    'academic_total' => 0,
                    'academic_agreed' => 0,
                    'academic_pending' => 0,
                    'employee_total' => 0,
                    'employee_agreed' => 0,
                    'employee_pending' => 0,
                    'prodis' => [],
                ];
            }

            $unitBreakdown[$key]['total']++;
            if ($r->consent_status === 'agreed') {
                $unitBreakdown[$key]['agreed']++;
                $agreedTotal++;
            } else {
                $unitBreakdown[$key]['pending']++;
                $pendingTotal++;
            }

            if ($r->email_sent_at === null) {
                $unitBreakdown[$key]['not_emailed']++;
            }

            if ($isEmployee) {
                $employeeTotal++;
                $unitBreakdown[$key]['employee_total']++;
                if ($r->consent_status === 'agreed') {
                    $employeeAgreed++;
                    $unitBreakdown[$key]['employee_agreed']++;
                } else {
                    $unitBreakdown[$key]['employee_pending']++;
                }
            } else {
                $academicTotal++;
                $unitBreakdown[$key]['academic_total']++;
                if ($r->consent_status === 'agreed') {
                    $academicAgreed++;
                    $unitBreakdown[$key]['academic_agreed']++;
                } else {
                    $unitBreakdown[$key]['academic_pending']++;
                }
            }

            // Track specific prodi / user under this faculty
            if (!isset($unitBreakdown[$key]['prodis'][$specificName])) {
                $unitBreakdown[$key]['prodis'][$specificName] = [
                    'name' => $specificName,
                    'total' => 0,
                    'agreed' => 0,
                    'pending' => 0,
                    'academic_total' => 0,
                    'academic_agreed' => 0,
                    'employee_total' => 0,
                    'employee_agreed' => 0,
                ];
            }

            $unitBreakdown[$key]['prodis'][$specificName]['total']++;
            if ($r->consent_status === 'agreed') {
                $unitBreakdown[$key]['prodis'][$specificName]['agreed']++;
            } else {
                $unitBreakdown[$key]['prodis'][$specificName]['pending']++;
            }

            if ($isEmployee) {
                $unitBreakdown[$key]['prodis'][$specificName]['employee_total']++;
                if ($r->consent_status === 'agreed') {
                    $unitBreakdown[$key]['prodis'][$specificName]['employee_agreed']++;
                }
            } else {
                $unitBreakdown[$key]['prodis'][$specificName]['academic_total']++;
                if ($r->consent_status === 'agreed') {
                    $unitBreakdown[$key]['prodis'][$specificName]['academic_agreed']++;
                }
            }
        }
        ksort($unitBreakdown);

        // Format and compute rates
        $formattedUnits = [];
        foreach ($unitBreakdown as $u) {
            $total = $u['total'];
            $agreed = $u['agreed'];
            $rate = $total > 0 ? round(($agreed / $total) * 100, 1) : 0;
            $acadRate = $u['academic_total'] > 0 ? round(($u['academic_agreed'] / $u['academic_total']) * 100, 1) : 0;
            $empRate = $u['employee_total'] > 0 ? round(($u['employee_agreed'] / $u['employee_total']) * 100, 1) : 0;

            $prodis = [];
            foreach ($u['prodis'] as $p) {
                $pTotal = $p['total'];
                $pAgreed = $p['agreed'];
                $pRate = $pTotal > 0 ? round(($pAgreed / $pTotal) * 100, 1) : 0;
                $pAcadRate = $p['academic_total'] > 0 ? round(($p['academic_agreed'] / $p['academic_total']) * 100, 1) : 0;
                $pEmpRate = $p['employee_total'] > 0 ? round(($p['employee_agreed'] / $p['employee_total']) * 100, 1) : 0;

                $prodis[] = [
                    'name' => $p['name'],
                    'total' => $pTotal,
                    'agreed' => $pAgreed,
                    'pending' => $p['pending'],
                    'rate' => $pRate,
                    'academic_total' => $p['academic_total'],
                    'academic_agreed' => $p['academic_agreed'],
                    'academic_rate' => $pAcadRate,
                    'employee_total' => $p['employee_total'],
                    'employee_agreed' => $p['employee_agreed'],
                    'employee_rate' => $pEmpRate,
                ];
            }
            usort($prodis, fn($a, $b) => $b['total'] <=> $a['total']);

            $formattedUnits[] = [
                'unit' => $u['unit'],
                'total' => $total,
                'agreed' => $agreed,
                'pending' => $u['pending'],
                'not_emailed' => $u['not_emailed'],
                'rate' => $rate,
                'academic_total' => $u['academic_total'],
                'academic_agreed' => $u['academic_agreed'],
                'academic_pending' => $u['academic_pending'],
                'academic_rate' => $acadRate,
                'employee_total' => $u['employee_total'],
                'employee_agreed' => $u['employee_agreed'],
                'employee_pending' => $u['employee_pending'],
                'employee_rate' => $empRate,
                'prodis' => $prodis,
            ];
        }

        $overallRate = $totalRespondents > 0 ? round(($agreedTotal / $totalRespondents) * 100, 1) : 0;
        $academicRate = $academicTotal > 0 ? round(($academicAgreed / $academicTotal) * 100, 1) : 0;
        $employeeRate = $employeeTotal > 0 ? round(($employeeAgreed / $employeeTotal) * 100, 1) : 0;

        return [
            'stats' => [
                'id' => $session->id,
                'name' => $session->name,
                'status' => $session->status,
                'mode' => $session->mode,
                'description' => $session->description,
                'start_date' => $session->start_date ? $session->start_date->format('d M Y') : '-',
                'end_date' => $session->end_date ? $session->end_date->format('d M Y') : '-',
                'total_respondents' => $totalRespondents,
                'agreed_count' => $agreedTotal,
                'pending_count' => $pendingTotal,
                'rate' => $overallRate,
                'academic_total' => $academicTotal,
                'academic_agreed' => $academicAgreed,
                'academic_pending' => $academicTotal - $academicAgreed,
                'academic_rate' => $academicRate,
                'employee_total' => $employeeTotal,
                'employee_agreed' => $employeeAgreed,
                'employee_pending' => $employeeTotal - $employeeAgreed,
                'employee_rate' => $employeeRate,
            ],
            'units' => $formattedUnits,
        ];
    }

    /**
     * Excel Export for Legacy Responden Report.
     */
    public function exportLegacy(Request $request)
    {
        $user = Auth::user();
        $isFinishedSubquery = $this->getIsFinishedSubquery();

        $baseQuery = $this->buildLegacyBaseQuery($request, $user);

        // Rekap Penginput sheet uses the same scope as the on-screen breakdown panel
        $inputerBreakdown = $user->isProdi() ? [] : $this->buildInputerBreakdown($baseQuery);

        $query = (clone $baseQuery)
            ->selectRaw("respondens.*, ($isFinishedSubquery) as is_finished")
            ->with('user:id,name,role');

        $this->applyLegacyInputerFilter($query, $request, $user);
        $this->applyLegacyStatusFilter($query, $request);

        $query->orderBy('respondens.created_at', 'desc');

        $fileName = 'Laporan_Responden_Legacy_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new LegacyReportExport($query, $inputerBreakdown), $fileName);
    }

    /**
     * Excel Export for QS Campaign Session Report (2 sheets: Summary + Detail).
     */
    public function exportSession(Request $request)
    {
        $user = Auth::user();
        $accessibleUserIds = $user->getAccessibleUserIds();

        $sessionId = $request->get('session_id', 'all');

        $query = QsSessionRespondent::query()
            ->with(['session', 'bankRespondent', 'addedByUser']);

        if ($accessibleUserIds !== null) {
            $query->whereIn('added_by', $accessibleUserIds);
        }

        if ($sessionId !== 'all' && is_numeric($sessionId)) {
            $query->where('qs_session_id', $sessionId);
        }

        $detailRespondents = $query->orderBy('qs_session_id', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        // Build Summary per Fakultas / Unit
        $summaryGroups = [];
        foreach ($detailRespondents as $r) {
            $label = $this->resolveFacultyLabel($r->addedByUser);
            if (!isset($summaryGroups[$label])) {
                $summaryGroups[$label] = [
                    'unit' => $label,
                    'total' => 0,
                    'agreed' => 0,
                    'pending' => 0,
                    'not_emailed' => 0,
                ];
            }
            $summaryGroups[$label]['total']++;
            if ($r->consent_status === 'agreed') {
                $summaryGroups[$label]['agreed']++;
            } else {
                $summaryGroups[$label]['pending']++;
            }
            if ($r->email_sent_at === null) {
                $summaryGroups[$label]['not_emailed']++;
            }
        }
        ksort($summaryGroups);

        $summaryCollection = collect(array_values($summaryGroups));

        $fileName = 'Laporan_QS_Campaign_Sessions_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new SessionReportExport($summaryCollection, $detailRespondents), $fileName);
    }

    // --- Helper Methods ---

    /**
     * Map any raw faculty name, alias, legacy variation, or user name to its canonical code.
     * Mappings:
     * - FAKULTAS BAHASA DAN SENI -> FBS
     * - FAKULTAS EKONOMI DAN BISNIS -> FEB
     * - FE -> FEB
     * - FAKULTAS ILMU PENDIDIKAN -> FIP
     * - FAKULTAS ILMU SOSIAL -> FISH
     * - FIS -> FISH
     * - FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM -> FMIPA
     * - FAKULTAS PSIKOLOGI -> FPSI
     * - FAKULTAS TEKNIK -> FT
     * - TEKNIK -> FT
     * - FPBS -> FPB
     */
    public static function normalizeFacultyCode(?string $name): string
    {
        if (empty($name)) {
            return '';
        }

        $str = strtolower(trim($name));

        // Strip prefixes like "equity fakultas", "equity", "fakultas -"
        $str = preg_replace('/^(equity\s+fakultas|equity)\s+/i', '', $str);
        $str = preg_replace('/^fakultas\s*-\s*/i', '', $str);
        $str = trim($str);

        $directMap = [
            // FBS
            'fbs' => 'FBS',
            'fakultas bahasa dan seni' => 'FBS',
            'bahasa dan seni' => 'FBS',

            // FEB
            'feb' => 'FEB',
            'fe' => 'FEB',
            'fakultas ekonomi dan bisnis' => 'FEB',
            'ekonomi dan bisnis' => 'FEB',
            'fakultas ekonomi' => 'FEB',
            'ekonomi' => 'FEB',

            // FIP
            'fip' => 'FIP',
            'fkip' => 'FIP',
            'fakultas ilmu pendidikan' => 'FIP',
            'ilmu pendidikan' => 'FIP',
            'keguruan dan ilmu pendidikan' => 'FIP',

            // FISH
            'fish' => 'FISH',
            'fis' => 'FISH',
            'fakultas ilmu sosial' => 'FISH',
            'ilmu sosial' => 'FISH',
            'fakultas ilmu sosial dan hukum' => 'FISH',
            'ilmu sosial dan hukum' => 'FISH',

            // FMIPA
            'fmipa' => 'FMIPA',
            'mipa' => 'FMIPA',
            'fakultas matematika dan ilmu pengetahuan alam' => 'FMIPA',
            'matematika dan ilmu pengetahuan alam' => 'FMIPA',

            // FPSI
            'fpsi' => 'FPSI',
            'fppsi' => 'FPSI',
            'fakultas psikologi' => 'FPSI',
            'psikologi' => 'FPSI',

            // FT
            'ft' => 'FT',
            'teknik' => 'FT',
            'fakultas teknik' => 'FT',

            // FPB
            'fpb' => 'FPB',
            'fpbs' => 'FPB',

            // FIKK
            'fikk' => 'FIKK',
            'fik' => 'FIKK',
            'fakultas ilmu keolahragaan dan kesehatan' => 'FIKK',
            'ilmu keolahragaan dan kesehatan' => 'FIKK',
            'fakultas ilmu keolahragaan' => 'FIKK',
            'ilmu keolahragaan' => 'FIKK',

            // Others
            'profesi' => 'PROFESI',
            'program profesi' => 'PROFESI',
            'profesi ppg' => 'PROFESI',
            'pascasarjana' => 'PASCASARJANA',
            'pps' => 'PASCASARJANA',
            'pss' => 'PASCASARJANA',
        ];

        if (isset($directMap[$str])) {
            return $directMap[$str];
        }

        // Substring pattern matching
        if (str_contains($str, 'bahasa dan seni') || str_contains($str, 'bahasa & seni')) return 'FBS';
        if (str_contains($str, 'ekonomi dan bisnis') || str_contains($str, 'ekonomi & bisnis') || str_contains($str, 'ekonomi')) return 'FEB';
        if (str_contains($str, 'ilmu pendidikan') || str_contains($str, 'keguruan')) return 'FIP';
        if (str_contains($str, 'ilmu sosial')) return 'FISH';
        if (str_contains($str, 'matematika dan ilmu pengetahuan alam') || str_contains($str, 'mipa')) return 'FMIPA';
        if (str_contains($str, 'psikologi')) return 'FPSI';
        if (str_contains($str, 'teknik')) return 'FT';
        if (str_contains($str, 'fpbs') || str_contains($str, 'fpb')) return 'FPB';
        if (str_contains($str, 'keolahragaan')) return 'FIKK';

        return strtoupper($str);
    }

    /**
     * Get faculty code for the user if they are fakultas or prodi.
     * Returns null for directorate admin (meaning unrestricted).
     */
    private function getUserFacultyCode(?User $user): ?string
    {
        if (!$user || $user->isDirectorateAdmin()) {
            return null;
        }

        if ($user->isFakultas()) {
            return self::normalizeFacultyCode($user->name);
        }

        if ($user->isProdi()) {
            $parts = explode('-', $user->name, 2);
            return self::normalizeFacultyCode($parts[0]);
        }

        return null;
    }

    /**
     * Faculty aliases to match database variations.
     */
    private function getFacultyAliases(string $code): array
    {
        $canonical = self::normalizeFacultyCode($code);

        $aliasMap = [
            'FBS' => ['fbs', 'fakultas bahasa dan seni', 'fakultas bahasa & seni', 'bahasa dan seni'],
            'FEB' => ['feb', 'fe', 'fakultas ekonomi dan bisnis', 'fakultas ekonomi & bisnis', 'fakultas ekonomi', 'ekonomi dan bisnis', 'ekonomi'],
            'FIP' => ['fip', 'fkip', 'fakultas ilmu pendidikan', 'ilmu pendidikan', 'keguruan dan ilmu pendidikan'],
            'FISH' => ['fish', 'fis', 'fakultas ilmu sosial dan hukum', 'fakultas ilmu sosial', 'ilmu sosial dan hukum', 'ilmu sosial'],
            'FMIPA' => ['fmipa', 'mipa', 'fakultas matematika dan ilmu pengetahuan alam', 'matematika dan ilmu pengetahuan alam'],
            'FPSI' => ['fpsi', 'fppsi', 'fakultas psikologi', 'psikologi'],
            'FT' => ['ft', 'teknik', 'fakultas teknik'],
            'FPB' => ['fpb', 'fpbs'],
            'FIKK' => ['fikk', 'fik', 'fakultas ilmu keolahragaan dan kesehatan', 'fakultas ilmu keolahragaan', 'ilmu keolahragaan'],
            'PROFESI' => ['profesi', 'program profesi', 'profesi ppg'],
            'PASCASARJANA' => ['pascasarjana', 'pps', 'pss'],
        ];

        if (isset($aliasMap[$canonical])) {
            return $aliasMap[$canonical];
        }

        $lowerCode = strtolower(trim($code));
        return array_unique(array_filter([$lowerCode, strtolower($canonical)]));
    }

    /**
     * Get available legacy faculties based on user scope and canonical normalization.
     */
    public function getAvailableFaculties(User $user): array
    {
        if ($user->isProdi()) {
            $facultyCode = $this->getUserFacultyCode($user);
            $userCanonical = $facultyCode ? self::normalizeFacultyCode($facultyCode) : null;
            return $userCanonical ? [$userCanonical] : [];
        }

        if ($user->isFakultas()) {
            $facultyCode = $this->getUserFacultyCode($user);
            $userCanonical = $facultyCode ? self::normalizeFacultyCode($facultyCode) : null;
            return $userCanonical ? [$userCanonical] : [];
        }

        $rawFaculties = Responden::selectRaw('DISTINCT LOWER(fakultas) as fak')
            ->whereNotNull('fakultas')
            ->where('fakultas', '!=', '')
            ->pluck('fak');

        $canonicalList = [];
        foreach ($rawFaculties as $rawFak) {
            $canon = self::normalizeFacultyCode($rawFak);
            if (!empty($canon)) {
                $canonicalList[$canon] = true;
            }
        }

        $standardFaculties = ['FBS', 'FEB', 'FIP', 'FISH', 'FMIPA', 'FPB', 'FPSI', 'FT'];
        foreach ($standardFaculties as $std) {
            $canonicalList[$std] = true;
        }

        $faculties = array_keys($canonicalList);
        sort($faculties);
        return $faculties;
    }

    /**
     * Get available legacy years based on user scope.
     */
    public function getAvailableLegacyYears(User $user): array
    {
        $yearsQuery = Responden::selectRaw('YEAR(created_at) as yr')
            ->whereNotNull('created_at');

        if ($user->isProdi()) {
            $yearsQuery->where('user_id', $user->id);
        } elseif ($user->isFakultas()) {
            $facultyCode = $this->getUserFacultyCode($user);
            if ($facultyCode !== null) {
                $yearsQuery->whereIn(DB::raw('LOWER(fakultas)'), $this->getFacultyAliases($facultyCode));
            }
        }

        return $yearsQuery->distinct()
            ->orderBy('yr', 'desc')
            ->pluck('yr')
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Resolve faculty label from User model.
     */
    private function resolveFacultyLabel(?User $user): string
    {
        if (!$user) {
            return 'Direktorat';
        }

        $role = $user->role ?? '';
        if (in_array($role, self::DIREKTORAT_ROLES)) {
            return 'Direktorat';
        }

        if ($role === 'prodi') {
            $parts = explode('-', $user->name, 2);
            $canonical = self::normalizeFacultyCode(trim($parts[0]));
            return 'Fakultas - ' . ($canonical ?: strtoupper(trim($parts[0])));
        }

        if (in_array($role, ['fakultas', 'equity_fakultas'])) {
            $canonical = self::normalizeFacultyCode($user->name);
            return 'Fakultas - ' . ($canonical ?: strtoupper($user->name));
        }

        return 'Direktorat';
    }

    /**
     * Subquery to determine if a legacy respondent is finished (replied/fulfilled form).
     * Any status except 'clear' / 'selesai' is considered unfinished (belum selesai).
     */
    private function getIsFinishedSubquery(): string
    {
        return "CASE 
            WHEN LOWER(TRIM(respondens.status)) IN ('clear', 'selesai') THEN 1 
            ELSE 0 
        END";
    }

    // --- Legacy Filter Builders ---

    /**
     * Base legacy query: role scope + date / year / fakultas / category / search.
     * Status and Penginput filters are applied separately so stats and the
     * inputer breakdown can be computed before them.
     */
    private function buildLegacyBaseQuery(Request $request, User $user)
    {
        $query = Responden::query();

        // Role-based scoping
        if ($user->isProdi()) {
            $query->where('respondens.user_id', $user->id);
        } elseif ($user->isFakultas()) {
            $facultyCode = $this->getUserFacultyCode($user);
            if ($facultyCode !== null) {
                $allowedFakultas = $this->getFacultyAliases($facultyCode);
                $query->whereIn(DB::raw('LOWER(respondens.fakultas)'), $allowedFakultas);
            }
        }

        // Date range / Jenjang Tanggal (Date Created)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('respondens.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } elseif ($request->filled('start_date')) {
            $query->where('respondens.created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $query->where('respondens.created_at', '<=', $request->end_date . ' 23:59:59');
        } elseif ($request->filled('date')) {
            $query->whereDate('respondens.created_at', $request->date);
        }

        if ($request->filled('year') && $request->year !== 'all') {
            $query->whereYear('respondens.created_at', $request->year);
        }

        if (!$user->isProdi() && $request->filled('fakultas') && $request->fakultas !== 'all') {
            $selectedAliases = $this->getFacultyAliases(strtolower($request->fakultas));
            $query->whereIn(DB::raw('LOWER(respondens.fakultas)'), $selectedAliases);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $cat = strtolower(trim($request->category));
            if ($cat === 'academic') {
                $query->whereIn('respondens.category', ['academic', 'researcher', 'reseracher']);
            } elseif ($cat === 'employer') {
                $query->whereIn('respondens.category', ['employer', 'employeer', 'industri', 'employee']);
            }
        }

        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));
            $query->where(function ($q) use ($search) {
                $q->where(DB::raw('LOWER(respondens.fullname)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(respondens.email)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(respondens.instansi)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(respondens.jabatan)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(respondens.phone_responden)'), 'LIKE', "%{$search}%");
            });
        }

        return $query;
    }

    /**
     * Apply Status (email / final) filter.
     */
    private function applyLegacyStatusFilter($query, Request $request): void
    {
        if (!$request->filled('status') || $request->status === 'all') {
            return;
        }

        $isFinishedSubquery = $this->getIsFinishedSubquery();
        $statusVal = strtolower(trim($request->status));

        if (in_array($statusVal, ['selesai', 'clear', 'finished'])) {
            $query->whereRaw("($isFinishedSubquery) = 1");
        } elseif (in_array($statusVal, ['belum_selesai', 'unfinished'])) {
            $query->whereRaw("($isFinishedSubquery) = 0");
        } elseif ($statusVal === 'done') {
            $query->where(DB::raw('LOWER(respondens.status)'), 'done');
        } elseif ($statusVal === 'belum') {
            $query->where(function ($q) {
                $q->where(DB::raw('LOWER(respondens.status)'), 'belum')
                  ->orWhereNull('respondens.status');
            });
        } elseif ($statusVal === 'dones') {
            $query->where(DB::raw('LOWER(respondens.status)'), 'dones');
        }
    }

    /**
     * Apply Penginput filter: numeric user_id, or 'none' for rows without user_id.
     * Ignored for Prodi accounts (already locked to their own user_id).
     */
    private function applyLegacyInputerFilter($query, Request $request, User $user): void
    {
        if ($user->isProdi() || !$request->filled('inputer') || $request->inputer === 'all') {
            return;
        }

        $inputer = (string) $request->inputer;
        if ($inputer === 'none') {
            $query->whereNull('respondens.user_id');
        } elseif (ctype_digit($inputer)) {
            $query->where('respondens.user_id', (int) $inputer);
        }
    }

    // --- Inputer (Penginput) Helpers ---

    /**
     * Classify an inputer account into direktorat / fakultas / prodi / unknown.
     */
    public static function classifyInputerType(?string $role, bool $hasUser): string
    {
        if (!$hasUser) {
            return 'unknown';
        }
        if (in_array($role, ['fakultas', 'equity_fakultas'])) {
            return 'fakultas';
        }
        if ($role === 'prodi') {
            return 'prodi';
        }
        // Direktorat roles and any other role default to Direktorat (same as resolveFacultyLabel)
        return 'direktorat';
    }

    public static function inputerTypeLabel(string $type): string
    {
        return match ($type) {
            'direktorat' => 'Direktorat',
            'fakultas' => 'Fakultas',
            'prodi' => 'Prodi',
            default => 'Tidak Diketahui (Import Lama)',
        };
    }

    /**
     * Describe the inputer of a legacy respondent row.
     */
    public static function describeInputer(?User $user, $userId): array
    {
        if ($user) {
            $type = self::classifyInputerType($user->role, true);
            $name = $user->name;
        } else {
            $type = 'unknown';
            $name = $userId === null ? 'Tidak Diketahui' : 'Akun Terhapus (#' . $userId . ')';
        }

        return [
            'name' => $name,
            'type' => $type,
            'type_label' => self::inputerTypeLabel($type),
        ];
    }

    /**
     * Grouped breakdown of who inputted the respondents in the given (cloned) query.
     * Returns groups ordered Direktorat, Fakultas, Prodi, Tidak Diketahui; empty groups omitted.
     */
    private function buildInputerBreakdown($baseQuery): array
    {
        $finishedSql = $this->getIsFinishedSubquery();
        $academicSql = "CASE WHEN LOWER(TRIM(respondens.category)) IN ('academic', 'researcher', 'reseracher') THEN 1 ELSE 0 END";
        $employeeSql = "CASE WHEN LOWER(TRIM(respondens.category)) IN ('employer', 'employeer', 'industri', 'employee') THEN 1 ELSE 0 END";

        $rows = (clone $baseQuery)
            ->leftJoin('users as inp', 'inp.id', '=', 'respondens.user_id')
            ->selectRaw("respondens.user_id as inputer_id, inp.name as inputer_name, inp.role as inputer_role, COUNT(*) as total, SUM($finishedSql) as finished, SUM($academicSql) as academic_total, SUM($employeeSql) as employee_total")
            ->groupBy('respondens.user_id', 'inp.name', 'inp.role')
            ->toBase()
            ->get();

        $groups = [];
        foreach (['direktorat', 'fakultas', 'prodi', 'unknown'] as $type) {
            $groups[$type] = [
                'type' => $type,
                'label' => self::inputerTypeLabel($type),
                'total' => 0,
                'finished' => 0,
                'rate' => 0,
                'inputers' => [],
            ];
        }

        foreach ($rows as $row) {
            $hasUser = $row->inputer_id !== null && $row->inputer_name !== null;
            $type = self::classifyInputerType($row->inputer_role, $hasUser);
            $total = (int) $row->total;
            $finished = (int) $row->finished;
            $academicTotal = (int) ($row->academic_total ?? 0);
            $employeeTotal = (int) ($row->employee_total ?? 0);

            if ($hasUser) {
                $name = $row->inputer_name;
            } elseif ($row->inputer_id === null) {
                $name = 'Tidak Diketahui (Import Lama)';
            } else {
                $name = 'Akun Terhapus (#' . $row->inputer_id . ')';
            }

            $groups[$type]['inputers'][] = [
                'id' => $row->inputer_id === null ? 'none' : (string) $row->inputer_id,
                'name' => $name,
                'total' => $total,
                'finished' => $finished,
                'pending' => max(0, $total - $finished),
                'academic_total' => $academicTotal,
                'employee_total' => $employeeTotal,
                'rate' => $total > 0 ? round(($finished / $total) * 100, 1) : 0,
            ];
            $groups[$type]['total'] += $total;
            $groups[$type]['finished'] += $finished;
        }

        $result = [];
        foreach ($groups as $group) {
            if ($group['total'] === 0) {
                continue;
            }
            usort($group['inputers'], fn ($a, $b) => $b['total'] <=> $a['total'] ?: strcmp($a['name'], $b['name']));
            $group['rate'] = round(($group['finished'] / $group['total']) * 100, 1);
            $result[] = $group;
        }

        return $result;
    }
}
