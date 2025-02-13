<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRespondenAnswerRequest;
use App\Http\Requests\UpdateRespondenAnswerRequest;
use App\Models\Responden;
use App\Models\RespondenAnswer;
use Illuminate\Support\Facades\Auth;

class RespondenAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('admin.qsresponden', [
        //     'respondens' => RespondenAnswer::all()
        // ]);
        // $respondenAnswers = RespondenAnswer::all();
        // if (Auth::user()->role === 'admin_direktorat') {
        //         return view('admin.respondenanswer', compact('respondenAnswers'));
        //     } else if (Auth::user()->role === 'admin_pemeringkatan') {
        //         return view('pemeringkatan.respondenanswer', compact('respondenAnswers'));
        //     } else if (Auth::user()->role === 'prodi') {
        //         return view('prodi.qsresponden', compact('respondenAnswers'));
        //     } else if (Auth::user()->role === 'fakultas') {
        //         return view('fakultas.respondenanswer', compact('respondenAnswers'));
        //     }
        // }

        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.qsresponden', [
                'respondens' => RespondenAnswer::all()
            ]);
        } else if (Auth::user()->role === 'prodi') {
            return view('prodi.qsresponden', [
                'respondens' => RespondenAnswer::all()
            ]);
        } else if (Auth::user()->role === 'fakultas') {
            return view('fakultas.qsresponden', [
                'respondens' => RespondenAnswer::all()
            ]);
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = request()->get('view');
        return view($view, [
            'category' => request()->get('category'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRespondenAnswerRequest $request)
    {
        $answerValidatedData = $request->validated();
        // temporary insert, must be updated with create method later
        RespondenAnswer::create([
            'title' => $answerValidatedData['answer_title'],
            'first_name' => $answerValidatedData['answer_firstname'],
            'last_name' => $answerValidatedData['answer_lastname'],
            'job_title' => $answerValidatedData['answer_job_title'],
            'institution' => $answerValidatedData['answer_institution'],
            'company_name' => $answerValidatedData['answer_company'],
            'country' => $answerValidatedData['answer_country'],
            'email' => $answerValidatedData['email'],
            'phone' => $answerValidatedData['phone'],
            'survey_2023' => $answerValidatedData['answer_survey_2023'],
            'survey_2024' => $answerValidatedData['answer_survey_2024'],
            'category' => request()->get('category')
        ]);
        // update status
        Responden::where('email', $answerValidatedData['email'])->update([
            'status' => 'clear'
        ]);

        return $this->create();
    }

    /**
     * Display the specified resource.
     */
    public function show(RespondenAnswer $respondenAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RespondenAnswer $respondenAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RespondenAnswer $respondenAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RespondenAnswer $respondenAnswer)
    {
        //
    }
}
