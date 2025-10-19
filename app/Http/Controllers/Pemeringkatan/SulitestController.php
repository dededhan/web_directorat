<?php

namespace App\Http\Controllers\Pemeringkatan;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\ExamSessionAnswer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Option;
use App\Models\ExamSessionLog;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

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
        $currentIsFlagged = $userAnswers[$currentQuestionId]->is_flagged ?? false;
        
        //flagging
        $flaggedQuestionIds = $session->answers()->where('is_flagged', true)->pluck('question_id')->toArray();

        return view('sulitest.test', [
            'examSession' => $session,
            'question' => $question,
            'total_questions' => $totalQuestions,
            'current_question_number' => $questionNumber,
            'all_question_ids' => $allQuestionIds,
            'user_answers' => $userAnswers,
            'current_answer_id' => $currentAnswerId,
            'current_is_flagged' => $currentIsFlagged,
            'flagged_question_ids' => $flaggedQuestionIds,
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

    public function logActivity(Request $request, ExamSession $session)
    {
        if ($session->user_id !== Auth::id() || $session->status !== 'ongoing') {
            return response()->json(['status' => 'error'], 403);
        }

        $request->validate([
            'activity_type' => 'required|string',
            'metadata' => 'nullable|array',
        ]);

        ExamSessionLog::create([
            'exam_session_id' => $session->id,
            'activity_type' => $request->activity_type,
            'metadata' => $request->metadata,
            'logged_at' => now(),
        ]);

        return response()->json(['status' => 'success']);
    }

    public function toggleFlag(Request $request, ExamSession $session)
    {
        if ($session->user_id !== Auth::id() || $session->status !== 'ongoing') {
            return response()->json(['status' => 'error'], 403);
        }

        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'is_flagged' => 'required|boolean',
        ]);

        $answer = $session->answers()->where('question_id', $request->question_id)->first();
        
        if ($answer) {
            $answer->update(['is_flagged' => $request->is_flagged]);
        } else {
            
            $session->answers()->create([
                'question_id' => $request->question_id,
                'option_id' => null,
                'points' => 0,
                'is_flagged' => $request->is_flagged,
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function riwayat()
    {
        $user = Auth::user();
        $sessions = ExamSession::with(['exam.questionBank'])
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('end_time', 'desc')
            ->get();

        return view('sulitest.riwayat.index', compact('sessions'));
    }

    public function riwayatDetail(ExamSession $session)
    {
        $user = Auth::user();
        $user->load(['sulitestProfile.fakultas', 'sulitestProfile.prodi']);
        
        if ($session->user_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses riwayat ini.');
        }

        if ($session->status !== 'completed') {
            return redirect()->route('sulitest.riwayat.index')
                ->with('error', 'Ujian belum selesai.');
        }

        $exam = $session->exam;
        if (Carbon::now()->lt($exam->end_time)) {
            return redirect()->route('sulitest.riwayat.index')
                ->with('error', 'Hasil ujian hanya dapat diakses setelah periode ujian berakhir.');
        }

        $answers = $session->answers()->with(['question.options', 'question.category'])->get();
        
        $resultsByCategory = [];
        foreach ($answers as $answer) {
            $question = $answer->question;
            $category = $question->category ? $question->category->name : 'Umum';
            
            if (!isset($resultsByCategory[$category])) {
                $resultsByCategory[$category] = [
                    'name' => $category,
                    'total_questions' => 0,
                    'total_points' => 0,
                    'max_points' => 0,
                ];
            }
            
            $resultsByCategory[$category]['total_questions']++;
            $resultsByCategory[$category]['total_points'] += $answer->points;
            
            $maxPoints = $question->options->max('points');
            $resultsByCategory[$category]['max_points'] += $maxPoints;
        }

        foreach ($resultsByCategory as $key => $category) {
            $resultsByCategory[$key]['percentage'] = $category['max_points'] > 0 
                ? round(($category['total_points'] / $category['max_points']) * 100, 2) 
                : 0;
        }

        $totalQuestions = count($answers);
        $totalScore = $session->score;
        $maxPossibleScore = $answers->sum(function ($answer) {
            return $answer->question->options->max('points');
        });

        return view('sulitest.riwayat.detail', compact(
            'session',
            'exam',
            'answers',
            'resultsByCategory',
            'totalQuestions',
            'totalScore',
            'maxPossibleScore'
        ));
    }

    public function riwayatDownload(ExamSession $session)
    {
        $user = Auth::user();
        $user->load(['sulitestProfile.fakultas', 'sulitestProfile.prodi']);
        
        if ($session->user_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses riwayat ini.');
        }

        if ($session->status !== 'completed') {
            return redirect()->route('sulitest.riwayat.index')
                ->with('error', 'Ujian belum selesai.');
        }

        $exam = $session->exam;
        if (Carbon::now()->lt($exam->end_time)) {
            return redirect()->route('sulitest.riwayat.index')
                ->with('error', 'Hasil ujian hanya dapat diakses setelah periode ujian berakhir.');
        }

        $answers = $session->answers()->with(['question.options', 'question.category'])->get();
        
        $resultsByCategory = [];
        foreach ($answers as $answer) {
            $question = $answer->question;
            $category = $question->category ? $question->category->name : 'Umum';
            
            if (!isset($resultsByCategory[$category])) {
                $resultsByCategory[$category] = [
                    'name' => $category,
                    'total_questions' => 0,
                    'total_points' => 0,
                    'max_points' => 0,
                ];
            }
            
            $resultsByCategory[$category]['total_questions']++;
            $resultsByCategory[$category]['total_points'] += $answer->points;
            
            $maxPoints = $question->options->max('points');
            $resultsByCategory[$category]['max_points'] += $maxPoints;
        }

        foreach ($resultsByCategory as $key => $category) {
            $resultsByCategory[$key]['percentage'] = $category['max_points'] > 0 
                ? round(($category['total_points'] / $category['max_points']) * 100, 2) 
                : 0;
        }

        $totalScore = $session->score;
        $maxPossibleScore = array_sum(array_column($resultsByCategory, 'max_points'));
        $overallPercentage = $maxPossibleScore > 0 ? round(($totalScore / $maxPossibleScore) * 100, 2) : 0;

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText('HASIL UJIAN SULITEST', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $section->addText('Informasi Peserta', ['bold' => true, 'size' => 12]);
        $section->addText('Nama: ' . $user->name);
        $section->addText('Email: ' . $user->email);
        if ($user->sulitestProfile) {
            $section->addText('NIM: ' . ($user->sulitestProfile->nim ?? '-'));
            $section->addText('Fakultas: ' . ($user->sulitestProfile->fakultas->name ?? '-'));
            $section->addText('Prodi: ' . ($user->sulitestProfile->prodi->name ?? '-'));
        }
        $section->addTextBreak(1);

        $section->addText('Informasi Ujian', ['bold' => true, 'size' => 12]);
        $section->addText('Judul: ' . $exam->title);
        $section->addText('Kategori: ' . ($exam->category ?? '-'));
        $section->addText('Tanggal Ujian: ' . $session->start_time->format('d F Y H:i'));
        $section->addText('Durasi: ' . $exam->duration . ' menit');
        $section->addTextBreak(1);

        $section->addText('Hasil Ujian', ['bold' => true, 'size' => 12]);
        $section->addText('Total Soal: ' . count($answers));
        $section->addText('Skor yang Diperoleh: ' . $totalScore);
        $section->addText('Skor Maksimum: ' . $maxPossibleScore);
        $section->addText('Persentase: ' . $overallPercentage . '%');
        $section->addTextBreak(1);

        $section->addText('Hasil Per Kategori', ['bold' => true, 'size' => 12]);
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
        ]);

        $table->addRow();
        $table->addCell(4000)->addText('Kategori', ['bold' => true]);
        $table->addCell(2500)->addText('Total Soal', ['bold' => true]);
        $table->addCell(3000)->addText('Skor (Diperoleh/Maksimum)', ['bold' => true]);
        $table->addCell(2000)->addText('Persentase', ['bold' => true]);

        foreach ($resultsByCategory as $category) {
            $table->addRow();
            $table->addCell(4000)->addText($category['name']);
            $table->addCell(2500)->addText((string)$category['total_questions']);
            $table->addCell(3000)->addText($category['total_points'] . ' / ' . $category['max_points']);
            $table->addCell(2000)->addText($category['percentage'] . '%');
        }

        $safeTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $exam->title);
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $user->name);
        $filename = 'Hasil_Ujian_' . $safeTitle . '_' . $safeName . '.docx';
        
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }
}
