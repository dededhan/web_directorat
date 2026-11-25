<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Models\AktivitasDosenAsing;
use App\Models\DosenInternasional;
use App\Services\LecturerDataSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Halaman "Rekapan Data" — ringkasan statistik khusus data dosen asing
 * (gender, jabatan, subject, fakultas, serta waktu data dimasukkan per tahun).
 */
class InternationalLectureRecapController extends Controller
{
    private const FACULTIES = [
        'pascasarjana' => 'Pascasarjana',
        'fip' => 'FIP',
        'fmipa' => 'FMIPA',
        'fppsi' => 'FPPsi',
        'fbs' => 'FBS',
        'ft' => 'FT',
        'fik' => 'FIK',
        'fis' => 'FIS',
        'fe' => 'FE',
        'profesi' => 'Profesi',
        'lainnya' => 'Lainnya',
    ];

    /** Jumlah jabatan teratas yang ditampilkan terpisah; sisanya digabung ke "Lainnya". */
    private const TOP_POSITIONS = 8;

    public function index(Request $request)
    {
        $currentYear = (int) now()->format('Y');

        // Opsi semester (gabungan nilai di database + daftar semester standar agar tetap tersedia walau belum ada data)
        $dbSemesters = DosenInternasional::query()
            ->whereNotNull('sesi')
            ->where('sesi', '!=', '')
            ->distinct()
            ->pluck('sesi')
            ->map(fn ($s) => trim((string) $s))
            ->filter();

        $availableSemesters = $dbSemesters
            ->concat(['121', '122', '123', '124', '125', '126'])
            ->unique()
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->reverse()
            ->values()
            ->all();

        // Opsi tahun kedatangan dosen ke UNJ (gabungan kolom tahun, tanggal aktivitas, dan rentang tahun)
        $dbVisitYears = DosenInternasional::query()
            ->whereNotNull('tahun')
            ->where('tahun', '!=', '')
            ->distinct()
            ->pluck('tahun')
            ->filter(fn ($y) => is_numeric(trim((string) $y)))
            ->map(fn ($y) => (int) trim((string) $y));

        $activityYears = AktivitasDosenAsing::query()
            ->whereNotNull('tanggal')
            ->pluck('tanggal')
            ->map(fn ($d) => (int) $d->format('Y'))
            ->filter(fn ($y) => $y > 0);

        $availableVisitYears = $dbVisitYears
            ->concat($activityYears)
            ->concat(range(min(2024, $currentYear), max(2027, $currentYear + 1)))
            ->unique()
            ->sortDesc()
            ->values()
            ->all();

        $visitMonths = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $selectedSesi = trim((string) $request->input('sesi', ''));

        $rawVisitYear = trim((string) $request->input('visit_year', ''));
        $selectedVisitYear = (ctype_digit($rawVisitYear) && (int) $rawVisitYear > 0) ? (int) $rawVisitYear : null;

        $rawVisitMonth = trim((string) $request->input('visit_month', ''));
        $selectedVisitMonth = (ctype_digit($rawVisitMonth) && (int) $rawVisitMonth >= 1 && (int) $rawVisitMonth <= 12)
            ? (int) $rawVisitMonth
            : null;

        $hasActiveFilter = ($selectedSesi !== '' || $selectedVisitYear !== null || $selectedVisitMonth !== null);

        $query = DosenInternasional::query();

        if ($selectedSesi !== '') {
            $query->where('sesi', $selectedSesi);
        }

        if ($selectedVisitMonth !== null) {
            // Filter berdasarkan bulan (dan tahun bila dipilih) kedatangan pada aktivitas dosen
            $query->whereHas('activities', function ($q) use ($selectedVisitMonth, $selectedVisitYear) {
                $q->whereNotNull('tanggal')->whereMonth('tanggal', $selectedVisitMonth);
                if ($selectedVisitYear !== null) {
                    $q->whereYear('tanggal', $selectedVisitYear);
                }
            });
        } elseif ($selectedVisitYear !== null) {
            // Filter tahun datang dosen dari kolom tahun maupun tanggal aktivitas
            $query->where(function ($q) use ($selectedVisitYear) {
                $q->where('tahun', (string) $selectedVisitYear)
                    ->orWhereHas('activities', function ($aq) use ($selectedVisitYear) {
                        $aq->whereNotNull('tanggal')->whereYear('tanggal', $selectedVisitYear);
                    });
            });
        }

        $lecturers = $query->get([
            'id', 'jenis_kelamin', 'jabatan', 'subject_1', 'subject_2', 'fakultas', 'sesi', 'tahun', 'negara', 'created_at',
        ]);

        $total = $lecturers->count();

        $gender = $this->genderRecap($lecturers);
        $positions = $this->positionRecap($lecturers, $total);
        $countries = $this->countryRecap($lecturers, $total);
        $subjects = $this->subjectRecap($lecturers);
        $faculties = $this->facultyRecap($lecturers);
        $semesters = $this->semesterRecap($lecturers);

        // ================= REKAPAN WAKTU INPUT DATA PER TAHUN =================
        $targetFutureYear = 2027; // Opsi tahun-tahun selanjutnya (sampai 2027 saja dahulu)

        $dbYears = $lecturers
            ->filter(fn ($l) => $l->created_at !== null)
            ->map(fn ($l) => (int) $l->created_at->format('Y'))
            ->filter(fn ($y) => $y > 0)
            ->unique();

        // Gabungkan tahun dari database, tahun sekarang, serta tahun selanjutnya (sampai 2027)
        $availableYears = $dbYears
            ->toBase()
            ->concat(range(min($currentYear, 2026), max($currentYear, $targetFutureYear)))
            ->unique()
            ->sort()
            ->values();

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$currentYear]);
        }

        $defaultYear = $availableYears->contains($currentYear) ? $currentYear : $availableYears->first();
        $selectedYear = (int) $request->input('year', $defaultYear);
        if (!$availableYears->contains($selectedYear)) {
            $selectedYear = $defaultYear;
        }

        $yearlyLecturers = $lecturers->filter(fn ($l) => $l->created_at && (int) $l->created_at->format('Y') === $selectedYear);

        // Distribusi 12 bulan (Januari - Desember)
        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyCounts = array_fill(1, 12, 0);
        foreach ($yearlyLecturers as $l) {
            $m = (int) $l->created_at->format('n');
            if (isset($monthlyCounts[$m])) {
                $monthlyCounts[$m]++;
            }
        }

        $peakMonthNum = 1;
        $peakMonthCount = 0;
        foreach ($monthlyCounts as $m => $count) {
            if ($count > $peakMonthCount) {
                $peakMonthCount = $count;
                $peakMonthNum = $m;
            }
        }
        $fullMonthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $peakMonthLabel = $peakMonthCount > 0 ? $fullMonthNames[$peakMonthNum] . ' (' . number_format($peakMonthCount) . ' data)' : '-';

        // Rekap per Tahun (Semua tahun yang terdata)
        $yearComparison = [];
        foreach ($availableYears as $y) {
            $countY = $lecturers->filter(fn ($l) => $l->created_at && (int) $l->created_at->format('Y') === $y)->count();
            $yearComparison[] = [
                'year' => $y,
                'count' => $countY,
                'percent' => $total > 0 ? round(($countY / $total) * 100, 1) : 0,
            ];
        }

        // Distribusi Sesi / Semester pada tahun terpilih
        $sesiCounts = [];
        foreach ($yearlyLecturers as $l) {
            $s = trim((string) $l->sesi);
            $key = $s !== '' ? 'Sesi ' . $s : 'Tanpa Sesi';
            $sesiCounts[$key] = ($sesiCounts[$key] ?? 0) + 1;
        }
        arsort($sesiCounts);

        $yearlyRecap = [
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears->all(),
            'totalYear' => $yearlyLecturers->count(),
            'percentOfTotal' => $total > 0 ? round(($yearlyLecturers->count() / $total) * 100, 1) : 0,
            'monthlyCounts' => array_values($monthlyCounts),
            'monthLabels' => $monthLabels,
            'peakMonth' => $peakMonthLabel,
            'averagePerMonth' => round($yearlyLecturers->count() / 12, 1),
            'yearComparison' => $yearComparison,
            'sesiLabels' => array_keys($sesiCounts),
            'sesiData' => array_values($sesiCounts),
        ];

        $summary = [
            'total' => $total,
            'male' => $gender['data'][0],
            'female' => $gender['data'][1],
            'positions' => count($positions['all']),
            'countries' => $countries['totalCountries'],
            'subjects' => count($subjects['all']),
            'faculties' => collect($faculties['data'])->filter()->count(),
            'totalThisYear' => $yearlyLecturers->count(),
        ];

        $chartData = [
            'gender' => ['labels' => $gender['labels'], 'data' => $gender['data']],
            'positions' => ['labels' => $positions['labels'], 'data' => $positions['data']],
            'countries' => ['labels' => $countries['labels'], 'data' => $countries['data']],
            'subjects' => ['labels' => $subjects['labels'], 'data' => $subjects['data']],
            'faculties' => [
                'labels' => $faculties['labels'],
                'data' => $faculties['data'],
                'datasets' => $faculties['datasets'],
            ],
            'semesters' => [
                'labels' => $semesters['labels'],
                'data' => $semesters['data'],
            ],
            'yearlyMonthly' => [
                'labels' => $yearlyRecap['monthLabels'],
                'data' => $yearlyRecap['monthlyCounts'],
            ],
            'yearlySesi' => [
                'labels' => $yearlyRecap['sesiLabels'],
                'data' => $yearlyRecap['sesiData'],
            ],
            'yearComparison' => [
                'labels' => array_column($yearComparison, 'year'),
                'data' => array_column($yearComparison, 'count'),
            ],
        ];

        return view('admin_pemeringkatan.international-lecture.recap', [
            'summary' => $summary,
            'chartData' => $chartData,
            'genderRows' => $gender['rows'],
            'positionRows' => $positions['all'],
            'countryRows' => $countries['all'],
            'totalCountries' => $countries['totalCountries'],
            'subjectRows' => $subjects['all'],
            'facultyRows' => $faculties['rows'],
            'withoutSesiCount' => $semesters['withoutSesi'],
            'yearlyRecap' => $yearlyRecap,
            'filters' => [
                'sesi' => $selectedSesi,
                'visit_year' => $selectedVisitYear,
                'visit_month' => $selectedVisitMonth,
                'hasActive' => $hasActiveFilter,
                'semesters' => $availableSemesters,
                'visitYears' => $availableVisitYears,
                'months' => $visitMonths,
            ],
        ]);
    }

    private function countryRecap(Collection $lecturers, int $total): array
    {
        $counts = $lecturers
            ->map(fn ($l) => LecturerDataSanitizer::normalizeCountry($l->negara) ?? 'Belum Diisi')
            ->countBy()
            ->sortDesc();

        $all = $this->withPercent($counts->all(), $total);

        return [
            'labels' => $counts->keys()->all(),
            'data' => $counts->values()->all(),
            'all' => $all,
            'totalCountries' => $counts->reject(fn ($v, $k) => in_array($k, ['Belum Diisi', 'Belum Ditentukan'], true))->count(),
        ];
    }

    private function genderRecap(Collection $lecturers): array
    {
        $counts = ['Laki-laki' => 0, 'Perempuan' => 0, 'Belum diisi' => 0];

        foreach ($lecturers as $l) {
            $g = strtolower(trim((string) $l->jenis_kelamin));
            if (in_array($g, ['male', 'm', 'l', 'laki-laki', 'laki laki', 'pria'], true)) {
                $counts['Laki-laki']++;
            } elseif (in_array($g, ['female', 'f', 'p', 'perempuan', 'wanita'], true)) {
                $counts['Perempuan']++;
            } else {
                $counts['Belum diisi']++;
            }
        }

        // "Belum diisi" hanya ditampilkan di diagram bila memang ada.
        $labels = ['Laki-laki', 'Perempuan'];
        $data = [$counts['Laki-laki'], $counts['Perempuan']];
        if ($counts['Belum diisi'] > 0) {
            $labels[] = 'Belum diisi';
            $data[] = $counts['Belum diisi'];
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'rows' => $this->withPercent(array_combine($labels, $data), $lecturers->count()),
        ];
    }

    private function positionRecap(Collection $lecturers, int $total): array
    {
        $counts = $lecturers
            ->map(fn ($l) => trim((string) $l->jabatan) ?: 'Belum diisi')
            ->countBy()
            ->sortDesc();

        $all = $this->withPercent($counts->all(), $total);

        // Diagram: N jabatan teratas + sisanya digabung "Lainnya" agar tetap terbaca.
        $top = $counts->take(self::TOP_POSITIONS);
        $rest = $counts->slice(self::TOP_POSITIONS)->sum();

        $labels = $top->keys()->all();
        $data = $top->values()->all();
        if ($rest > 0) {
            $labels[] = 'Lainnya (' . ($counts->count() - self::TOP_POSITIONS) . ' jabatan)';
            $data[] = $rest;
        }

        return ['labels' => $labels, 'data' => $data, 'all' => $all];
    }

    private function subjectRecap(Collection $lecturers): array
    {
        // Satu dosen dihitung sekali per subject (subject_1 & subject_2 digabung).
        $counts = [];
        $withoutSubject = 0;

        foreach ($lecturers as $l) {
            $subjects = collect([$l->subject_1, $l->subject_2])
                ->map(fn ($s) => trim((string) $s))
                ->filter()
                ->unique(fn ($s) => strtolower($s));

            if ($subjects->isEmpty()) {
                $withoutSubject++;
                continue;
            }

            foreach ($subjects as $s) {
                $counts[$s] = ($counts[$s] ?? 0) + 1;
            }
        }

        arsort($counts);
        if ($withoutSubject > 0) {
            $counts['Belum diisi'] = $withoutSubject;
        }

        return [
            'labels' => array_keys($counts),
            'data' => array_values($counts),
            'all' => $this->withPercent($counts, $lecturers->count()),
        ];
    }

    private function facultyRecap(Collection $lecturers): array
    {
        $facultyKeys = array_keys(self::FACULTIES);
        $counts = array_fill_keys($facultyKeys, 0);
        $subjectMatrix = [];
        $subjectLabels = [];
        $subjectTotals = [];

        foreach ($lecturers as $l) {
            $rawFaculty = strtolower(trim((string) $l->fakultas));
            $facultyKey = isset($counts[$rawFaculty]) ? $rawFaculty : 'lainnya';
            $counts[$facultyKey]++;

            $subject = trim((string) $l->subject_1) ?: trim((string) $l->subject_2);
            if ($subject === '' || mb_strtolower($subject) === 'belum diisi') {
                $subject = 'Belum diisi';
            }

            $subjectKey = mb_strtolower($subject);
            if (!isset($subjectLabels[$subjectKey])) {
                $subjectLabels[$subjectKey] = $subject;
                $subjectMatrix[$subjectKey] = array_fill_keys($facultyKeys, 0);
                $subjectTotals[$subjectKey] = 0;
            } elseif ($subjectLabels[$subjectKey] === mb_strtolower($subjectLabels[$subjectKey]) && $subject !== mb_strtolower($subject)) {
                $subjectLabels[$subjectKey] = $subject;
            }

            $subjectMatrix[$subjectKey][$facultyKey]++;
            $subjectTotals[$subjectKey]++;
        }

        // Urutkan subject terbanyak di bawah/awal, dan "Belum diisi" selalu di paling akhir.
        uksort($subjectTotals, function (string $a, string $b) use ($subjectTotals) {
            if ($a === 'belum diisi') {
                return 1;
            }
            if ($b === 'belum diisi') {
                return -1;
            }
            return $subjectTotals[$b] <=> $subjectTotals[$a];
        });

        $datasets = [];
        foreach (array_keys($subjectTotals) as $subjectKey) {
            $datasets[] = [
                'label' => $subjectLabels[$subjectKey],
                'data' => array_values($subjectMatrix[$subjectKey]),
                'total' => $subjectTotals[$subjectKey],
                'isEmpty' => $subjectKey === 'belum diisi',
            ];
        }

        $labels = array_values(self::FACULTIES);
        $data = array_values($counts);

        return [
            'labels' => $labels,
            'data' => $data,
            'datasets' => $datasets,
            'rows' => $this->withPercent(array_combine($labels, $data), $lecturers->count()),
        ];
    }

    private function semesterRecap(Collection $lecturers): array
    {
        $counts = [
            '123' => 0,
            '124' => 0,
            '125' => 0,
            '126' => 0,
        ];
        $extraCounts = [];
        $withoutSesi = 0;

        foreach ($lecturers as $l) {
            $sesi = trim((string) $l->sesi);
            if ($sesi === '') {
                $withoutSesi++;
                continue;
            }
            if (array_key_exists($sesi, $counts)) {
                $counts[$sesi]++;
            } else {
                $extraCounts[$sesi] = ($extraCounts[$sesi] ?? 0) + 1;
            }
        }

        if ($extraCounts) {
            ksort($extraCounts, SORT_NATURAL | SORT_FLAG_CASE);
            $counts = $counts + $extraCounts;
            uksort($counts, fn (string $a, string $b) => strnatcasecmp($a, $b));
        }

        $labels = array_map(fn ($s) => 'Semester ' . $s, array_keys($counts));
        $data = array_values($counts);

        return [
            'labels' => $labels,
            'data' => $data,
            'withoutSesi' => $withoutSesi,
        ];
    }

    /**
     * @param array<string,int> $counts
     * @return array<int,array{label:string,count:int,percent:float}>
     */
    private function withPercent(array $counts, int $total): array
    {
        $rows = [];
        foreach ($counts as $label => $count) {
            $rows[] = [
                'label' => (string) $label,
                'count' => $count,
                'percent' => $total > 0 ? round($count / $total * 100, 1) : 0,
            ];
        }

        return $rows;
    }
}
