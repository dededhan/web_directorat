<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SulitestController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();


        $exams = $user->exams()
                      ->where('exams.end_time', '>', now())
                      ->get();

        return view('sulitest.dashboard', ['exams' => $exams]);
    }

    public function startTest(Request $request, $testId)
    {
        // TODO: Ganti dengan logika database asli.
        // 1. Buat record baru di tabel 'test_sessions'.
        // 2. Ambil soal secara acak dari database berdasarkan testId.
        // 3. Simpan ID soal-soal tersebut ke dalam sesi tes.

        $sessionId = Str::uuid();

        $dummyQuestions = [
            ['id' => 1, 'question' => 'Apa ibu kota Indonesia?', 'options' => ['Jakarta', 'Bandung', 'Surabaya', 'Medan'], 'correct_answer' => 'Jakarta'],
            ['id' => 2, 'question' => 'Siapakah presiden pertama Indonesia?', 'options' => ['Soekarno', 'Soeharto', 'Habibie', 'Gus Dur'], 'correct_answer' => 'Soekarno'],
            ['id' => 3, 'question' => 'Berapa hasil dari 5 + 5 * 2?', 'options' => ['20', '15', '25', '10'], 'correct_answer' => '15'],
        ];

        $testSessionData = [
            'test_id' => $testId,
            'test_title' => 'Uji Coba Pengetahuan Umum',
            'duration' => 10,
            'questions' => $dummyQuestions,
            'user_answers' => [],
            'current_question_index' => 0,
        ];

        $request->session()->put('test_session_' . $sessionId, $testSessionData);
        return redirect()->route('sulitest.test.show', ['session' => $sessionId]);
    }


    public function showTest(Request $request, $sessionId)
    {
        $sessionData = $request->session()->get('test_session_' . $sessionId);

        if (!$sessionData) {
            return redirect()->route('sulitest.dashboard')->with('error', 'Sesi tes tidak valid atau telah berakhir.');
        }

        $currentQuestion = $sessionData['questions'][$sessionData['current_question_index']];

        return view('sulitest.test', [
            'session_id' => $sessionId,
            'test_title' => $sessionData['test_title'],
            'duration' => $sessionData['duration'],
            'question' => $currentQuestion,
            'total_questions' => count($sessionData['questions']),
            'current_question_number' => $sessionData['current_question_index'] + 1,
        ]);
    }
    public function submitAnswer(Request $request, $sessionId)
    {
        $request->validate(['answer' => 'required']);
        $sessionData = $request->session()->get('test_session_' . $sessionId);

        if (!$sessionData) {
            return redirect()->route('sulitest.dashboard')->with('error', 'Sesi tes tidak valid.');
        }

        $currentQuestionIndex = $sessionData['current_question_index'];
        $sessionData['user_answers'][$currentQuestionIndex] = $request->input('answer');

        $sessionData['current_question_index']++;


        $request->session()->put('test_session_' . $sessionId, $sessionData);


        if ($sessionData['current_question_index'] < count($sessionData['questions'])) {
            return redirect()->route('sulitest.test.show', ['session' => $sessionId]);
        } else {
            return $this->finishTest($request, $sessionId);
        }
    }

    private function finishTest(Request $request, $sessionId)
    {
        $sessionData = $request->session()->get('test_session_' . $sessionId);

        if (!$sessionData) {
            return redirect()->route('sulitest.dashboard')->with('error', 'Sesi tes tidak valid.');
        }

        $score = 0;
        foreach ($sessionData['questions'] as $index => $question) {
            if (isset($sessionData['user_answers'][$index]) && $sessionData['user_answers'][$index] === $question['correct_answer']) {
                $score++;
            }
        }
        $totalQuestions = count($sessionData['questions']);
        $finalScore = ($score / $totalQuestions) * 100;

        // TODO: skor akhir belum ada database

        $request->session()->put('test_results_' . $sessionId, [
            'score' => round($finalScore),
            'correct_answers' => $score,
            'total_questions' => $totalQuestions,
            'test_title' => $sessionData['test_title'],
        ]);

        $request->session()->forget('test_session_' . $sessionId);

        return redirect()->route('sulitest.results.show', ['session' => $sessionId]);
    }

    public function showResults(Request $request, $sessionId)
    {
        $results = $request->session()->get('test_results_' . $sessionId);

        if (!$results) {
            return redirect()->route('sulitest.dashboard.index')->with('error', 'Hasil tes tidak ditemukan.');
        }

        $request->session()->forget('test_results_' . $sessionId);

        return view('sulitest.results', [
            'results' => $results,
        ]);
    }
}
