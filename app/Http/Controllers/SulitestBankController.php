<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\IOFactory;

class SulitestBankController extends Controller
{

    public function index()
    {
        $questionBanks = QuestionBank::withCount('questions')->latest()->get();
        return view('admin_pemeringkatan.question_banks.index', compact('questionBanks'));
    }


    public function show(QuestionBank $questionBank)
    {
        $questionBank->load('questions.options');
        return view('admin_pemeringkatan.question_banks.show', compact('questionBank'));
    }


    public function importQuestions(Request $request, QuestionBank $questionBank)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:docx',
        ]);

        try {
            $file = $request->file('import_file');
            $phpWord = IOFactory::load($file->getPathname());

            $fullText = '';
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $fullText .= $element->getText() . "\n";
                    } else if (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $nestedElement) {
                            if (method_exists($nestedElement, 'getText')) {
                                $fullText .= $nestedElement->getText();
                            }
                        }
                        $fullText .= "\n";
                    }
                }
            }

            $fullText = preg_replace('/\r\n/', "\n", $fullText);
            $fullText = preg_replace('/[\x00-\x1F\x7F]/u', '', $fullText);
            $fullText = preg_replace('/\n\s*(\((?:Skor|Bobot)\s*:?\s*\d+\))/', ' $1', $fullText);

            $questionBlocks = preg_split('/(?=\d+\.\s)/', $fullText, -1, PREG_SPLIT_NO_EMPTY);

            $importedCount = 0;
            $errors = [];

            DB::transaction(function () use ($questionBlocks, $questionBank, &$importedCount, &$errors) {
                foreach ($questionBlocks as $index => $block) {
                    $block = trim($block);
                    if (empty($block)) continue;

                    if (!preg_match('/^(\d+)\.\s*/', $block, $numberMatch)) {
                        $errors[] = "Soal #" . ($index + 1) . ": Format nomor soal tidak valid.";
                        continue;
                    }

                    $questionNumber = $numberMatch[1];

                    preg_match_all(
                        '/([A-E])\.\s*(.*?)\s*\((?:Skor|Bobot)\s*:?\s*(\d+)\)/is',
                        $block,
                        $optionMatches,
                        PREG_SET_ORDER
                    );

                    if (count($optionMatches) !== 5) {
                        $errors[] = "Soal #$questionNumber: Ditemukan " . count($optionMatches) . " opsi, seharusnya 5. Periksa format (Skor X).";
                        continue;
                    }

                    $foundOptions = array_column($optionMatches, 1);
                    $expectedOptions = ['A', 'B', 'C', 'D', 'E'];
                    $missingOptions = array_diff($expectedOptions, $foundOptions);
                    
                    if (!empty($missingOptions)) {
                        $errors[] = "Soal #$questionNumber: Opsi tidak lengkap. Hilang: " . implode(', ', $missingOptions);
                        continue;
                    }
                    $firstOptionPos = strpos($block, $optionMatches[0][0]);
                    if ($firstOptionPos === false) {
                        $errors[] = "Soal #$questionNumber: Tidak dapat menemukan teks pertanyaan.";
                        continue;
                    }

                    $questionText = substr($block, strlen($numberMatch[0]), $firstOptionPos - strlen($numberMatch[0]));
                    $questionText = trim($questionText);
                    $questionText = preg_replace('/\s+/', ' ', $questionText);

                    if (empty($questionText)) {
                        $errors[] = "Soal #$questionNumber: Teks pertanyaan kosong.";
                        continue;
                    }

                    $question = $questionBank->questions()->create(['question_text' => $questionText]);

                    $optionsData = [];
                    foreach ($optionMatches as $match) {
                        $optionsData[] = [
                            'text' => trim($match[2]),
                            'points' => (int) $match[3],
                        ];
                    }
                    $question->options()->createMany($optionsData);
                    $importedCount++;
                }
            });

            if ($importedCount > 0) {
                return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)
                    ->with('success', "$importedCount soal berhasil diimpor!" . (count($errors) > 0 ? " (dengan " . count($errors) . " error)" : ""))
                    ->with('import_errors', $errors);
            } else {
                return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)
                    ->with('error', 'Gagal mengimpor soal. Pastikan format file DOCX sudah sesuai template.')
                    ->with('import_errors', $errors);
            }
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage(), [
                'bank_id' => $questionBank->id,
                'line' => $e->getLine()
            ]);
            
            return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)
                ->with('error', 'Terjadi kesalahan sistem saat memproses file. Silakan cek format file atau hubungi administrator.');
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        QuestionBank::create($request->all());

        return redirect()->route('admin_pemeringkatan.question_banks.index')->with('success', 'Bank soal berhasil dibuat!');
    }


    public function storeQuestion(Request $request, QuestionBank $questionBank)
    {
        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|size:5',
            'options.*.text' => 'required|string|max:255',
            'options.*.points' => 'required|integer|min:1|max:5',
        ]);

        DB::transaction(function () use ($request, $questionBank) {
            $question = $questionBank->questions()->create([
                'question_text' => $request->input('question_text'),
            ]);

            foreach ($request->input('options') as $optionData) {
                $question->options()->create($optionData);
            }
        });

        return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)->with('success', 'Soal berhasil ditambahkan!');
    }


    public function editQuestion(Question $question)
    {
        $question->load('options', 'questionBank');
        return view('admin_pemeringkatan.question_banks.edit', compact('question'));
    }


    public function updateQuestion(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|size:5',
            'options.*.id' => ['required', Rule::exists('options', 'id')->where('question_id', $question->id)],
            'options.*.text' => 'required|string|max:255',
            'options.*.points' => 'required|integer|min:1|max:5',
        ]);

        DB::transaction(function () use ($request, $question) {
            $question->update([
                'question_text' => $request->input('question_text')
            ]);

            foreach ($request->input('options') as $optionData) {

                $option = Option::find($optionData['id']);
                if ($option && $option->question_id === $question->id) {
                    $option->update([
                        'text' => $optionData['text'],
                        'points' => $optionData['points'],
                    ]);
                }
            }
        });

        return redirect()->route('admin_pemeringkatan.question_banks.show', $question->question_bank_id)->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroyQuestion(Question $question)
    {
        $questionBankId = $question->question_bank_id;
        $question->delete();
        return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBankId)->with('success', 'Soal berhasil dihapus!');
    }

    public function clearAllQuestions(QuestionBank $questionBank)
    {
        try {
            $count = $questionBank->questions()->count();
            
            if ($count === 0) {
                return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)
                    ->with('info', 'Tidak ada soal yang perlu dihapus.');
            }

            DB::transaction(function () use ($questionBank) {
                Option::whereIn('question_id', $questionBank->questions()->pluck('id'))->delete();
                $questionBank->questions()->delete();
            });

            Log::info("Cleared all questions", [
                'bank_id' => $questionBank->id,
                'count' => $count
            ]);

            return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)
                ->with('success', "Berhasil menghapus semua soal ($count soal dihapus)!");
        } catch (\Exception $e) {
            Log::error('Clear all failed: ' . $e->getMessage(), [
                'bank_id' => $questionBank->id
            ]);
            
            return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)
                ->with('error', 'Gagal menghapus soal. Silakan coba lagi.');
        }
    }
}
