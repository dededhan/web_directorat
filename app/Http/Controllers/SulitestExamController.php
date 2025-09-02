<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\QuestionBank;
use App\Models\User;
use Illuminate\Http\Request;

class SulitestExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('questionBank')->latest()->get();
        return view('admin_pemeringkatan.sulitest_exams.index', compact('exams'));
    }


    public function create()
    {
        $questionBanks = QuestionBank::pluck('name', 'id');
        return view('admin_pemeringkatan.sulitest_exams.create', compact('questionBanks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|integer|min:1',
            'question_bank_id' => 'required|exists:question_banks,id',
            'number_of_questions' => 'required|integer|min:1',
        ]);

        Exam::create($request->all());

        return redirect()->route('admin_pemeringkatan.sulitest_exams.index')
                         ->with('success', 'Ujian baru berhasil dibuat.');
    }

    public function edit(Exam $exam)
    {
        $questionBanks = QuestionBank::pluck('name', 'id');
        return view('admin_pemeringkatan.sulitest_exams.edit', compact('exam', 'questionBanks'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|integer|min:1',
            'question_bank_id' => 'required|exists:question_banks,id',
            'number_of_questions' => 'required|integer|min:1',
        ]);

        $exam->update($request->all());

        return redirect()->route('admin_pemeringkatan.sulitest_exams.index')
                         ->with('success', 'Data ujian berhasil diperbarui.');
    }


    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin_pemeringkatan.sulitest_exams.index')
                         ->with('success', 'Ujian berhasil dihapus.');
    }


        public function show(Exam $exam)
    {
        $potentialParticipants = User::role('sulitest_user')
            ->whereDoesntHave('exams', function ($query) use ($exam) {
                $query->where('exam_id', $exam->id);
            })
            ->get();
            
        $exam->load('participants');

        return view('admin_pemeringkatan.sulitest_exams.show', compact('exam', 'potentialParticipants'));
    }


    public function assignParticipants(Request $request, Exam $exam)
    {
        $request->validate([
            'participants' => 'required|array',
            'participants.*' => 'exists:users,id',
        ]);

        $exam->participants()->attach($request->participants);

        return redirect()->route('admin_pemeringkatan.sulitest_exams.show', $exam)
                         ->with('success', 'Peserta berhasil ditambahkan.');
    }


    public function removeParticipant(Exam $exam, User $user)
    {
        $exam->participants()->detach($user->id);

        return redirect()->route('admin_pemeringkatan.sulitest_exams.show', $exam)
                         ->with('success', 'Peserta berhasil dihapus.');
    }
}

