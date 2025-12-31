<?php

namespace App\Http\Controllers\Pemeringkatan;

use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class SulitestRiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sessions = ExamSession::with(['exam.questionBank'])
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('end_time', 'desc')
            ->get();

        return view('sulitest.riwayat.index', compact('sessions'));
    }

    public function detail(ExamSession $session)
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

    public function download(ExamSession $session)
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

        // Add logo
        $logoPath = public_path('images/logos/logo-sulitest.png');
        if (file_exists($logoPath)) {
            $section->addImage($logoPath, [
                'width' => 100,
                'height' => 100,
                'alignment' => 'center'
            ]);
        }
        
        $section->addText('Hasil Sustainability Literacy Question', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addText('Universitas Negeri Jakarta', ['bold' => true, 'size' => 14], ['alignment' => 'center']);
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
