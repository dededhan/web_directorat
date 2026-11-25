<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Models\DosenInternasional;
use App\Models\InternationalLecturerEmailLog;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

/**
 * Laporan Email International Lecture.
 *
 * Halaman ini khusus menampilkan data yang berhubungan dengan email:
 * - status email per dosen (terkirim / belum / gagal / tanpa alamat email),
 * - progres pengiriman email per fakultas,
 * - tren pengiriman harian (dari log email),
 * - mode pengiriman (template / manual) dan respons consent.
 */
class InternationalLectureReportController extends Controller
{
    /**
     * Daftar seluruh fakultas resmi di sistem.
     */
    private const FACULTIES = [
        'pascasarjana' => 'PASCASARJANA',
        'fip' => 'FIP',
        'fmipa' => 'FMIPA',
        'fppsi' => 'FPPsi',
        'fbs' => 'FBS',
        'ft' => 'FT',
        'fik' => 'FIK',
        'fis' => 'FIS',
        'fe' => 'FE',
        'profesi' => 'PROFESI',
        'lainnya' => 'LAINNYA',
    ];

    public function index(Request $request)
    {
        // ================= RENTANG TANGGAL (untuk data log email) =================
        $endDate = $this->parseDate($request->input('end_date')) ?? now()->endOfDay();
        $startDate = $this->parseDate($request->input('start_date')) ?? $endDate->copy()->subDays(29)->startOfDay();
        if ($startDate->gt($endDate)) {
            [$startDate, $endDate] = [$endDate->copy(), $startDate->copy()];
        }
        $startDate = $startDate->copy()->startOfDay();
        $endDate = $endDate->copy()->endOfDay();

        // ================= FILTER DOSEN =================
        $selectedFaculty = $request->input('fakultas');
        $lecturerQuery = DosenInternasional::query();

        if ($request->filled('sesi')) {
            $lecturerQuery->where('sesi', trim($request->input('sesi')));
        }
        if ($selectedFaculty && $selectedFaculty !== 'semua') {
            $lecturerQuery->where('fakultas', $selectedFaculty);
        }
        if ($request->filled('email_status')) {
            $status = $request->input('email_status');
            if ($status === 'not_sent') {
                $lecturerQuery->where(function ($q) {
                    $q->whereNull('email_status')->orWhereIn('email_status', ['not_sent', '']);
                });
            } elseif ($status === 'no_email') {
                $lecturerQuery->where(function ($q) {
                    $q->whereNull('email')->orWhere('email', '');
                });
            } else {
                $lecturerQuery->where('email_status', $status);
            }
        }

        $lecturers = (clone $lecturerQuery)->get([
            'id', 'fakultas', 'email', 'email_status', 'email_sent_at', 'consent_status',
        ]);

        // ================= AGREGASI STATUS EMAIL PER DOSEN =================
        $summary = [
            'total' => 0,
            'has_email' => 0,
            'no_email' => 0,
            'sent' => 0,
            'not_sent' => 0,
            'in_progress' => 0,
            'failed' => 0,
            'consent_agreed' => 0,
            'consent_declined' => 0,
            'consent_pending' => 0,
        ];

        $facultyRows = [];
        foreach (self::FACULTIES as $key => $label) {
            $facultyRows[$key] = [
                'key' => $key,
                'label' => $label,
                'total' => 0,
                'has_email' => 0,
                'no_email' => 0,
                'sent' => 0,
                'not_sent' => 0,
                'failed' => 0,
            ];
        }

        foreach ($lecturers as $d) {
            $fKey = strtolower(trim((string) $d->fakultas));
            if (!isset($facultyRows[$fKey])) {
                $fKey = 'lainnya';
            }

            $summary['total']++;
            $facultyRows[$fKey]['total']++;

            $hasEmail = trim((string) $d->email) !== '';
            if ($hasEmail) {
                $summary['has_email']++;
                $facultyRows[$fKey]['has_email']++;
            } else {
                $summary['no_email']++;
                $facultyRows[$fKey]['no_email']++;
            }

            $status = $d->email_status ?: 'not_sent';
            if ($status === 'sent') {
                $summary['sent']++;
                $facultyRows[$fKey]['sent']++;

                $consent = $d->consent_status ?: 'pending';
                if ($consent === 'agreed') {
                    $summary['consent_agreed']++;
                } elseif ($consent === 'declined') {
                    $summary['consent_declined']++;
                } else {
                    $summary['consent_pending']++;
                }
            } elseif ($status === 'failed') {
                $summary['failed']++;
                $facultyRows[$fKey]['failed']++;
            } elseif (in_array($status, ['queued', 'sending'], true)) {
                $summary['in_progress']++;
                // Dalam proses tetap dihitung belum terkirim pada progres fakultas.
                $facultyRows[$fKey]['not_sent']++;
            } else {
                $summary['not_sent']++;
                $facultyRows[$fKey]['not_sent']++;
            }
        }

        if ($selectedFaculty && $selectedFaculty !== 'semua') {
            $facultyRows = array_filter($facultyRows, fn ($k) => $k === $selectedFaculty, ARRAY_FILTER_USE_KEY);
        }

        // Urutkan: fakultas dengan dosen terbanyak di atas, yang kosong di bawah.
        uasort($facultyRows, function ($a, $b) {
            return [$b['total'] > 0, $b['total']] <=> [$a['total'] > 0, $a['total']];
        });

        foreach ($facultyRows as &$row) {
            $row['pct'] = $row['total'] > 0 ? round(($row['sent'] / $row['total']) * 100, 1) : 0;
        }
        unset($row);

        // ================= DATA LOG EMAIL (dalam rentang tanggal) =================
        $logQuery = InternationalLecturerEmailLog::query()
            ->whereBetween('created_at', [$startDate, $endDate]);

        $lecturerFilterActive = $request->filled('sesi')
            || ($selectedFaculty && $selectedFaculty !== 'semua')
            || $request->filled('email_status');

        if ($lecturerFilterActive) {
            $logQuery->whereIn('dosen_internasional_id', (clone $lecturerQuery)->select('id'));
        }

        $logs = $logQuery->get(['id', 'status', 'mode', 'language_mode', 'created_at']);

        $logSummary = [
            'total' => $logs->count(),
            'sent' => $logs->where('status', 'sent')->count(),
            'failed' => $logs->where('status', 'failed')->count(),
            'pending' => $logs->whereIn('status', ['queued', 'sending'])->count(),
            'template' => $logs->where('mode', 'template')->count(),
            'manual' => $logs->where('mode', 'manual')->count(),
        ];

        // Tren harian
        $trendLabels = [];
        $trendSent = [];
        $trendFailed = [];
        $trendPending = [];
        $grouped = $logs->groupBy(fn ($l) => $l->created_at->format('Y-m-d'));

        foreach (CarbonPeriod::create($startDate->copy()->startOfDay(), $endDate->copy()->startOfDay()) as $day) {
            $key = $day->format('Y-m-d');
            $dayLogs = $grouped->get($key, collect());
            $trendLabels[] = $day->translatedFormat('d M');
            $trendSent[] = $dayLogs->where('status', 'sent')->count();
            $trendFailed[] = $dayLogs->where('status', 'failed')->count();
            $trendPending[] = $dayLogs->whereIn('status', ['queued', 'sending'])->count();
        }

        $busiestDayIndex = null;
        $busiestDayTotal = 0;
        foreach ($trendLabels as $i => $label) {
            $total = $trendSent[$i] + $trendFailed[$i] + $trendPending[$i];
            if ($total > $busiestDayTotal) {
                $busiestDayTotal = $total;
                $busiestDayIndex = $i;
            }
        }

        // ================= REKAPAN PENGIRIMAN EMAIL PER TAHUN =================
        $currentEmailYear = (int) now()->format('Y');
        $targetFutureEmailYear = 2027; // Opsi tahun-tahun selanjutnya (sampai 2027 saja dahulu)

        $dbEmailYears = InternationalLecturerEmailLog::query()
            ->whereNotNull('created_at')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->pluck('year')
            ->map(fn ($y) => (int) $y)
            ->filter(fn ($y) => $y > 0);

        // Gabungkan tahun dari database, tahun sekarang, serta tahun selanjutnya (sampai 2027)
        $emailAvailableYears = $dbEmailYears
            ->concat(range(min($currentEmailYear, 2026), max($currentEmailYear, $targetFutureEmailYear)))
            ->unique()
            ->sort()
            ->values();

        if ($emailAvailableYears->isEmpty()) {
            $emailAvailableYears = collect([$currentEmailYear]);
        }

        $defaultEmailYear = $emailAvailableYears->contains($currentEmailYear) ? $currentEmailYear : $emailAvailableYears->first();
        $selectedEmailYear = (int) $request->input('email_year', $defaultEmailYear);
        if (!$emailAvailableYears->contains($selectedEmailYear)) {
            $selectedEmailYear = $defaultEmailYear;
        }

        $yearlyEmailQuery = InternationalLecturerEmailLog::query()
            ->whereYear('created_at', $selectedEmailYear);

        if ($lecturerFilterActive) {
            $yearlyEmailQuery->whereIn('dosen_internasional_id', (clone $lecturerQuery)->select('id'));
        }

        $yearlyLogs = $yearlyEmailQuery->get(['id', 'status', 'created_at']);

        $yearlyEmailSummary = [
            'total' => $yearlyLogs->count(),
            'sent' => $yearlyLogs->where('status', 'sent')->count(),
            'failed' => $yearlyLogs->where('status', 'failed')->count(),
            'pending' => $yearlyLogs->whereIn('status', ['queued', 'sending'])->count(),
        ];
        $yearlyEmailSummary['success_rate'] = $yearlyEmailSummary['total'] > 0
            ? round(($yearlyEmailSummary['sent'] / $yearlyEmailSummary['total']) * 100, 1)
            : 0;

        $emailMonthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $emailMonthlySent = array_fill(1, 12, 0);
        $emailMonthlyFailed = array_fill(1, 12, 0);
        $emailMonthlyTotal = array_fill(1, 12, 0);

        foreach ($yearlyLogs as $log) {
            $m = (int) $log->created_at->format('n');
            if (isset($emailMonthlyTotal[$m])) {
                $emailMonthlyTotal[$m]++;
                if ($log->status === 'sent') {
                    $emailMonthlySent[$m]++;
                } elseif ($log->status === 'failed') {
                    $emailMonthlyFailed[$m]++;
                }
            }
        }

        $peakEmailMonthNum = 1;
        $peakEmailMonthTotal = 0;
        foreach ($emailMonthlyTotal as $m => $tot) {
            if ($tot > $peakEmailMonthTotal) {
                $peakEmailMonthTotal = $tot;
                $peakEmailMonthNum = $m;
            }
        }
        $fullMonthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $peakEmailMonthLabel = $peakEmailMonthTotal > 0
            ? $fullMonthNames[$peakEmailMonthNum] . ' (' . number_format($peakEmailMonthTotal) . ' email)'
            : '-';

        $emailYearComparison = [];
        foreach ($emailAvailableYears as $y) {
            $cnt = InternationalLecturerEmailLog::query()->whereYear('created_at', $y)->count();
            $snt = InternationalLecturerEmailLog::query()->whereYear('created_at', $y)->where('status', 'sent')->count();
            $emailYearComparison[] = [
                'year' => $y,
                'total' => $cnt,
                'sent' => $snt,
            ];
        }

        $yearlyEmailRecap = [
            'selectedYear' => $selectedEmailYear,
            'availableYears' => $emailAvailableYears->all(),
            'summary' => (object) $yearlyEmailSummary,
            'peakMonth' => $peakEmailMonthLabel,
            'monthLabels' => $emailMonthLabels,
            'monthlySent' => array_values($emailMonthlySent),
            'monthlyFailed' => array_values($emailMonthlyFailed),
            'monthlyTotal' => array_values($emailMonthlyTotal),
            'yearComparison' => $emailYearComparison,
        ];

        $chartData = [
            'trend' => [
                'labels' => $trendLabels,
                'sent' => $trendSent,
                'failed' => $trendFailed,
                'pending' => $trendPending,
            ],
            'statusDistribution' => [
                'labels' => ['Terkirim', 'Belum Terkirim', 'Dalam Proses', 'Gagal'],
                'data' => [$summary['sent'], $summary['not_sent'], $summary['in_progress'], $summary['failed']],
            ],
            'modeDistribution' => [
                'labels' => ['Template', 'Tulis Manual'],
                'data' => [$logSummary['template'], $logSummary['manual']],
            ],
            'consentDistribution' => [
                'labels' => ['Setuju', 'Menolak', 'Belum Merespons'],
                'data' => [$summary['consent_agreed'], $summary['consent_declined'], $summary['consent_pending']],
            ],
            'yearlyEmail' => [
                'labels' => $yearlyEmailRecap['monthLabels'],
                'sent' => $yearlyEmailRecap['monthlySent'],
                'failed' => $yearlyEmailRecap['monthlyFailed'],
                'total' => $yearlyEmailRecap['monthlyTotal'],
            ],
        ];

        $summary = (object) $summary;
        $logSummary = (object) $logSummary;
        $busiestDay = $busiestDayIndex !== null
            ? ['label' => $trendLabels[$busiestDayIndex], 'total' => $busiestDayTotal]
            : null;

        $faculties = self::FACULTIES;
        $activeFacultyRows = $facultyRows;

        return view('admin_pemeringkatan.international-lecture.report', compact(
            'summary',
            'logSummary',
            'chartData',
            'activeFacultyRows',
            'faculties',
            'startDate',
            'endDate',
            'busiestDay',
            'yearlyEmailRecap'
        ));
    }

