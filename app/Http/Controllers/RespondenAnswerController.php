<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRespondenAnswerRequest;
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

        $respondens = RespondenAnswer::latest()->paginate(500);
        $userRole = Auth::user()->role;

        $viewMap = [
            'admin_direktorat' => 'admin.qsresponden',
            'prodi' => 'prodi.qsresponden',
            'fakultas' => 'fakultas.qsresponden',
            'admin_pemeringkatan' => 'admin_pemeringkatan.qsresponden',
        ];

        if (array_key_exists($userRole, $viewMap)) {
            return view($viewMap[$userRole], compact('respondens'));
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses.');
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
        //TYPO KUDU DI BENERIN
        $normalizedCategory = $responden->category === 'employer' ? 'employee' : $responden->category;

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
            'category' => $normalizedCategory,
        ]);

        $responden->update(['status' => 'clear']);
        return redirect(route('survey.thankyou'));
    }

    /**
     * Display the specified resource.
     */
    public function show(RespondenAnswer $respondenAnswer)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RespondenAnswer $qsresponden)
    {
        // Memanggil view dari lokasi yang benar: admin/qsresponden/edit.blade.php
        return view('admin.qsresponden.edit', ['responden' => $qsresponden]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RespondenAnswer $qsresponden)
    {
        // Validasi data dari form edit
        $validatedData = $request->validate([
            'title' => 'required|string|max:20',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'survey_2023' => 'nullable|string|max:255',
            'survey_2024' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
        ]);

        $qsresponden->update($validatedData);

        return redirect()->route('admin.qsresponden.index')->with('success', 'Data responden berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RespondenAnswer $qsresponden)
    {
        try {
            $qsresponden->delete();
            return redirect()->route('admin.qsresponden.index')->with('success', 'Data responden berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.qsresponden.index')->with('error', 'Gagal menghapus data.');
        }
    }
}

