<?php

// Namespace diubah, tidak lagi di dalam 'Admin'
namespace App\Http\Controllers;

use Illuminate\Http\Request;
// TODO: model 
// use App\Models\SulitestQuestionBank;
// use App\Models\SulitestQuestion;
// use App\Models\SulitestOption;

class SulitestBankController extends Controller
{
    public function index()
    {
        $dummyBanks = [
            (object)['id' => 1, 'name' => 'Soal Logika Penalaran 2024', 'description' => 'Kumpulan soal untuk menguji kemampuan penalaran logis.', 'questions_count' => 50, 'created_at' => now()->subDays(5)],
            (object)['id' => 2, 'name' => 'Soal Pengetahuan Umum Batch 1', 'description' => 'Berisi soal-soal seputar pengetahuan umum dan wawasan kebangsaan.', 'questions_count' => 120, 'created_at' => now()->subDays(10)],
        ];

        // TODO: data asli
        // $banks = SulitestQuestionBank::withCount('questions')->latest()->get();

        return view('admin_pemeringkatan.question_banks.index', ['questionBanks' => $dummyBanks]);
    }

    public function show($id) // Nanti $id akan menjadi Model Binding (SulitestQuestionBank $questionBank)
    {
// dummy
        $questionBank = (object)[
            'id' => $id,
            'name' => 'Soal Logika Penalaran 2024',
            'description' => 'Kumpulan soal untuk menguji kemampuan penalaran logis dan analitis calon peserta.',
            'questions' => [
                (object)[
                    'id' => 101,
                    'question_text' => 'Semua mamalia menyusui. Paus adalah mamalia. Kesimpulannya adalah...',
                    'context' => 'Logika Deduktif',
                    'weight' => 2,
                    'options' => [
                        (object)['option_text' => 'Paus bertelur', 'is_correct' => false],
                        (object)['option_text' => 'Paus menyusui', 'is_correct' => true],
                        (object)['option_text' => 'Semua hewan laut adalah mamalia', 'is_correct' => false],
                        (object)['option_text' => 'Paus bukan hewan laut', 'is_correct' => false],
                    ]
                ],
                (object)[
                    'id' => 102,
                    'question_text' => 'Jika hari ini hujan, maka jalanan basah. Hari ini tidak hujan. Kesimpulannya adalah...',
                    'context' => 'Logika Proposisi',
                    'weight' => 3,
                    'options' => [
                        (object)['option_text' => 'Jalanan pasti kering', 'is_correct' => false],
                        (object)['option_text' => 'Jalanan mungkin basah karena sebab lain', 'is_correct' => false],
                        (object)['option_text' => 'Tidak dapat ditarik kesimpulan', 'is_correct' => true],
                        (object)['option_text' => 'Besok akan hujan', 'is_correct' => false],
                    ]
                ]
            ]
        ];


        // TODO: Ganti dengan query database asli
        // $questionBank->load('questions.options');

        return view('admin_pemeringkatan.question_banks.show', ['questionBank' => $questionBank]);
    }

    //
    public function store(Request $request)
    {
        return redirect()->route('admin_pemeringkatan.question_banks.index')->with('success', 'Bank soal berhasil dibuat!');
    }

    public function storeQuestion(Request $request, $bankId)
    {
        return redirect()->route('admin_pemeringkatan.question_banks.show', $bankId)->with('success', 'Soal berhasil ditambahkan!');
    }
}
