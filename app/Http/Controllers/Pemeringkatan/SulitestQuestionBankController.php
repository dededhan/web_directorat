<?php

namespace App\Http\Controllers\Pemeringkatan;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use App\Models\QuestionBank;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SulitestQuestionBankController extends Controller
{

    public function index()
    {
        $questionBanks = QuestionBank::withCount('questions')->latest()->get();
        return view('admin_pemeringkatan.question_banks.index', compact('questionBanks'));
    }


    public function show(QuestionBank $questionBank)
    {
        $questionBank->load(['questions.options', 'questions.category', 'categories']);
        return view('admin_pemeringkatan.question_banks.show', compact('questionBank'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        QuestionBank::create($request->all());

        return redirect()->route('admin_pemeringkatan.sulitest_question_banks.index')->with('success', 'Bank soal berhasil dibuat!');
    }


    public function storeQuestion(Request $request, QuestionBank $questionBank)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_category_id' => 'nullable|exists:question_categories,id',
            'options' => 'required|array|size:5',
            'options.*.text' => 'required|string|max:255',
            'options.*.points' => 'required|integer|min:1|max:5',
        ]);

        DB::transaction(function () use ($request, $questionBank) {
            $question = $questionBank->questions()->create([
                'question_text' => $request->input('question_text'),
                'question_category_id' => $request->input('question_category_id'),
            ]);

            foreach ($request->input('options') as $optionData) {
                $question->options()->create($optionData);
            }
        });

        return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)->with('success', 'Soal berhasil ditambahkan!');
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
            'question_category_id' => 'nullable|exists:question_categories,id',
            'options' => 'required|array|size:5',
            'options.*.id' => ['required', Rule::exists('options', 'id')->where('question_id', $question->id)],
            'options.*.text' => 'required|string|max:255',
            'options.*.points' => 'required|integer|min:1|max:5',
        ]);

        DB::transaction(function () use ($request, $question) {
            $question->update([
                'question_text' => $request->input('question_text'),
                'question_category_id' => $request->input('question_category_id'),
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

        return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $question->question_bank_id)->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroyQuestion(Question $question)
    {
        $questionBankId = $question->question_bank_id;
        $question->delete();
        return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBankId)->with('success', 'Soal berhasil dihapus!');
    }

    public function clearAllQuestions(QuestionBank $questionBank)
    {
        try {
            $count = $questionBank->questions()->count();
            
            if ($count === 0) {
                return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)
                    ->with('info', 'Tidak ada soal yang perlu dihapus.');
            }

            DB::transaction(function () use ($questionBank) {
                Option::whereIn('question_id', $questionBank->questions()->pluck('id'))->delete();
                $questionBank->questions()->delete();
            });

            return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)
                ->with('success', "Berhasil menghapus semua soal ($count soal dihapus)!");
        } catch (\Exception $e) {
            return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)
                ->with('error', 'Gagal menghapus soal. Silakan coba lagi.');
        }
    }

    public function storeCategory(Request $request, QuestionBank $questionBank)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $maxOrder = $questionBank->categories()->max('order') ?? 0;

        $questionBank->categories()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)->with('success', 'Kategori berhasil dibuat!');
    }

    public function updateCategory(Request $request, QuestionCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $category->question_bank_id)->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroyCategory(QuestionCategory $category)
    {
        $questionBankId = $category->question_bank_id;
        $category->delete();

        return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBankId)->with('success', 'Kategori berhasil dihapus!');
    }

    public function showCategory(QuestionCategory $category)
    {
        $category->load(['questionBank', 'questions.options']);
        $questionBank = $category->questionBank;
        
        return view('admin_pemeringkatan.question_banks.category-detail', compact('category', 'questionBank'));
    }

    public function destroy(QuestionBank $questionBank)
    {
        try {
            $name = $questionBank->name;
            $questionBank->delete();

            return redirect()->route('admin_pemeringkatan.sulitest_question_banks.index')
                ->with('success', "Bank soal '$name' berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()->route('admin_pemeringkatan.sulitest_question_banks.index')
                ->with('error', 'Gagal menghapus bank soal. Silakan coba lagi.');
        }
    }
}
