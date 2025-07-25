<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRespondenAnswerRequest;
use App\Http\Requests\UpdateRespondenAnswerRequest;
use App\Models\Responden;
use App\Models\RespondenAnswer;
use Illuminate\Support\Facades\Auth;
use Monarobase\CountryList\CountryListFacade as Countries;
use Illuminate\Http\Request;


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
        } else if (Auth::user()->role === 'admin_pemeringkatan') {
            return view('admin_pemeringkatan.qsresponden', [
                'respondens' => RespondenAnswer::all()
            ]);
        }
    }



    /**
     * Show the form for creating a new resource.
     */


    public function create(Request $request)
    {
        if (!$request->has('token')) {
            abort(404, 'Tautan tidak valid atau kedaluwarsa.');
        }

        $responden = Responden::where('token', $request->token)->first();

        if (!$responden || $responden->status === 'clear') {
            abort(404, 'Tautan tidak valid atau Anda sudah mengisi survei ini.');
        }
        $view = $responden->category === 'academic' ? 'qsrangking.qs_academic' : 'qsrangking.qs_employee';
        $countries = Countries::getList('en', 'php');

        return view($view, [
            'category' => $responden->category,
            'countries' => $countries,
            'token' => $responden->token,
            'email' => $responden->email,
        ]);
    }

    public function store(StoreRespondenAnswerRequest $request)
    {
        $validatedData = $request->validated();
        $responden = Responden::where('token', $validatedData['token'])->firstOrFail();
        RespondenAnswer::create([
            'title' => $validatedData['answer_title'],
            'first_name' => $validatedData['answer_firstname'],
            'last_name' => $validatedData['answer_lastname'],
            'job_title' => $validatedData['answer_job_title'],
            'institution' => $validatedData['answer_institution'],
            'company_name' => $validatedData['answer_company'],
            'country' => $validatedData['answer_country'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['answer_phone'],
            'survey_2023' => $validatedData['answer_survey_2023'],
            'survey_2024' => $validatedData['answer_survey_2024'],
            'category' => $responden->category,
        ]);

        $responden->update(['status' => 'clear']);
        return redirect(route('survey.thankyou'));
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
