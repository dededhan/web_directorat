<?php

namespace App\Http\Controllers\Pemeringkatan;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SulitestHasilController extends Controller
{
    public function index()
    {
        $exams = Exam::withCount(['examSessions' => function ($query) {
            $query->where('status', 'completed');
        }])->latest()->get();

        return view('admin_pemeringkatan.hasil.index', compact('exams'));
    }

    public function show(Exam $exam)
    {
        $sessions = ExamSession::with(['user.sulitestProfile.fakultas', 'user.sulitestProfile.prodi'])
            ->where('exam_id', $exam->id)
            ->where('status', 'completed')
            ->latest()
            ->get();

        $results = $sessions->map(function ($session) {
            $categorizedScores = $this->calculateCategorizedScores($session);
            
            return [
                'session' => $session,
                'user' => $session->user,
                'total_score' => $session->answers->sum('points'),
                'categorized_scores' => $categorizedScores,
                'duration' => $session->start_time && $session->end_time 
                    ? $session->end_time->diffInMinutes($session->start_time) 
                    : null,
            ];
        });

        return view('admin_pemeringkatan.hasil.show', compact('exam', 'results'));
    }

    public function detail(ExamSession $session)
    {
        $session->load([
            'user.sulitestProfile.fakultas',
            'user.sulitestProfile.prodi',
            'exam.questionBank.categories',
            'answers.question.category',
            'answers.option'
        ]);

        $categoryScores = $this->calculateCategorizedScores($session);
        
        $answersByCategory = $session->answers->groupBy(function ($answer) {
            return $answer->question->category_id ?? 'uncategorized';
        });

        $totalScore = $session->answers->sum('points');

        return view('admin_pemeringkatan.hasil.detail', compact('session', 'categoryScores', 'answersByCategory', 'totalScore'));
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
            $categoryScores[$categoryId]['max_possible'] += 5; // ini 5 dulu ya gan takutnye ditambah bjirrrrrrr
        }


        foreach ($categoryScores as $key => $category) {
            $categoryScores[$key]['percentage'] = $category['max_possible'] > 0 
                ? round(($category['total_points'] / $category['max_possible']) * 100, 2)
                : 0;
        }

        return collect($categoryScores);
    }

    public function export(Exam $exam)
    {
        //export (tar dlu ngerjainya pusing gw)
        return back()->with('info', 'Fitur export akan segera tersedia');
    }

    public function analytics(Exam $exam)
    {
        $sessions = ExamSession::with(['user.sulitestProfile.fakultas', 'user.sulitestProfile.prodi', 'answers.question.category'])
            ->where('exam_id', $exam->id)
            ->where('status', 'completed')
            ->get();


        $analytics = [
            'total_participants' => $sessions->count(),
            'avg_score' => round($sessions->avg(function ($session) {
                return $session->answers->sum('points');
            }), 2),
            'by_fakultas' => $sessions->groupBy('user.sulitestProfile.fakultas_id')->map(function ($group, $fakultasId) {
                $fakultas = $group->first()->user->sulitestProfile?->fakultas;
                return [
                    'name' => $fakultas ? $fakultas->name : 'Tidak Ada',
                    'count' => $group->count(),
                    'avg_score' => round($group->avg(function ($session) {
                        return $session->answers->sum('points');
                    }), 2),
                ];
            }),
            'by_prodi' => $sessions->groupBy('user.sulitestProfile.prodi_id')->map(function ($group, $prodiId) {
                $prodi = $group->first()->user->sulitestProfile?->prodi;
                return [
                    'name' => $prodi ? $prodi->name : 'Tidak Ada',
                    'count' => $group->count(),
                    'avg_score' => round($group->avg(function ($session) {
                        return $session->answers->sum('points');
                    }), 2),
                ];
            }),
        ];


        $categoryAnalytics = [];
        foreach ($sessions as $session) {
            $categorized = $this->calculateCategorizedScores($session);
            foreach ($categorized as $catId => $catData) {
                if (!isset($categoryAnalytics[$catId])) {
                    $categoryAnalytics[$catId] = [
                        'name' => $catData['name'],
                        'total_points' => 0,
                        'total_participants' => 0,
                        'scores' => [],
                    ];
                }
                $categoryAnalytics[$catId]['total_points'] += $catData['total_points'];
                $categoryAnalytics[$catId]['total_participants']++;
                $categoryAnalytics[$catId]['scores'][] = $catData['total_points'];
            }
        }

        foreach ($categoryAnalytics as $key => $data) {
            $categoryAnalytics[$key]['avg_score'] = round($data['total_points'] / $data['total_participants'], 2);
        }

        return view('admin_pemeringkatan.hasil.analytics', compact('exam', 'analytics', 'categoryAnalytics'));
    }
}
