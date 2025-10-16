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

            // Normalize whitespace dan remove special characters
            $fullText = preg_replace('/\r\n/', "\n", $fullText);
            $fullText = preg_replace('/[\x00-\x1F\x7F]/u', '', $fullText);
            
            Log::info('=== DEBUG IMPORT SOAL ===');
            Log::info('Full extracted text:', ['text' => $fullText]);

            // Split berdasarkan nomor soal (1., 2., 3., dst)
            $questionBlocks = preg_split('/(?=\d+\.\s)/', $fullText, -1, PREG_SPLIT_NO_EMPTY);

            Log::info('Question blocks found:', ['count' => count($questionBlocks)]);

            $importedCount = 0;
            $errors = [];

            DB::transaction(function () use ($questionBlocks, $questionBank, &$importedCount, &$errors) {
                foreach ($questionBlocks as $index => $block) {
                    $block = trim($block);
                    if (empty($block)) continue;

                    Log::info("Processing block #$index:", ['block' => $block]);

                    // Match nomor soal dan teks pertanyaan (lebih flexible)
                    if (!preg_match('/^(\d+)\.\s*(.*?)(?=\n[A-E]\.|\Z)/s', $block, $questionMatches)) {
                        $errors[] = "Soal #" . ($index + 1) . ": Format nomor atau teks pertanyaan tidak valid.";
                        Log::warning("Block #$index: Failed to match question pattern");
                        continue;
                    }

                    $questionNumber = $questionMatches[1];
                    $questionText = trim($questionMatches[2]);

                    Log::info("Question #$questionNumber:", ['text' => $questionText]);

                    // Match opsi dengan regex yang lebih robust
                    // Mencari: A. text (Skor X) atau A. text (Bobot X) atau A. text (Skor: X)
                    preg_match_all(
                        '/([A-E])\.\s*(.*?)\s*\((?:Skor|Bobot)\s*:?\s*(\d+)\)/is',
                        $block,
                        $optionMatches,
                        PREG_SET_ORDER
                    );

                    Log::info("Options found for question #$questionNumber:", [
                        'count' => count($optionMatches),
                        'options' => $optionMatches
                    ]);

                    if (count($optionMatches) !== 5) {
                        $errors[] = "Soal #$questionNumber ($questionText): Ditemukan " . count($optionMatches) . " opsi, seharusnya 5. Periksa format (Skor X).";
                        Log::warning("Question #$questionNumber: Expected 5 options, got " . count($optionMatches));
                        continue;
                    }

                    // Validasi opsi A-E lengkap
                    $foundOptions = array_column($optionMatches, 1);
                    $expectedOptions = ['A', 'B', 'C', 'D', 'E'];
                    $missingOptions = array_diff($expectedOptions, $foundOptions);
                    
                    if (!empty($missingOptions)) {
                        $errors[] = "Soal #$questionNumber: Opsi tidak lengkap. Hilang: " . implode(', ', $missingOptions);
                        Log::warning("Question #$questionNumber: Missing options", ['missing' => $missingOptions]);
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

                    Log::info("Question #$questionNumber imported successfully");
                }
            });

            Log::info('Import completed:', [
                'imported' => $importedCount,
                'errors' => count($errors)
            ]);

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
            Log::error('Gagal impor soal: ' . $e->getMessage() . ' on line ' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)
                ->with('error', 'Terjadi kesalahan sistem saat memproses file: ' . $e->getMessage());
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
                foreach ($questionBank->questions as $question) {
                    $question->options()->delete();
                    $question->delete();
                }
            });

            Log::info("Cleared all questions from bank: {$questionBank->name}", [
                'bank_id' => $questionBank->id,
                'questions_deleted' => $count
            ]);

            return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)
                ->with('success', "Berhasil menghapus semua soal ($count soal dihapus)!");
        } catch (\Exception $e) {
            Log::error('Failed to clear questions: ' . $e->getMessage());
            return redirect()->route('admin_pemeringkatan.question_banks.show', $questionBank->id)
                ->with('error', 'Gagal menghapus soal: ' . $e->getMessage());
        }
    }
}
