<?php

namespace App\Exports;

use App\Models\Exam;
use App\Models\ExamSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SulitestAnalyticsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $exam;
    protected $reportType;

    public function __construct(Exam $exam, $reportType = 'overall')
    {
        $this->exam = $exam;
        $this->reportType = $reportType;
    }

    public function collection()
    {
        //RELATION GAMING BROTHER
        $sessions = ExamSession::with(['user.sulitestProfile.fakultas', 'user.sulitestProfile.prodi', 'answers.question.category'])
            ->where('exam_id', $this->exam->id)
            ->where('status', 'completed')
            ->get();

        if ($this->reportType === 'by_fakultas') {
            return $this->groupByFakultas($sessions);
        } elseif ($this->reportType === 'by_prodi') {
            return $this->groupByProdi($sessions);
        } elseif ($this->reportType === 'by_category') {
            return $this->groupByCategory($sessions);
        }

        return $sessions;
    }

    public function headings(): array
    {
        if ($this->reportType === 'by_fakultas') {
            return [
                'Fakultas',
                'Jumlah Peserta',
                'Total Skor',
                'Rata-rata Skor',
                'Skor Tertinggi',
                'Skor Terendah'
            ];
        } elseif ($this->reportType === 'by_prodi') {
            return [
                'Program Studi',
                'Fakultas',
                'Jumlah Peserta',
                'Total Skor',
                'Rata-rata Skor',
                'Skor Tertinggi',
                'Skor Terendah'
            ];
        } elseif ($this->reportType === 'by_category') {
            return [
                'Kategori Soal',
                'Total Peserta',
                'Total Poin',
                'Rata-rata Poin',
                'Total Soal',
                'Max Possible Score'
            ];
        }

        return [
            'Nama Peserta',
            'NIM',
            'Email',
            'Fakultas',
            'Program Studi',
            'Total Skor',
            'Max Possible Score',
            'Persentase',
            'Waktu Mulai',
            'Waktu Selesai',
            'Durasi (menit)',
            'Status'
        ];
    }

    public function map($row): array
    {
        if ($this->reportType === 'by_fakultas') {
            return [
                $row['name'],
                $row['count'],
                $row['total_score'],
                $row['avg_score'],
                $row['max_score'],
                $row['min_score']
            ];
        } elseif ($this->reportType === 'by_prodi') {
            return [
                $row['name'],
                $row['fakultas_name'],
                $row['count'],
                $row['total_score'],
                $row['avg_score'],
                $row['max_score'],
                $row['min_score']
            ];
        } elseif ($this->reportType === 'by_category') {
            return [
                $row['name'],
                $row['total_participants'],
                $row['total_points'],
                $row['avg_score'],
                $row['question_count'],
                $row['max_possible']
            ];
        }

        $totalScore = $row->answers->sum('points');
        $totalQuestions = $row->answers->count();
        $maxPossibleScore = $totalQuestions * 5;
        $percentage = $maxPossibleScore > 0 ? round(($totalScore / $maxPossibleScore) * 100, 2) : 0;

        $duration = null;
        if ($row->start_time && $row->end_time) {
            $duration = $row->end_time->diffInMinutes($row->start_time);
        }

        return [
            $row->user->name ?? '-',
            $row->user->sulitestProfile->nim ?? '-',
            $row->user->email ?? '-',
            $row->user->sulitestProfile?->fakultas->name ?? '-',
            $row->user->sulitestProfile?->prodi->name ?? '-',
            $totalScore,
            $maxPossibleScore,
            $percentage . '%',
            $row->start_time ? $row->start_time->format('d-m-Y H:i:s') : '-',
            $row->end_time ? $row->end_time->format('d-m-Y H:i:s') : '-',
            $duration ?? '-',
            $row->status
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        $titles = [
            'overall' => 'Laporan Keseluruhan',
            'by_fakultas' => 'Laporan per Fakultas',
            'by_prodi' => 'Laporan per Prodi',
            'by_category' => 'Laporan per Kategori'
        ];

        return $titles[$this->reportType] ?? 'Laporan';
    }

    private function groupByFakultas($sessions)
    {
        $grouped = $sessions->groupBy('user.sulitestProfile.fakultas_id')->map(function ($group) {
            $scores = $group->map(fn($s) => $s->answers->sum('points'));
            $fakultas = $group->first()->user->sulitestProfile?->fakultas;

            return [
                'name' => $fakultas ? $fakultas->name : 'Tidak Ada',
                'count' => $group->count(),
                'total_score' => $scores->sum(),
                'avg_score' => round($scores->avg(), 2),
                'max_score' => $scores->max(),
                'min_score' => $scores->min()
            ];
        });

        return collect($grouped->values());
    }

    private function groupByProdi($sessions)
    {
        $grouped = $sessions->groupBy('user.sulitestProfile.prodi_id')->map(function ($group) {
            $scores = $group->map(fn($s) => $s->answers->sum('points'));
            $prodi = $group->first()->user->sulitestProfile?->prodi;
            $fakultas = $group->first()->user->sulitestProfile?->fakultas;

            return [
                'name' => $prodi ? $prodi->name : 'Tidak Ada',
                'fakultas_name' => $fakultas ? $fakultas->name : 'Tidak Ada',
                'count' => $group->count(),
                'total_score' => $scores->sum(),
                'avg_score' => round($scores->avg(), 2),
                'max_score' => $scores->max(),
                'min_score' => $scores->min()
            ];
        });

        return collect($grouped->values());
    }

    private function groupByCategory($sessions)
    {
        $categoryAnalytics = [];
        
        foreach ($sessions as $session) {
            $categorized = $this->calculateCategorizedScores($session);
            foreach ($categorized as $catId => $catData) {
                if (!isset($categoryAnalytics[$catId])) {
                    $categoryAnalytics[$catId] = [
                        'name' => $catData['name'],
                        'total_points' => 0,
                        'total_participants' => 0,
                        'question_count' => 0,
                        'max_possible' => 0,
                    ];
                }
                $categoryAnalytics[$catId]['total_points'] += $catData['total_points'];
                $categoryAnalytics[$catId]['total_participants']++;
                $categoryAnalytics[$catId]['question_count'] += $catData['question_count'];
                $categoryAnalytics[$catId]['max_possible'] += $catData['max_possible'];
            }
        }

        foreach ($categoryAnalytics as $key => $data) {
            $categoryAnalytics[$key]['avg_score'] = round($data['total_points'] / $data['total_participants'], 2);
        }

        return collect(array_values($categoryAnalytics));
    }

    private function calculateCategorizedScores(ExamSession $session)
    {
        $answers = $session->answers()->with('question.category')->get();
        
        $categoryScores = [];
        
        foreach ($answers as $answer) {
            $categoryId = $answer->question->category_id ?? 'uncategorized';
            $categoryName = $answer->question->category->name ?? 'Tanpa Kategori';
            
            if (!isset($categoryScores[$categoryId])) {
                $categoryScores[$categoryId] = [
                    'name' => $categoryName,
                    'total_points' => 0,
                    'question_count' => 0,
                    'max_possible' => 0,
                ];
            }
            
            $categoryScores[$categoryId]['total_points'] += $answer->points;
            $categoryScores[$categoryId]['question_count']++;
            $categoryScores[$categoryId]['max_possible'] += 5;
        }

        return $categoryScores;
    }
}