    /**
     * Halaman Rincian Respons Consent Dosen Asing.
     *
     * Menampilkan daftar nama dosen asing yang telah menerima email,
     * status konfirmasi consent (Setuju / Menolak / Belum Merespons),
     * serta timestamp respons consent.
     */
    public function consentDetail(Request $request)
    {
        // Lingkup data:
        // 'sent_only' (default): Dosen yang sudah menerima email (sesuai diagram Respons Consent di halaman Laporan)
        // 'all': Semua dosen asing dalam sistem
        $scope = $request->input('scope', 'sent_only');

        $query = DosenInternasional::query();

        if ($scope === 'sent_only') {
            $query->where(function ($q) {
                $q->where('email_status', 'sent')
                  ->orWhereNotNull('email_sent_at')
                  ->orWhereIn('consent_status', ['agreed', 'declined', 'rejected']);
            });
        }

        // Filter Fakultas
        $selectedFaculty = $request->input('fakultas');
        if ($selectedFaculty && $selectedFaculty !== 'semua') {
            $query->where('fakultas', $selectedFaculty);
        }

        // Filter Sesi / Semester
        if ($request->filled('sesi')) {
            $query->where('sesi', trim($request->input('sesi')));
        }

        // Pencarian (Search)
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('universitas_asal', 'like', "%{$search}%")
                  ->orWhere('prodi', 'like', "%{$search}%")
                  ->orWhere('negara', 'like', "%{$search}%");
            });
        }

        // Hitung statistik (KPI) berdasarkan scope, fakultas, sesi, dan pencarian saat ini (sebelum filter status consent)
        $baseStatQuery = clone $query;
        $allLecturersInScope = $baseStatQuery->get(['id', 'consent_status', 'email_status', 'consented_at']);
        $totalCount = $allLecturersInScope->count();
        $agreedCount = $allLecturersInScope->where('consent_status', 'agreed')->count();
        $declinedCount = $allLecturersInScope->whereIn('consent_status', ['declined', 'rejected'])->count();
        $pendingCount = $totalCount - $agreedCount - $declinedCount;

        $stats = [
            'total' => $totalCount,
            'agreed' => $agreedCount,
            'agreed_pct' => $totalCount > 0 ? round(($agreedCount / $totalCount) * 100, 1) : 0,
            'declined' => $declinedCount,
            'declined_pct' => $totalCount > 0 ? round(($declinedCount / $totalCount) * 100, 1) : 0,
            'pending' => $pendingCount,
            'pending_pct' => $totalCount > 0 ? round(($pendingCount / $totalCount) * 100, 1) : 0,
            'responded_total' => $agreedCount + $declinedCount,
            'response_rate' => $totalCount > 0 ? round((($agreedCount + $declinedCount) / $totalCount) * 100, 1) : 0,
        ];

        // Filter Status Consent (setelah perhitungan KPI agar ringkasan statistik tetap lengkap)
        $selectedStatus = $request->input('status', 'semua');
        if ($selectedStatus && $selectedStatus !== 'semua') {
            if ($selectedStatus === 'agreed') {
                $query->where('consent_status', 'agreed');
            } elseif (in_array($selectedStatus, ['declined', 'rejected'], true)) {
                $query->whereIn('consent_status', ['declined', 'rejected']);
            } elseif ($selectedStatus === 'pending') {
                $query->where(function ($q) {
                    $q->whereNull('consent_status')
                      ->orWhere('consent_status', 'pending')
                      ->orWhere('consent_status', '');
                });
            }
        }

        // Export CSV jika diminta
        if ($request->input('export') === 'csv') {
            return $this->exportConsentCsv($query->orderByRaw("
                CASE 
                    WHEN consent_status = 'agreed' THEN 1 
                    WHEN consent_status IN ('declined', 'rejected') THEN 2 
                    ELSE 3 
                END ASC,
                COALESCE(consented_at, email_sent_at) DESC,
                id DESC
            ")->get());
        }

        // Urutan:
        // Prioritaskan dosen yang sudah consent (agreed), lalu declined, lalu pending.
        // Di dalamnya urutkan berdasarkan consented_at DESC, email_sent_at DESC, id DESC
        $lecturers = $query
            ->orderByRaw("
                CASE 
                    WHEN consent_status = 'agreed' THEN 1 
                    WHEN consent_status IN ('declined', 'rejected') THEN 2 
                    ELSE 3 
                END ASC,
                COALESCE(consented_at, email_sent_at) DESC,
                id DESC
            ")
            ->paginate(20)
            ->withQueryString();

        $faculties = self::FACULTIES;

        return view('admin_pemeringkatan.international-lecture.consent-detail', compact(
            'lecturers',
            'stats',
            'faculties',
            'scope',
            'selectedStatus',
            'selectedFaculty'
        ));
    }

    /**
     * Export data respons consent dosen asing ke format CSV (UTF-8 BOM).
     */
    private function exportConsentCsv($lecturers)
    {
        $filename = 'rekap_respons_consent_dosen_asing_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($lecturers) {
            $handle = fopen('php://output', 'w');
            // Tulis BOM UTF-8 agar karakter bahasa / aksen terbaca dengan sempurna di Microsoft Excel
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No',
                'Nama Dosen Asing',
                'Email',
                'Institusi / Universitas Asal',
                'Negara',
                'Fakultas',
                'Prodi',
                'Sesi',
                'Tahun',
                'Status Email',
                'Tanggal Email Terkirim',
                'Status Consent',
                'Waktu Respons Consent',
            ]);

            $no = 1;
            foreach ($lecturers as $d) {
                $consentStatusLabel = 'Belum Merespons';
                if ($d->consent_status === 'agreed') {
                    $consentStatusLabel = 'Setuju (Agreed)';
                } elseif (in_array($d->consent_status, ['declined', 'rejected'], true)) {
                    $consentStatusLabel = 'Menolak (Declined)';
                }

                $emailSentAt = $d->email_sent_at ? $d->email_sent_at->format('Y-m-d H:i:s') : '-';
                $consentedAt = $d->consented_at ? $d->consented_at->format('Y-m-d H:i:s') : '-';

                fputcsv($handle, [
                    $no++,
                    $d->nama ?? '-',
                    $d->email ?? '-',
                    $d->universitas_asal ?? '-',
                    $d->negara ?? '-',
                    strtoupper($d->fakultas ?? '-'),
                    $d->prodi ?? '-',
                    $d->sesi ?? '-',
                    $d->tahun ?? '-',
                    $d->email_status ?: 'not_sent',
                    $emailSentAt,
                    $consentStatusLabel,
                    $consentedAt,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function parseDate($value): ?Carbon
    {
        if (!is_string($value) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $value);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
