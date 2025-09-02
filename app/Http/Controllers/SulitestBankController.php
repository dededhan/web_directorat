<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
}

