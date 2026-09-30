<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Models\Responden;
use App\Models\QsSession;
use App\Models\QsSessionRespondent;
use App\Models\User;
use App\Exports\LegacyRespondenExport;
use App\Exports\SessionReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display the main Reports page with both tabs.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $accessibleUserIds = $user->getAccessibleUserIds();

        // 1. Available QS Sessions for dropdown
        $sessions = QsSession::orderBy('created_at', 'desc')->get();

        // 2. Legacy filters metadata
        $legacyYears = Responden::selectRaw('YEAR(created_at) as yr')
            ->whereNotNull('created_at')
            ->distinct()
            ->orderBy('yr', 'desc')
            ->pluck('yr')
            ->filter()
            ->values();

        // Scope faculties for non-directorate
        $facultyCode = $this->getUserFacultyCode($user);
        if ($facultyCode !== null) {
            $userCanonical = self::normalizeFacultyCode($facultyCode);
            $legacyFaculties = $userCanonical ? [$userCanonical] : [];
        } else {
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
            // Ensure standard faculties requested are present in filter options
            $standardFaculties = ['FBS', 'FEB', 'FIP', 'FISH', 'FMIPA', 'FPB', 'FPSI', 'FT'];
            foreach ($standardFaculties as $std) {
                $canonicalList[$std] = true;
            }
            $legacyFaculties = array_keys($canonicalList);
            sort($legacyFaculties);
        }

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

        $query = Responden::selectRaw("respondens.*, ($isFinishedSubquery) as is_finished");

        // Role-based scoping
        $facultyCode = $this->getUserFacultyCode($user);
        if ($facultyCode !== null) {
            $allowedFakultas = $this->getFacultyAliases($facultyCode);
            $query->whereIn(DB::raw('LOWER(respondens.fakultas)'), $allowedFakultas);
        }

        // Apply filters
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

        if ($request->filled('fakultas') && $request->fakultas !== 'all') {
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
                $q->where(DB::raw('LOWER(fullname)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(instansi)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(jabatan)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(phone_responden)'), 'LIKE', "%{$search}%");
            });
        }

        // Calculate summary stats on the filtered query (before status filter to know total vs finished)
        $statsBaseQuery = clone $query;
        $totalCount = $statsBaseQuery->count();
        $finishedCount = (clone $statsBaseQuery)->whereRaw("($isFinishedSubquery) = 1")->count();
        $pendingCount = $totalCount - $finishedCount;
        $finishRate = $totalCount > 0 ? round(($finishedCount / $totalCount) * 100, 1) : 0;

        // Apply status filter if specified
        if ($request->filled('status') && $request->status !== 'all') {
            $statusVal = strtolower(trim($request->status));
            if (in_array($statusVal, ['selesai', 'clear', 'finished'])) {
                $query->whereRaw("($isFinishedSubquery) = 1");
            } elseif (in_array($statusVal, ['belum_selesai', 'unfinished'])) {
                $query->whereRaw("($isFinishedSubquery) = 0");
            } elseif ($statusVal === 'done') {
                $query->where(DB::raw('LOWER(respondens.status)'), 'done');
            } elseif ($statusVal === 'belum') {
                $query->where(function($q) {
                    $q->where(DB::raw('LOWER(respondens.status)'), 'belum')
                      ->orWhereNull('respondens.status');
                });
            } elseif ($statusVal === 'dones') {
                $query->where(DB::raw('LOWER(respondens.status)'), 'dones');
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $direction = strtolower($request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';
        $allowedSorts = ['fullname', 'email', 'instansi', 'fakultas', 'category', 'created_at', 'is_finished'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = max(5, min(100, (int) $request->get('per_page', 15)));
        $paginator = $query->paginate($perPage);

        $paginator->getCollection()->transform(function ($item) {
            $item->fakultas = self::normalizeFacultyCode($item->fakultas) ?: ($item->fakultas ? strtoupper($item->fakultas) : '-');
            return $item;
        });

        return response()->json([
            'stats' => [
                'total' => $totalCount,
                'finished' => $finishedCount,
                'pending' => $pendingCount,
                'rate' => $finishRate,
            ],
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

        $query = QsSessionRespondent::where('qs_session_id', $sessionId)
            ->with(['bankRespondent', 'addedByUser']);

        if ($accessibleUserIds !== null) {
            $query->whereIn('added_by', $accessibleUserIds);
        }

        $respondents = $query->get();

        $unitBreakdown = [];
        foreach ($respondents as $r) {
            $addedUser = $r->addedByUser;
            $unitLabel = $this->resolveFacultyLabel($addedUser);
            $specificName = $r->added_by_label;

            $key = $unitLabel;
            if (!isset($unitBreakdown[$key])) {
                $unitBreakdown[$key] = [
                    'unit' => $unitLabel,
                    'total' => 0,
                    'agreed' => 0,
                    'pending' => 0,
                    'not_emailed' => 0,
                    'prodis' => [],
                ];
            }

            $unitBreakdown[$key]['total']++;
            if ($r->consent_status === 'agreed') {
                $unitBreakdown[$key]['agreed']++;
            } else {
                $unitBreakdown[$key]['pending']++;
            }
            if ($r->email_sent_at === null) {
                $unitBreakdown[$key]['not_emailed']++;
            }

            // Track specific prodi / user under this faculty
            if (!isset($unitBreakdown[$key]['prodis'][$specificName])) {
                $unitBreakdown[$key]['prodis'][$specificName] = [
                    'name' => $specificName,
                    'total' => 0,
                    'agreed' => 0,
                ];
            }
            $unitBreakdown[$key]['prodis'][$specificName]['total']++;
            if ($r->consent_status === 'agreed') {
                $unitBreakdown[$key]['prodis'][$specificName]['agreed']++;
            }
        }
        ksort($unitBreakdown);

        // Format and compute rates
        $formattedUnits = [];
        foreach ($unitBreakdown as $u) {
            $total = $u['total'];
            $agreed = $u['agreed'];
            $rate = $total > 0 ? round(($agreed / $total) * 100, 1) : 0;

            $formattedUnits[] = [
                'unit' => $u['unit'],
                'total' => $total,
                'agreed' => $agreed,
                'pending' => $u['pending'],
                'not_emailed' => $u['not_emailed'],
                'rate' => $rate,
                'prodis' => array_values($u['prodis']),
            ];
        }

        return response()->json([
            'session' => [
                'id' => $session->id,
                'name' => $session->name,
                'status' => $session->status,
                'mode' => $session->mode,
                'description' => $session->description,
                'total_respondents' => $respondents->count(),
                'agreed_count' => $respondents->where('consent_status', 'agreed')->count(),
                'rate' => $respondents->count() > 0 ? round(($respondents->where('consent_status', 'agreed')->count() / $respondents->count()) * 100, 1) : 0,
            ],
            'units' => $formattedUnits,
        ]);
    }

    /**
     * Excel Export for Legacy Responden Report.
     */
    public function exportLegacy(Request $request)
    {
        $user = Auth::user();
        $isFinishedSubquery = $this->getIsFinishedSubquery();

        $query = Responden::selectRaw("respondens.*, ($isFinishedSubquery) as is_finished");

        // Role-based scoping
        $facultyCode = $this->getUserFacultyCode($user);
        if ($facultyCode !== null) {
            $allowedFakultas = $this->getFacultyAliases($facultyCode);
            $query->whereIn(DB::raw('LOWER(respondens.fakultas)'), $allowedFakultas);
        }

        // Apply filters
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

        if ($request->filled('fakultas') && $request->fakultas !== 'all') {
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

        if ($request->filled('status') && $request->status !== 'all') {
            $statusVal = strtolower(trim($request->status));
            if (in_array($statusVal, ['selesai', 'clear', 'finished'])) {
                $query->whereRaw("($isFinishedSubquery) = 1");
            } elseif (in_array($statusVal, ['belum_selesai', 'unfinished'])) {
                $query->whereRaw("($isFinishedSubquery) = 0");
            } elseif ($statusVal === 'done') {
                $query->where(DB::raw('LOWER(respondens.status)'), 'done');
            } elseif ($statusVal === 'belum') {
                $query->where(function($q) {
                    $q->where(DB::raw('LOWER(respondens.status)'), 'belum')
                      ->orWhereNull('respondens.status');
                });
            } elseif ($statusVal === 'dones') {
                $query->where(DB::raw('LOWER(respondens.status)'), 'dones');
            }
        }

        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));
            $query->where(function ($q) use ($search) {
                $q->where(DB::raw('LOWER(fullname)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw('LOWER(instansi)'), 'LIKE', "%{$search}%");
            });
        }

        $query->orderBy('created_at', 'desc');

        $fileName = 'Laporan_Responden_Legacy_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new LegacyRespondenExport($query), $fileName);
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
     * Resolve faculty label from User model.
     */
    private function resolveFacultyLabel(?User $user): string
    {
        if (!$user) {
            return 'Direktorat';
        }

        $role = $user->role ?? '';
        if (in_array($role, ['admin_pemeringkatan', 'admin_direktorat', 'super_admin', 'kepala_direktorat', 'kepala_sub_direktorat', 'wr3', 'admin_hilirisasi', 'admin_inovasi'])) {
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
}
