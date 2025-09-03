<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\ExamSessionAnswer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Option;

class SulitestController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $exams = $user->exams()
                      ->where('exams.end_time', '>', now())
                      ->whereDoesntHave('examSessions', function ($query) use ($user) {
                          $query->where('user_id', $user->id)->where('status', 'completed');
                      })
                      ->get();

        return view('sulitest.dashboard', ['exams' => $exams]);
    }

    public function startTest(Request $request, Exam $exam)
    {
        $user = Auth::user();

        $existingSession = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->where('status', 'ongoing')
            ->first();

        if ($existingSession) {
            return redirect()->route('sulitest.test.show', $existingSession->id);
        }

        DB::beginTransaction();
        try {
            $questionIds = $exam->questionBank->questions()
                ->inRandomOrder()
                ->limit($exam->number_of_questions)
                ->pluck('id')
                ->toArray();
            
            if (count($questionIds) < $exam->number_of_questions) {
                return redirect()->route('sulitest.dashboard')->with('error', 'Jumlah soal di bank soal tidak mencukupi.');
            }

            $now = Carbon::now();
            $session = ExamSession::create([
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'start_time' => $now,
                'end_time' => $now->clone()->addMinutes($exam->duration),
                'question_ids' => $questionIds,
                'status' => 'ongoing',
            ]);

            DB::commit();

            return redirect()->route('sulitest.test.show', $session->id);

        } catch (\Exception $e) {
            DB::rollBack();
            // \Log::error($e->getMessage());
            return redirect()->route('sulitest.dashboard')->with('error', 'Gagal memulai ujian. Silakan coba lagi.');
        }
    }

    public function showTest(Request $request, ExamSession $session, $questionNumber = 1)
    {
        if ($session->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses sesi ini.');
        }

        if ($session->status !== 'ongoing' || Carbon::now()->isAfter($session->end_time)) {
            if ($session->status === 'ongoing') {
                $this->finishTest($session);
            }
            return redirect()->route('sulitest.results.show', $session->id);
        }

        $allQuestionIds = $session->question_ids;
        $totalQuestions = count($allQuestionIds);

        $questionNumber = (int)$questionNumber;
        if ($questionNumber < 1 || $questionNumber > $totalQuestions) {
            $questionNumber = 1;
        }

        $currentQuestionId = $allQuestionIds[$questionNumber - 1];
        $question = Question::with('options')->find($currentQuestionId);

        $userAnswers = $session->answers()->get()->keyBy('question_id');
        $currentAnswerId = $userAnswers[$currentQuestionId]->option_id ?? null;

        return view('sulitest.test', [
            'examSession' => $session,
            'question' => $question,
            'total_questions' => $totalQuestions,
            'current_question_number' => $questionNumber,
            'all_question_ids' => $allQuestionIds,
            'user_answers' => $userAnswers,
            'current_answer_id' => $currentAnswerId,
        ]);
    }

    public function autosaveAnswer(Request $request, ExamSession $session)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'option_id' => 'required|exists:options,id'
        ]);

        if ($session->user_id !== Auth::id() || $session->status !== 'ongoing' || Carbon::now()->isAfter($session->end_time)) {
            return response()->json(['status' => 'error', 'message' => 'Sesi tidak valid.'], 403);
        }

        $option = Option::find($request->option_id);
        if ($option->question_id != $request->question_id) {
             return response()->json(['status' => 'error', 'message' => 'Jawaban tidak cocok.'], 422);
        }

        $session->answers()->updateOrCreate(
            ['question_id' => $request->question_id],
            ['option_id' => $request->option_id, 'points' => $option->points]
        );

        return response()->json(['status' => 'success']);
    }

    public function submitAnswer(Request $request, ExamSession $session)
    {
        if ($session->user_id !== Auth::id() || $session->status !== 'ongoing') {
            abort(403);
        }

        $this->finishTest($session);
        return redirect()->route('sulitest.results.show', $session->id);
    }

    private function finishTest(ExamSession $session)
    {
        if ($session->status !== 'ongoing') {
            return;
        }

        $totalScore = $session->answers()->sum('points');
        
        $session->update([
            'status' => 'completed',
            'score' => $totalScore
        ]);
    }

    public function showResults(Request $request, ExamSession $session)
    {
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        if ($session->status === 'ongoing') {
             return redirect()->route('sulitest.test.show', $session->id);
        }

        $totalQuestions = count($session->question_ids);
        $correctAnswers = $session->answers()->where('points', '>', 0)->count();

        return view('sulitest.results', compact('session', 'totalQuestions', 'correctAnswers'));
    }
}

